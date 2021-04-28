<?php

require __DIR__.'/../boot/boot.php';

use Hotel\User;

//Check for existing logged in user
if (!empty(User::getCurrentUserId())) {
  header('Location: /public/index.php'); die;
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <title>Register</title>
        <style type="text/css">
            body {
               background: #333;
            }
        </style>
          <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          />
        <script src="assets/js/form.js" type="text/javascript"></script>
    </head>
      <body>
          <header>
              <div class="container">
                  <a href="list.php" class="Hotels">
                    <p class="main-logo">Hotels</p>
                  </a>
                  <a href="login.php" target="_blank" class="home">
                      <i class="fas fa-home"></i>
                      Home
                  </a>
              </div>
          </header>

          <main class="main-content register page-home">
              
              <!--Main section start-->
              <section class="hero" style="margin-top: -90px;">

                        <!--Register Form section start for new user-->
                      <form method="post" action="actions/register.php">
                                <?php 
                                  if (!empty($_GET['error'])) { 
                                ?>
                                    <div class ="alert alert-danger alert-styled-left">Register Error</div>
                                <?php 
                                  }  
                                ?>
                                <div class="row" id="form-introduction">
                                    <div class="form_group_introduction">
                                        <label for="name" class="form-label">Your Name</label>
                                        <input id="name" class="form-control" placeholder="Your Name" type="text" name="name">
                                    </div>
                                </div>
                                <div class="text-danger name-error" style="margin-top: -15px; color: #b50707; font-size: 12px;">
                                    Must be a valid name!
                                </div>
                                <div class="row" id="form-introduction">
                                      <div class="form_group_introduction">
                                          <label for="email" class="form-label">Your E-mail Address</label>
                                          <input id="email" class="form-control" placeholder="Your E-mail Address" type="email" name="email">
                                      </div>
                                </div>
                                <div class="text-danger email-error" style="margin-top: -15px; color: #b50707; font-size: 12px;">
                                    Must be a valid email address!
                                </div>
                                <div class="row" id="form-introduction">
                                         <div class="form_group_introduction">
                                             <label for="email_repeat" class="form-label">Verify your address</label>
                                             <input id="email_repeat" class="form-control" placeholder="Verify your address" type="email" name="email_repeat">
                                         </div>
                                </div>
                                <div class="text-danger email_repeat-error" style="margin-top: -15px; color: #b50707; font-size: 12px;">
                                    Repeat your valid email address!
                                </div>
                                <div class="row" id="form-introduction">
                                        <div class="form_group_introduction">
                                            <label for="password" class="form-label">Your password</label>
                                            <input id="password" class="form-control" placeholder="Your password" type="password" name="password">
                                        </div>
                                </div>
                                <div class="text-danger password-error" style="margin-top: -15px; color: #b50707; font-size: 12px;">
                                    Password must be more than 4 characters!
                                </div>
                                <div class="form_group_introduction">
                                        <button class="btn_landing btn-brick" name="submit" disabled type="submit" id="submitButton">Register</button>
                                </div>
                      </form>
                      <!--form section end-->

              </section>

          </main>
          <footer>
              <p>(c) Copyright Collegelink 2020 </p>
          </footer>

          <link rel="stylesheet" href="assets/css/fontawesome.min.css" />
          <link href="assets/css/login.css" type="text/css" rel="stylesheet" />
      </body>
  </html>
