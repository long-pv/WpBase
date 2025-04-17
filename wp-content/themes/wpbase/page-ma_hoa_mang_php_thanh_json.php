<?php

/**
 * Template name: Mã hóa mảng php thành json
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package basetheme
 */

get_header();

$array = [
    'start_date_format' => '01/05/2025',
    'end_date_format' => '10/05/2025',
    'start_date' => '2025-05-01',
    'end_date' => '2025-05-10',
    'price_added' => 50000
];

$json_value = json_encode($array);
$json_value = htmlspecialchars($json_value, ENT_QUOTES, 'UTF-8');
?>
<div class="py-section">
    <div class="container">
        <input type="text" name="php_to_json" value="<?php echo $json_value; ?>" autocomplete="off">
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        var php_to_json = $('input[name="php_to_json"]').val();
        if (php_to_json) {
            php_to_json = JSON.parse(php_to_json);
            date_start = php_to_json.start_date;
            console.log(date_start);
        }
    });
</script>
<?php
get_footer();
