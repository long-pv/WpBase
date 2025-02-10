<?php

/**
 * Template name: Page Demo
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

// header template
get_header();
?>

<div id="loader"></div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            document.getElementById('loader').style.transition = 'opacity 0.5s';
            document.getElementById('loader').style.opacity = 0;

            setTimeout(function() {
                document.getElementById('loader').style.display = 'none';
            }, 500);
        }, 1000);
    });
</script>

<div class="container py-5">
    <div class="pb-5">
        <h2>Form validate</h2>
        <form id="personal-info-form">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address">
            </div>

            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
            </div>

            <!-- Radio buttons -->
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="gender_male" name="gender" value="male" checked>
                    <label class="form-check-label" for="gender_male">Male</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="gender_female" name="gender" value="female">
                    <label class="form-check-label" for="gender_female">Female</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="gender_other" name="gender" value="other">
                    <label class="form-check-label" for="gender_other">Other</label>
                </div>

                <label for="add_info" class="form-label">Add info</label>
                <input type="text" class="form-control" id="add_info" name="add_info" placeholder="Enter your add info">
            </div>

            <!-- Checkboxes -->
            <div class="mb-3">
                <label class="form-label">Hobbies</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="hobby_reading" name="hobbies[]" value="reading">
                    <label class="form-check-label" for="hobby_reading">Reading</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="hobby_traveling" name="hobbies[]" value="traveling">
                    <label class="form-check-label" for="hobby_traveling">Traveling</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="hobby_sports" name="hobbies[]" value="sports">
                    <label class="form-check-label" for="hobby_sports">Sports</label>
                </div>
            </div>

            <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITEKEY_KEY; ?>"></div>
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>

            <!-- Nút submit -->
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div class="pb-5">
        <h2>Thư viện intlTelInput</h2>
        <div class="mb-4">
            <input type="text" id="phone" name="phone">
        </div>
        <div class="seclect_country">
            <input type="text" id="country" name="country">
        </div>
    </div>


    <div class="pb-5">
        <h2>Hiệu ứng load more ajax</h2>
        <div>
            <button type="button" id="ajax_loader_demo" class="btn btn-primary">Demo</button>
            <div id="ajax-loader" style="display: none;">
                <div class="spinner"></div>
            </div>
        </div>
    </div>


    <div class="pb-5">
        <h2>Downdload file</h2>
        <div>
            <form id="download-zip-form" class="mb-4" method="post">
                <input type="hidden" name="post_id" value="1">
                <button type="submit" class="btn btn-primary">Download ZIP</button>
            </form>

            <form id="download-pdf-form" method="post">
                <input type="hidden" name="post_id" value="123">
                <button type="submit" class="btn btn-primary">Download PDF</button>
            </form>
        </div>
    </div>

    <div class="pb-5">
        <h2>Tabs scroll slider</h2>
        <div>
            <div id="example_1">
                <ul role="tablist">
                    <li role="tab"><a href="#tabs-1" role="presentation">Tab 1</a></li>
                    <li role="tab"><a href="#tabs-2" role="presentation">This is tab 2</a></li>
                    <li role="tab"><a href="#tabs-3" role="presentation">This is tab number 3</a></li>
                    <li role="tab"><a href="#tabs-4" role="presentation">Tab no 4</a></li>
                    <li role="tab"><a href="#tabs-5" role="presentation">And tab number 5</a></li>
                    <li role="tab"><a href="#tabs-6" role="presentation">Tab number 6</a></li>
                    <li role="tab"><a href="#tabs-7" role="presentation">And last tab number 7</a></li>
                    <li role="tab"><a href="#tabs-8" role="presentation">Very very long name 8</a></li>
                    <li role="tab"><a href="#tabs-9" role="presentation">Short name 9</a></li>
                </ul>
                <div id="tabs-1" role="tabpanel">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque hendrerit vulputate porttitor.
                    Fusce purus leo, faucibus a sagittis congue, molestie tempus felis. Donec convallis semper enim,
                    varius sagittis
                    eros
                    imperdiet in. Vivamus semper sem at metus mattis a aliquam neque ornare. Proin sed semper lacus.
                </div>
                <div id="tabs-2" role="tabpanel">This is tab 2<br>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque hendrerit vulputate porttitor.
                    Fusce
                    purus leo, faucibus a sagittis congue, molestie tempus felis. Donec convallis semper enim, varius
                    sagittis eros
                    imperdiet
                    in. Vivamus semper sem at metus mattis a aliquam neque ornare. Proin sed semper lacus.</div>
                <div id="tabs-3" role="tabpanel">This is tab number 3<br>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque hendrerit vulputate porttitor.
                    Fusce purus leo, faucibus a sagittis congue, molestie tempus felis. Donec convallis semper enim,
                    varius sagittis
                    eros
                    imperdiet in. Vivamus semper sem at metus mattis a aliquam neque ornare. Proin sed semper lacus.
                </div>
                <div id="tabs-4" role="tabpanel">Tab no 4<br>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque hendrerit vulputate porttitor.
                    Fusce purus
                    leo, faucibus a sagittis congue, molestie tempus felis. Donec convallis semper enim, varius sagittis
                    eros
                    imperdiet
                    in. Vivamus semper sem at metus mattis a aliquam neque ornare. Proin sed semper lacus.</div>
                <div id="tabs-5" role="tabpanel">And this is the tab number 5<br>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque hendrerit vulputate
                    porttitor. Fusce purus leo, faucibus a sagittis congue, molestie tempus felis. Donec convallis
                    semper enim, varius
                    sagittis eros imperdiet in. Vivamus semper sem at metus mattis a aliquam neque ornare. Proin sed
                    semper lacus.
                </div>
                <div id="tabs-6" role="tabpanel">Tab number 6<br>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque hendrerit vulputate porttitor.
                    Fusce
                    purus leo, faucibus a sagittis congue, molestie tempus felis. Donec convallis semper enim, varius
                    sagittis eros
                    imperdiet
                    in. Vivamus semper sem at metus mattis a aliquam neque ornare. Proin sed semper lacus.</div>
                <div id="tabs-7" role="tabpanel">And last tab number 7<br>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque hendrerit vulputate porttitor.
                    Fusce purus leo, faucibus a sagittis congue, molestie tempus felis. Donec convallis semper enim,
                    varius sagittis
                    eros
                    imperdiet in. Vivamus semper sem at metus mattis a aliquam neque ornare. Proin sed semper lacus.
                </div>
                <div id="tabs-8" role="tabpanel">Very very long name 8<br>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque hendrerit vulputate porttitor.
                    Fusce purus leo, faucibus a sagittis congue, molestie tempus felis. Donec convallis semper enim,
                    varius sagittis
                    eros
                    imperdiet in. Vivamus semper sem at metus mattis a aliquam neque ornare. Proin sed semper lacus.
                </div>
                <div id="tabs-9" role="tabpanel">Short name 9<br>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque hendrerit vulputate porttitor.
                    Fusce
                    purus leo, faucibus a sagittis congue, molestie tempus felis. Donec convallis semper enim, varius
                    sagittis eros
                    imperdiet
                    in. Vivamus semper sem at metus mattis a aliquam neque ornare. Proin sed semper lacus.</div>
            </div>

            <a class="ui-state-default ui-corner-all" id="prev" href="javascript:void(0)"
                style="padding:20px;text-decoration:none;position:relative">
                Prev
            </a>
            <a class="ui-state-default ui-corner-all" id="next" href="javascript:void(0)"
                style="padding:20px;text-decoration:none;position:relative">
                Next
            </a>
        </div>
    </div>

    <div class="pb-5">
        <h2>View PDF</h2>
        <?php echo do_shortcode('[custom_pdf_viewer pdf="https://ontheline.trincoll.edu/images/bookdown/sample-local-pdf.pdf"]'); ?>
    </div>

    <div class="pb-5">
        <h2>Thu gọn nội dung</h2>

        <div class="readmore_content">
            <div class="editor">
                Lorem ipsum odor amet, consectetuer adipiscing elit. Arcu nullam consequat sagittis pulvinar ante cras
                lorem. Duis habitant mi neque at lacus dapibus proin. Blandit quisque sapien ullamcorper montes cubilia
                sed
                sapien convallis curabitur. Lorem cubilia accumsan blandit mollis at efficitur iaculis torquent. Auctor
                habitasse inceptos risus senectus feugiat turpis. Morbi suscipit lectus nisi accumsan lobortis sodales
                pulvinar fringilla.

                Mauris nisl montes in; mi sodales tristique habitant ridiculus. Donec orci libero inceptos in imperdiet.
                Id
                commodo elit habitasse dui; malesuada cubilia phasellus sagittis. Fames varius aliquam quis taciti
                praesent
                integer sem. Elementum viverra sociosqu ut, aptent taciti rhoncus. Sodales ornare lobortis primis sit
                torquent sem. Elementum felis mattis a, gravida class pellentesque.

                Sed aliquet bibendum ridiculus lacus; hac elementum id interdum tempus. Justo netus netus aliquam vel
                mollis
                vulputate integer? Massa leo penatibus pharetra ipsum senectus sapien orci mauris ridiculus. Convallis
                ipsum
                tincidunt ipsum aliquam dolor dictum litora dis. Ante mus mollis; venenatis sed elit nibh. Leo ridiculus
                ligula neque, rutrum pretium ipsum. Consequat fermentum eget ex dolor; etiam neque.

                Quisque magnis nascetur, molestie ac himenaeos imperdiet nibh. Montes lorem habitant consequat curabitur
                nibh platea et ex. Morbi aliquam volutpat luctus vivamus mus nisl. Himenaeos cras sagittis gravida
                luctus
                maecenas suspendisse et adipiscing. Imperdiet gravida nam fames fusce primis magna est lacinia posuere.
                Nunc
                placerat turpis interdum cras a et.

                Leo sodales aliquam per semper pharetra dui id per quam. Dictumst sociosqu dictum enim non dolor.
                Maximus
                curabitur felis maximus primis curabitur hac sociosqu vestibulum. Nullam egestas bibendum consectetur
                penatibus commodo. Finibus cursus litora adipiscing lacinia sed nullam, luctus ante. Lacinia fringilla
                tempus, ridiculus suspendisse pulvinar ipsum. Dapibus rhoncus donec in justo leo placerat.

                Aliquet ante orci tellus integer eleifend curae proin sed. Facilisis tortor risus urna sodales lacinia
                aenean malesuada elit. Ultrices duis ut interdum, dignissim iaculis ante imperdiet felis. Convallis mus
                lectus ridiculus nostra pellentesque. Lobortis gravida malesuada tristique sollicitudin convallis
                facilisi
                tortor porta. Habitant lacinia dignissim venenatis tempor ex vivamus. Sapien ligula vehicula fermentum
                faucibus bibendum mattis lacus. Rhoncus et tincidunt varius nascetur montes pulvinar hendrerit euismod
                consequat.

                Commodo auctor himenaeos morbi cursus dictumst ac ad tempus. Magna mus porttitor nam ridiculus porttitor
                purus montes curabitur semper. Viverra cras urna malesuada dictum aenean ultricies condimentum nec nunc.
                Vehicula elementum turpis orci tellus ex. Ac at suscipit lobortis porta tempor; gravida iaculis dui.
                Gravida
                dictum condimentum; proin velit scelerisque risus cubilia sed. Duis sit neque in egestas odio neque
                blandit
                platea. Sem sem duis aptent ligula aptent interdum fusce. At habitant nulla senectus mi inceptos. Litora
                sit
                imperdiet euismod blandit ex ad volutpat facilisi accumsan.

                Odio sapien odio diam facilisis sagittis condimentum. Tellus aliquet eros morbi auctor velit elit
                sagittis
                magna. Sit ridiculus imperdiet mus condimentum maecenas. Suscipit potenti consequat hendrerit nullam;
                hac
                gravida a. Vestibulum ipsum inceptos mus dapibus netus maximus cras curae accumsan. Finibus posuere
                augue;
                sagittis bibendum sed dignissim. Scelerisque facilisi nisi taciti luctus sed. Nostra id condimentum
                dictum
                magna laoreet at.

                Primis fermentum turpis blandit luctus pharetra justo ultrices. Curae himenaeos himenaeos nam efficitur
                congue. Per tortor curabitur sagittis magnis gravida morbi justo. Nunc rhoncus placerat platea, euismod
                vestibulum venenatis bibendum. Elit cras fames dignissim ridiculus egestas. Est dictum elementum massa
                felis
                placerat elit turpis nostra. Neque purus fames velit eu parturient maecenas viverra diam. Diam odio
                ornare
                adipiscing semper commodo porttitor mus feugiat inceptos.

                Auctor vehicula phasellus condimentum habitasse curae ante ligula nibh feugiat. Hac etiam etiam ante mus
                mauris varius suspendisse. Tempor ullamcorper tincidunt tellus vestibulum augue orci. Vestibulum primis
                bibendum turpis nam quam, donec malesuada semper. Vehicula hac id sagittis fusce feugiat fames at
                natoque.
                Dignissim in neque a phasellus ligula, scelerisque viverra habitant iaculis. Parturient elit maximus id
                magnis, duis eros. Tellus id ad fusce venenatis odio. Odio aliquet a rutrum faucibus parturient sapien
                inceptos!
            </div>
        </div>
    </div>

    <div class="pb-5">
        <h2>Upload image</h2>

        <div class="upload_block" style="width: 300px;">
            <label class="upload_btn" for="upload_img">
                <div class="upload_inner">
                    <div class="upload_icon">
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M17.5 12.2227C17.9142 12.2227 18.25 11.8869 18.25 11.4727V4.28332L19.9697 6.00299C20.2626 6.29588 20.7374 6.29588 21.0303 6.00299C21.3232 5.71009 21.3232 5.23522 21.0303 4.94233L18.0303 1.94233C17.7374 1.64943 17.2626 1.64943 16.9697 1.94233L13.9697 4.94233C13.6768 5.23522 13.6768 5.71009 13.9697 6.00299C14.2626 6.29588 14.7374 6.29588 15.0303 6.00299L16.75 4.28332V11.4727C16.75 11.8869 17.0858 12.2227 17.5 12.2227Z"
                                fill="#1A1A1A" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12.5 1.72266L12.4426 1.72266C10.1342 1.72264 8.32519 1.72263 6.91371 1.9124C5.46897 2.10664 4.32895 2.51198 3.43414 3.40679C2.53933 4.3016 2.13399 5.44163 1.93975 6.88636C1.74998 8.29785 1.74999 10.1069 1.75 12.4153V12.53C1.74999 14.8384 1.74998 16.6475 1.93975 18.059C2.13399 19.5037 2.53933 20.6437 3.43414 21.5385C4.32895 22.4333 5.46897 22.8387 6.91371 23.0329C8.32519 23.2227 10.1342 23.2227 12.4426 23.2227H12.5574C14.8658 23.2227 16.6748 23.2227 18.0863 23.0329C19.531 22.8387 20.6711 22.4333 21.5659 21.5385C22.4607 20.6437 22.866 19.5037 23.0603 18.059C23.25 16.6475 23.25 14.8384 23.25 12.53V12.4727C23.25 12.0584 22.9142 11.7227 22.5 11.7227C22.0858 11.7227 21.75 12.0584 21.75 12.4727C21.75 14.8509 21.7484 16.5591 21.5736 17.8591C21.5667 17.9104 21.5596 17.9608 21.5522 18.0105L18.7782 15.5139C17.4788 14.3444 15.5437 14.228 14.1134 15.2332L13.8152 15.4427C13.3182 15.792 12.6421 15.7334 12.2125 15.3039L7.92282 11.0142C6.78741 9.87877 4.96613 9.81813 3.75771 10.8755L3.25098 11.3189C3.25552 9.52661 3.28124 8.16568 3.42637 7.08623C3.59825 5.80783 3.92514 5.03711 4.4948 4.46745C5.06445 3.8978 5.83517 3.5709 7.11358 3.39903C8.41356 3.22425 10.1218 3.22266 12.5 3.22266C12.9142 3.22266 13.25 2.88687 13.25 2.47266C13.25 2.05844 12.9142 1.72266 12.5 1.72266ZM3.42637 17.8591C3.59825 19.1375 3.92514 19.9082 4.4948 20.4779C5.06445 21.0475 5.83517 21.3744 7.11358 21.5463C8.41356 21.7211 10.1218 21.7227 12.5 21.7227C14.8782 21.7227 16.5864 21.7211 17.8864 21.5463C19.1648 21.3744 19.9355 21.0475 20.5052 20.4779C20.7487 20.2343 20.9479 19.954 21.1096 19.6131C21.0707 19.5893 21.0334 19.5616 20.9983 19.53L17.7747 16.6288C16.9951 15.9272 15.834 15.8573 14.9758 16.4604L14.6776 16.67C13.5843 17.4384 12.0968 17.3095 11.1519 16.3646L6.86216 12.0748C6.28515 11.4978 5.35958 11.467 4.74546 12.0044L3.25038 13.3125C3.25296 15.2611 3.27289 16.7175 3.42637 17.8591Z"
                                fill="#1A1A1A" />
                        </svg>
                    </div>

                    <div class="upload_label">
                        Upload an image from your current device
                    </div>
                </div>

                <div class="upload_change_file"
                    style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.60) 0%, rgba(0, 0, 0, 0.60) 100%),  url('')  lightgray center / cover no-repeat;">
                    change image
                </div>

                <input type="file" name="upload_img" class="upload_img" id="upload_img" accept="image/jpeg, image/png">
                <input type="hidden" name="upload_img_url" autocomplete="off" />
                <input type="hidden" name="upload_img_height" autocomplete="off" />
            </label>
        </div>
    </div>

    <div class="pb-5">
        <h2>Thanh toán stripe</h2>
        <div>
            <?php
            if (!empty($_GET['session_id'])) {
                require_once 'inc/stripe/vendor/autoload.php';

                $total_payment = !empty($_GET["total_payment"]) ? sanitize_text_field($_GET["total_payment"]) : '';

                $key_stripe = 'sk_test_51Q78biGYyIJ7x0h4s4xbyYTb52yZLTLmkEZmW8mmYhAezfNTHWCMKI2UkeVwEOUjK4rG9J1K0ZBN0WPKjESMafQd00xD8edBG1';
                \Stripe\Stripe::setApiKey($key_stripe);
                $session_id = $_GET['session_id'];
                $session = \Stripe\Checkout\Session::retrieve($session_id);
                $payment_intent_id = $session->payment_intent;
                $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
                $status = $payment_intent->status ?? '';

                if ($status == 'succeeded') {
                    echo '<strong>Đã thanh toán thành công. Số tiền : ' . $total_payment . '</strong>';
                } else {
                    die('Something went wrong');
                }
            }
            ?>
        </div>
        <div>
            <p>
                composer require stripe/stripe-php
            </p>
            <p>
                <strong>Data Test:</strong>
                <br>
                Email: test@gmail.com
                <br>
                Thẻ: 4242 4242 4242 4242
                <br>
                Date: 05/30
                <br>
                CVC: 123
                <br>
                Tên: Test
            </p>
            <button class="btn btn-primary" id="btn_stripe_payment">Stripe payment</button>
        </div>
    </div>

    <div class="pb-5">
        <h2>Thanh toán paypal</h2>

        <div class="payment_method_paypal" style="width:200px;">
            <div id="paypal-button-container"></div>
        </div>
    </div>

    <div class="pb-5">
        <h2>Gửi mail</h2>

        <button class="btn btn-primary" id="send_mail">Gửi mail demo</button>
    </div>

    <div class="pb-5">
        <h2>Currency format (hiển thị tiền tệ)</h2>
        <div>PHP: <?php echo currency_format('10023456789.567'); ?></div>
        <div>Javascript:
            <div>
                <input type="number" id="input_price" value="0">
            </div>
            <div>
                Số tiền đã nhập là: <span id="show_price">0</span>
            </div>
        </div>
    </div>

    <div class="pb-5">
        <h2>Social login coding</h2>

        <div>
            <a href="<?php echo home_url('/facebook-login'); ?>" style="display:inline-flex;width:30px;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path
                        d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64h98.2V334.2H109.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H255V480H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64z" />
                </svg>
            </a>
        </div>

        <div>
            <a href="<?php echo home_url('/google-login'); ?>" style="display:inline-flex;width:30px;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path
                        d="M448 96c0-35.3-28.7-64-64-64H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96zM64 256c0-55.3 44.7-100 100-100c27 0 49.5 9.8 67 26.2l-27.1 26.1c-7.4-7.1-20.3-15.4-39.8-15.4c-34.1 0-61.9 28.2-61.9 63.2c0 34.9 27.8 63.2 61.9 63.2c39.6 0 54.4-28.5 56.8-43.1H164V241.8h94.4c1 5 1.6 10.1 1.6 16.6c0 57.1-38.3 97.6-96 97.6c-55.3 0-100-44.7-100-100zm291 18.2v29H325.8v-29h-29V245h29V216H355v29h29v29.2H355z" />
                </svg>
            </a>
        </div>
    </div>

    <div class="pb-5">
        <h2>Calendar</h2>

        <div id="calendar-controls" style="text-align: center; margin-bottom: 10px;">
            <select id="month-select"></select>
            <select id="year-select"></select>
        </div>

        <div class="calendar_block">
            <div id="calendar"></div>
            <div class="calendar_footer">
                <div class="calendar_footer_left">
                    <div class="calendar_footer_item">
                        <span class="calendar_footer_label">
                            Departure date:
                        </span>
                        <span class="calendar_footer_date">
                        </span>
                    </div>

                    <div class="calendar_footer_item">
                        <span class="calendar_footer_label">
                            Price per person:
                        </span>
                        <span class="calendar_footer_price">
                        </span>
                    </div>
                </div>
                <div class="calendar_footer_right">
                    <a href="javascript:vodi(0);" class="calendar_footer_btn calendar_booking_date_btn">
                        Select
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-5">
        <h2>Custom dropdown</h2>
        <div class="row">
            <div class="col-lg-6">
                <div class="custom_dropdown">
                    <div class="custom_dropdown_button">Chọn tùy chọn</div>
                    <div class="custom_dropdown_menu">
                        <label><input type="checkbox" name="how_do_you_know[]" value="Bạn bè giới thiệu"> Bạn bè giới thiệu</label>
                        <label><input type="checkbox" name="how_do_you_know[]" value="Facebook"> Facebook</label>
                        <label><input type="checkbox" name="how_do_you_know[]" value="Google search"> Google search</label>
                        <label><input type="checkbox" name="how_do_you_know[]" value="Email"> Email</label>
                        <label><input type="checkbox" name="how_do_you_know[]" value="Youtube"> Youtube</label>
                        <label><input type="checkbox" name="how_do_you_know[]" value="Báo chí"> Báo chí</label>
                        <label><input type="checkbox" name="how_do_you_know[]" value="Khác"> Khác</label>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="custom_dropdown">
                    <div class="custom_dropdown_button">Chọn tùy chọn</div>
                    <div class="custom_dropdown_menu">
                        <label><input type="checkbox" name="translation_skill[]" value="Dịch xuôi"> Dịch xuôi</label>
                        <label><input type="checkbox" name="translation_skill[]" value="Dịch ngược"> Dịch ngược</label>
                        <label><input type="checkbox" name="translation_skill[]" value="Cả 2"> Cả 2</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-5">
        <h2>Share post</h2>

        <?php
        $share_link = get_permalink();
        ?>
        <div class="social_share_post">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_link; ?>" onclick="window.open(this.href, this.target, 'width=500,height=500'); return false;" class="social_share_post_facebook">
                <span class="social_share_post_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64h98.2V334.2H109.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H255V480H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64z"></path>
                    </svg>
                </span>
            </a>

            <a href="https://twitter.com/home?status=<?php echo $share_link; ?>" onclick="window.open(this.href, this.target, 'width=500,height=500'); return false;" class="social_share_post_twitter">
                <span class="social_share_post_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM351.3 199.3v0c0 86.7-66 186.6-186.6 186.6c-37.2 0-71.7-10.8-100.7-29.4c5.3 .6 10.4 .8 15.8 .8c30.7 0 58.9-10.4 81.4-28c-28.8-.6-53-19.5-61.3-45.5c10.1 1.5 19.2 1.5 29.6-1.2c-30-6.1-52.5-32.5-52.5-64.4v-.8c8.7 4.9 18.9 7.9 29.6 8.3c-9-6-16.4-14.1-21.5-23.6s-7.8-20.2-7.7-31c0-12.2 3.2-23.4 8.9-33.1c32.3 39.8 80.8 65.8 135.2 68.6c-9.3-44.5 24-80.6 64-80.6c18.9 0 35.9 7.9 47.9 20.7c14.8-2.8 29-8.3 41.6-15.8c-4.9 15.2-15.2 28-28.8 36.1c13.2-1.4 26-5.1 37.8-10.2c-8.9 13.1-20.1 24.7-32.9 34c.2 2.8 .2 5.7 .2 8.5z"></path>
                    </svg>
                </span>
            </a>

            <a href="https://pinterest.com/pin/create/button/?url=<?php echo $share_link; ?>&media=&description=text" onclick="window.open(this.href, this.target, 'width=500,height=500'); return false;" class="social_share_post_pinterest">
                <span class="social_share_post_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path d="M384 32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64h72.6l-2.2-.8c-5.4-48.1-3.1-57.5 15.7-134.7c3.9-16 8.5-35 13.9-57.9c0 0-7.3-14.8-7.3-36.5c0-70.7 75.5-78 75.5-25c0 13.5-5.4 31.1-11.2 49.8c-3.3 10.6-6.6 21.5-9.1 32c-5.7 24.5 12.3 44.4 36.4 44.4c43.7 0 77.2-46 77.2-112.4c0-58.8-42.3-99.9-102.6-99.9C153 139 112 191.4 112 245.6c0 21.1 8.2 43.7 18.3 56c2 2.4 2.3 4.5 1.7 7c-1.1 4.7-3.1 12.9-4.7 19.2c-1 4-1.8 7.3-2.1 8.6c-1.1 4.5-3.5 5.5-8.2 3.3c-30.6-14.3-49.8-59.1-49.8-95.1C67.2 167.1 123.4 96 229.4 96c85.2 0 151.4 60.7 151.4 141.8c0 84.6-53.3 152.7-127.4 152.7c-24.9 0-48.3-12.9-56.3-28.2c0 0-12.3 46.9-15.3 58.4c-5 19.3-17.6 42.9-27.4 59.3H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64z"></path>
                    </svg>
                </span>
            </a>

            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_link; ?>&title=text" onclick="window.open(this.href, this.target, 'width=500,height=500'); return false;" class="social_share_post_linkedin">
                <span class="social_share_post_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"></path>
                    </svg>
                </span>
            </a>

            <a href="mailto:?subject=ChongthamTaiko&body=<?php echo $share_link; ?>" onclick="window.location = this.href" class="social_share_post_email">
                <span class="social_share_post_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zM218 271.7L64.2 172.4C66 156.4 79.5 144 96 144l256 0c16.5 0 30 12.4 31.8 28.4L230 271.7c-1.8 1.2-3.9 1.8-6 1.8s-4.2-.6-6-1.8zm29.4 26.9L384 210.4 384 336c0 17.7-14.3 32-32 32L96 368c-17.7 0-32-14.3-32-32l0-125.6 136.6 88.2c7 4.5 15.1 6.9 23.4 6.9s16.4-2.4 23.4-6.9z"></path>
                    </svg>
                </span>
            </a>

            <a href="javascript:void(0);" onclick="copyToClipboard('#copy2')" class="social_share_post_copy">
                <span id="copy2" style="display:none"><?php echo $share_link; ?></span>
                <span class="social_share_post_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path d="M208 0L332.1 0c12.7 0 24.9 5.1 33.9 14.1l67.9 67.9c9 9 14.1 21.2 14.1 33.9L448 336c0 26.5-21.5 48-48 48l-192 0c-26.5 0-48-21.5-48-48l0-288c0-26.5 21.5-48 48-48zM48 128l80 0 0 64-64 0 0 256 192 0 0-32 64 0 0 48c0 26.5-21.5 48-48 48L48 512c-26.5 0-48-21.5-48-48L0 176c0-26.5 21.5-48 48-48z" />
                    </svg>
                </span>
                <script>
                    function copyToClipboard(selector) {
                        var textElement = document.querySelector(selector);
                        if (textElement) {
                            var tempInput = document.createElement('input');
                            tempInput.value = textElement.textContent;
                            document.body.appendChild(tempInput);
                            tempInput.select();

                            try {
                                var successful = document.execCommand('copy');
                                var msg = successful ? 'Copy thành công!' : 'Copy không thành công, vui lòng thử lại.';
                                alert(msg);
                            } catch (err) {
                                console.error('Oops, unable to copy', err);
                                alert('Copy không thành công, vui lòng thử lại.');
                            }

                            document.body.removeChild(tempInput);
                        }
                    }
                </script>
            </a>
        </div>
    </div>

    <div class="pb-5">
        <h2>Phân trang bằng Ajax</h2>

        <div>
            <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'paged' => 1,
            );
            $query = new WP_Query($args);
            if ($query->have_posts()):
            ?>
                <ul class="post_list">
                    <?php
                    while ($query->have_posts()):
                        $query->the_post();
                    ?>
                        <li>
                            <?php the_title(); ?>
                        </li>
                    <?php
                    endwhile;
                    ?>
                </ul>

                <?php
                echo '<div class="pagination pagination_ajax justify-content-start">';
                echo paginate_links(
                    array(
                        'total'   => $query->max_num_pages,
                        'current' => 1,
                        'end_size' => 2,
                        'mid_size' => 1,
                        'prev_text' => __('Trước', 'basetheme'),
                        'next_text' => __('Sau', 'basetheme'),
                    )
                );
                echo '</div>';
                ?>
            <?php
            endif;
            ?>
        </div>
    </div>

</div>

<?php
get_footer();
?>
<script src="<?php echo get_template_directory_uri() . '/assets/js/jquery.ui.scrolltabs.js'; ?>"></script>
<!-- stripe -->
<script src="https://js.stripe.com/v3/"></script>
<!-- paypal -->
<script
    src="https://www.paypal.com/sdk/js?client-id=AQDtyFOubNFVF-BohVnhaovzU517KKryur7IiYYMPp2Y-nMitDcqzeFH3v5C9TwW6lvcqOxgV8kV0e0h&locale=en_US&disable-funding=credit,card"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script>
    jQuery(document).ready(function($) {
        var page_default = '<?php echo get_permalink(); ?>';
        var stripe = Stripe("pk_test_51Q78biGYyIJ7x0h4Tv4TSOChaIIHb0YzqHpqDv2PTpCBVMHfcSyF97Ti6zJkM0jThfAJIcJFkRoDF3j1UiluleKx00AZQKgU9u");

        $('#input_price').on('change', function() {
            let val = $(this).val();
            $('#show_price').text(currency_format(val));
        });

        function currency_format(price) {
            price = price ? price : 0;
            price = parseFloat(price);

            if (Number.isInteger(price)) {
                return price.toLocaleString("en-US");
            } else {
                price = price.toFixed(1).toString();
                let parts = price.split(".");
                let integer_part = parseInt(parts[0]).toLocaleString("en-US");
                let decimal_part = parts[1];
                return integer_part + "." + decimal_part;
            }
        }

        // pagination_ajax
        $(document).on('click', '.pagination_ajax .page-numbers', function(e) {
            e.preventDefault();

            var paged_current = $('.page-numbers.current').text() ?? 1;
            paged_current = parseInt(paged_current);
            var paged = 1;

            if ($(this).hasClass('next')) {
                paged = paged_current + 1;
            } else if ($(this).hasClass('prev')) {
                paged = paged_current - 1;
            } else if ($(this).hasClass('dots')) {
                return 0;
            } else {
                paged = $(this).text() ?? 1;
            }

            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'ajax_pagination_load_post',
                    paged: paged,
                },
                beforeSend: function() {
                    $("#ajax-loader").show();
                },
                success: function(response) {
                    $('.post_list').html(response);
                },
                error: function() {
                    alert('Có lỗi xảy ra khi gửi dữ liệu.');
                },
                complete: function() {
                    $("#ajax-loader").hide();
                }
            });

            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'ajax_pagination',
                    paged: paged,
                },
                success: function(response) {
                    $('.pagination_ajax').html(response);
                },
                error: function() {
                    alert('Có lỗi xảy ra khi gửi dữ liệu.');
                },
            });
        });
        // end pagination_ajax

        $('#send_mail').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: url_ajax,
                type: 'POST',
                data: {
                    action: 'send_demo_mail',
                },
                beforeSend: function() {
                    $("#ajax-loader").show();
                },
                success: function(response) {
                    alert('Mail đã được gửi thành công!');
                },
                error: function(error) {
                    alert('Something went wrong.');
                },
                complete: function() {
                    $("#ajax-loader").hide();
                }
            });
        });

        // paypal
        paypal
            .Buttons({
                funding: {
                    allowed: [paypal.FUNDING.CARD],
                    disallowed: [paypal.FUNDING.CREDIT],
                },
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: 10,
                            },
                        }, ],
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        alert('Thanh toán thành công.');
                    });
                },
                onCancel: function(data) {
                    alert("Transaction cancelled");
                },
                onError: function(err) {
                    alert("Something went wrong.");
                },
            })
            .render("#paypal-button-container");


        $('#btn_stripe_payment').on('click', function() {
            $.ajax({
                url: url_ajax,
                type: "POST",
                data: {
                    action: "create_stripe_session",
                    page_success: page_default,
                    total_payment: 10,
                    post_id: 123,
                },
                beforeSend: function() {
                    $("#ajax-loader").show();
                },
                success: function(response) {
                    if (response.success) {
                        var sessionId = response.data.id;
                        stripe.redirectToCheckout({
                            sessionId: sessionId
                        });
                    } else {
                        alert("Error creating checkout session: " + response);
                    }
                },
                error: function(error) {
                    alert('Something went wrong.');
                },
                complete: function() {
                    $("#ajax-loader").hide();
                },
            });
        });

        // Custom regex for email validation
        $.validator.addMethod(
            "customEmail",
            function(value, element) {
                var regex = /^[a-zA-Z0-9._%+-]+(?:.[a-zA-Z0-9._%+-]+)*@[a-zA-Z0-9.-]+.[a-zA-Z]{2,}$/;
                return this.optional(element) || regex.test(value);
            },
            "Please enter a valid email address"
        );

        $("#personal-info-form").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    customEmail: true,
                    maxlength: 40,
                },
                address: {
                    required: true
                },
                avatar: {
                    required: true,
                },
                gender: {
                    required: true,
                },
                add_info: {
                    required: function() {
                        return $('input[name="gender"]:checked').val() == "other" ? true : false;
                    },
                },
                'hobbies[]': {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Please enter your full name",
                    minlength: "Your name must be at least 2 characters long"
                },
                email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address"
                },
                address: {
                    required: "Please enter your address"
                },
                avatar: {
                    required: "Please upload an avatar",
                },
                gender: {
                    required: "Please enter your gender",
                },
                add_info: {
                    required: "Please enter your add info",
                },
                'hobbies[]': {
                    required: "Please enter your hobbies",
                },
            },
            errorPlacement: function(error, element) {
                error.addClass('text-danger');
                error.appendTo(element.closest(".mb-3"));
            },
            submitHandler: function(form) {
                // Kiểm tra reCAPTCHA trước khi gửi form
                let recaptcha_response = grecaptcha.getResponse();
                if (recaptcha_response.length === 0) {
                    alert('Vui lòng chọn reCAPTCHA.');
                    return false;
                }

                // thực hiện ajax
                var formData = new FormData(form);
                formData.append("action", "send_email");

                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $("#ajax-loader").show();
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Thông tin đã được gửi thành công!');
                        } else {
                            alert(response.data.message);
                        }
                    },
                    error: function() {
                        alert('Có lỗi xảy ra khi gửi dữ liệu.');
                    },
                    complete: function() {
                        $("#ajax-loader").hide();
                    }
                });

                // ngăn không submit
                return false;
            }
        });

        $('#ajax_loader_demo').on('click', function() {
            $('#ajax-loader').toggle();
        });

        $('#example_1').scrollTabs({
            scrollOptions: {
                customNavNext: '#next',
                customNavPrev: '#prev',
                customNavFirst: '',
                customNavLast: '',
                easing: 'swing',
                enableDebug: false,
                closable: false,
                showFirstLastArrows: false,
                selectTabAfterScroll: true
            }
        });

        $(".readmore_content").readmore({
            moreLink: '<div class="rm_down"><button class="btn btn-primary">Đọc thêm</button></div>',
            lessLink: '<div class="rm_up"><button class="btn btn-primary">Thu gọn</button></div>',
            collapsedHeight: 150,
            afterToggle: function(trigger, element, expanded) {
                if (!expanded) {
                    $("html, body").animate({
                        scrollTop: element.offset().top
                    }, {
                        duration: 100
                    });
                }
            },
        }).css('overflow', 'hidden');

        $('input[name="upload_img"]').on("change", function(e) {
            e.preventDefault();
            let this_el = $(this);
            let file = this_el.get(0).files[0];
            let parent = this_el.closest(".upload_btn");
            parent.find('input[name="upload_img_url"]').val("");
            let input_height = parent.find('input[name="upload_img_height"]');

            if (file) {
                let fileType = file.type;
                let validImageTypes = ["image/jpeg", "image/png"];

                if ($.inArray(fileType, validImageTypes) < 0) {
                    alert("Vui lòng chỉ upload ảnh với định dạng JPG hoặc PNG.");
                    this_el.val("");
                    return;
                }

                let reader = new FileReader();

                reader.onload = function(e) {
                    let img = new Image();
                    img.onload = function() {
                        let width = img.width;
                        let height = img.height;
                        let w_img_wrap = parent.outerWidth();
                        let ty_le_anh = height / width;
                        let h_img_wrap = ty_le_anh * w_img_wrap;

                        parent.css("height", h_img_wrap);
                        input_height.val(h_img_wrap);
                        parent.find(".upload_change_file").css("background", `linear-gradient(0deg, rgba(0, 0, 0, 0.60) 0%, rgba(0, 0, 0, 0.60) 100%), url(${e.target.result}) center / cover no-repeat`);
                        parent.addClass("uploaded_btn");
                    };
                    img.src = e.target.result;
                };

                reader.readAsDataURL(file);
            } else {
                parent.removeClass("uploaded_btn");
                parent.css("height", "unset");
                input_height.val("");
            }
        });

        // calendar event
        var selectedDate = null;
        var calendarEl = $('#calendar')[0];
        var today = new Date();
        var todayDate = today.setHours(0, 0, 0, 0);

        var specialPrices = [{
                date: '2024-11-15',
                price: 2500
            },
            {
                date: '2024-11-17',
                price: 2500
            },
            {
                date: '2024-12-01',
                price: 2500
            },
        ];

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            firstDay: 1,
            headerToolbar: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            contentHeight: 'auto',
            dateClick: function(info) {
                if ($(info.dayEl).hasClass('fc-day-other')) {
                    return;
                }

                if (info.date >= todayDate) {
                    selectedDate = info.dateStr;
                    $('.fc-daygrid-day').removeClass('selected');
                    $(info.dayEl).addClass('selected');
                    let price = $(info.dayEl).find('.fc-event-price').data('price');
                    price = parseFloat(price);
                    let formattedPrice = '$' + display_price(price);

                    $('.calendar_footer_price').text(formattedPrice);
                    $('.accordion_header_price').text(formattedPrice);

                    // date
                    let dateObj = new Date(info.date);
                    let options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    let formattedDate = dateObj.toLocaleDateString('en-US', options);
                    let [weekday, month, day, year] = formattedDate.replace(/,/g, '').split(' ');
                    let finalFormattedDate = `${weekday} ${day} ${month} ${year}`;
                    $('.calendar_footer_date').text(finalFormattedDate);
                    $('.accordion_header_date').text(finalFormattedDate);
                } else {
                    return;
                }
            },
            datesSet: function() {
                if (selectedDate) {
                    let selectedDayEl = $(`.fc-daygrid-day[data-date="${selectedDate}"]`);
                    if (selectedDayEl.length) {
                        selectedDayEl.addClass('selected');
                    }
                }

                let currentDate = calendar.getDate();
                $('#month-select').val(currentDate.getMonth());
                $('#year-select').val(currentDate.getFullYear());

                $(this).find('.fc-event-price').remove();

                $('.fc-daygrid-day').each(function() {
                    let dayDate = $(this).data('date');
                    let price = 2000;
                    price = parseFloat(price);
                    let price_format = '$' + display_price(price);

                    let specialPrice = specialPrices.find(sp => sp.date === dayDate);
                    if (specialPrice) {
                        price = specialPrice.price;
                        price_format = '$' + price.toLocaleString();
                        $(this).addClass('fc-special-day');
                    }

                    if ($(this).find('.fc-event-price').length === 0) {
                        var priceElement = $('<div>', {
                            class: 'fc-event-price',
                            'data-price': price,
                            text: price_format
                        });
                        $(this).find('.fc-daygrid-day-top').append(priceElement);
                    }
                });
            }
        });

        calendar.render();

        function display_price(price_val) {
            let price = parseFloat(price_val);
            let formattedPrice = 0;

            if (Number.isInteger(price)) {
                formattedPrice = price.toLocaleString("en-US");
            } else {
                price = price.toFixed(1).toString();
                let parts = price.split(".");
                let integer_part = parseInt(parts[0]).toLocaleString("en-US");
                let decimal_part = parts[1];
                formattedPrice = integer_part + "." + decimal_part;
            }

            return formattedPrice;
        }

        function updatePriceAndDateInfo(info) {
            let price = $(info.dayEl).find('.fc-event-price').data('price');
            price = parseFloat(price);
            let formattedPrice = '$' + display_price(price);

            $('.calendar_footer_price').text(formattedPrice);
            $('.accordion_header_price').text(formattedPrice);

            let dateObj = new Date(info.date);
            let options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            let formattedDate = dateObj.toLocaleDateString('en-US', options);
            let [weekday, month, day, year] = formattedDate.replace(/,/g, '').split(' ');
            let finalFormattedDate = `${weekday} ${day} ${month} ${year}`;
            $('.calendar_footer_date').text(finalFormattedDate);
            $('.accordion_header_date').text(finalFormattedDate);
        }

        function setSelectedDate(dateString) {
            var targetDate = new Date(dateString);
            if (!isNaN(targetDate.getTime())) {
                selectedDate = targetDate.toISOString().split('T')[0];
                calendar.gotoDate(targetDate);

                setTimeout(function() {
                    $('.fc-daygrid-day').removeClass('selected');
                    var selectedDayEl = $(`.fc-daygrid-day[data-date="${selectedDate}"]`);
                    if (selectedDayEl.length) {
                        selectedDayEl.addClass('selected');

                        updatePriceAndDateInfo({
                            dayEl: selectedDayEl[0],
                            date: targetDate,
                            dateStr: selectedDate
                        });
                    }
                }, 0);
            }
        }
        var today = new Date();
        today.setDate(today.getDate() + 1);
        var formattedDate = today.toISOString().split('T')[0];
        date_select = formattedDate;
        setSelectedDate(formattedDate);

        var monthSelect = $('#month-select');
        var yearSelect = $('#year-select');

        for (var month = 0; month < 12; month++) {
            monthSelect.append($('<option>', {
                value: month,
                text: new Date(0, month).toLocaleString('default', {
                    month: 'long'
                })
            }));
        }

        var currentYear = new Date().getFullYear();
        for (var year = currentYear; year <= currentYear + 5; year++) {
            yearSelect.append($('<option>', {
                value: year,
                text: year
            }));
        }

        var currentDate = calendar.getDate();
        monthSelect.val(currentDate.getMonth());
        yearSelect.val(currentDate.getFullYear());

        monthSelect.change(function() {
            var selectedMonth = parseInt($(this).val());
            var selectedYear = parseInt(yearSelect.val());
            calendar.gotoDate(new Date(selectedYear, selectedMonth, 1));
        });

        yearSelect.change(function() {
            var selectedMonth = parseInt(monthSelect.val());
            var selectedYear = parseInt($(this).val());
            calendar.gotoDate(new Date(selectedYear, selectedMonth, 1));
        });

        // dropdown custom
        $(".custom_dropdown_button").on("click", function(e) {
            e.stopPropagation();
            var dropdownMenu = $(this).next(".custom_dropdown_menu");
            $(".custom_dropdown_menu").not(dropdownMenu).hide();

            dropdownMenu.toggle();
        });

        $(document).on("click", function() {
            $(".custom_dropdown_menu").hide();
        });

        $(".custom_dropdown_menu").on("click", function(e) {
            e.stopPropagation();
        });
    });
</script>