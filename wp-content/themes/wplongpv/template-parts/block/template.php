<?php
// Get values
$block_info = $args['flexible']['block_info'] ?? [];
$tex1 = 'Vestibulum sit amet malesuada elit.';
$tex2 = 'Morbi porta ullamcorper pulvinar.';
$arr = ['Sed eget est', 'mollis nulla'];
$url = '';

$test_or = validate_data([$tex1, $tex2, $arr, $url]);
$test_and = validate_data([$tex1, $tex2, $arr, $url], 'and');

if (!validate_data([$tex1, $tex2, $arr, $url]))
    return;
?>
<div class="container">
    <!-- block info -->
    <?php echo block_info($block_info); ?>
    <!-- html code -->
</div>