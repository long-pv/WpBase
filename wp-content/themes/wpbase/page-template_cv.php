<?php
/**
 * Template name: Template CV
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
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?php echo get_template_directory_uri(); ?>/assets_cv/vendor/bootstrap/css/bootstrap.min.css"
        rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/assets_cv/vendor/bootstrap-icons/bootstrap-icons.css"
        rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/assets_cv/vendor/aos/aos.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/assets_cv/vendor/glightbox/css/glightbox.min.css"
        rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/assets_cv/vendor/swiper/swiper-bundle.min.css"
        rel="stylesheet">

    <!-- Main CSS File -->
    <link href="<?php echo get_template_directory_uri(); ?>/assets_cv/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

    <?php
    $link = get_permalink();
    ?>

    <header id="header" class="header dark-background d-flex flex-column">
        <i class="header-toggle d-xl-none bi bi-list"></i>

        <div class="profile-img">
            <img width="120" height="120" src="<?php the_field('anh_dai_dien'); ?>" alt="ảnh đại diện"
                class="rounded-circle object-fit-cover">
        </div>

        <div class="logo d-flex align-items-center justify-content-center mb-4">
            <h1 class="sitename">
                <?php the_field('ho_va_ten'); ?>
            </h1>
        </div>

        <div class="social-links text-center">
            <!--facebook  -->
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $link; ?>"
                onclick="window.open(this.href, this.target, 'width=500,height=500'); return false;" class="facebook"><i
                    class="bi bi-facebook"></i></a>

            <!-- twitter -->
            <a href="https://twitter.com/home?status=<?php echo $link; ?>"
                onclick="window.open(this.href, this.target, 'width=500,height=500'); return false;" class="twitter"><i
                    class="bi bi-twitter-x"></i></a>

            <!-- linkedin -->
            <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $link; ?>&amp;title=text"
                onclick="window.open(this.href, this.target, 'width=500,height=500'); return false;" class="linkedin"><i
                    class="bi bi-linkedin"></i></a>

            <!-- mailto -->
            <a href="mailto:?subject=ChongthamTaiko&amp;body=<?php echo $link; ?>" onclick="window.location = this.href"
                class="mailto"><i class="bi bi-envelope"></i></a>

            <!-- copy -->
            <a href="javascript:void(0);" onclick="copyToClipboard('#copy2')" class="copy">
                <span id="copy2" style="display:none"><?php echo $link; ?></span>
                <i class="bi bi-copy"></i></a>

        </div>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="#hero" class="active"><i class="bi bi-house navicon"></i>Trang chủ</a></li>
                <li><a href="#about"><i class="bi bi-person navicon"></i>Giới thiệu</a></li>
                <li><a href="#skills"><i class="bi bi-lightning-charge navicon"></i>Kỹ năng</a></li>
                <li><a href="#resume"><i class="bi bi-file-earmark-text navicon"></i>Hoạt động</a></li>
                <li><a href="#services"><i class="bi bi-hdd-stack navicon"></i>Dự án</a></li>
                <li><a href="#contact"><i class="bi bi-envelope navicon"></i>Liên hệ</a></li>
                <li><a href="<?php echo home_url(); ?>"><i class="bi bi-reply navicon"></i>Về trang chính</a></li>
            </ul>
        </nav>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">

            <img src="<?php the_field('anh_background'); ?>" alt="ảnh nền">

            <div class="container">
                <h2 data-aos="fade-up" data-aos-delay="300"><?php the_field('ho_va_ten'); ?></h2>
                <p data-aos="fade-up" data-aos-delay="300">
                    <?php
                    the_field('gioi_thieu');
                    $cong_viec = get_field('cong_viec');
                    $ten_cong_viec = array_column($cong_viec, 'ten_cong_viec');
                    $danh_sach_cong_viec = implode(', ', $ten_cong_viec);
                    ?>
                    <span class="typed" data-typed-items="<?php echo $danh_sach_cong_viec; ?>"></span>
                    <span class="typed-cursor typed-cursor--blink" aria-hidden="true"></span>
                    <span class="typed-cursor typed-cursor--blink" aria-hidden="true"></span>
                </p>
            </div>

        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up" data-aos-delay="300">
                <h2>Giới thiệu</h2>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4 justify-content-center">
                    <div class="col-lg-4">
                        <img src="<?php the_field('anh_dai_dien'); ?>" class="img-fluid" alt="ảnh đại diện"
                            data-aos="fade-up" data-aos-delay="300">
                    </div>
                    <div class="col-lg-8 content">
                        <h2 data-aos="fade-up" data-aos-delay="300">
                            <?php the_field('cong_viec_chinh'); ?>
                        </h2>
                        <div class="fst-italic py-3" data-aos="fade-up" data-aos-delay="300">
                            <?php the_field('mo_ta_ngan'); ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-10">
                                <ul>
                                    <li data-aos="fade-up" data-aos-delay="300">
                                        <i class="bi bi-chevron-right"></i>
                                        <strong>Ngày sinh:</strong>
                                        <span>
                                            <?php the_field('ngay_sinh'); ?>
                                        </span>
                                    </li>
                                    <li data-aos="fade-up" data-aos-delay="300">
                                        <i class="bi bi-chevron-right"></i>
                                        <strong>Điện thoại:</strong>
                                        <span>
                                            <?php the_field('so_dien_thoai'); ?>
                                        </span>
                                    </li>
                                    <li data-aos="fade-up" data-aos-delay="300">
                                        <i class="bi bi-chevron-right"></i>
                                        <strong>Địa chỉ:</strong>
                                        <span>
                                            <?php the_field('dia_chi'); ?>
                                        </span>
                                    </li>
                                    <li data-aos="fade-up" data-aos-delay="300">
                                        <i class="bi bi-chevron-right"></i>
                                        <strong>Email:</strong>
                                        <span>
                                            <?php the_field('email'); ?>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /About Section -->

        <!-- Skills Section -->
        <section id="skills" class="skills section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up" data-aos-delay="300">
                <h2>Kỹ năng</h2>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row skills-content skills-animation">
                    <?php
                    $danh_sach_ky_nang = get_field('danh_sach_ky_nang') ?? [];
                    foreach ($danh_sach_ky_nang as $item):
                        ?>
                        <div class="col-lg-7">
                            <div class="progress">
                                <span class="skill" data-aos="fade-up" data-aos-delay="300">
                                    <span><?php echo $item['ten_ky_nang']; ?></span>
                                    <i class="val"><?php echo $item['so_phan_tram']; ?>%</i>
                                </span>
                                <div class="progress-bar-wrap" data-aos="fade-up" data-aos-delay="300">
                                    <div class="progress-bar" role="progressbar"
                                        aria-valuenow="<?php echo $item['so_phan_tram']; ?>" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            </div>

        </section><!-- /Skills Section -->

        <!-- Resume Section -->
        <section id="resume" class="resume section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up" data-aos-delay="300">
                <h2>Hoạt động</h2>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row">
                    <?php
                    $danh_sach_hoat_dong = get_field('danh_sach_hoat_dong') ?? [];
                    foreach ($danh_sach_hoat_dong as $item):
                        ?>
                        <div class="col-lg-8">
                            <h3 class="resume-title" data-aos="fade-up" data-aos-delay="300">
                                <?php echo $item['tieu_de']; ?>
                            </h3>
                            <div class="resume-item">
                                <h4 data-aos="fade-up" data-aos-delay="300">
                                    <?php echo $item['thoi_gian']; ?>
                                </h4>
                                <div data-aos="fade-up" data-aos-delay="300">
                                    <?php echo $item['mo_ta']; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section><!-- /Resume Section -->

        <!-- Services Section -->
        <section id="services" class="services section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up" data-aos-delay="300">
                <h2>Dự án</h2>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">
                    <?php
                    $danh_sach_du_an = get_field('danh_sach_du_an') ?? [];
                    foreach ($danh_sach_du_an as $item):
                        ?>
                        <div class="col-lg-4 col-md-6 service-item d-flex">
                            <div class="icon flex-shrink-0" data-aos="fade-up" data-aos-delay="300"><i
                                    class="bi bi-code-slash"></i></div>
                            <div>
                                <h4 class="title" data-aos="fade-up" data-aos-delay="300">
                                    <a target="_blank" href="<?php echo $item['link_website'] ?: '#'; ?>"
                                        class="stretched-link">
                                        <?php echo $item['ten_du_an']; ?>
                                    </a>
                                </h4>
                                <div class="description" data-aos="fade-up" data-aos-delay="300">
                                    <?php echo $item['mo_ta']; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section><!-- /Services Section -->

        <!-- Contact Section -->
        <section id="contact" class="contact section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up" data-aos-delay="300">
                <h2>Liên hệ</h2>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-5">

                        <div class="info-wrap">
                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                                <i class="bi bi-geo-alt flex-shrink-0"></i>
                                <div>
                                    <h3>Địa chỉ</h3>
                                    <div><?php the_field('dia_chi'); ?></div>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                                <i class="bi bi-telephone flex-shrink-0"></i>
                                <div>
                                    <h3>Điện thoại</h3>
                                    <div><?php the_field('so_dien_thoai'); ?></div>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                                <i class="bi bi-envelope flex-shrink-0"></i>
                                <div>
                                    <h3>Email</h3>
                                    <div><?php the_field('email'); ?></div>
                                </div>
                            </div><!-- End Info Item -->

                            <div data-aos="fade-up" data-aos-delay="300">
                                <?php the_field('google_map'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div data-aos="fade-up" data-aos-delay="300">
                            <?php
                            if (get_field('contact_form')):
                                $form = get_field('contact_form');
                                echo do_shortcode("[contact-form-7 id=\"$form\" html_class=\"php-email-form\"]");
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                .wpcf7-spinner {
                    display: block;
                }
            </style>
        </section><!-- /Contact Section -->
    </main>

    <footer id="footer" class="footer position-relative light-background">
        <div class="container">
            <div class="copyright text-center ">
                <p>
                    © <span>Copyright</span>
                    <strong class="px-1 sitename">Long xemer</strong>
                    <span>All Rights Reserved</span>
                </p>
            </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script
        src="<?php echo get_template_directory_uri(); ?>/assets_cv/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/assets_cv/vendor/aos/aos.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/assets_cv/vendor/typed.js/typed.umd.js"></script>
    <script
        src="<?php echo get_template_directory_uri(); ?>/assets_cv/vendor/purecounter/purecounter_vanilla.js"></script>
    <script
        src="<?php echo get_template_directory_uri(); ?>/assets_cv/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/assets_cv/vendor/glightbox/js/glightbox.min.js"></script>
    <script
        src="<?php echo get_template_directory_uri(); ?>/assets_cv/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script
        src="<?php echo get_template_directory_uri(); ?>/assets_cv/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/assets_cv/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="<?php echo get_template_directory_uri(); ?>/assets_cv/js/main.js"></script>

    <script>
        function copyToClipboard(selector) {
            // Lấy phần tử chứa văn bản cần sao chép
            var textElement = document.querySelector(selector);
            if (textElement) {
                // Tạo một phần tử tạm thời để sao chép văn bản
                var tempInput = document.createElement('input');
                tempInput.value = textElement.textContent;
                document.body.appendChild(tempInput);
                tempInput.select();

                // Sao chép văn bản vào clipboard
                try {
                    var successful = document.execCommand('copy');
                    var msg = successful ? 'Copy thành công!' : 'Copy không thành công, vui lòng thử lại.';
                    alert(msg); // Hiển thị thông báo cho người dùng
                } catch (err) {
                    console.error('Oops, unable to copy', err);
                    alert('Copy không thành công, vui lòng thử lại.');
                }

                // Xóa phần tử tạm thời sau khi sao chép
                document.body.removeChild(tempInput);
            }
        }
    </script>

    <?php wp_footer(); ?>
</body>

</html>