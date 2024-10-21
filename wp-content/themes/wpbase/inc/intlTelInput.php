<?php
function intlTelInput_scripts()
{
    // intlTelInput
    wp_enqueue_style('basetheme-style-intlTelInput', get_template_directory_uri() . '/assets/inc/intlTelInput/intlTelInput.css', array(), _S_VERSION);
    wp_enqueue_script('basetheme-script-intlTelInput', get_template_directory_uri() . '/assets/inc/intlTelInput/intlTelInput.js', array(), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'intlTelInput_scripts');

function add_custom_intlTelInput_script()
{
    if (!is_admin()) {
        ?>
        <!-- input html -->
        <input type="text" id="phone" name="phone">

        <div class="seclect_country">
            <input type="text" id="country" name="country">
        </div>

        <!-- script -->
        <script>
            // Hàm khởi tạo intlTelInput cho các trường nhập số điện thoại
            function initIntlTelInput(selector) {
                var inputs = document.querySelectorAll(selector);
                inputs.forEach(function (input) {
                    const mobile_phone_val = window.intlTelInput(input, {
                        initialCountry: "us",
                        strictMode: true,
                        utilsScript: "<?php echo get_template_directory_uri(); ?>/assets/inc/intlTelInput/utils.js",
                    });
                });
            }
            initIntlTelInput('input[name="phone"]');

            // Tạo dropdown cho tất cả các ô input country
            const countryData = window.intlTelInput.getCountryData();
            $('input[name="country"]').each(function () {
                const $hiddenInput = $(this);
                const initialValue = $hiddenInput.val();

                const $select = $("<select>", {
                    name: "country",
                    class: "country-select",
                });

                const $placeholderOption = $("<option>", {
                    value: "",
                    text: "Choose your country",
                    selected: true,
                    disabled: true,
                });
                $select.append($placeholderOption);

                $.each(countryData, function (index, country) {
                    const $option = $("<option>", {
                        value: country.iso2,
                        text: country.name,
                    });

                    if (country.iso2 === initialValue) {
                        $option.prop("selected", true);
                    }

                    $select.append($option);
                });

                $hiddenInput.before($select);
                $hiddenInput.hide();

                if (!initialValue) {
                    $select.addClass("is-placeholder");
                    $hiddenInput.val("");
                }

                $select.on("change", function () {
                    const selectedValue = $(this).val();
                    if (selectedValue) {
                        $(this).removeClass("is-placeholder");
                    } else {
                        $(this).addClass("is-placeholder");
                    }
                    $hiddenInput.val(selectedValue);
                });
            });
        </script>
        <?php
    }
}
add_action('wp_footer', 'add_custom_intlTelInput_script', 99);
