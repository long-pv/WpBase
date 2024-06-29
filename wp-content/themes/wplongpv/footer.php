<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package cltheme
 */

?>
</main>
<!-- end main body -->

<!-- footer -->
<footer id="footer" class="footer secSpace">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-4 mb-3 mb-lg-0">
                <div class="footer__logo">
                    <img src="<?php echo get_template_directory_uri() . '/assets/images/logo_white.svg'; ?>" alt="logo">
                </div>
                <?php
                $introduce = get_field('introduce', 'option');
                if ($introduce):
                    ?>
                    <div class="footer__intro">
                        <?php echo $introduce; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <?php
                if (get_field('iframe_google_map', 'option')):
                    ?>
                    <div class="video">
                        <?php echo get_field('iframe_google_map', 'option'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (get_field('copyright', 'option')): ?>
            <div class="copyright mt-4 text-center">
                <?php echo get_field('copyright', 'option'); ?>
            </div>
        <?php endif; ?>
    </div>
</footer>
<!-- end footer -->

<?php wp_footer(); ?>

</body>

</html>