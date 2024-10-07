<?php
function load_more_posts()
{
    // get number page
    $paged = !empty($_POST['page']) ? intval($_POST['page']) + 1 : 1;

    // get posts_per_page
    $posts_per_page = !empty($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : get_option('posts_per_page');

    // get post type
    $post_type = !empty($_POST['post_type']) ? $_POST['post_type'] : 'post';

    // query
    $query = new WP_Query(array(
        'post_type' => $post_type,
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
    ));

    // data element html
    if ($query->have_posts()):
        while ($query->have_posts()):
            $query->the_post(); ?>
            <div class="col-md-6 col-lg-4 mb-3">
                <?php get_template_part('template-parts/single/post'); ?>
            </div>
        <?php endwhile;
    else:
        wp_send_json_error('No more posts');
    endif;

    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_nopriv_load_more', 'load_more_posts');
add_action('wp_ajax_load_more', 'load_more_posts');

// handle script call ajax
function add_load_more_script()
{
    if (!is_admin()):
        ?>
        <!-- Button load more -->
        <div id="ajax-loader" style="display: none;">
            <div class="spinner"></div>
        </div>

        <style>
            #ajax-loader {
                position: fixed;
                top: 0px;
                left: 0px;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1000;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .spinner {
                border: 4px solid #f3f3f3;
                border-top: 4px solid #3498db;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
        </style>

        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('.load_more').on('click', function () {
                    // get data button
                    var button = $(this);
                    var page = button.data('page') ?? 1;
                    var posts_per_page = button.data('posts_per_page') ?? 1;
                    var post_type = button.data('post_type') ?? 'post';
                    var text_btn = button.text();

                    // Prevent multiple clicks
                    if (button.hasClass('loading')) {
                        return false;
                    }

                    // Add class 'loading' and disable button
                    button.addClass('loading');
                    button.prop('disabled', true);

                    // call ajax request
                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        type: 'POST',
                        data: {
                            page: page,
                            post_type: post_type,
                            posts_per_page: posts_per_page,
                            action: 'load_more'
                        },
                        beforeSend: function () {
                            button.text('Loading...');
                            $("#ajax-loader").show();
                        },
                        success: function (data) {
                            if (data) {
                                $('#post-list').append(data);
                                button.data('page', page + 1);
                            } else {
                                alert('No more posts');
                            }

                            // data mh active
                            $('.singlePost__title').matchHeight();
                        },
                        error: function () {
                            alert('Error loading posts');
                        },
                        complete: function () {
                            button.text(text_btn);
                            button.prop('disabled', false);
                            button.removeClass('loading');
                            $("#ajax-loader").hide();
                        },
                    });
                });
            });
        </script>
        <!-- end -->
        <?php
    endif;
}
add_action('wp_footer', 'add_load_more_script', 99);