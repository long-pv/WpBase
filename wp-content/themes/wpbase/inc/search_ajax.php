<?php
function add_custom_search_ajax_script()
{
    if (!is_admin()) {
        ?>
        <!-- search ajax -->
        <style>
            :root {
                --search-ajax-border: #c0c0c0;
            }

            .seachAjax {
                position: relative;
                display: inline-block;
            }

            .seachAjax__input {
                outline: none;
                width: 150px;
                height: 32px;
                padding: 12px;
                border-radius: 8px;
                border: 1px solid var(--search-ajax-border);
                font-size: 14px;
            }

            .seachAjax__result {
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                max-height: 200px;
                overflow-y: auto;
                background-color: white;
                z-index: 1000;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                font-size: 12px;
            }

            .seachAjax__result ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .seachAjax__result li {
                padding: 8px;
                cursor: pointer;
                border-bottom: 1px solid var(--search-ajax-border);
            }

            .seachAjax__result li:hover {
                transition: all 0.5s;
            }

            .seachAjax__clear {
                position: absolute;
                top: 10px;
                right: 10px;
                width: 12px;
                height: 12px;
                background-position: center center;
                background-repeat: no-repeat;
                background-size: contain;
                display: inline-flex;
                background-image: url("data:image/svg+xml,%3Csvg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M18 6L6 18' stroke='%23333333' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' /%3E%3Cpath d='M6 6L18 18' stroke='%23333333' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' /%3E%3C/svg%3E");
            }
        </style>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                var input_search = $('.seachAjax__input');

                // Add an event listener that triggers on each input in the search field.
                input_search.on('input', function () {
                    let query = $(this).val();
                    query = query.replace(/<[^>]*>?/gm, '');
                    query = query.replace(/[^a-zA-Z0-9\s]/g, '');
                    $(this).val(query);
                    let input_result = $(this).parents('.seachAjax').find('.seachAjax__result');

                    if (query.length > 0) {
                        $.ajax({
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            type: 'POST',
                            data: {
                                action: 'search_suggestions',
                                query: query
                            },
                            success: function (response) {
                                input_result.html(response);
                            },
                            error: function () {
                                input_result.html('');
                            },
                        });
                    } else {
                        input_result.html('');
                    }
                });

                $('.seachAjax__clear').on('click', function () {
                    $(this).parents('.seachAjax').find('.seachAjax__input').val('');
                    $(this).parents('.seachAjax').find('.seachAjax__result').html('');
                });
            });
        </script>
        <!-- end -->
        <?php
    }
}
add_action('wp_footer', 'add_custom_search_ajax_script', 99);

// Function to handle AJAX search suggestions
function ajax_search_suggestions()
{
    global $wpdb; // Access the global $wpdb object for database operations

    // Sanitize the search query to prevent XSS attacks and other issues
    $query = sanitize_text_field($_POST['query']);

    // Perform SQL query to get search results
    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT ID, post_title, post_date
        FROM $wpdb->posts
        WHERE post_title LIKE %s
        AND post_status = 'publish'
        AND post_type IN ('post')
        ORDER BY post_date DESC",
            '%' . $wpdb->esc_like($query) . '%'
        )
    );


    // Check if there are results from the query
    if ($results) {
        // Start an unordered list to display search suggestions
        echo '<ul>';
        foreach ($results as $result) {
            $permalink = get_permalink($result->ID);
            $formatted_date = date('d/m/Y', strtotime($result->post_date));

            // Output each result as a list item with a link and occurrence count
            echo '<li>';
            echo '<a target="_blank" href="' . $permalink . '">' . $result->post_title . '</a>';
            echo ' <br>' . $formatted_date;
            echo '</li>';
        }
        // Close the unordered list
        echo '</ul>';
    } else {
        // If no results, display a message indicating no suggestions found
        echo '<ul><li>No suggestions found</li></ul>';
    }

    wp_die();
}
add_action('wp_ajax_search_suggestions', 'ajax_search_suggestions');
add_action('wp_ajax_nopriv_search_suggestions', 'ajax_search_suggestions');

// Function to generate the search input and suggestions container
function custom_search_input_shortcode()
{
    ob_start();
    ?>
    <div class="seachAjax">
        <input class="seachAjax__input" type="text" placeholder="Search...">
        <div class="seachAjax__clear"></div>
        <div class="seachAjax__result"></div>
    </div>
    <?php
    return ob_get_clean(); // Return the buffered content
}
add_shortcode('search_ajax', 'custom_search_input_shortcode');