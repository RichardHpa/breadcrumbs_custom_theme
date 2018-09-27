<?php get_header('blog'); ?>
    <?php while(have_posts()): the_post();?>
        <div class="container mt-5 contentContainer wp_content">
            <?php the_content() ?>
        </div>
        <div class="container mt-5">
            <hr>
            <?php
            wp_list_comments( array(
            	'callback' => 'better_comments'
            ) ); ?>
        </div>
    <?php endwhile; ?>
<?php get_footer(); ?>
