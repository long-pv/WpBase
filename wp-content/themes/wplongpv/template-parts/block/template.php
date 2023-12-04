<?php
// Get values
$title = $args['flexible']['title'] ?? '';
$content = $args['flexible']['content'] ?? '';

// Validate data
$validate = 'true';
$validate .= $title ? '-true' : '-false';
$validate .= $content ? '-true' : '-false';

// Build UI
if (strpos($validate, 'false'))
    return;
?>

<!-- html code -->