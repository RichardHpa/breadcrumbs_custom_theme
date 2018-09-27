<?php
/*
	Template Name: Downloads Template
*/

  $response = "";
  function my_contact_form_generate_response($type, $message){

    global $response;

    if($type == "success") $response = "<div class='success'>{$message}</div>";
    else $response = "<div class='error'>{$message}</div>";
  }
  //response messages
  $missing_content = "Please supply all information.";
  $email_invalid   = "Email Address Invalid.";
  $message_unsent  = "Message was not sent. Try Again.";
  $message_sent    = "Thanks! Your message has been sent.";

  //user posted variables
  $name = $_POST['message_name'];
  $email = $_POST['message_email'];
  $location = $_POST['message_location'];
  $messageMessage = $_POST['message_message'];

  $message  = "Name :" . $name ."\n";
  $message .= "Email :" .  $email     ."\n";
  $message .= "Location :" .  $location    ."\n";
  $message .= "Message :" . $messageMessage ."\n";
  if($option){
      $message .= "Which Breadcrumbs promotional options interest you? :" .  $option     ."\n";
  }

  $to = get_option('admin_email');
  $subject = "Someone sent a message from ".get_bloginfo('name');
  $headers = 'From: '. $email . "\r\n" .
    'Reply-To: ' . $email . "\r\n";

  if(!$_POST == 0){

      if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        my_contact_form_generate_response("error", $email_invalid);
      else
      {

        if(empty($name) || empty($message)){
          my_contact_form_generate_response("error", $missing_content);
        }
        else
        {
          $sent = wp_mail($to, $subject, strip_tags($message), $headers);
          if($sent) my_contact_form_generate_response("success", $message_sent); //message sent!
          else my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
        }
      }
  }
  else if ($_POST['submitted']) my_contact_form_generate_response("error", $missing_content);

get_header(); ?>

<?php if(have_posts()): ?>
    <div class="container content">
        <?php while(have_posts()): the_post();?>
            <div class="row justify-content-md-center">
                <div class="col-12 wp_content">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

<?php if(get_post_meta( $id , 'sectionArray', true)): ?>
    <?php
        $count = get_post_meta( $id , 'sectionArray', true);
        $countArray = explode(',', $count);
    ?>
    <div class="container-fluid aboutSection pb-5">
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

<?php endif; ?>

<div class="container form mt-5 mb-5">
    <div class="row justify-content-md-center">
        <div class="col-12 col-md-10">
            <style type="text/css">
              .error{
                padding: 5px 9px;
                border: 1px solid red;
                color: red;
                border-radius: 3px;
              }

              .success{
                padding: 5px 9px;
                border: 1px solid green;
                color: green;
                border-radius: 3px;
              }

              form span{
                color: red;
              }
            </style>
            <div id="respond">
              <?php echo $response; ?>
            <div class="d-flex justify-content-center align-items-center container ">
                <div class="col-6">
                    <form action="<?php the_permalink(); ?>" method="post">
                        <div class="form-group col-12">
                            <label for="name">Name: <span class="text-muted">(required)</span></label>
                            <input type="text" class="form-control" name="message_name" value="<?php echo esc_attr($_POST['message_name']); ?>">
                        </div>
                        <div class="form-group col-12">
                            <label for="email">Email: <span class="text-muted">(required)</span></label>
                            <input type="email" class="form-control" name="message_email" value="<?php echo esc_attr($_POST['message_email']); ?>">
                        </div>
                        <div class="form-group col-12">
                            <label for="location">Location: </label>
                            <input type="text" class="form-control" name="message_location" value="<?php echo esc_attr($_POST['message_location']); ?>">
                        </div>
                        <div class="form-group col-12">
                            <label for="company">Message: </label>
                            <textarea class="form-control" rows="5" type="text" name="message_message"><?php echo esc_textarea($_POST['message_message']); ?></textarea>
                        </div>
                        <div class="form-group col-4">
                            <input type="hidden" name="submitted" value="1">
                            <input type="submit" class="form-control btn btn-breadcrumbs">
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>




<?php  get_footer(); ?>
