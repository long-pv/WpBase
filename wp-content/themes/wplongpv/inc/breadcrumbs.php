<?php
/**
 * Breadcrumbs
 */
function wp_breadcrumbs()
{
	$breadcrumb_page = get_field('br_' . LANG, 'option') ?? null;
	$delimiter = '<span class="icon"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
	<path d="M6.6665 11.3333L9.72861 8.58922C10.0902 8.26515 10.0902 7.73485 9.72861 7.41077L6.6665 4.66666" stroke="#818181" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
	</svg>
	</span>';

	$home = __('Home', 'wplongpv');
	$before = '<span class="current">';
	$after = '</span>';
	if (!is_home() && !is_front_page() || is_paged()) {
		echo '<div class="breadcrumbs">';
		global $post;
		$homeLink = get_bloginfo('url');
		echo '<a href="' . $homeLink . '">' . $home . '</a>' . $delimiter . ' ';

		if (is_category()) {
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$thisCat = $cat_obj->term_id;
			$thisCat = get_category($thisCat);
			$parentCat = get_category($thisCat->parent);

			if ($thisCat->parent != 0) {
				echo (get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
			}

			if ($breadcrumb_page && $breadcrumb_page['page_news_events']) {
				if (isset($breadcrumb_page['page_news_events']->post_parent)) {
					echo generateBreadcrumbsParent($breadcrumb_page['page_news_events']->post_parent, $delimiter);
				}
				echo bread_posts($breadcrumb_page['page_news_events'], $delimiter);
			}

			echo $before . single_cat_title('', false) . $after;
		} elseif (is_archive()) {
			if (is_post_type_archive('event')) {
				if ($breadcrumb_page && $breadcrumb_page['page_news_events']) {
					if (isset($breadcrumb_page['page_news_events']->post_parent)) {
						echo generateBreadcrumbsParent($breadcrumb_page['page_news_events']->post_parent, $delimiter);
					}
					echo bread_posts($breadcrumb_page['page_news_events'], $delimiter);
				}
			}

			echo $before . post_type_archive_title('', false) . $after;
		} elseif (is_single() && !is_attachment()) {
			$post_type = get_post_type(get_the_ID());

			if (in_array($post_type, ['post', 'event']) && $breadcrumb_page && $breadcrumb_page['page_news_events']) {
				if (isset($breadcrumb_page['page_news_events']->post_parent)) {
					echo generateBreadcrumbsParent($breadcrumb_page['page_news_events']->post_parent, $delimiter);
				}
				echo bread_posts($breadcrumb_page['page_news_events'], $delimiter);

				if ($post_type == 'post') {
					$post_category = get_the_category(get_the_ID());

					if ($post_category) {
						$first_post_category = $post_category[0];
						echo '<a href="' . get_category_link($first_post_category) . '">' . ucfirst($first_post_category->name) . '</a>' . $delimiter . ' ';
					}
				} elseif ($post_type == 'event') {
					echo '<a href="' . get_post_type_archive_link($post_type) . '">' . ucfirst($post_type) . '</a>' . $delimiter . ' ';
				}
			}

			if ($post_type == 'student_life') {
				$id_page = get_field('student_life_' . LANG, 'option') ?? null;
				if ($id_page) {
					echo '<a href="' . get_permalink($id_page) . '">' . __('Student Life', 'wplongpv') . '</a>' . $delimiter . ' ';
				}
			} elseif ($post_type == 'global_exchange') {
				$id_page = get_field('global_exchange_' . LANG, 'option') ?? null;
				if ($id_page) {
					echo '<a href="' . get_permalink($id_page) . '">' . __('Global exchange', 'wplongpv') . '</a>' . $delimiter . ' ';
				}
			}

			echo $before . get_the_title() . $after;
		} elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404() && !is_search()) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;
		} elseif (is_attachment()) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID);
			$cat = $cat[0];
			echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
			echo '<a href="' . get_permalink($parent) . '">' . custom_title($parent->post_title, false) . '</a>' . $delimiter . ' ';
			echo $before . custom_title(get_the_title(), false) . $after;
		} elseif (is_page() && !$post->post_parent) {
			echo $before . custom_title(get_the_title(), false) . $after;
		} elseif (is_page() && $post->post_parent) {
			$parent_id = $post->post_parent;
			echo generateBreadcrumbsParent($parent_id, $delimiter);
			echo $before . custom_title(get_the_title(), false) . $after;
		} elseif (is_search()) {
			echo $before . 'Search' . $after;
		} elseif (is_tag()) {
			echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
		} elseif (is_404()) {
			echo $before . 'Error 404' . $after;
		} elseif (get_query_var('paged')) {
			if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
				echo ' (';
			echo __('Page') . ' ' . get_query_var('paged');
			if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
				echo ')';
		}
		echo '</div>';
	}
} // end wp_breadcrumbs()

// breadcrumbs for each post
function bread_posts($breadcrumb = [], $delimiter)
{
	$string = '';
	if ($breadcrumb && $breadcrumb->post_title) {
		$label = custom_title($breadcrumb->post_title, false);
		$link = $breadcrumb->guid;

		$string = '<a href="' . $link . '">' . $label . '</a>' . $delimiter . ' ';
	}

	return $string;
}

// Generate breadcrumbs ancestor page
function generateBreadcrumbsParent($parent_id, $delimiter)
{
	$breadcrumbs = array();

	while ($parent_id) {
		$page = get_post($parent_id);
		$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . custom_title(get_the_title($page->ID), false) . '</a>';
		$parent_id = $page->post_parent;
	}

	$breadcrumbs = array_reverse($breadcrumbs);

	$output = '';
	foreach ($breadcrumbs as $crumb) {
		$output .= $crumb . $delimiter;
	}

	return rtrim($output);
}