<div class="sidebar-filter">
    <h2>Lọc Sản Phẩm</h2>

    <!-- Form lọc sản phẩm -->
    <form method="GET">

        <!-- Tìm kiếm theo tên -->
        <div class="filter-item">
            <label for="product-search">Tìm kiếm tên sản phẩm</label>
            <input type="text" id="product-search" name="title" placeholder="Nhập tên sản phẩm"
                value="<?php echo isset($_GET['title']) ? esc_attr($_GET['title']) : ''; ?>">
        </div>

        <!-- Lựa chọn danh mục (Radio Button) -->
        <?php if (is_post_type_archive('product')): ?>
            <div class="filter-item">
                <label>Danh mục sản phẩm</label>
                <?php
                $categories = get_terms(array(
                    'taxonomy' => 'product_cat',
                    'hide_empty' => true,
                ));
                foreach ($categories as $category): ?>
                    <div>
                        <input type="radio" id="cat_<?php echo esc_attr($category->slug); ?>" name="product_cat"
                            value="<?php echo esc_attr($category->slug); ?>" <?php checked(isset($_GET['product_cat']) && $_GET['product_cat'] == $category->slug); ?>>
                        <label for="cat_<?php echo esc_attr($category->slug); ?>">
                            <?php echo esc_html($category->name); ?>
                        </label>
                    </div>
                <?php endforeach; ?>
                <div>
                    <input type="radio" id="cat_all" name="product_cat" value="" <?php checked(!isset($_GET['product_cat']) || $_GET['product_cat'] == ''); ?>>
                    <label for="cat_all">Tất cả danh mục</label>
                </div>
            </div>
        <?php endif; ?>

        <?php
        $selected_tags = isset($_GET['product_tags']) ? $_GET['product_tags'] : [];

        $tags = get_terms([
            'taxonomy' => 'product_tag',
            'hide_empty' => false,
        ]);

        if (!empty($tags)):
        ?>
            <div class="product-tags-checkboxes">
                <h3>Chọn tags</h3>
                <?php
                foreach ($tags as $tag):
                    $checked = in_array($tag->term_id, $selected_tags) ? 'checked' : '';
                ?>
                    <label>
                        <input type="checkbox" name="product_tags[]" value="<?php echo esc_attr($tag->term_id); ?>" <?php echo $checked; ?>>
                        <?php echo esc_html($tag->name); ?> 
                        (<?php echo $tag->count ?? 0; ?>)
                    </label>
                    <br>
                <?php
                endforeach;
                ?>
            </div>
        <?php
        endif;
        ?>

        <!-- Khoảng giá (Range Slider) -->
        <div class="price-slider">
            <label for="price-range">Price</label>
            <div id="slider-range-labels">
                <span id="min-label"></span>
                <span id="max-label"></span>
            </div>
            <div id="slider-range" data-min="0" data-max="1000"></div>
            <div class="price-range-inputs">
                <input type="hidden" id="min-price" name="min_price"
                    value="<?php echo isset($_GET['min_price']) ? $_GET['min_price'] : '0'; ?>">
                <input type="hidden" id="max-price" name="max_price"
                    value="<?php echo isset($_GET['max_price']) ? $_GET['max_price'] : '1000'; ?>">
            </div>
        </div>


        <?php
        // Lấy danh sách các thuộc tính
        $attributes = wc_get_attribute_taxonomies();

        if (!empty($attributes)): ?>
            <div class="product-attributes-filter">
                <h3>Chọn thuộc tính</h3>
                <?php foreach ($attributes as $attribute): ?>
                    <?php
                    $terms = get_terms(array(
                        'taxonomy' => 'pa_' . $attribute->attribute_name,
                        'hide_empty' => false,
                    ));
                    ?>
                    <?php if (!empty($terms)): ?>
                        <h4><?php echo esc_html($attribute->attribute_label); ?></h4>
                        <div class="attribute-checkboxes">
                            <?php foreach ($terms as $term): ?>
                                <label>
                                    <input type="checkbox" name="product_attributes[]" value="<?php echo esc_attr($term->term_id); ?>"
                                        <?php echo (isset($_GET['product_attributes']) && in_array($term->term_id, $_GET['product_attributes'])) ? 'checked' : ''; ?>>
                                    <?php echo esc_html($term->name); ?>
                                    (<?php echo $term->count ?? 0; ?>)
                                </label>
                                <br>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Nút Submit -->
        <button type="submit" class="button">Áp dụng bộ lọc</button>
        <?php
        $reset_url = esc_url(remove_query_arg(array('title', 'product_cat', 'min_price', 'max_price', 'product_tags')));
        ?>
        <a href="<?php echo $reset_url; ?>" class="button" id="reset-filters">
            Reset bộ lọc
        </a>
    </form>
</div>