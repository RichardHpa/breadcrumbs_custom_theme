<?php
 /**
 * Maintenance mode template
 */
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
     <head>
         <meta charset="utf-8">
         <title>Breadcrumbs - In Maintenance</title>
         <?php wp_head(); ?>

        <style media="screen">
            #bannerImage{
                height: 100vh;
                color: white;
            }
            h1{
                font-family: museosansrounded;
                font-size: 5em;
            }
        </style>
     </head>
     <body>
         <div id="bannerImage" class="d-flex">
             <div class="container align-self-center text-center">
                 <div class="col">
                     <h1>Breadcrumbs site is<br>currently updating</h1>
                     <h2 class="mt-5">Please check back shortly ☺️</h2>
                 </div>
             </div>
         </div>

         <?php wp_footer(); ?>
     </body>
 </html>
