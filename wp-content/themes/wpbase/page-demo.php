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

            <style>
                #ajax-loader {
                    position: fixed;
                    top: 0px;
                    left: 0px;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.5);
                    z-index: 1000;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .spinner {
                    border: 4px solid #f3f3f3;
                    border-top: 4px solid #3498db;
                    border-radius: 50%;
                    width: 40px;
                    height: 40px;
                    animation: spin 1s linear infinite;
                }

                @keyframes spin {
                    0% {
                        transform: rotate(0deg);
                    }

                    100% {
                        transform: rotate(360deg);
                    }
                }
            </style>
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
            <style>
                /* Scroll tab default css*/
                .ui-scroll-tabs-view {
                    z-index: 1;
                    overflow: hidden;
                }

                .ui-scroll-tabs-view .ui-widget-header {
                    border: none;
                    background: transparent;
                }

                .ui-scroll-tabs-header {
                    position: relative;
                    overflow: hidden;
                }

                .ui-scroll-tabs-header .stNavMain {
                    position: absolute;
                    top: 0;
                    z-index: 2;
                    height: 100%;
                    opacity: 0;
                    transition: left .5s, right .5s, opacity .8s;
                    transition-timing-function: swing;
                }

                .ui-scroll-tabs-header .stNavMain button {
                    height: 100%;
                }

                .ui-scroll-tabs-header .stNavMainLeft {
                    left: -250px;
                }

                .ui-scroll-tabs-header .stNavMainLeft.stNavVisible {
                    left: 0;
                    opacity: 1;
                }

                .ui-scroll-tabs-header .stNavMainRight {
                    right: -250px;
                }

                .ui-scroll-tabs-header .stNavMainRight.stNavVisible {
                    right: 0;
                    opacity: 1;
                }

                .ui-scroll-tabs-header ul.ui-tabs-nav {
                    position: relative;
                    white-space: nowrap;
                }

                .ui-scroll-tabs-header ul.ui-tabs-nav li {
                    display: inline-block;
                    float: none;
                }

                .ui-scroll-tabs-header ul.ui-tabs-nav li.stHasCloseBtn a {
                    padding-right: 0.5em;
                }

                .ui-scroll-tabs-header ul.ui-tabs-nav li span.stCloseBtn {
                    float: left;
                    padding: 4px 2px;
                    border: none;
                    cursor: pointer;
                }

                /*End of scrolltabs css*/
            </style>

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
</div>
</div>

<?php
get_footer();
?>
<link href="https://code.jquery.com/ui/1.12.1/themes/flick/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="<?php echo get_template_directory_uri() . '/assets/js/jquery.ui.scrolltabs.js'; ?>"></script>
<script>
    jQuery(document).ready(function ($) {
        var url_ajax = '<?php echo admin_url('admin-ajax.php'); ?>';

        $("#personal-info-form").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                address: {
                    required: true
                },
                avatar: {
                    required: true,
                    extension: "jpg,jpeg,png,gif"
                }
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
                    extension: "Only jpg, jpeg, png, or gif files are allowed"
                }
            },
            submitHandler: function (form) {
                var formData = new FormData(form); // lấy data
                formData.append("action", "ajax_action"); // gọi tới hook action

                // ngăn không submit
                return false;
            }
        });

        $('#ajax_loader_demo').on('click', function () {
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
            afterToggle: function (trigger, element, expanded) {
                if (!expanded) {
                    $("html, body").animate({ scrollTop: element.offset().top }, { duration: 100 });
                }
            },
        }).css('overflow', 'hidden');
    });
</script>