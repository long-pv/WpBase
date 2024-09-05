<?php
function export_data_csv($column_title = [], $data = [])
{
    // Delete cached html
    ob_clean();

    $current_time = date("Y-m-d H:i:s"); // get the current time
    $output_filename = 'export_data_' . $current_time . '.csv';
    $output_handle = @fopen('php://output', 'w');
    fwrite($output_handle, "\xEF\xBB\xBF"); // display Vietnamese text
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header('Content-Type: text/x-csv; charset=utf-8');
    header('Content-Disposition: attachment;filename=' . $output_filename);

    // Create CSV file and write data
    $column_title = (array) $column_title; // array ['column 1', 'column 2']
    $data = (array) $data; // 2D array [['Title 1', 'Content 1'], ['Title 2', 'Content 2']]

    fputcsv(
        $output_handle,
        $column_title
    );

    foreach ($data as $item) {
        // Handle logic if any


        // Add value to each row in csv sheet
        fputcsv(
            $output_handle,
            $item
        );
    }

    // Close output file stream
    fclose($output_handle);

    die();
}