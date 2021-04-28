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
        <title>Log in</title>
        <style type="text/css">
            body {
               background: #333;
            }
        </style>
          <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          />
        <script src="assets/js/FormLogin.js" type="text/javascript"></script>
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

          <main class="main-content login page-home">
              
              <!--Main section start-->
              <section class="hero">

                        <!--ΦΟΡΜΑ ΓΙΑ ΕΙΣΟΔΟ ΜΕ ΣΥΜΠΛΗΡΩΣΗ ΣΤΟΙΧΕΙΩΝ ΛΟΓΑΡΙΑΣΜΟΥ ΧΡΗΣΤΗ ΣΤΑ ΑΝΤΙΣΤΟΙΧΑ ΠΕΔΙΑ -->
                        <!--Form section start-->
                      <form method="post" action="actions/login.php">
                                <?php 
                                  if (!empty($_GET['error'])) { 
                                ?>
                                <div class ="alert alert-danger alert-styled-left">Login Error</div>
                                 <?php }  ?>
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
                                        <label for="password" class="form-label">Your password</label>
                                        <input id="password" class="form-control" placeholder="Your password" type="password" name="password">
                                    </div>
                                </div>
                                <div class="text-danger password-error" style="margin-top: -15px; color: #b50707; font-size: 12px;">
                                    Password must be more than 4 characters!
                                </div>
                                <div class="form_group_introduction">
                                    <button class="btn_landing btn-brick" name="submit" disabled type="submit" id="submitButton">Login</button>
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
