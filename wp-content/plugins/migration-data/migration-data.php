<?php
/**
 * Plugin Name: Migration data
 * Version: 1.0.0
 * Requires at least: 4.8.0
 * Requires PHP: 7.2
 * Plugin URI: https://trithuctuyetvoi.com/
 * Description: A plugin that shares data between parent and child sites.
 * Author: Long xemer
 * Author URI: https://trithuctuyetvoi.com/author/long-xemer/
 * Network: false
 * Text Domain: migration-data
 * License: GPLv2
 */

function my_plugin_menu_migration()
{
    add_menu_page(
        'Migration Data',
        'Migration Data',
        'manage_options',
        'migration_data_acf',
        'migration_data_acf_export_page',
        'dashicons-migrate'
    );

    add_submenu_page(
        'migration_data_acf',
        'Import Data',
        'Import Data',
        'manage_options',
        'migration_data_acf_import',
        'migration_data_acf_import_page'
    );
}
add_action('admin_menu', 'my_plugin_menu_migration');

function migration_data_acf_export_page()
{
    ?>
    <div class="wrap">
        <h2>Migration Data - Long xemer</h2>

        <!-- Page -->
        <form class="form_select" method="post" action="">
            <?php
            $pages = get_pages();

            if ($pages) {
                ?>
                <label for="selected_page">Select a Page:</label>
                <select name="selected_page" id="selected_page">
                    <option value="">Select Page</option>
                    <?php
                    foreach ($pages as $page) {
                        ?>
                        <option value="<?php echo esc_attr($page->ID); ?>">
                            <?php echo esc_html($page->post_title); ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
                <?php
            }
            ?>
            <input type="submit" name="submit" value="Export">
        </form>

        <!-- Post type -->
        <form class="form_select" method="post" action="">
            <?php
            $post_types = get_post_types(
                array(
                    'public' => true,
                    '_builtin' => false,
                )
            );

            ?>
            <label for="selected_post_type">Select a post type:</label>
            <select name="selected_post_type" id="selected_post_type">
                <option value="">Select Post type</option>
                <?php
                foreach ($post_types as $post_type) {
                    ?>
                    <option value="<?php echo $post_type; ?>">
                        <?php echo $post_type; ?>
                    </option>
                    <?php
                }
                ?>
            </select>

            <input type="submit" name="submit_post_type" value="Export">
        </form>

        <!-- Post type -->
        <?php
        $options = get_fields('option') ?? null;
        if ($options):
            ?>
            <form class="form_select" method="post" action="">
                <label>Export all theme settings</label>
                <input type="submit" name="submit_export_option" value="Export">
            </form>
            <?php
        endif;
        ?>
    </div>

    <style>
        .form_select {
            padding-top: 40px;
        }
    </style>
    <?php

    if (isset($_POST['submit']) && isset($_POST['selected_page'])) {
        $post_id = intval($_POST['selected_page']);
        export_posts_to_xml($post_id);
    }

    if (isset($_POST['submit_post_type']) && isset($_POST['selected_post_type'])) {
        $post_type = $_POST['selected_post_type'];
        export_posts_to_xml($post_type, 'post_type');
    }

    if (isset($_POST['submit_export_option'])) {
        export_posts_to_xml(null, 'option');
    }
}

function migration_data_acf_import_page()
{
    ?>
    <div class="wrap">
        <h2>Import Data - Long xemer</h2>
        <form class="form_select" action="" method="post" enctype="multipart/form-data">
            <label for="xml_file">Select XML File:</label>
            <input type="file" name="xml_file" id="xml_file" accept=".xml">
            <input type="submit" name="submit" value="Import">
        </form>
    </div>

    <style>
        .form_select {
            padding-top: 40px;
        }
    </style>
    <?php

    if (isset($_POST['submit'])) {
        if (isset($_FILES['xml_file']) && $_FILES['xml_file']['error'] === UPLOAD_ERR_OK) {
            $temp_file = $_FILES['xml_file']['tmp_name'];
            import_posts_from_xml($temp_file);
            unlink($temp_file);
        } else {
            echo 'Please select a valid XML file.';
        }
    }
}

// Hàm xuất bài viết thành XML
function export_posts_to_xml($id = null, $type = null)
{
    // Get the absolute path to the uploads folder
    $uploads_dir = wp_upload_dir();
    $absolute_path = $uploads_dir['basedir'];

    // Check and create the directory if it doesn't exist
    $export_dir = $absolute_path . '/exports';
    if (!file_exists($export_dir)) {
        mkdir($export_dir);
    }

    // Create an absolute path to the XML file
    $export_path = $export_dir . '/exported_posts.xml';
    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><posts></posts>');

    $posts = [];
    if ($type == 'post_type') {
        $posts = get_posts(
            array(
                'post_type' => $id,
                'numberposts' => -1,
            )
        );
    } elseif ($type == 'option') {
        $xml = new SimpleXMLElement('<settings></settings>');
        $options = get_fields('option') ?? null;

        if ($options) {
            $xml->addChild('posttype', 'option');
            $xml->addChild('data', json_encode($options));
        }
    } else {
        if ($id) {
            $posts[] = get_post($id);
        }
    }

    if ($posts) {
        foreach ($posts as $post) {
            $post_node = $xml->addChild('post');
            $post_node->addChild('id', $post->ID);
            $post_node->addChild('title', get_the_title($post->ID));
            $post_node->addChild('content', $post->post_content);
            $post_node->addChild('posttype', get_post_type($post->ID));

            if (function_exists('pll_get_post_language')) {
                $post_language = pll_get_post_language($post->ID);

                if ($post_language) {
                    $post_node->addChild('postlang', $post_language);
                }
            }

            // Take all the meta data fields of the article
            $post_meta = get_post_meta($post->ID);
            $postmeta_node = $post_node->addChild('postmeta');
            foreach ($post_meta as $meta_key => $meta_value) {
                $postmeta_node->addChild($meta_key, htmlspecialchars($meta_value[0]));
            }
        }
    }

    // Save XML to file
    $xml->asXML($export_path);

    // Export the path to the exported file
    echo '<br>Exported posts to XML successfully. Download the file <a target="_blank" download="exported_posts.xml" href="' . esc_url($uploads_dir['baseurl'] . '/exports/exported_posts.xml') . '">HERE</a>.';
}


function import_posts_from_xml($xml_file_path)
{
    // Check if the file exists
    if (!file_exists($xml_file_path)) {
        echo 'File does not exist.';
        return false;
    }

    // Read XML content from file
    $xml_content = file_get_contents($xml_file_path);
    $xml = simplexml_load_string($xml_content);

    // Loop through each post in XML
    if ($xml->post) {
        foreach ($xml->post as $post_data) {
            $post_title = (string) $post_data->title;
            $post_content = (string) $post_data->content;
            $post_lang = (string) $post_data->postlang ?? null;
            $post_type = (string) $post_data->posttype ?? 'post';

            // Post data
            $post_data_array = array(
                'post_title' => $post_title,
                'post_content' => $post_content,
                'post_status' => 'publish',
                'post_type' => $post_type,
            );

            // Add posts to WordPress
            $post_id = wp_insert_post($post_data_array);

            // Notification
            if ($post_id) {

                $postmeta_data_json = json_encode($post_data->postmeta);
                $postmeta_data_array = json_decode($postmeta_data_json, true);

                if ($post_lang && function_exists('pll_set_post_language')) {
                    pll_set_post_language($post_id, $post_lang);
                }

                // Add postmeta to the newly created post
                foreach ($postmeta_data_array as $meta_key => $meta_value) {
                    if ($meta_key == 'flexible_content') {
                        $meta_value = unserialize($meta_value);
                    }
                    update_post_meta($post_id, $meta_key, $meta_value);
                }

                echo 'Post added successfully: ' . $post_title . '<br>';
            } else {
                echo 'Failed to add post: ' . $post_title . '<br>';
            }
        }
    } else {
        if ($xml->posttype && $xml->posttype == 'option' && $xml->data) {
            $array = json_decode($xml->data);

            if ($array) {
                update_theme_options($array);
                echo 'Update options successfully';
            }
        }
    }

    return true;
}

function update_theme_options($options_array)
{
    if ($options_array && is_array($options_array)) {
        $current_options = get_fields('option');
        if (!$current_options) {
            $current_options = array();
        }
        $updated_options = array_merge_recursive($current_options, $options_array);
        update_field('option', $updated_options, 'option');
    }
}