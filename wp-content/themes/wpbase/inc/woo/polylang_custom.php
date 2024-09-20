<?php 
function add_polylang_custom_lang() {
    if ( !is_admin() ) {
        ?>
        <!-- custom lang -->
        <script type="text/javascript">
            function setCookie(name, value, expireDays, path) {
                var expireDate = new Date();
                expireDate.setDate(expireDate.getDate() + expireDays);
                var cookieValue = encodeURIComponent(name) + "=" + encodeURIComponent(value) + ";expires=" + expireDate.toUTCString() + ";path=" + path;
                document.cookie = cookieValue;
            }

            var currentUrl = window.location.href;
            if (currentUrl.indexOf('/vi/') !== -1) {
                setCookie('clang', 'vi', 30, '/');
            } else {
                setCookie('clang', 'en', 30, '/');
            }
        </script>
        <!-- end -->
        <?php
    }
}
add_action('wp_head', 'add_polylang_custom_lang');