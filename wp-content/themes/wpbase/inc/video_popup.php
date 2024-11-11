<?php
function add_custom_video_popup_script()
{
    if (!is_admin()) {
?>
        <!-- modal video -->
        <div class="modal modalVideo fade" id="videoUrl" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close modalVideo__video" data-dismiss="modal" aria-label="Close">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 18L18 6" stroke="#333333" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M18 18L6 6" stroke="#333333" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>

                    <div class="modal-body p-0">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="" id="video" allowscriptaccess="always"
                                allow="autoplay"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                if ($("#videoUrl").length) {
                    let videoSrc = "";
                    let videoId = $("#video");
                    let videoUrl = $("#videoUrl");

                    // Add click event for each .videoBlock__playAction
                    $(document).on("click", ".videoBlock__playAction", function(e) {
                        e.preventDefault();
                        videoSrc = $(this).data("src");
                    });

                    videoUrl.on("shown.bs.modal", function(e) {
                        videoId.attr("src", videoSrc + "?autoplay=1&mute=1&modestbranding=1&showinfo=0");
                    });

                    videoUrl.on("hide.bs.modal", function(e) {
                        videoId.attr("src", "");
                        videoSrc = "";
                    });
                }
            });
        </script>
        <!-- end -->
    <?php
    }
}
add_action('wp_footer', 'add_custom_video_popup_script', 99);

function video_popup($src_iframe, $thumb = null)
{
    $url = getYoutubeEmbedUrl($src_iframe);
    ?>
    <div class="videoBlock">
        <div class="videoBlock__inner" style="background-image: url('<?php echo img_url($thumb); ?>');">
            <div class="videoBlock__overlay"></div>
            <div class="videoBlock__videoAction">
                <a href="javascript:void(0);" class="videoBlock__playAction" data-toggle="modal" data-target="#videoUrl"
                    data-src="<?php echo $url; ?>">
                    <?php _e('Xem thêm', 'basetheme'); ?>
                </a>
            </div>
        </div>
    </div>
<?php
}

function getYoutubeEmbedUrl($input)
{
    // Case 1: If the input is a direct URL (starting with https://)
    if (filter_var($input, FILTER_VALIDATE_URL)) {
        return $input; // Return the URL as is
    }

    // Case 2: If the input is an HTML string containing an iframe
    // Use regex to find the value of the src attribute
    if (preg_match('/<iframe.*?src="([^"]+)".*?>/i', $input, $matches)) {
        return $matches[1]; // Return the URL found in the src attribute of the iframe
    }

    // If neither case, return null or an error message
    return NO_IMAGE;
}
