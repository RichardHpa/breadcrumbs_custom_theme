<?php
/*
	Template Name: Promotions Template
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
  $company = $_POST['message_company'];
  $location = $_POST['message_location'];
  $option = $_POST['message_whichOption'];

  $message  = "Name :" . $name ."\n";
  $message .= "Company :" .  $company  ."\n";
  $message .= "Email :" .  $email     ."\n";
  $message .= "Location :" .  $location    ."\n";
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

        if(empty($name) || empty($message) || empty($company) || empty($location)){
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

<?php if(get_post_meta($id, 'page_description', true)): ?>
    <?php $pageDescription = get_post_meta($id, 'page_description', true); ?>
    <div class="section text-center mt-5">
        <div class="container quote">
            <h2><?php echo $pageDescription ?></h2>
        </div>
    </div>
<?php endif; ?>

<?php
    $args = array(
        'post_type' => 'promotions_icons'
    );
    $promotions = new WP_Query( $args );
?>

<?php if($promotions->have_posts()): ?>
    <div class="container mt-5 promotions">
        <div class="row">
            <div class="col-12">
                <div class="card-deck icons-deck text-center">
                    <?php while($promotions->have_posts()): $promotions->the_post();?>
                        <?php $postId = get_the_id();?>
                            <div class="card icon-card">
                                <a href="#post_<?=$postId;  ?>">
                                    <img class="card-img-top" src="<?= get_the_post_thumbnail_url() ?>" alt="Card image cap">
                                    <div class="card-body">
                                      <h5 class="card-title"><?php the_title() ?></h5>
                                      <p class="card-text"><?php echo get_post_meta( $id , 'icon_blurb', true); ?></p>
                                    </div>
                                </a>
                            </div>
                    <?php endwhile; ?>
                </div>

            </div>
        </div>
    </div>
<?php endif; ?>


<?php if(get_theme_mod('promotions_large_image_setting')): ?>
    <?php $image = get_theme_mod('promotions_large_image_setting'); ?>
    <div class="container text-center mt-5">
        <img class="img-fluid" src="<?php echo wp_get_attachment_image_src($image, 'large')[0]; ?>" alt="">
    </div>
<?php endif; ?>

<?php if(have_posts()): ?>
    <div class="container content mt-5">
        <?php while(have_posts()): the_post();?>
            <div class="row justify-content-md-center">
                <div class="col-12 wp_content">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

<?php if(get_post_meta( $id , 'page_video', true)): ?>
    <div class="container promo-video video mt-5">
        <?php
            $videoURL = get_post_meta( $id , 'page_video', true);
            $embed_code = wp_oembed_get($videoURL);
        ?>
        <?php echo $embed_code?>
    </div>
<?php endif; ?>

<div class="container form mt-5">
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
              <form action="<?php the_permalink(); ?>" method="post">
                  <div class="col">
                      <h4>Get in touch with us!</h4>
                  </div>

                <div class="form-group col-12 col-md-4">
                    <label for="name">Name: <span class="text-muted">(required)</span></label>
                    <input type="text" class="form-control" name="message_name" value="<?php echo esc_attr($_POST['message_name']); ?>">
                </div>
                <div class="form-group col-12 col-md-4">
                    <label for="email">Email: <span class="text-muted">(required)</span></label>
                    <input type="email" class="form-control" name="message_email" value="<?php echo esc_attr($_POST['message_email']); ?>">
                </div>
                <div class="form-group col-12 col-md-7">
                    <label for="company">Company: <span class="text-muted">(required)</span></label>
                    <textarea class="form-control" rows="5" type="text" name="message_company"><?php echo esc_textarea($_POST['message_company']); ?></textarea>
                </div>
                <div class="form-group col-12 col-md-4">
                    <label for="location">Location: <span class="text-muted">(required)</span></label>
                    <input type="text" class="form-control" name="message_location" value="<?php echo esc_attr($_POST['message_location']); ?>">
                </div>
                <div class="form-group col-12 col-md-4">
                    <label for="whichOption">Comments?:</label>
                    <input type="text" class="form-control" name="message_whichOption" value="<?php echo esc_attr($_POST['message_whichOption']); ?>">
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


<?php if(get_post_meta($id, 'company_main', true)): ?>
    <div class="container">
        <?php echo get_post_meta($id, 'company_main', true)?>
    </div>
<?php endif; ?>

<?php if($promotions->have_posts()): ?>
    <div class="container mt-5 promotionsSection">
        <?php while($promotions->have_posts()): $promotions->the_post();?>
            <?php $postId = get_the_id();?>
            <a id="post_<?=$postId ?>" class="anchor"></a>
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <h3><?php the_title(); ?></h3>
                    <?php the_content(); ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

<?php
    $args = array(
        'post_type' => 'companies'
    );
    $companies = new WP_Query( $args );
?>

<?php if($companies->have_posts()): ?>
    <div class="container-fluid companies mt-5 p-5">
        <div class="container text-center">
            <h4>Companies We Have Worked With</h4>
            <div class="companyIcons">
                <?php while($companies->have_posts()): $companies->the_post();?>
                    <div class="companyIcon">
                        <?php the_post_thumbnail('companies_thumb', ['class' => 'img-fuild responsive--full', 'title' => 'Company Icon']); ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php  get_footer(); ?>
