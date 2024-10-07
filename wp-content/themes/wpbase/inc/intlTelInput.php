<?php
function add_custom_intlTelInput_script()
{
    if (!is_admin()) {
        ?>
        <!-- input html -->
        <input type="text" id="phone">

        <!-- script -->
        <script>
            const input = document.querySelector("#phone");
            window.intlTelInput(input, {
                initialCountry: "us",
                strictMode: true,
                utilsScript: "<?php echo get_template_directory_uri(); ?>/assets/inc/intlTelInput/utils.js",
            });
        </script>
        <?php
    }
}
add_action('wp_footer', 'add_custom_intlTelInput_script', 99);
