<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Room;
use Hotel\RoomType;

//Initialize Room Service
$room = new Room();

//Get cities
$cities = $room->getCities();


//Get all room types
$type = new RoomType();
$allTypes = $type->getAllTypes();

//Get page parameters
$selectedCity =  $_REQUEST['city']; 
$selectedTypeId = $_REQUEST['room_type'];
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];

$roomId = $_REQUEST['room_id'];

//Prices from form slider
if(!empty($_REQUEST['price-min'])) {
    $minimumPrice = $_REQUEST['price-min'];
} else {
    $minimumPrice = 0;
}

if(!empty($_REQUEST['price-max'])) {
    $maximumPrice = $_REQUEST['price-max'];
} else {
    $maximumPrice = 5000;
}

//Load room info
$roomInfo = $room->get($roomId);


//Search for room

$allAvailableRooms = $room->search($minimumPrice, $maximumPrice, new DateTime($checkInDate), new DateTime($checkOutDate), $selectedCity, $selectedTypeId);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <title>Search Results</title>
        <style type="text/css">
            body {
               background: #333;
            }
        </style>
        
        <!-- Add icon library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="assets/pages/search.js"></script>

    <!-- JAVASCRIPT FOR CHECK DATES -->
        <script type="text/javascript" style="color: black;">
            $( function() {
                $( "#datepicker1" ).datepicker({
                    dateFormat:"yy-mm-dd",
                    minDate: 0,
                    onSelect: function() {
                        var dt2 = $("#datepicker2");
                        var minDate = $(this).datepicker('getDate');
                        var dt2Date = dt2.datepicker('getDate');
                        //difference in days. 86400 seconds in day, 1000 ms in second
                        var dateDifference = (dt2Date - minDate)/(86400*1000);
                        //dt2 not set or dt1 date is greater than dt2 date
                        if (dt2Date == null || dateDifference < 0) {
                            dt2.datepicker('setDate', minDate);
                        }
                        //first day which can be selected in dt2 is selected date in dt1
                        dt2.datepicker('option', 'minDate', minDate);
                    }});
                $( "#datepicker2" ).datepicker({
                    dateFormat:"yy-mm-dd",
                    minDate: 0});
            } );
        </script>

    <!-- JAVASCRIPT FOR PRICE FILTERS(MIN-MAX) -->
        <script>
           $( function() {
              $( "#slider-range" ).slider({
                range: true,
                min: 0,
                max: 5000,
                values: [ 0, 5000 ],
                slide: function( event, ui ) {
                  $( "#amount1" ).val(ui.values[ 0 ] + "€");
                  $( "#amount2" ).val(ui.values[ 1 ] + "€");
                }
              });
              $( "#amount1" ).val($("#slider-range").slider( "values", 0 ) + "€");
              $( "#amount2" ).val($("#slider-range").slider( "values", 1 ) + "€");
            } );
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
                                          <img src="assets/images/icons/user.png" style="color:#b50707;"/>
                                          <a href="profile.php">Profile</a>
                                    </li>
                              </ul>
                       </div>
                </div>
            </header>

            <!--Main section start-->
            <main class="main-content view_hotel page-home">

              <!-- Μain div starts (search_box and results) -->
              <div class="container">

                  <!-- FORM-SEARCH BOX HOTEL WITH FILTERS  -->
                    <aside class="hotel-search box">
                        <form name="searchForm" method="get" class="searchForm" action="list.php">
                              <h1>FIND THE PERFECT HOTEL</h1>
                                  <div class="form-guests" style="text-align-last: center;">
                                      <select id="count_of_guests" style="color:grey;" name="count_of_guests">
                                          <option value="" disabled selected hidden>Count of Guests</option>
                                          <option value="1">1</option>
                                          <option value="2">2</option>
                                          <option value="3">3</option>
                                          <option value="4">4</option>
                                      </select>
                                  </div>
                                  <div class="form-roomtype" style="text-align-last: center;">
                                      <select id="room_type" style="color:grey;" name="room_type">
                                          <option value="" disabled selected hidden>Room Type</option>
                                          <?php
                                              foreach ($allTypes as $roomType) {
                                           ?>
                                          <option <?php echo $selectedTypeId == $roomType['type_id'] ? 'selected="selected"' : ''; ?> value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?></option>
                                          <?php
                                              }
                                          ?>
                                      </select>
                                  </div>
                                  <div class="form-city" style="text-align-last: center;">
                                      <select id="city" style="color:grey;" name="city">
                                          <option disabled selected hidden>City</option>
                                          <?php
                                              foreach ($cities as $city) {
                                           ?>
                                              <option <?php echo $selectedCity == $city ? 'selected="selected"' : ''; ?> 
                                              value="<?php echo $city; ?>"><?php echo $city; ?></option>
                                          <?php
                                              }
                                          ?>
                                      </select>
                                  </div>

                                  <div class="resultpage-price" style="display:inline-block;">
                                      <input type="text" name="price-min" id="amount1" placeholder="0&euro;" style="margin:0 10% 10px 0; width:35%; height:0px;
                                      text-align:center; color:grey;">
                                      <input type="text" name="price-max" id="amount2" placeholder="5000&euro;" style="margin:0 0 0 10px; width:35%; height:0px;
                                      text-align:center; color:grey;">
                                  </div>
                                  <div class="resultpage-slider">
                                      <div id="slider-range"></div>
                                  </div>

                                  <div class="prices">
                                        <h2 style="font-size: 10px; color: grey; margin: 10px auto auto 15px; float:left;">
                                          PRICE MIN.</h2>
                                        <h3 style="font-size: 10px; color: grey; margin: 10px auto auto auto; float:right;">
                                          PRICE MAX.</h3>
                                  </div>

                                  <section class="Check_dates" style="margin:30px 10px auto auto; text-align-last: center;">
                                            <input type="text" id="datepicker1" name="check_in_date" value="<?php echo $checkInDate; ?>" placeholder="Check-in Date" required>
                                            <input type="text" id="datepicker2" name="check_out_date" value="<?php echo $checkOutDate; ?>" placeholder="Check-out Date" required>
                                  </section>
                                  <div class="action">
                                      <input name="Search" id="SearchButton" type="submit" value="FIND HOTEL">
                                  </div>
                          </form>
                      </aside>

                    
                    <!-- RESULTS WITH HOTELS -->
                    <section class="hotel-list box" id="search-results-container">
                          <header class="page-title">
                              <h2>Search Results</h2>
                          </header>
                        <section>
                            <section>
                                <?php
                                    foreach ($allAvailableRooms as $availableRoom) {
                                ?>

                                  <article class="hotel">
                                      <aside class="media">
                                         <img src="assets/images/rooms/<?php echo $availableRoom['photo_url']; ?>" alt="Room" width="100%" height="auto">
                                          <div class="overlay">
                                              <a href="room.php?room_id=<?php echo $availableRoom['room_id']; ?>">
                                                  <i class="fas fa-camera"></i>
                                              </a>
                                          </div>
                                      </aside>

                                      <main class="info">
                                          <h1><?php echo $availableRoom['name']; ?></h1>
                                          <h2><?php echo sprintf('%s, %s', $availableRoom['city'], $availableRoom['area']); ?></h2>
                                          <p><?php echo  $availableRoom['description_short']; ?></p>

                                          <div class="text-right">
                                              <button><a href="room.php?room_id=<?php echo $availableRoom['room_id'];?>&check_in_date=<?php echo $checkInDate;?>&check_out_date=<?php echo $checkOutDate;?> ">Go to Room Page</a></button>
                                          </div>
                                      </main>
                                      <section class="informations">
                                          <div class="night" style="float: left;">
                                            <h3>Per Night: <?php echo $availableRoom['price']; ?>€</h3>
                                          </div>
                                          <div class="room-guests" style="display: inline-block; margin: 17px auto auto 30px; background-color: #e7e7e7; width: 79%; text-align: center;">
                                              <h4>Count of Guests: <?php echo $availableRoom['count_of_guests']; ?></h4>

                                              <h5 style="border-left: 0px solid #7e7e7e; box-sizing: border-box; margin: 0px 0px 0px -14px; border-left-width: thin;">
                                              Type of Room: 
                                              <?php if ($availableRoom['type_id']== 1) { 
                                                        $availableRoom['type_id']="Single Room"; 
                                                        echo sprintf('%s', $availableRoom['type_id']); 
                                                        } 
                                                        elseif ($availableRoom['type_id']== 2) { 
                                                          $availableRoom['type_id']="Double Room"; 
                                                          echo sprintf('%s', $availableRoom['type_id']); 
                                                          }
                                                          elseif ($availableRoom['type_id']== 3) { 
                                                            $availableRoom['type_id']="Triple Room"; 
                                                            echo sprintf('%s', $availableRoom['type_id']); 
                                                            }
                                                            elseif ($availableRoom['type_id']== 4) { 
                                                              $availableRoom['type_id']="Fourfold Room"; 
                                                              echo sprintf('%s', $availableRoom['type_id']); 
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
                                  if (count($allAvailableRooms) == 0) {
                              ?>
                                  <h2 class="check-search" style="text-align:center; color:red;">There are no rooms !!!</h2>
                                  <hr>
                              <?php
                                  }
                                ?>
                        </section>
                    </section>
              </div>
            </main>

            <footer>
                <p>(c) Copyright Collegelink 2020 </p>
            </footer>

            <link rel="stylesheet" href="assets/css/fontawesome.min.css" />
            <link href="assets/css/styles_list.css" type="text/css" rel="stylesheet" />
        </body>
  </html>
