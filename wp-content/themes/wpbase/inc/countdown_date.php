<?php 
function add_countdown_date_script()
{
    if (!is_admin()) {
        ?>
        <!-- count down time -->
        <style>
            .countDown {
                display: flex;
                gap: 10px;
                margin-bottom: 16px;
            }
            .countDown__item {
                background: #0088ff;
                flex: 1;
                text-align: center;
                color: #fff;
            }
            .countDown__item > p {
                text-transform: uppercase;
                background: #0069ff;
                padding: 8px;
                margin: 0px;
            }
            .countDown__item > span {
                display: block;
                height: 125px;
                font-size: 50px;
                line-height: 125px;
            }
        </style>

        <script type="text/javascript">
            $(document).ready(function(){

                $('.countDown').each(function() {
                    let this_el = $(this);

                    // Set the countdown date
                    let date = this_el.data('date');
                    var countDownDate = new Date(date).getTime();

                    // Update the count down every 1 second
                    let x = setInterval(function() {
                        // Get the current time
                        let now = new Date().getTime();

                        // Find the distance between current time and the count down date
                        let distance = countDownDate - now;

                        // Time calculations for days, hours, minutes and seconds
                        let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // Display the result in the corresponding elements
                        this_el.find('.countDown__days').text(days < 10 ? '0' + days : days);
                        this_el.find('.countDown__hours').text(hours < 10 ? '0' + hours : hours);
                        this_el.find('.countDown__minutes').text(minutes < 10 ? '0' + minutes : minutes);
                        this_el.find('.countDown__seconds').text(seconds < 10 ? '0' + seconds : seconds);

                        // If the count down is finished display Happy New Year text
                        if (distance < 0) {
                            clearInterval(x);
                            this_el.find('.countDown__days').text("00");
                            this_el.find('.countDown__hours').text("00");
                            this_el.find('.countDown__minutes').text("00");
                            this_el.find('.countDown__seconds').text("00");
                        }
                    }, 1000);
                });
            });
        </script>
        <!-- end -->
<?php
    }
}
add_action('wp_footer', 'add_countdown_date_script', 99);

function custom_countdowm_date_shortcode($atts) {
    $date = new DateTime();
    $date->modify('+1 month');
    $default_date = $date->format('Y-m-d 00:00:00');

    $atts = shortcode_atts(
        array(
            'date' => $default_date,
        ),
        $atts,
        'countdowm_date'
    );

    ob_start();
    ?>
    <div class='countDown' data-date="<?php echo esc_html($atts['date']); ?>">
        <div class='countDown__item'>
            <span class='countDown__days'>--</span>
            <p>Days</p>
        </div>

        <div class='countDown__item'>
            <span class='countDown__hours'>--</span>
            <p>Hours</p>
        </div>

        <div class='countDown__item'>
            <span class='countDown__minutes'>--</span>
            <p>Minutes</p>
        </div>

        <div class='countDown__item'>
            <span class='countDown__seconds'>--</span>
            <p>Seconds</p>
        </div>
    </div>
    <?php
    return ob_get_clean();;
}
add_shortcode('countdowm_date', 'custom_countdowm_date_shortcode');