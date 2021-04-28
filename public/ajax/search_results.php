<!-- These are the search results! -->

<?php

require __DIR__.'/../../boot/boot.php';

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

<header class="page-title">
    <h2>Search Results from Ajax</h2>
</header>

<section>
    <section>
        <?php
                foreach ($allAvailableRooms as $availableRoom) {
            ?>

            <article class="hotel">
                <aside class="media">
                    <img src="assets/images/rooms/<?php echo sprintf('%s', $availableRoom['photo_url']) ?>" alt="Room" width="100%" height="auto">
                    <div class="overlay">
                        <a href="room.php?room_id=<?php echo sprintf('%d', $availableRoom['room_id']) ?> ">
                            <i class="fas fa-camera"></i>
                        </a>
                    </div>
                </aside>

                <main class="info">
                    <h1><?php echo sprintf('%s', $availableRoom['name']) ?></h1>
                    <h2><?php echo sprintf('%s, %s', $availableRoom['city'], $availableRoom['area']) ?></h2>
                    <p><?php echo sprintf('%s', $availableRoom['description_short']) ?></p>

                    <div class="text-right">
                        <button><a href="room.php?room_id=<?php echo $availableRoom['room_id'];?>&check_in_date=<?php echo $checkInDate;?>&check_out_date=<?php echo $checkOutDate;?> ">Go to Room Page</a></button>
                    </div>
                </main>
                <section class="informations">
                <div class="night" style="float: left;">
                    <h3>Per Night: <?php echo sprintf('%s', $availableRoom['price']) ?>€</h3>
                </div>
                <div class="room-guests" style="display: inline-block; margin: 17px auto auto 30px; background-color: #e7e7e7; width: 79%; text-align: center;">
                    <h4>Count of Guests: <?php echo sprintf('%d', $availableRoom['count_of_guests']) ?></h4>

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