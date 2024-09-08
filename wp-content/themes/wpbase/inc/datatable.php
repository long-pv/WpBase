<?php
function data_table_scripts()
{
    wp_enqueue_style('basetheme-style-dataTable', get_template_directory_uri() . '/assets/inc/dataTables/dataTables.css', array(), _S_VERSION);
    wp_enqueue_script('basetheme-script-dataTable', get_template_directory_uri() . '/assets/inc/dataTables/dataTables.js', array(), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'data_table_scripts');

function add_custom_data_table_script()
{
    if (!is_admin()) {
        ?>
        <!-- dataTable -->
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('.dataTable[data-table]').each(function () {
                    let $dataTable = $(this);
                    let settings = $dataTable.data('table') || {};
                    console.log(settings)
                    $dataTable.DataTable(settings);
                });
            });
        </script>
        <!-- end -->
        <?php
    }
}
add_action('wp_footer', 'add_custom_data_table_script', 99);

function render_table($heading = [], $rows = [], $options = [], $selector = '')
{
    if ($heading && $rows):
        echo '<table class="dataTable ' . $selector . '" data-table=\'' . json_encode($options) . '\'>';
        ?>
        <thead>
            <tr>
                <?php foreach ($heading as $item): ?>
                    <th>
                        <span><?php echo $item; ?></span>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($rows as $row):
                ?>
                <tr>
                    <?php
                    foreach ((array) $row as $key => $item):
                        ?>
                        <td data-label="<?php echo $heading[$key]; ?>">
                            <?php echo $item; ?>
                        </td>
                        <?php
                    endforeach;
                    ?>
                </tr>
                <?php
            endforeach;
            ?>
        </tbody>
        <?php
        echo '</table>';
    endif;
}

// ví dụ
// $heading = [
//     'Tiêu đề',
//     'Mô tả'
// ];

// $rows = [
//     [
//         'Lorem ipsum odor amet, consectetuer adipiscing elit.',
//         'Taciti velit scelerisque nostra sit ante; dictum elit pulvinar. Suscipit facilisis venenatis tincidunt, dictum sodales lobortis.'
//     ],
//     [
//         'Egestas sit platea semper aenean eleifend habitasse nibh felis erat.',
//         'Malesuada himenaeos interdum; dictumst natoque aenean parturient. Consequat habitant est diam, sagittis pretium in? Porta commodo turpis fusce sem aptent torquent ante?'
//     ],
//     [
//         'Magnis taciti justo vulputate adipiscing class; sollicitudin pretium justo.',
//         'Magnis est molestie dictum finibus rhoncus et parturient. Habitasse aenean lobortis; proin ex litora pharetra purus fames. Neque egestas molestie etiam quisque faucibus; nisl dapibus taciti. '
//     ],
// ];

// $options = [
//     'rowReorder' => true,
//     'searching' => false,
//     'paging' => false,
//     'ordering' => false,
//     'info' => false,
//     'autoWidth' => false,
//     'responsive' => true,
// ];

// render_table($heading, $rows, $options);