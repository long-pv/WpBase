<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package basetheme
 */

?>
</main>
<!-- end main body -->

<!-- footer -->
<footer id="footer" class="footer secSpace">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-4 mb-3 mb-lg-0">
                <div class="footer__logo">
                    <img src="<?php echo get_template_directory_uri() . '/assets/images/logo_white.svg'; ?>" alt="logo">
                </div>
                <?php
                $introduce = get_field('introduce', 'option');
                if ($introduce):
                ?>
                    <div class="footer__intro">
                        <?php echo $introduce; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <?php
                if (get_field('iframe_google_map', 'option')):
                ?>
                    <div class="video">
                        <?php echo get_field('iframe_google_map', 'option'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (get_field('copyright', 'option')): ?>
            <div class="copyright mt-4 text-center">
                <?php echo get_field('copyright', 'option'); ?>
            </div>
        <?php endif; ?>
    </div>
</footer>
<!-- end footer -->

<?php wp_footer(); ?>

<script>
    (function() {
        // URL ảnh mồi trên CHÍNH site của bạn. Hãy chắc chắn file tồn tại để tránh nhầm 404.
        var BAIT_IMG = "/wp-content/uploads/2024/09/Logo.svg";

        function goHome() {
            alert("Please disable ad blocker to avoid affecting payment.");
            location.reload();
        }

        function checkScriptBlocked() {
            return new Promise(function(resolve) {
                var s = document.createElement("script");
                s.async = true;
                // dummy client, chỉ để test bị chặn
                s.src = "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-0000000000000000";
                s.crossOrigin = "anonymous";
                var done = false;
                s.onload = function() {
                    if (!done) {
                        done = true;
                        resolve(false);
                    }
                }; // không bị chặn
                s.onerror = function() {
                    if (!done) {
                        done = true;
                        resolve(true);
                    }
                }; // bị chặn (Cốc Cốc thường vào đây)
                // timeout phòng trường hợp treo
                setTimeout(function() {
                    if (!done) {
                        done = true;
                        resolve(false);
                    }
                }, 1500);
                document.head.appendChild(s);
            });
        }

        function checkImageBlocked() {
            return new Promise(function(resolve) {
                var img = new Image();
                var finished = false;

                function done(v) {
                    if (!finished) {
                        finished = true;
                        resolve(v);
                    }
                }
                var to = setTimeout(function() {
                    done(false);
                }, 1500); // quá hạn: coi như không bị chặn
                img.onload = function() {
                    clearTimeout(to);
                    done(false);
                }; // tải OK
                img.onerror = function() {
                    clearTimeout(to);
                    done(true);
                }; // bị chặn (hoặc không tồn tại)
                img.src = BAIT_IMG + (BAIT_IMG.includes("?") ? "&" : "?") + "t=" + Date.now();
            });
        }

        function run() {
            Promise.allSettled([checkScriptBlocked(), checkImageBlocked()]).then(function(rs) {
                var blocked = rs.some(function(r) {
                    return r.status === "fulfilled" && r.value === true;
                });
                if (blocked) goHome();
            });
        }

        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", run, {
                once: true
            });
        } else {
            run();
        }
    })();
</script>


</body>

</html>