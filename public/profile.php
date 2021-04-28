<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Favorite;
use Hotel\Review;
use Hotel\Booking;
use Hotel\User;

// Check for existing logged in user
$userId = User::getCurrentUserId();

if (empty($userId)) {
    header('Location: index.php');

    return;
  }

//Get all favorites 
$favorite = new Favorite();
$userFavorites = $favorite->getListByUser($userId);

//Get all reviews 
$review = new Review();
$userReviews = $review->getListByUser($userId);

//Get all user bookings
$booking = new Booking();
$userBookings = $booking->getListByUser($userId);

?>


<!DOCTYPE html>
<html>
    <head>
        <meta name="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <title>Profile Page</title>
        <style type="text/css">
            body {
               background: #333;
            }
        </style>

        <!-- Add icon library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">

        <!--CHECKED(FULL) OR NOT CHECKED STAR----->
        <style>
            .checked {
                color : #ffc107;
                font-size : 15px;
            }
            .unchecked {
                font-size : 15px;
            }
        </style>

      </head>
        <body>
            <header>
                <div class="container">
                        <div class="primary-menu text-right">
                              <ul>
                                    <li class="main-logo" style="position:absolute; left:400px;">
                                      <a href="list.php">
                                        <strong>Hotels</strong>
                                      </a>
                                    </li>
                                    <li><a href="index.php" target="_blank">
                                      <i class="fas fa-home"></i>
                                            Home
                                        </a>
                                    </li>
                                    <li>
                                          <img src="assets/images/icons/user.png" style="color:#b50707;"/>
                                          <a href="profile.php">Profile</a>
                                    </li>
                              </ul>
                       </div>
                </div>
            </header>

            <!--Main section start-->
            <main class="main-content view_profile page-home">

              <!-- Μain div starts (search_box and results) -->
              <div class="container">

                    <!-- FORM-SEARCH BOX HOTEL WITH FILTERS  -->
                    <aside class="favorite-review box">

                            <div class="favorites">
                                    <h1>FAVORITES</h1>
                                    <?php 
                                        if (count($userFavorites) > 0) {
                                    ?>
                                        <ol style="margin-left: -8px;">
                                            <?php 
                                                foreach ($userFavorites as $favorite) {
                                            ?>
                                            <li style="margin-left: -10px;">
                                                <a href="room.php?room_id=<?php echo $favorite['room_id']; ?>" style="text-decoration: none; color: black;">
                                                    <p class="room-name"><?php echo $favorite['name']; ?></p>
                                                </a>
                                            </li>
                                            <?php 
                                                }
                                            ?>
                                        </ol>
                                    <?php 
                                        } else {
                                    ?>
                                        <p class="msg alert">You don't have any favorite Hotel !!!</p>
                                    <?php
                                        }
                                    ?>
                            </div>

                            <div class="reviews">
                                <h1>REVIEWS</h1>
                                <?php 
                                    if (count($userReviews) > 0) {
                                ?>
                                <ol style="margin-left: -8px;">
                                    <?php 
                                            foreach ($userReviews as $review) {
                                    ?>
                                    <li style="margin-left: -10px;">
                                        <a href="room.php?room_id=<?php echo $review['room_id']; ?>" style="text-decoration: none; color: black;">
                                            <p class="room-name"><?php echo $review['name']; ?></p>
                                        </a>
                                        <div class="stars">
                                            <?php
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($review['rate'] >= $i) {
                                                    ?>
                                                    <span class="fa fa-star checked" style="font-size: 12px;"></span>
                                                    <?php
                                                    } else {
                                                    ?>
                                                    <span class="fa fa-star unchecked" style="font-size: 12px;"></span>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                        </div>
      
                                    </li> 
                                    <?php 
                                            }
                                    ?> 
                                </ol> 
                                <?php 
                                    } else {
                                ?>
                                <p class="msg">You haven't made any review yet !!!</p>
                                <?php
                                      }
                                ?>
                            </div>
                                 
                      </aside>

                    <!-- RESULTS WITH HOTELS -->
                    <section class="hotel-list box">
                          <header class="page-title">
                              <h2>My bookings</h2>
                          </header>
                          <div>
                                <?php
                                    if (count($userBookings) > 0) {
                                ?>
                                    <section>
                                        <?php
                                            foreach ($userBookings as $booking) {
                                        ?>
                                        <article class="hotel">
                                            <aside class="media">
                                                    <img src="assets/images/rooms/<?php echo $booking['photo_url']; ?>" alt="Room" width="100%" height="auto">
                                                    <div class="overlay">
                                                        <a href="room.php?room_id=<?php echo $booking['room_id']; ?> ">
                                                        <i class="fas fa-camera"></i>
                                                        </a>
                                                    </div>
                                            </aside>

                                            <main class="info">
                                                <h1><?php echo $booking['name']; ?></h1>
                                                <h2><?php echo sprintf('%s, %s', $booking['city'], $booking['area']); ?></h2>
                                                <p><?php echo $booking['description_short']; ?></p>

                                                <div class="text-right">
                                                    <button><a href="room.php?room_id=<?php echo $booking['room_id']; ?> ">Go to Room Page</a></button>
                                                </div>
                                            </main>
                                            <section class="informations">
                                                <div class="night" style="float: left; width: 95px; padding-right: 17px;">
                                                <h3>Total Cost: <?php echo $booking['total_price']; ?>€</h3>
                                                </div>
                                                <div class="room-dates-types" style="display: flex; width: 79%; padding: 10px;">
                                                    <h5>Check-in Date: <?php echo $booking['check_in_date']; ?></h5>
                                                    <h5 style="border-left: 0px solid #7e7e7e; margin: 0px 0px 0px -30px; border-left-width: thin;">
                                                        Check-out Date: <?php echo $booking['check_out_date']; ?>
                                                    </h5>

                                                    <h5 style="border-left: 0px solid #7e7e7e; box-sizing: border-box; margin: 0px 0px 0px -14px; border-left-width: thin;">
                                                    Type of Room: 
                                                    <?php if ($booking['type_id']== 1) { 
                                                            $booking['type_id']="Single Room"; 
                                                            echo $booking['type_id']; 
                                                            } 
                                                            elseif ($booking['type_id']== 2) { 
                                                                $booking['type_id']="Double Room"; 
                                                                echo $booking['type_id']; 
                                                                }
                                                                elseif ($booking['type_id']== 3) { 
                                                                $booking['type_id']="Triple Room"; 
                                                                echo $booking['type_id']; 
                                                                }
                                                                elseif ($booking['type_id']== 4) { 
                                                                    $booking['type_id']="Fourfold Room"; 
                                                                    echo $booking['type_id']; 
                                                                    }
                                                    ?>
                                                    </h5>
                                                </div>
                                            </section>
                                        </article>
                                        <?php 
                                            }
                                        ?>
                                    </section>
                                <?php
                                    } else {
                                ?>
                                    <p class="msg">You don't have any booking !!!</p>
                                    <hr>
                                <?php
                                      }
                                ?>
                            </div>
                    </section>
              </div>
            </main>

            <footer>
                <p>(c) Copyright Collegelink 2020 </p>
            </footer>

            <link rel="stylesheet" href="assets/css/fontawesome.min.css" />
            <link href="assets/css/styles_profile.css" type="text/css" rel="stylesheet" />
        </body>
  </html>
