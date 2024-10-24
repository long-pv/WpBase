<?php
function lpv_datepicker_start_date()
{
    ?>
    <script type="text/javascript">
        (function ($) {
            acf.add_filter('date_picker_args', function (args, $field) {
                var key = $field.data('key');
                if (key == 'field_6719e939598ea' || key == 'field_6719e958598eb') {
                    var today = new Date();
                    today.setHours(0, 0, 0, 0);
                    args['minDate'] = today;
                }
                return args;
            });
        })(jQuery);
    </script>
    <?php
}
add_action('acf/input/admin_footer', 'lpv_datepicker_start_date');

function my_acf_load_repeater_end_date($valid, $value, $field, $input_name)
{
    if ($field['key'] === 'field_6719e920598e9') {
        $index = 1;

        foreach ($value as $row) {
            $start_date = isset($row['field_6719e939598ea']) ? $row['field_6719e939598ea'] : '';
            $end_date = isset($row['field_6719e958598eb']) ? $row['field_6719e958598eb'] : '';

            if ($start_date && $end_date) {
                $end_timestamp = strtotime($end_date);
                $start_timestamp = strtotime($start_date);

                if ($end_timestamp < $start_timestamp) {
                    $valid = 'End date must be greater than or equal to start date (Row ' . $index . ').';
                    break;
                }
            }
            $index++;
        }
    }
    return $valid;
}
add_filter('acf/validate_value/key=field_6719e920598e9', 'my_acf_load_repeater_end_date', 10, 4);