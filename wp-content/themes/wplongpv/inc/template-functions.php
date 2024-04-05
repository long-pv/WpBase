<?php
// Setup theme setting page
if (function_exists('acf_add_options_page')) {
    $name_option = 'Theme Setting';
    acf_add_options_page(
        array(
            'page_title' => $name_option,
            'menu_title' => $name_option,
            'menu_slug' => 'theme-general-settings',
            'capability' => 'edit_posts',
            'redirect' => false
        )
    );
}

// save ACF local
function custom_acf_json_save_point($path)
{
    return get_template_directory() . '/acf';
}
add_filter('acf/settings/save_json', 'custom_acf_json_save_point');

// The function "write_log" is used to write debug logs to a file in PHP.
function write_log($log = null, $title = 'Debug')
{
    if ($log) {
        if (is_array($log) || is_object($log)) {
            $log = print_r($log, true);
        }

        $timestamp = date('Y-m-d H:i:s');
        $text = '[' . $timestamp . '] : ' . $title . ' - Log: ' . $log . "\n";
        $log_file = WP_CONTENT_DIR . '/debug.log';
        $file_handle = fopen($log_file, 'a');
        fwrite($file_handle, $text);
        fclose($file_handle);
    }
}

// Replacing underscores and dashes with spaces, capitalizing the first letter of each word, and removing spaces.
function custom_name_block($input)
{
    $normalized = str_replace(['_', '-'], ' ', $input);
    $ucwords = ucwords($normalized);
    $formatted = str_replace(' ', '', $ucwords);

    return 'section' . $formatted;
}

// custom text title by character
function custom_title($text = '', $character = true)
{
    if ($character) {
        $text = preg_replace('/\[{(.*?)}\]/', '<span class="character">$1</span>', $text);
    } else {
        $text = str_replace(['[', ']', '{', '}'], '', $text);
    }

    return $text;
}

// block info general information
function block_info($data_block = null)
{
    $html = '';

    if ($data_block) {
        $data = [
            'title' => $data_block['title'] ?? null,
            'desc' => $data_block['description'] ?? null,
            'link' => $data_block['link'] ?? null,
        ];

        $layout = $data_block['display_type'] ?? 'left';

        // render html the section
        if ($data['title'] || $data['desc'] || $data['link']) {
            $html .= ($layout == 'center') ? '<div class="row no-gutters justify-content-center"><div class="col-lg-10">' : '';
            $html .= '<div class="secHeading' . (($layout == 'center') ? ' secHeading--center ' : '') . '">';
            $html .= $data['title'] ? '<h2 class="secTitle secHeading__title wow fadeInUp" data-wow-duration="1s">' . custom_title($data['title']) . '</h2>' : '';
            $html .= $data['desc'] ? '<div class="editor secHeading__desc wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">' . $data['desc'] . '</div>' : '';
            $html .= ($layout == 'left') ? '<div class="wow fadeInUp" data-wow-duration="1s">' . custom_btn_link($data['link'], 'secHeading__link', true) . '</div>' : '';
            $html .= '</div>';
            $html .= ($layout == 'center') ? '</div></div>' : '';
        }
    }

    return $html;
}
// end block info

// block btn link general
function custom_btn_link($link = null, $class = null, $block = false)
{
    $html = '';

    if ($link) {
        // validate link
        $url = !empty($link['url']) ? $link['url'] : 'javascript:void(0);';
        $title = !empty($link['title']) ? $link['title'] : __('See more', 'wplongpv');
        $target = !empty($link['target']) ? $link['target'] : '_self';
        $class_link = !$block ? ($class ? $class : '') : '';

        // renter html
        $html .= $block ? '<div class="wow fadeInUp ' . $class . '" data-wow-duration="1s">' : '';
        $html .= '<a href="' . $url . '" target="' . $target . '" class="btnSeeMore wow fadeInUp ' . $class_link . '" data-wow-duration="1s">';
        $html .= $title;
        $html .= '</a>';
        $html .= $block ? '</div>' : '';
    }

    return $html;
}

// block image link general
function custom_img_link($link = null, $image = null, $class = null, $alt = null)
{
    $html = '';

    if ($image) {
        // validate link
        $url = !empty($link['url']) ? $link['url'] : 'javascript:void(0);';
        $title = !empty($link['title']) ? $link['title'] : __('See more', 'wplongpv');
        $target = !empty($link['target']) ? $link['target'] : '_self';
        $class_img = empty($link['url']) ? ' imgGroup--noEffect cursor-default ' : '';
        $class_img .= $class ?: '';

        // renter html
        $html .= '<a class="imgGroup ' . $class_img . '" href="' . $url . '" target="' . $target . '">';
        $html .= '<img width="300" height="300" src="' . $image . '" alt="' . ($alt ?: $title) . '">';
        $html .= '</a>';
    }

    return $html;
}

// Count the elements that exist in the array to use check
function custom_count_array($array = [], $keys = [], $requireAll = true)
{
    $count = 0;

    foreach ($array as $item) {
        $hasValues = $requireAll;

        foreach ($keys as $key) {
            if ($requireAll) {
                if (empty($item[$key])) {
                    $hasValues = false;
                    break;
                }
            } else {
                if (!empty($item[$key])) {
                    $hasValues = true;
                    break;
                }
            }
        }

        if ($hasValues) {
            $count++;
        }
    }

    return $count;
}

// change hex color code to rgba
function hexToRgb($hex)
{
    $hex = str_replace("#", "", $hex);

    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    return $r . ', ' . $g . ', ' . $b;
}

// Added color selection option
function custom_color_tinymce($options)
{
    $options['textcolor_map'] = json_encode(
        array(
            '134D8B',
            'Primary',
            'C72127',
            'Secondary',
            '2E2E2E',
            'Text body'
        )
    );
    return $options;
}
add_filter('tiny_mce_before_init', 'custom_color_tinymce');

// used for fulltext search
function modify_search_query($query)
{
    if ($query->is_search() && !is_admin()) {
        // get param on url
        $postTypeSearch = 'all';
        if (isset($_GET["post_type"])) {
            $postTypeSearch = $_GET['post_type'];
        }

        // Returns results according to the desired post types
        if ($postTypeSearch == 'event') {
            $query->set('post_type', 'event');
        } else if ($postTypeSearch == 'post') {
            $query->set('post_type', 'post');
        } else if ($postTypeSearch == 'testimonial') {
            $query->set('post_type', 'testimonial');
        } else if ($postTypeSearch == 'leader') {
            $query->set('post_type', 'leader');
        } else {
            $query->set('post_type', ['post', 'event', 'leader', 'testimonial']);
        }
    }

    return $query;
}
add_filter('pre_get_posts', 'modify_search_query', 99, 1);

// Converts date types into a certain format
function custom_convert_time($date_time, $format = "d/m/Y")
{
    $date_time_object = null;

    switch (true) {
        // Format d/m/Y
        case (strpos($date_time, '/') !== false):
            $date_time_object = DateTime::createFromFormat('d/m/Y', $date_time);
            break;
        // Format Ymd
        case (strlen($date_time) === 8 && ctype_digit($date_time)):
            $date_time_object = DateTime::createFromFormat('Ymd', $date_time);
            break;
        // Format Y-m-d
        case (strpos($date_time, '-') !== false):
            $date_time_object = DateTime::createFromFormat('Y-m-d', $date_time);
            break;
        // Format d.m.Y or m.d.Y
        case (strpos($date_time, '.') !== false):
            $date_time_object = DateTime::createFromFormat('d.m.Y', $date_time);
            if (!$date_time_object) {
                $date_time_object = DateTime::createFromFormat('m.d.Y', $date_time);
            }
            break;
        // Format M j, Y or j M Y
        case (preg_match('/^(?:\d{1,2}\s)?(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s\d{4}$/', $date_time)):
            $date_time_object = DateTime::createFromFormat('M j, Y', $date_time);
            if (!$date_time_object) {
                $date_time_object = DateTime::createFromFormat('j M Y', $date_time);
            }
            break;
        // Format j F Y or F j, Y
        case (preg_match('/^(?:\d{1,2}\s)?(?:January|February|March|April|May|June|July|August|September|October|November|December)\s\d{4}$/', $date_time)):
            $date_time_object = DateTime::createFromFormat('j F Y', $date_time);
            if (!$date_time_object) {
                $date_time_object = DateTime::createFromFormat('F j, Y', $date_time);
            }
            break;
    }

    // If there's a date object, format it to the desired format
    if ($date_time_object instanceof DateTime) {
        return $date_time_object->format($format);
    }

    return false;
}

add_action('admin_footer', 'custom_required_featured_image');
function custom_required_featured_image()
{
    global $post_type;

    $post_type_arr = [
        'post',
        'event',
    ];

    if (in_array($post_type, $post_type_arr)) {
        ?>
        <script>
            jQuery(document).ready(function ($) {
                $('label[for="postimagediv-hide"]').remove();

                $('#post').submit(function () {
                    // Check for featured images
                    if ($('#set-post-thumbnail img').length == 0) {
                        // image input area
                        let postimagediv = $('#postimagediv');

                        // Scroll to the image import area
                        $('html, body').animate({
                            scrollTop: postimagediv.offset().top - 100
                        }, 500);

                        // show notification
                        alert('Please enter Featured image.');

                        return false;
                    }
                });

                // If an image is selected, remove the 'error' class
                $('#set-post-thumbnail').on('click', function () {
                    $('#postimagediv').removeClass('error');
                });
            });
        </script>
        <?php
    }
}

/**
 * Add Recommended size image to Featured Image Box
 */
add_filter('admin_post_thumbnail_html', 'add_featured_image_instruction');
function add_featured_image_instruction($html)
{
    $post_type = get_post_type();
    switch ($post_type) {
        case 'post':
            $html .= '<p>Recommended size: 500x310</p>';
            break;
        case 'event':
            $html .= '<p>Recommended size: 500x135</p>';
            break;
        default:
            break;
    }

    return $html;
}

// dump + die()
function dd($data)
{
    echo '<div style="background-color: #c0c0c0; border: 1px solid #ddd; color: #333; padding: 20px; margin: 20px;">';
    echo '<div style="font-size: 20px; font-weight: bold; color: #007bff; margin-bottom: 10px;">Debug Data</div>';
    echo '<div style="font-family: monospace;">';
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    echo '</div>';
    echo '</div>';
    die();
}

function the_url_search()
{
    $search = get_site_url();
    if (pll_default_language() !== LANG) {
        $search = $search . '/' . LANG . '/';
    }

    echo $search;
}

// Required to enter category for article
add_action('admin_footer', 'custom_required_enter_category');
function custom_required_enter_category()
{
    global $post_type;
    if ($post_type == 'post') {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('label[for="categorydiv-hide"]').remove();

                $('#post').submit(function () {
                    if ($('#categorychecklist input[type="checkbox"]:checked').length === 0) {
                        alert('Please enter category.');
                        $('html, body').animate({
                            scrollTop: $('#categorydiv').offset().top - 100
                        }, 'slow');
                        return false;
                    }
                });
            });
        </script>
        <?php
    }

    // Check if it is a new post creation page
    if ($post_type == 'post' && isset($_GET['post']) && $_GET['post'] == 0) {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('#categorychecklist input[type="checkbox"]').prop('checked', false);
            });
        </script>
        <?php
    }
}

function custom_replace_text($text, $arr = null)
{
    if ($text && $arr) {
        $patterns = array_map(function ($key) {
            return '/\b(' . preg_quote($key, '/') . ')\b/i';
        }, array_keys($arr));

        $replacements = array_values($arr);

        $text = preg_replace($patterns, $replacements, $text);

        return $text;
    }

    return false;
}

function custom_filter_by_post_type($post_type)
{
    $taxonomies = get_object_taxonomies($post_type, 'objects');
    $tax_ignore = [
        'language',
        'post_translations',
    ];

    foreach ($taxonomies as $taxonomy) {
        if (in_array($taxonomy->name, $tax_ignore)) {
            continue;
        }

        $terms = get_terms(
            array(
                'taxonomy' => $taxonomy->name,
                'hide_empty' => true,
            )
        );

        if (!empty($terms)) {
            wp_dropdown_categories(
                array(
                    'show_option_all' => __("All {$taxonomy->label}"),
                    'taxonomy' => $taxonomy->name,
                    'name' => "{$taxonomy->name}_filter",
                    'orderby' => 'name',
                    'selected' => isset($_GET["{$taxonomy->name}_filter"]) ? $_GET["{$taxonomy->name}_filter"] : '',
                    'show_count' => false,
                    'hide_empty' => false,
                )
            );
        }
    }
}
add_action('restrict_manage_posts', 'custom_filter_by_post_type');

function custom_filter_by_post_type_query($query)
{
    if (is_admin() && $query->is_main_query() && !empty($_GET['post_type'])) {
        $taxonomies = get_object_taxonomies($_GET['post_type'], 'objects');

        if ($taxonomies) {
            foreach ($taxonomies as $taxonomy) {
                if (!empty($_GET["{$taxonomy->name}_filter"])) {
                    if ($_GET["{$taxonomy->name}_filter"] !== '0') {
                        $query->set(
                            'tax_query',
                            array(
                                array(
                                    'taxonomy' => $taxonomy->name,
                                    'field' => 'term_id',
                                    'terms' => $_GET["{$taxonomy->name}_filter"],
                                ),
                            )
                        );
                    }
                }
            }
        }
    }
}
add_action('pre_get_posts', 'custom_filter_by_post_type_query');