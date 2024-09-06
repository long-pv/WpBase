<?php
function polylang_dropdown_scripts()
{
    if (function_exists('pll_the_languages')) {
        wp_enqueue_script('basetheme-script-switch_lang', get_template_directory_uri() . '/assets/js/polylang_dropdown.js', array(), _S_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'polylang_dropdown_scripts');

function switch_lang()
{
    if (function_exists('pll_the_languages')):
        ?>
        <div class="switchLang">
            <ul class="switchLang__list">
                <?php
                pll_the_languages(
                    array(
                        'show_flags' => 1,
                        'show_names' => 0,
                        'hide_if_empty' => 0,
                        'display_names_as' => 'slug',
                    )
                );
                ?>
            </ul>
        </div>
        <?php
    endif;
}