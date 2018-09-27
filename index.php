<?php get_header(); ?>

<div class="container blog_container mt-5 mb-5">
    <?php if(have_posts()): ?>
        <?php while(have_posts()): the_post();?>
            <div class="card blog_post mt-4">
                <a href="<?php echo esc_url(get_permalink()); ?>">
                    <div class="row ">
                        <?php if(has_post_thumbnail()): ?>
                            <div class="col-md-4">
                                <?php the_post_thumbnail('medium', array('class' => 'w-100')); ?>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-8 blog_content px-3">
                            <div class="card-block px-3">
                                <h4 class="card-title"><?php the_title(); ?></h4>
                                <div class="excerpt"><?php the_excerpt(); ?></div>
                                <small>By: <?php echo get_the_author(); ?></small><small><?php echo get_the_date(); ?></small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <hr>
        <?php endwhile; ?>
    <?php endif; ?>
</div>
<?php get_footer(); ?>
