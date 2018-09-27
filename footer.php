        <footer>
            <div class="container footerNavContainer">
                <div class="footer-top">
                    <div class="footerNav">
                        <?php
                        wp_nav_menu( array(
                            'menu_class' => 'menu',
                            'theme_location'    => 'footer_Navigation',
                            'container_class'   => 'footer_nav'
                        ) );
                        ?>
                        <?php my_social_icons_output(); ?>
                    </div>
                </div>
                <?php
                    $args = array(
                        'post_type' => 'associations'
                    );
                    $associations = new WP_Query( $args );
                ?>
                <?php if($associations->have_posts()): ?>
                    <div class="container associationsContainer">
                        <div class="row align-items-center">
                            <?php while($associations->have_posts()): $associations->the_post();?>
                                <div class="col-2">
                                    <?php the_post_thumbnail('companies_thumb', ['class' => 'img-fluid']); ?>
                                </div>
                            <?php endwhile ?>
                        </div>
                    </div>
                <?php endif; ?>
                <hr>

                <div class="footer-bottom">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-center">&copy; Copyright <?php echo date("Y"); ?> - Breadcrumbs.  All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <?php wp_footer(); ?>
    </body>
</html>
