<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package basetheme
 */

$product_id = get_the_ID();
$product = wc_get_product($product_id);
set_post_views($product_id);
$terms = wp_get_post_terms($product_id, 'product_cat');
$categories = array_filter($terms, function ($term) {
	return $term->taxonomy === 'product_cat';
});
get_header();
?>

<!-- Single Product -->
<section class="secSpace">
	<div class="container">
		<?php wp_breadcrumbs(); ?>

		<?php
		if (!empty($_POST['add-to-cart']) && $_POST['add-to-cart'] == $product_id) {
			echo '<p>Đơn hàng đã được thêm vào giỏ hàng.</p>';
			$cart_url = wc_get_cart_url();
			echo '<a href="' . esc_url($cart_url) . '">Xem giỏ hàng</a>';
		}
		?>

		<div class="product_info_wrap">
			<div class="row">
				<div class="col-lg-6">
					<?php
					$attachment_ids = $product->get_gallery_image_ids();
					if ($attachment_ids):
					?>
						<div class="product-gallery">
							<?php foreach ($attachment_ids as $attachment_id): ?>
								<div class="gallery-item">
									<picture>
										<source media="(min-width:768px)"
											srcset="<?php echo img_url($attachment_id, 'large') ?>">
										<img width="400" height="400" loading="lazy"
											src="<?php echo img_url($attachment_id, 'medium') ?>"
											alt="gallery large item <?php echo $attachment_id; ?>">
									</picture>
								</div>
							<?php endforeach; ?>
						</div>

						<div class="product-thumbnails">
							<?php foreach ($attachment_ids as $attachment_id): ?>
								<div class="thumbnail-item">
									<img width="200" height="200" loading="lazy"
										src="<?php echo img_url($attachment_id, 'thumbnail') ?>"
										alt="gallery thumbnail item <?php echo $attachment_id; ?>">
								</div>
							<?php endforeach; ?>
						</div>
					<?php else: ?>
						<div class="product_info_img">
							<?php
							$image_id = get_post_thumbnail_id(get_the_ID());
							?>
							<picture>
								<source media="(min-width:768px)" srcset="<?php echo img_url($image_id, 'large') ?>">
								<img width="400" height="400" loading="lazy"
									src="<?php echo img_url($image_id, 'medium') ?>" alt="<?php the_title(); ?>">
							</picture>

						</div>

					<?php endif; ?>
				</div>
				<div class="col-lg-6">
					<div class="product_info">
						<?php
						if ($product->is_on_sale()) {
							$regular_price = $product->get_regular_price();
							$sale_price = $product->get_sale_price();

							if ($regular_price > 0) {
								$discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
						?>
								<div class="sale_notification">Sale <?php echo $discount_percentage; ?>%</div>
						<?php
							}
						}
						?>

						<h1 class="h1 product_title">
							<?php the_title(); ?>
						</h1>

						<!-- hiển thị thông tin chung -->
						<?php
						$product_sku = $product->get_sku() ? $product->get_sku() : 'N/A';
						$stock_status = $product->is_in_stock() ? 'Còn hàng' : 'Hết hàng';
						$product_views = get_post_meta($product_id, 'post_views_count', true);
						$product_views = $product_views ? $product_views : 0;
						?>
						<div class="meta_product">
							<div class="sku_pro">
								Mã sản phẩm: <span class="sku"><?php echo esc_html($product_sku); ?></span>
							</div>
							<div class="meta_product_line">|</div>
							<div class="stock_pro">
								Tình trạng: <span class="stock">
									<?php echo esc_html($stock_status); ?>
								</span>
							</div>
							<div class="meta_product_line">|</div>
							<div class="view_pro">
								Lượt xem: <?php echo esc_html($product_views); ?>
							</div>
						</div>

						<?php
						// hiển thị giá trong 2 trường hợp
						if ($product->is_type('variable')) {
							if ($product instanceof WC_Product_Variable) {
								$available_variations = $product->get_available_variations();
							} else {
								$available_variations = [];
							}

							$min_price = null;
							$max_price = null;

							if ($available_variations) {
								foreach ($available_variations as $variation) {
									$variation_price = $variation['display_price'];

									if ($min_price === null || $variation_price < $min_price) {
										$min_price = $variation_price;
									}

									if ($max_price === null || $variation_price > $max_price) {
										$max_price = $variation_price;
									}
								}
							}

							if ($min_price && $max_price) {
								if ($min_price === $max_price) {
									echo '<p>Giá: ' . wc_price($min_price) . '</p>';
								} else {
									echo '<p>Giá từ: ' . wc_price($min_price) . ' đến ' . wc_price($max_price) . '</p>';
								}
							}
						} else {
						?>
							<div class="product_info_price h1">
								<span class="price_title">Giá:</span>
								<?php
								$regular_price = $product->get_regular_price();
								$sale_price = $product->get_sale_price();

								if ($regular_price == 0): ?>
									<span class="contact-price">Liên hệ</span>
								<?php elseif ($product->is_on_sale()): ?>
									<span class="regular-price-sale">
										<?php echo wc_price($regular_price); ?>
									</span>
									<span class="sale-price" style="color: red; margin-left: 10px;">
										<?php echo wc_price($sale_price); ?>
									</span>
								<?php else: ?>
									<span class="regular-price"><?php echo wc_price($regular_price); ?></span>
								<?php endif; ?>
							</div>
						<?php
						}
						?>

						<?php
						// Lấy ngày kết thúc của chương trình giảm giá (Sale)
						if (shortcode_exists('countdowm_date')) {
							if ($product->is_on_sale()) {
								$sale_end_date = $product->get_date_on_sale_to();
								if ($sale_end_date) {
									$sale_end_timestamp = $sale_end_date->getTimestamp();
									$formatted_sale_end_date = date('Y-m-d H:i:s', $sale_end_timestamp);
									echo do_shortcode('[countdowm_date class="product_sale_date" date="' . $formatted_sale_end_date . '"]');
								}
							}
						}
						?>

						<?php
						$short_description = $product->get_short_description();
						if (!empty($short_description)):
							$short_description = apply_filters('the_content', $short_description);
						?>
							<div class="product_summary">
								<h3 class="h4 product_summary_title">
									Đặc điểm nổi bật
								</h3>
								<div class="editor editor_table_striped">
									<?php echo $short_description; ?>
								</div>
							</div>
						<?php endif; ?>

						<?php
						if ($product->is_type('variable')) {
							woocommerce_variable_add_to_cart();
						} else {
							$product_attributes = $product->get_attributes();

							if (!empty($product_attributes)) {
								echo '<div class="product-attributes">';
								foreach ($product_attributes as $attribute_name => $attribute) {
									echo '<div class="attribute">';
									echo '<strong>' . wc_attribute_label($attribute_name) . ': </strong>';

									if ($attribute->is_taxonomy()) {
										$terms = wc_get_product_terms($product->get_id(), $attribute_name, array('fields' => 'names'));
										echo implode(', ', $terms);
									} else {
										echo implode(', ', $attribute->get_options());
									}

									echo '</div>';
								}
								echo '</div>';
							}


							if ($product->is_in_stock()):
								woocommerce_simple_add_to_cart();
							else:
						?>
								<p>Hết hàng</p>
						<?php
							endif;
						}
						?>

						<?php if (shortcode_exists('woosc')) : ?>
							<div class="my-3">
								<?php echo do_shortcode('[woosc id="' . $product_id . '"]'); ?>
							</div>
						<?php endif; ?>

						<?php
						if (!empty($categories)):
						?>
							<div class="product_cats">
								Danh mục:
								<?php
								$category_links = [];
								foreach ($categories as $category) {
									$category_links[] = '<a class="product_cats_item" href="' . get_term_link($category) . '">' . $category->name . '</a>';
								}
								echo implode(', ', $category_links);
								?>
							</div>
						<?php
						endif;
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- / Single Product -->

<section class="secSpace pt-0">
	<div class="container">
		<div class="product_info_wrap">
			<div class="product_content">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
							Thông tin sản phẩm
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">
							Thông số kỹ thuật
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">
							Đánh giá
						</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tabs-1" role="tabpanel">
						<div class="readmore_eidtor_content">
							<div class="editor">
								<?php
								$full_description = apply_filters('the_content', $product->get_description());
								echo !empty($full_description) ? $full_description : 'Nội dung đang được cập nhật...';
								?>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="tabs-2" role="tabpanel">
						<?php
						$product_attributes = $product->get_attributes();
						if (! empty($product_attributes)) :
						?>
							<div class="editor editor_table_striped">
								<table class="woocommerce-product-attributes shop_attributes" aria-label="<?php esc_attr_e('Product Details', 'woocommerce'); ?>">
									<?php foreach ($product_attributes as $product_attribute_key => $product_attribute) : ?>
										<tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo esc_attr($product_attribute_key); ?>">
											<th class="woocommerce-product-attributes-item__label" scope="row"><?php echo wp_kses_post($product_attribute->get_name()); ?></th>
											<td class="woocommerce-product-attributes-item__value">
												<?php
												// Kiểm tra xem thuộc tính có phải là taxonomy không
												if ($product_attribute->is_taxonomy()) {
													$terms = wc_get_product_terms($product->get_id(), $product_attribute->get_name(), array('fields' => 'names'));
													echo wp_kses_post(implode(', ', $terms));
												} else {
													// Nếu là thuộc tính tùy chỉnh, hiển thị giá trị
													echo wp_kses_post(implode(', ', $product_attribute->get_options()));
												}
												?>
											</td>
										</tr>
									<?php endforeach; ?>
								</table>
							</div>
						<?php else: ?>
							<p>Nội dung đang được cập nhật...</p>
						<?php endif; ?>
					</div>
					<div class="tab-pane" id="tabs-3" role="tabpanel">
						<?php
						$args = array(
							'post_id' => $product_id, // ID sản phẩm
							'status'  => array('approve', 'hold'),   // Chỉ lấy các đánh giá đã được duyệt
							'type'    => 'review',    // Lọc chỉ các đánh giá
						);
						$comments = get_comments($args);
						?>
						<div class="product-reviews">
							<?php if ($comments) : ?>
								<h3>Các đánh giá:</h3>
								<ul class="review-list">
									<?php foreach ($comments as $comment) : ?>
										<li class="review-item">
											<div class="review-author">
												<strong><?php echo esc_html($comment->comment_author); ?></strong>
											</div>
											<div class="review-date">
												<?php echo esc_html(date('d/m/Y', strtotime($comment->comment_date))); ?>
											</div>
											<div class="review-content">
												<?php echo esc_html($comment->comment_content); ?>
											</div>
											<div class="review-rating">
												<?php
												$rating = intval(get_comment_meta($comment->comment_ID, 'rating', true));
												if ($rating) {
													echo '<div class="star-rating-item" style="color: #f5b301;">';
													for ($i = 1; $i <= 5; $i++) {
														echo $i <= $rating ? '★' : '';
													}
													echo '</div>';
												}
												?>
											</div>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php else : ?>
								<p>Chưa có đánh giá nào cho sản phẩm này.</p>
							<?php endif; ?>

							<!-- Phần form đánh giá -->
							<?php
							if (comments_open() && is_user_logged_in()) :
								$user_id = get_current_user_id(); // Lấy ID người dùng hiện tại
								$args = array(
									'post_id' => $product_id,  // ID sản phẩm
									'user_id' => $user_id,     // Kiểm tra đánh giá của người dùng hiện tại
									'type'    => 'review',     // Chỉ lấy các đánh giá
									'status'  => array('approve', 'hold'),    // Chỉ lấy đánh giá đã duyệt
								);
								$user_reviews = get_comments($args);
								if (empty($user_reviews)) :
							?>
									<div class="review-form">
										<h3>Gửi đánh giá của bạn:</h3>
										<form action="<?php echo site_url('/wp-comments-post.php'); ?>" method="post" class="comment-form">
											<div class="comment-form-rating">
												<label for="rating">Xếp hạng:</label>
												<div class="rating-options">
													<label>
														<input type="radio" name="rating" value="5" required checked>
														5 Sao - Xuất sắc
													</label>
													<label>
														<input type="radio" name="rating" value="4">
														4 Sao - Tốt
													</label>
													<label>
														<input type="radio" name="rating" value="3">
														3 Sao - Bình thường
													</label>
													<label>
														<input type="radio" name="rating" value="2">
														2 Sao - Tệ
													</label>
													<label>
														<input type="radio" name="rating" value="1">
														1 Sao - Rất tệ
													</label>
												</div>
											</div>
											<p class="comment-form-comment">
												<label for="comment">Nội dung đánh giá:</label>
												<textarea name="comment" id="comment" rows="5" required></textarea>
											</p>
											<p class="form-submit">
												<input type="submit" name="submit" id="submit" class="submit" value="Gửi đánh giá">
												<input type="hidden" name="comment_post_ID" value="<?php echo $product_id; ?>">
												<input type="hidden" name="comment_parent" value="0">
											</p>
										</form>
									</div>
							<?php
								endif;
							endif;
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
if (!empty($categories)) {
	$term_ids = wp_list_pluck($categories, 'slug');
} else {
	$term_ids = [];
}

$args = array(
	'post_type' => 'product',
	'posts_per_page' => 10,
	'post__not_in' => array($product_id),
	'tax_query' => array(
		array(
			'taxonomy' => 'product_cat',
			'field' => 'slug',
			'terms' => $term_ids,
		),
	),
);

$query = new WP_Query($args);

if ($query->have_posts()):
?>
	<section class="secSpace pt-0">
		<div class="container">
			<div class="sec_heading">
				<h2 class="sec_title">
					Sản phẩm liên quan
				</h2>
			</div>

			<div class="product_list_slider">
				<?php
				while ($query->have_posts()):
					$query->the_post(); ?>
					<div>
						<div class="product_item">
							<?php get_template_part('template-parts/single/product'); ?>
						</div>
					</div>
				<?php endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php
get_footer();
?>
<script>
	jQuery(document).ready(function($) {
		$(".product_list_slider").slick({
			slidesToShow: 4,
			slidesToScroll: 2,
			autoplay: false,
			autoplaySpeed: 5000,
			arrows: true,

			responsive: [{
					breakpoint: 1200,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 1,
					},
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1,
					},
				},
			],
		});

		$(".product-gallery").slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: true,
			dots: false,
			infinite: true,
			asNavFor: ".product-thumbnails",
		});

		$(".product-thumbnails").slick({
			slidesToShow: 5,
			slidesToScroll: 1,
			asNavFor: ".product-gallery",
			focusOnSelect: true,
			arrows: false,
			dots: false,
		});
	});
</script>