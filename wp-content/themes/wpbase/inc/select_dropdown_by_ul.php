<?php
function select_dropdown_by_ul_scripts()
{
    // select dropdown by ul li
    wp_enqueue_script('basetheme-script-dropdown_ul', get_template_directory_uri() . '/assets/js/select_dropdown_by_ul.js', array(), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'select_dropdown_by_ul_scripts');

// $categories = [
//     ['name' => 'View all', 'url' => '/view-all'],
//     ['name' => 'Blog', 'url' => '/blog', 'active' => true],
//     ['name' => 'News', 'url' => '/news']
// ];
// echo select_ul($categories);
function select_ul($categories = null)
{
    ob_start();
    if ($categories):
        ?>
        <div id="categoryBlock" class="categoryBlock" data-label="Categories:">
            <div class="selectDropdownCat">
                <ul class="categoryBlock__list">
                    <?php foreach ($categories as $category): ?>
                        <?php
                        $name = !empty($category['name']) ? $category['name'] : '';
                        $url = !empty($category['url']) ? $category['url'] : '';
                        $activeClass = !empty($category['active']) && $category['active'] ? 'active' : '';

                        if ($name && $url):
                            ?>
                            <li class="categoryBlock__item <?= $activeClass ?>">
                                <a class="categoryBlock__link <?= $activeClass ?>" href="<?= $url ?>">
                                    <?= $name ?>
                                </a>
                            </li>
                            <?php
                        endif;
                    endforeach;
                    ?>
                </ul>
            </div>
        </div>
        <?php
    endif;
    return ob_get_clean();
}
