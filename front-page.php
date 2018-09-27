<?php get_header(); ?>

<?php if(have_posts()): ?>
    <div class="container">
        <?php while(have_posts()): the_post();?>
            <div class="row">
                <div class="col-12 mt-5 wp_content">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

<?php
    $iconSection = false;
    for ($i=1; $i <=4 ; $i++){
        $icon = get_theme_mod('icon_'.$i.'_setting');
        if($icon){
            $iconSection = true;
            break;
        }
    }
 ?>
<?php if($iconSection == true): ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card-deck icons-deck home-icons">
                    <?php for ($i=1; $i <=4 ; $i++): ?>
                        <?php $icon = get_theme_mod('icon_'.$i.'_setting');?>
                        <div class="card icon-card">
                            <img class="card-img-top" src="<?php echo wp_get_attachment_image_src($icon, 'companies_thumb')[0]; ?>" alt="Card image cap">
                            <div class="card-footer text-center">
                                <p><?php echo get_theme_mod('icon_'.$i.'_description_Setting'); ?></p>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if(get_post_meta( $id , 'page_video', true)): ?>
    <div class="homeVideo mt-5">
        <?php
            $videoURL = get_post_meta( $id , 'page_video', true);
            $embed_code = wp_oembed_get($videoURL);
        ?>
        <?php echo $embed_code?>
    </div>
<?php endif; ?>

<?php if(get_post_meta( $id , 'sectionArray', true)): ?>
    <?php
        $count = get_post_meta( $id , 'sectionArray', true);
        $countArray = explode(',', $count);
    ?>
    <div class="container-fluid homeAlt aboutSection pt-5">
        <div class="container">
            <?php foreach($countArray as $section): ?>
                <?php $imageLink = get_post_meta( $id , 'section_image_link_'.$section, true); ?>
                <?php
                    $pageID = get_post_meta( $id , 'section_link_'.$section, true);
                    if (is_numeric($pageID)) {
                        $link = get_permalink($pageID);
                    } else {
                        $link = get_post_meta( $id , 'section_link_external_'.$section, true);
                    }
                ?>
                <div class="alternatingSection pb-5">
                    <div class="halfSection">
                        <h3><?php echo get_post_meta( $id , 'section_title_'.$section, true); ?></h3>
                        <div>
                            <?php echo get_post_meta( $id , 'section_content_'.$section, true); ?>
                        </div>
                        <?php if(get_post_meta( $id , 'section_link_'.$section, true)): ?>

                            <a class="btn btn-breadcrumbs" href="<?php echo $link ?>"><?php echo get_post_meta( $id , 'section_button_'.$section, true); ?></a>
                        <?php endif; ?>
                    </div>
                    <?php if(get_post_meta( $id , 'section_image_'.$section, true)): ?>
                        <div class="halfSection text-center">

                            <?php if($imageLink === 'on'): ?>
                                <a href="<?php echo $link ?>">
                            <?php endif; ?>
                                <?php $imageID =  get_post_meta( $id , 'section_image_'.$section, true);?>
                                <?php echo wp_get_attachment_image($imageID, 'header_image', false) ?>
                            <?php if($imageLink === 'on'): ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="container homeAltCarousel mt-5">
        <?php foreach($countArray as $section): ?>
            <?php $imageLink = get_post_meta( $id , 'section_image_link_'.$section, true); ?>
            <?php
                $pageID = get_post_meta( $id , 'section_link_'.$section, true);
                if (is_numeric($pageID)) {
                    $link = get_permalink($pageID);
                } else {
                    $link = get_post_meta( $id , 'section_link_external_'.$section, true);
                }
            ?>
            <div class="item text-center mb-2">
                <h3 class="mb-2"><?php echo get_post_meta( $id , 'section_title_'.$section, true); ?></h3>
                <?php $imageID =  get_post_meta( $id , 'section_image_'.$section, true);?>
                <?php echo wp_get_attachment_image( $imageID, 'header_image', "", ["class" => "img-fluid"] ); ?>
                <div class="mt-2 mb-2">
                    <?php echo get_post_meta( $id , 'section_content_'.$section, true); ?>
                </div>
                <?php if(get_post_meta( $id , 'section_link_'.$section, true)): ?>
                    <a class="btn btn-breadcrumbs" href="<?php echo $link ?>"><?php echo get_post_meta( $id , 'section_button_'.$section, true); ?></a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
    $args = array(
        'post_type' => 'activities'
    );
    $activities = new WP_Query( $args );
    $countPosts = wp_count_posts( 'activities' )->publish;
?>

<?php if($activities->have_posts()): ?>
    <div class="container-fluid activity-container">
        <div class="container">
            <h3>Looking for Activity Inspo?</h3>
            <div class="owl-carousel owl-theme activityCarousel mt-5">
                <?php while($activities->have_posts()): $activities->the_post();?>
                    <div class="item card">
                        <?php the_post_thumbnail('large', ['class' => 'card-img-top img-fluid', 'title' => 'Feature image']); ?>
                        <div class="card-body">
                          <h4 class="card-title"><?php the_title(); ?></h4>
                          <p class="card-text"><?php the_excerpt(); ?></p>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo esc_url(get_permalink()); ?>">Read More</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php if($countPosts > 3): ?>
                <div class="row mt-5">
                    <div class="col-12">
                        <a class="btn btn-breadcrumbs" href="<?php echo get_post_type_archive_link('activities'); ?>">See More</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>


<?php endif; ?>





<?php get_footer(); ?>
