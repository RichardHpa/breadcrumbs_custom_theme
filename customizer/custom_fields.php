<?php
/*
    Adds custom fields into the theme
*/
/*
    Declares what fields for the meta boxes

    'MetaBoxTitle' => array(
        'title' => __('Title of the Metabox Section', 'Theme Name'),
        'applicableto' => 'What post type it is being added to',
        'location' => 'Where on the page ',
        'priority' => 'How imporatnt is it',
        'fields' => array(
            'MetaBox Name' => array(
                'title' => __('Title for the metabox', 'Theme Name'),
                'type' => 'what type of input field is it',
                'description' => 'description of the meta box',
                'size' => how tall do you want to textarea to be (optional for type = textareas)
            )
        )
    )

    @param array $arr (See above)
    @return Object A new editor object.

*/
$metaboxes = array(
    'header_text' => array(
        'title' => __('Header Information', 'Breadcrumbs'),
        'applicableto' => 'page',
        'location' => 'normal',
        'priority' => 'high',
        'fields' => array(
            'header_text' => array(
                'title' => __('Header Text: ', 'Breadcrumbs'),
                'type' => 'text',
                'description' => 'Text which will be added into the header section for the page'
            ),
            'header_description' => array(
                'title' => __('Header Blurb: ', 'Breadcrumbs'),
                'type' => 'textarea',
                'description' => 'Burb for the page which is rendered in the header',
                'size' => 5
            ),
            'header_image' => array(
                'title' => __('Header Image: ', 'Breadcrumbs'),
                'type' => 'image',
                'description' => 'Image which is being displayed in the header.'
            ),
            'header_background' => array(
                'title' => __('Header Background: ', 'Breadcrumbs'),
                'type' => 'image',
                'description' => 'Background Image for the page.'
            ),
            'store_link' => array(
                'title' => __('Link to Store: ', 'Breadcrumbs'),
                'type' => 'checkbox',
                'description' => 'Do you want to include the link to the store on this page?'
            )
        )
    ),
    'main_page_content' => array(
        'title' => __('Main Page Content', 'Breadcrumbs'),
        'applicableto' => 'page',
        'location' => 'normal',
        'priority' => 'core',
        'fields' => array(
            'page_description' => array(
                'title' => __('Page Desctiption: ', 'Breadcrumbs'),
                'type' => 'textarea',
                'description' => 'Description of the page',
                'size' => 10
            ),
            'page_video' => array(
                'title' => __('Page Video URL: ', 'Breadcrumbs'),
                'type' => 'text',
                'description' => 'URL for the video which is on the page',
                'size' => 100
            )
        )
    ),
    'alternating_section' => array(
        'title' => __('Alternating Page Content', 'Breadcrumbs'),
        'applicableto' => 'page',
        'location' => 'normal',
        'priority' => 'core',
        'fields' => array(
            'header_count' => array(
                'title' => __('Header Count: ', 'Breadcrumbs'),
                'type' => 'alternatingSections',
                'description' => 'Dynamically add alternating sections for the page',
                'size' => 100
            )
        )
    ),
    'promotion_content' => array(
        'title' => __('Promotional Content', 'Breadcrumbs'),
        'applicableto' => 'promotions',
        'location' => 'normal',
        'priority' => 'core',
        'fields' => array(
            'icon_blurb' => array(
                'title' => __('Icon Blurb:', 'Breadcrumbs'),
                'type' => 'textarea',
                'description' => 'Blurb about the icons',
                'size' => 5
            )
        )
    )
);

function add_post_format_metabox() {
    global $metaboxes;
    if ( ! empty( $metaboxes ) ) {
        foreach ( $metaboxes as $id => $metabox ) {
            add_meta_box( $id, $metabox['title'], 'show_metaboxes', $metabox['applicableto'], $metabox['location'], $metabox['priority'], $id );
        }
    }
}

add_action( 'admin_init', 'add_post_format_metabox' );

function show_metaboxes( $post, $args ) {
    global $metaboxes;

    $custom = get_post_custom( $post->ID );
    $fields = $tabs = $metaboxes[$args['id']]['fields'];

    $output = '<input type="hidden" name="post_format_meta_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';

    if ( sizeof( $fields ) ) {
        foreach ( $fields as $id => $field ) {
            switch ( $field['type'] ) {
                case 'text':
                    $output .= '<div class="form-group"><label for="' . $id . '">' . $field['title'] . '</label><input class="customInput" id="' . $id . '" type="text" name="' . $id . '" value="' . $custom[$id][0] . '" style="width: 100%;" /></div>';
                break;
                case 'textarea':
                    $output .= '<div class="form-group"><label for="' . $id . '">' . $field['title'] . '</label><textarea class="customInput" rows="'.$field['size'].'" id="' . $id . '" name="' . $id . '">' . $custom[$id][0] . '</textarea></div>';
                break;
                case 'image':
                    $image =  get_post_meta( $post->ID, $id, true );
                    $output .= '<div class="form-group half-group">';
                        $output .= '<label>'.$field['title'].'</label>';
                        $output .= '<input type="number" value="' . $custom[$id][0] . '" class="customInput regular-text process_custom_images" name="'.$id.'" max="" min="1" step="1" readonly style="display:block">';
                        $output .= '<button class="set_custom_images button">Set Image ID</button>';
                        $output .= '<button class="remove_custom_images button">Remove Image</button>';
                    $output .= '</div>';
                break;
                case 'checkbox':
                    $value = get_post_meta( $post->ID, $id, true );
                    if($value == 'yes'){
                        $checked = 'checked="checked"';
                    } else {
                        $checked = null;
                    }
                    $output .= '<div class="form-group half-group"><div id="'.$id.'" class="radio"><label>'.$field['title'].'</label><br><input type="checkbox" '.$checked.' name="'.$id.'"value="yes"/></div></div>';
                break;
                case 'alternatingSections':
                    if($custom[$id][0] == null){
                        $countValue = 0;
                    } else {
                        $countValue = $custom[$id][0];
                    }
                    $exsistingSections = get_post_meta( $post->ID, 'sectionArray', true );

                    if($exsistingSections){
                        $exsistingSectionsArray = explode(',', $exsistingSections);
                    }

                    $output .= '<input type="number" id="'.$id.'" name="'.$id.'" class="customInput" readonly value="' . $countValue . '" style="display: none;">';
                    $output .= '<input type="text" id="exsistingArray" name="exsistingSections" class="customInput" readonly value="'.$exsistingSections.'" style="display: none;">';
                    $output .= '<input type="text" id="deletingArray" name="deletingSections" class="customInput" readonly style="display: none;">';
                    $output .= '<div><a class="button" href="#" id="addNewSection">Add a new Section</a></div>';

                    $count = $custom[$id][0];
                    $args = array(
                        'sort_order' => 'asc',
                        'post_type' => 'page',
                        'post_status' => 'publish'
                    );
                    $pages = get_pages($args);

                    $pageList = array();
                    foreach ($pages as $page) {
                        array_push($pageList, $page);
                    }


                    $output .= '<select id="selectPagesTemplate" class="customInput hidden" name="section_link_'.$section.'">';
                    $output .= '<option value="null">What page do you want to link to?</option>';
                    foreach($pages as $page){
                        if ( $page->ID == $link ) {
                            $selected = 'selected';
                        } else if($link == 'externalPage'){
                            $selected = 'selected';
                            $display = 'block';
                        }else {
                            $selected = null;
                            $display = 'none;';
                        }
                        $output .= '<option value="'.$page->ID.'" '.$selected.'>'.$page->post_title.'</option>';
                    };
                    $output .= '<option disabled>---</option>';
                    $output .= '<option value="externalPage"'.$selected.'>Link to external Page</option>';
                    $output .= '</select>';



                    if($exsistingSections){
                        foreach($exsistingSectionsArray as $section) {
                            $title =  get_post_meta( $post->ID, 'section_title_'.$section, true );
                            $content =  get_post_meta( $post->ID, 'section_content_'.$section, true );
                            $image =  get_post_meta( $post->ID, 'section_image_'.$section, true );
                            $link =  get_post_meta( $post->ID, 'section_link_'.$section, true );
                            $button = get_post_meta( $post->ID, 'section_button_'.$section, true );
                            $imageLink = get_post_meta( $post->ID, 'section_image_link_'.$section, true );
                            $externalLink = get_post_meta( $post->ID, 'section_link_external_'.$section, true );

                            if(!$button){
                                $button = "Read More";
                            }
                            if($imageLink !== 'on'){
                                $checked = null;
                            } else{
                                $checked = 'checked';
                            }
                            $selected = "selected";

                            $output .= '<hr><div class="newAlternatingSection" data-id="'.$section.'">';
                                $output .= '<h3>Section</h3>';
                                $output .= '<div>';
                                    $output .= '<div class="form-group">';
                                        $output .= '<label>Section Title</label>';
                                        $output .= '<input class="customInput" type="text" name="section_title_'.$section.'" value="'.$title.'">';
                                    $output .= '</div>';
                                    $output .= '<div class="form-group">';
                                        $output .= '<label>Section Content (required)</label>';
                                        $output .= '<textarea rows="4" id="section_content_'.$section.'" class="customTextarea" name="section_content_'.$section.'">'.$content.'</textarea>';
                                    $output .= '</div>';
                                $output .= '</div>';
                                $output .= '<div class="halfSection">';
                                    $output .= '<div class="form-group">';
                                        $output .= '<label>Section Image</label>';
                                        $output .= '<input type="number" value="'.$image.'" class="customInput regular-text process_custom_images" name="section_image_'.$section.'" max="" min="1" step="1" readonly style="display:block">';
                                        $output .= '<button class="set_custom_images button">Set Image ID</button>';
                                    $output .= '</div>';
                                    $output .= '<div class="form-group">';
                                        $output .= '<label>Image Clickable </label>';
                                        $output .= '<input type="checkbox" '.$checked.' name="section_image_link_'.$section.'">';
                                    $output .= '</div>';
                                $output .= '</div>';
                                $output .= '<div class="halfSection">';
                                    $output .= '<div class="form-group">';
                                        $output .= '<label>Link to Page </label><br>';
                                        $output .= '<select class="customInput" name="section_link_'.$section.'">';
                                        $output .= '<option value="null">What page do you want to link to?</option>';
                                        foreach($pages as $page){
                                            if ( $page->ID == $link ) {
                                                $selected = 'selected';
                                            } else if($link == 'externalPage'){
                                                $selected = 'selected';
                                                $display = 'block';
                                            }else {
                                                $selected = null;
                                                $display = 'none;';
                                            }
                                            $output .= '<option value="'.$page->ID.'" '.$selected.'>'.$page->post_title.'</option>';
                                        };
                                        $output .= '<option disabled>---</option>';
                                        $output .= '<option value="externalPage"'.$selected.'>Link to external Page</option>';
                                        $output .= '</select>';
                                        $output .= '<div class="externalLink" style="display:'.$display.';"><label>External Link</label><input type="text" class="customInput" name="section_external_link_'.$section.'" value="'.$externalLink.'"></div>';
                                    $output .= '</div>';
                                    $output .= '<div class="form-group">';
                                        $output .= '<label>Button Label</label>';
                                        $output .= '<input type="text" value="'.$button.'" class="customInput" name="section_button_'.$section.'">';
                                    $output .= '</div>';
                                $output .= '</div>';
                                $output .= '<div class="form-group">';
                                    $output .= '<button class="remove_section_button button">Remove Section</button>';
                                $output .= '</div>';
                            $output .= '</div>';

                        }
                    }

                break;
                default:
                    $output .= '<div class="form-group"><label for="' . $id . '">' . $field['title'] . '</label><input class="customInput" id="' . $id . '" type="text" name="' . $id . '" value="' . $custom[$id][0] . '" style="width: 100%;" /></div>';
                break;
            }
        }
    }
    echo $output;
}

function save_metaboxes( $post_id ) {

    global $metaboxes;

    if ( ! wp_verify_nonce( $_POST['post_format_meta_box_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    if ( 'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) )
            return $post_id;
    } elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }
    $post_type = get_post_type();

    foreach ( $metaboxes as $id => $metabox ) {
        if ( $metabox['applicableto'] == $post_type ) {
            $fields = $metaboxes[$id]['fields'];

            foreach ( $fields as $id => $field ) {
                $old = get_post_meta( $post_id, $id, true );
                $new = $_POST[$id];

                if ( $new && $new != $old ) {
                    update_post_meta( $post_id, $id, $new );
                }
                elseif ( '' == $new && $old || ! isset( $_POST[$id] ) ) {
                    delete_post_meta( $post_id, $id, $old );
                }
            }
        }
    }

    if($_POST['deletingSections']){
        $exsistingDeleteArray = explode(',', $_POST['deletingSections']);
        if(sizeof($exsistingDeleteArray) > 0){
            update_post_meta( $post_id, 'sectionArray', $_POST['exsistingSections'] );
            foreach($exsistingDeleteArray as $section) {
                $title =  get_post_meta( $post->ID, 'section_title_'.$section, true );
                $content =  get_post_meta( $post->ID, 'section_content_'.$section, true );
                $image =  get_post_meta( $post->ID, 'section_image_'.$section, true );
                $imageLink = get_post_meta( $post->ID, 'section_image_link_'.$section, true );

                delete_post_meta( $post_id, 'section_title_'.$section);
                delete_post_meta( $post_id, 'section_content_'.$section);
                delete_post_meta( $post_id, 'section_image_'.$section);
                delete_post_meta( $post_id, 'section_link_'.$section);
                delete_post_meta( $post_id, 'section_button_'.$section);
                delete_post_meta( $post_id, 'section_image_link_'.$section);

            }
        }
    }
    if($_POST['exsistingSections']){
        $exsistingSectionsArray = explode(',', $_POST['exsistingSections']);
        if(sizeof($exsistingSectionsArray) > 0){
            update_post_meta( $post_id, 'sectionArray', $_POST['exsistingSections'] );
            foreach($exsistingSectionsArray as $section) {
                update_post_meta( $post_id, 'section_title_'.$section, $_POST['section_title_'.$section] );
                update_post_meta( $post_id, 'section_content_'.$section, $_POST['section_content_'.$section] );
                update_post_meta( $post_id, 'section_image_'.$section, $_POST['section_image_'.$section] );
                if($_POST['section_link_'.$section] !== 'null' || $_POST['section_link_'.$section] != 'externalPage'){
                    update_post_meta( $post_id, 'section_link_'.$section, $_POST['section_link_'.$section] );
                    update_post_meta( $post_id, 'section_button_'.$section, $_POST['section_button_'.$section] );
                    delete_post_meta( $post_id, 'section_link_external_'.$section);
                }
                if($_POST['section_image_link_'.$section] !== Null){
                    update_post_meta( $post_id, 'section_image_link_'.$section, $_POST['section_image_link_'.$section] );
                }
                if($_POST['section_link_'.$section] == 'externalPage'){
                    update_post_meta( $post_id, 'section_link_external_'.$section, $_POST['section_external_link_'.$section] );
                    update_post_meta( $post_id, 'section_link_'.$section, $_POST['section_link_'.$section] );

                }
            }
        }
    }

}
add_action( 'save_post', 'save_metaboxes' );

add_action( 'admin_print_scripts', 'display_metaboxes', 1000 );

function display_metaboxes() {
    global $metaboxes;
    if ( get_post_type() === "page" ) : ?>
        <script type="text/javascript">// <![CDATA[
            $ = jQuery;
            <?php
            $formats = $ids = array();
            foreach ( $metaboxes as $id => $metabox ) {
                if($metabox['display_condition']){
                    array_push( $formats, "'" . $metabox['display_condition'] . "': '" . $id . "'" );
                    array_push( $ids, "#" . $id );
                }
            }
            ?>
            var formats = { <?php echo implode( ',', $formats );?> };
            var ids = "<?php echo implode( ',', $ids ); ?>";
            function displayMetaboxes() {

            $(ids).hide();

            var selectedElt = $("input[name='post_format']:checked").attr("id");
            var selectedTemplate = $("select#page_template option:selected").text();

            if ( formats[selectedTemplate] )
                $("#" + formats[selectedTemplate]).fadeIn();
        }

        $(function() {
            displayMetaboxes();

            $("select#page_template").change(function() {
                // $('.customInput').val('');
                displayMetaboxes();
            });
        });

        // ]]></script>
    <?php
    endif;
}
