<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Room;
use Hotel\RoomType;

//Get cities
$room = new Room();
$cities = $room->getCities();

//Get all room types
$type = new RoomType();
$allTypes = $type->getAllTypes();


?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <title>Room search</title>
        <style type="text/css">
            body {
               background: #333;
            }
        </style>
        <script src="assets/js/script.js" type="text/javascript"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        
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

    </head>
      <body>
          <header>
              <div class="container">
                      <div class="primary-menu text-right">
                            <ul>
                                  <li class="main-logo" >
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


          <main class="main-content view_hotel page-home">

             <!--Main section start-->
              <section class="hero">

                        <!--searchForm section start (search hotel with filters for dates,roomtypes,cities)-->
                        <form class="filter-search-hero" method="get" action="list.php" >
                                    <section class="search_Room" >
                                          <select name="city" class="form-control">
                                              <option value="" disabled selected hidden>City</option>
                                              <?php
                                                  foreach ($cities as $city) {
                                               ?>
                                                  <option value="<?php echo $city; ?>"><?php echo $city; ?></option>
                                              <?php
                                                  }
                                              ?>
                                          </select>
                                            <select name="room_type" class="form-control">
                                                  <option value="" disabled selected hidden>Room Type</option>
                                                  <?php
                                                      foreach ($allTypes as $roomType) {
                                                   ?>
                                                  <option value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?></option>
                                                  <?php
                                                      }
                                                  ?>
                                            </select>
                                    </section>
                                    <section class="Check_dates">
                                              <input type="text" id="datepicker1" name="check_in_date" style="cursor:pointer;" placeholder="Check-in Date" required>
                                              <input type="text" id="datepicker2" name="check_out_date" style="cursor:pointer;" placeholder="Check-out Date" required>
                                    </section>
                                    <div class="action text-center">
                                        <input name="Search" id="SearchButton" type="submit" value="Search">
                                    </div>
                        </form>
              </section>
          </main>

          <footer>
              <p>(c) Copyright Collegelink 2020 </p>
          </footer>


          <link rel="stylesheet" href="assets/css/fontawesome.min.css" />
          <link href="assets/css/styles_index.css" type="text/css" rel="stylesheet" />
      </body>
</html>
