<?php get_header(); ?>






    <?php if(have_posts()): ?>
        <?php if($post->post_content !==""): ?>
            <div class="container mb-5 mt-5">
                <?php while(have_posts()): the_post();?>
                    <div class="row">
                        <div class="col-12 wp_content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

<div class="aboutSection">
    <?php if(get_post_meta( $id , 'page_video', true)): ?>
        <div class="container video mb-5 mt-5">
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
        <div class="container-fluid homeAlt pt-5">
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
                    <div class="alternatingSection mb-5">
                        <div class="halfSection">
                            <h3><?php echo get_post_meta( $id , 'section_title_'.$section, true); ?></h3>
                            <div>
                                <?php echo get_post_meta( $id , 'section_content_'.$section, true); ?>
                            </div>

                            <?php if(get_post_meta( $id , 'section_link_'.$section, true) !== 'null'): ?>
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
                    <h3 class="mb-5"><?php echo get_post_meta( $id , 'section_title_'.$section, true); ?></h3>
                    <?php $imageID =  get_post_meta( $id , 'section_image_'.$section, true);?>
                    <?php echo wp_get_attachment_image( $imageID, 'header_image', "", ["class" => "img-fluid"] ); ?>
                    <div class="mt-5 mb-5">
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
            'post_parent' => $post->ID,
            'post_type' => 'page'
        );
        $child_query = new WP_Query( $args );
    ?>

    <?php if($child_query->have_posts()): ?>
        <div class="container child-pages-container mt-5 pb-5">
            <div class="card-deck">
            <?php while($child_query->have_posts()): $child_query->the_post();?>
                    <div class="card child-page">
                        <a href="<?php echo esc_url(get_permalink()); ?>">
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
                        </div>
                        <div class="card-footer text-center">
                            <h4><?php the_title(); ?></h4>
                        </div>
                        </a>
                    </div>
            <?php endwhile; ?>
            </div>
        </div>
    <?php endif; ?>
</div>


<?php get_footer(); ?>
