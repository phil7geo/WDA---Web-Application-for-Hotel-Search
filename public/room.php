<?php

require __DIR__.'/../boot/boot.php';

//Let every site to read the resources( maybe from console with jQuery.ajax('https:/...');)
// header('Access-Control-Allow-Origin: collegelink.gr');

use Hotel\Room;
use Hotel\Favorite;
use Hotel\Review;
use Hotel\User;
use Hotel\Booking;

//Initialize Room Service
$room = new Room();

//Get Favorite rooms
$favorite = new Favorite();

//Check for room id
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
  header('Location: index.php');
  
  return;
}

//Load room info
$roomInfo = $room->get($roomId);
if (empty($roomInfo)) {
  header('Location: index.php');
  
  return;
}

// Get current user id 
$userId = User::getCurrentUserId();

//Check if room is favorite for current user
$isFavorite = $favorite->isFavorite($roomId, $userId);

//Load all room reviews
$review = new Review();
$allReviews = $review->getReviewsByRoom($roomId);

//Check for booking room 
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$alreadyBooked = empty($checkInDate) || empty($checkOutDate);
if (!$alreadyBooked) {
  // Look for booking 
    $booking = new Booking();
    $alreadyBooked = $booking->isBooked($roomId, $checkInDate, $checkOutDate);
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <title>Room Page</title>
        <style type="text/css">
            body {
               background: #333;
            }
        </style>
        
        <!-------JAVASCRIPT FOR GOOGLE MAP-------------->
        <script>
            function myMap() {
              const mapProp = {
                 center:new google.maps.LatLng(<?php echo $roomInfo['location_lat'] ?>, <?php echo $roomInfo['location_long'] ?>),
                zoom:17,
              };
              const map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

              const marker = new google.maps.Marker({
                  position: new google.maps.LatLng(<?php echo $roomInfo['location_lat'] ?>, <?php echo $roomInfo['location_long'] ?>),
                  map,
                  title: "Hotels!",
                });

                marker.setMap(map);
            }
        </script>

        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script src="assets/pages/room.js"></script>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        
        <!--  Add bootstrap icon Library  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
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

        <!-- Script to submit the input heart checkbox at the favoriteForm-->
        <script>
            $(document).ready(function(){
                $("#favoriteForm").on("change", "input:checkbox", function(){
                    $("#favoriteForm").submit();
                });
            });
        </script>

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
                                        <img src="assets/images/icons/user.png" style="color:#b50707; box-sizing:border-box;"/>
                                        <a href="profile.php">Profile</a>
                                  </li>
                            </ul>
                     </div>
              </div>
          </header>


            <!--Main section start-->
             <section class="container">

                 <!-- WITH NAME,INFO,REVIEWS,STARS,HEART,PRICE-->
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="heading-1">
                          <p>
                                <?php echo sprintf('%s - %s, %s', $roomInfo['name'], $roomInfo['city'], $roomInfo['area']) ?> |
                                  <span>Reviews:</span>
                                  <?php
                                    $roomAvgReview = $roomInfo['avg_reviews'];
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($roomAvgReview >= $i) {
                                          ?>
                                          <span class="fa fa-star checked"></span>
                                          <?php
                                        } else {
                                          ?>
                                          <span class="fa fa-star unchecked"></span>
                                          <?php
                                        }
                                    }
                                  ?>

                              <form name="favoriteForm" class="favoriteForm" method="post" id="favoriteForm" action="actions/favorite.php">
                                  <div id="checkbox_heart" class="favorite" style="border-left: 2px solid white; padding-left: 5px;">
                                        <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
                                        <input type="hidden" name="csrf" value="<?php echo User::getCsrf(); ?>">
                                        <input type="hidden" name="is_favorite" value="<?php echo $isFavorite ? '1' : '0'; ?>">
                                        <input type="checkbox" id="heart" name="favorite" 
                                              style="display:none;" onchange="document.getElementById('favoriteForm').submit()"/>
                                        <label for="heart" title="Favorite" class="heart <?php echo $isFavorite ? 'selected' : ''; ?>"></label>
                                  </div>
                              </form>

                            <span class="night_price">Per Night: <?php echo $roomInfo['price']; ?>€</span>
                          </p>
                      </div>
                    </div>
                  </div>

                  <!--ROOM IMG-->
                  <div class="row">
                    <div class="col-sm-6">
                      <img src="assets/images/rooms/<?php echo sprintf('%s', $roomInfo['photo_url']) ?>" alt="Room Name">
                    </div>
                  </div>

                  <!--HEADING 1 WITH NAME,INFO,REVIEWS,STARS,HEART,PRICE-->
                  <div class="row">
                    <div class="col-sm-12">
                        <ul class="room_info">

                            <li class="items">
                              <p><i class="fa fa-user" > <?php echo $roomInfo['count_of_guests']; ?></i><br>COUNT OF GUESTS</p>
                            </li>

                            <li class="items">
                              <p><i class="fa fa-bed" > 
                                <?php if ($roomInfo['type_id']== 1) { 
                                                      $roomInfo['type_id']="Single Room"; 
                                                      echo sprintf('%s', $roomInfo['type_id']); 
                                                      } 
                                                      elseif ($roomInfo['type_id']== 2) { 
                                                        $roomInfo['type_id']="Double Room"; 
                                                        echo sprintf('%s', $roomInfo['type_id']); 
                                                        }
                                                        elseif ($roomInfo['type_id']== 3) { 
                                                          $roomInfo['type_id']="Triple Room"; 
                                                          echo sprintf('%s', $roomInfo['type_id']); 
                                                          }
                                                          elseif ($roomInfo['type_id']== 4) { 
                                                            $roomInfo['type_id']="Fourfold Room"; 
                                                            echo sprintf('%s', $roomInfo['type_id']); 
                                                            }
                                ?>
                                </i><br>TYPE OF ROOM</p>
                            </li>

                            <li class="items">
                              <p><i class="fa fa-parking" > <?php if ($roomInfo['parking']== 1) { 
                                                                  $roomInfo['parking']="Yes"; 
                                                                  echo sprintf('%s', $roomInfo['parking']); 
                                                                  } 
                                                                    elseif ($roomInfo['parking']== 0) { 
                                                                      $roomInfo['parking']="No"; 
                                                                      echo sprintf('%s', $roomInfo['parking']); 
                                                                    }
                                                            ?></i><br>PARKING
                              </p>
                            </li>

                            <li class="items">
                              <p><i class="fa fa-wifi" > <?php if ($roomInfo['wifi']== 1) { 
                                                                  $roomInfo['wifi']="Yes"; 
                                                                  echo sprintf('%s', $roomInfo['wifi']); 
                                                                  } 
                                                                    elseif ($roomInfo['wifi']== 0) { 
                                                                      $roomInfo['wifi']="No"; 
                                                                      echo sprintf('%s', $roomInfo['wifi']); 
                                                                    }
                                                          ?></i><br>WIFI
                                </p>
                            </li>

                            <li class="items">
                              <p><i class="fa fa-paw" > <?php if ($roomInfo['pet_friendly']== 1) { 
                                                                  $roomInfo['pet_friendly']="Yes"; 
                                                                  echo sprintf('%s', $roomInfo['pet_friendly']); 
                                                                  } 
                                                                    elseif ($roomInfo['pet_friendly']== 0) { 
                                                                      $roomInfo['pet_friendly']="No"; 
                                                                      echo sprintf('%s', $roomInfo['pet_friendly']); 
                                                                    }
                                                          ?></i><br>PET FRIENDLY
                                </p>                            
                            </li>

                        </ul>
                      </div>
                    </div>

                    <!--ROOM DESCRIPTION-->
                    <div class="row">
                      <div class="col-sm-12">
                        <div id="description">
                          <h1 style="margin: 0px 700px 15px 0px;">Room Description</h1>
                          <p style="margin: 0px 40px 60px 10px; font-size: 12px;">
                            <?php echo sprintf('%s', $roomInfo['description_long']) ?>
                          </p>
                        </div>
                      </div>
                    </div>

                    <!--BUTTONS-BOOK NOW,ALREADY BOOKED-->
                      <div class="row">
                        <div class="col-sm-12">
                          <div id="button links" class="book_button">
                              <?php 
                                  if ($alreadyBooked) {
                              ?>                                  
                                  <span class="btn btn-brick button-disabled" >
                                        Already Booked</span>
                              <?php 
                                  } else {
                              ?>
                                  <form name="BookForm" method="post" action="actions/book.php">
                                      <input type="hidden" name="room_id" value="<?php echo $roomId ?>">
                                      <input type="hidden" name="csrf" value="<?php echo User::getCsrf(); ?>">
                                      <input type="hidden" name="check_in_date" value="<?php echo $checkInDate; ?>">
                                      <input type="hidden" name="check_out_date" value="<?php echo $checkOutDate; ?>">
                                      <button class="btn btn-brick" type="submit" >
                                        Book Now</button>
                                  </form>
                              <?php 
                                    }
                              ?>
                          </div>
                        </div>
                      </div>

                      <!--GOOGLE MAP-->
                      <div class="row">
                        <div class="col-sm-12">
                          <div id="googleMap">
                          </div>
                        </div>
                      </div>

                      <!--Reviews-->
                      <div class="row" style="padding-top: 30px;">
                          <div class="col-sm-12">
                            <div id="description">
                              <h1 style="margin: 0px 820px 0px 0px; color: grey; font-size: 20px;">Reviews</h1>
                              <div id="room-reviews-container">
                                    <?php 
                                        foreach ($allReviews as $counter => $review) {
                                    ?>
                                        <div class="room-reviews" id="reviews" style="margin: 30px 735px 0px 0px;">
                                              <p style="padding-right: 90px;"><?php echo sprintf('%d. %s', $counter +1, $review['user_name']); ?>
                                              <div class="div-reviews" style="padding-right: 60px;">
                                                  <?php
                                                    // $roomAvgReview = $review['review'];
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

                                              </p>
                                              <p style="font-size: 10px; margin: -10px 0px 0px 0px;">Created at: <?php echo $review['created_time']; ?></p>
                                              <p style="font-size: 10px; margin: 20px 50px 0px 0px;"><?php echo htmlentities($review['comment']); ?></p>
                                        </div>
                                    <?php
                                        }
                                    ?>
                              </div>
                              <?php 
                                  if (count($allReviews) == 0) {
                              ?>
                                      <h1 class="check-review" style="text-align:center; color:red;">No reviews yet!!</h1>
                              <?php
                                  }
                              ?>
                            </div>
                          </div>
                        </div>

                        <!--Add review-form-->
                        <div class="row">
                          <div class="col-sm-12">
                              <div id="description">
                                  <h1 style="margin: 50px 795px 30px 0px; color: grey; font-size: 20px;">Add review</h1>
                                  <form name="reviewForm" class="reviewForm" method="post" action="actions/review.php">
                                      <input type="hidden" name="room_id" value="<?php echo $roomId ?>">
                                      <input type="hidden" name="csrf" value="<?php echo User::getCsrf(); ?>">
                                      <div id="radio_stars" class="rating">
                                          <input type="radio" id="star5" name="rate" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                          <input type="radio" id="star4" name="rate" value="4" /><label class = "full" for="star4" title="Very Very good - 4 stars"></label>
                                          <input type="radio" id="star3" name="rate" value="3" /><label class = "full" for="star3" title="Not so good - 3 stars"></label>
                                          <input type="radio" id="star2" name="rate" value="2" /><label class = "full" for="star2" title="bad - 2 stars"></label>
                                          <input type="radio" id="star1" name="rate" value="1" /><label class = "full" for="star1" title="Terrible - 1 star"></label>
                                      </div>
                                      <div class="textarea-form-group controls">
                                          <textarea name="comment" id="review_comment" class="form-control_landing review-textarea" rows="2" 
                                                    placeholder="Review" data-validation-required-message="Please enter a review." required></textarea>
                                      </div>
                                          <button type="submit" id="reviewbtn" class="btn btn-brick">Submit</button>
                                  </form>
                              </div>
                          </div>
                        </div>

             </section>

         <footer>
             <p>(c) Copyright Collegelink 2020 </p>
         </footer>

         <link rel="stylesheet" href="assets/css/fontawesome.min.css" />
         <link href="assets/css/styles_room.css" type="text/css" rel="stylesheet" />

         <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4m1W7Z2xDCivBA0b8urzWtIXBoKN9mXQ&callback=myMap&libraries=&v=weekly" async></script>
     </body>
 </html>
