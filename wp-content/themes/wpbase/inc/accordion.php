<?php
// $data = [
//     [
//         'title' => 'tiêu đề 1',
//         'content' => 'nội dung 1'
//     ],
// ];
// accordion($data);

function accordion($data = [])
{
    if ($data):
        $key_id = mt_rand(1000, 9999);
        $accordion_id = 'accordion_' . $key_id;
        $index = 1;
        ?>
        <div class="accordion" id="<?php echo $accordion_id; ?>">
            <?php
            foreach ($data as $key => $item):
                if ($item['title'] && $item['content']):
                    $collapse = 'collapse_' . $key_id . '_' . $key;
                    $heading = 'heading_' . $key_id . '_' . $key;
                    $expanded = ($index == 1) ? 'true' : 'false';
                    $attr_button = 'type="button" data-toggle="collapse" data-target="#' . $collapse . '" aria-controls="' . $collapse . '"';
                    $attr_collapse = 'id="' . $collapse . '" aria-labelledby="' . $heading . '" data-parent="#' . $accordion_id . '"';
                    ?>
                    <div class="accordion__item">
                        <div class="accordion__header" id="<?php echo $heading; ?>">
                            <button class="accordion__btn" aria-expanded="<?php echo $expanded; ?>" <?php echo $attr_button; ?>>
                                <?php echo $item['title']; ?>
                            </button>
                        </div>

                        <div class="collapse <?php echo ($index == 1) ? 'show' : ''; ?>" <?php echo $attr_collapse; ?>>
                            <div class="accordion__body editor">
                                <?php echo $item['content']; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    $index++;
                endif;
            endforeach;
            ?>
        </div>
        <?php
    endif;
}