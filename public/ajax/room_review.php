<?php

use Hotel\User;
use Hotel\Review;


//Boot application
require_once __DIR__ . '/../../boot/boot.php';

//Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    echo "This is a post script.";
    die;
}

//If no user is logged in, return to main page
if (empty(User::getCurrentUserId())) {
    echo "No current user for this operation.";
    die;
}

//Check if room id is given 
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    echo "No room is given for this operation.";
    die;
}

//Verify csrf 
$csrf = $_REQUEST['csrf'];
if (empty($csrf) || !User::verifyCsrf($csrf)) {
    echo "This is an invalid request";
    return; 
}

//Add Review 
$review = new Review();
$review->insert($roomId, User::getCurrentUserId(), $_REQUEST['rate'], $_REQUEST['comment']);

//Get all reviews 
$roomReviews = $review->getReviewsByRoom($roomId);
$counter = count($roomReviews);

//Load user 
$user = new User();
$userInfo = $user->getByUserId(User::getCurrentUserId());

?>

<div class="room-reviews" id="reviews" style="margin: 30px 735px 0px 0px;">

        <p style="padding-right: 90px;"><?php echo sprintf('%d. %s', $counter, $userInfo['name']); ?>
        <div class="div-reviews" style="padding-right: 60px;">
            <?php
            // $roomAvgReview = $review['review'];
                for ($i = 1; $i <= 5; $i++) {
                    if ($_REQUEST['rate'] >= $i) {
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
        <p style="font-size: 10px; margin: -10px 0px 0px 0px;">Created at: <?php echo (new DateTime())->format('Y-m-d H:i:s'); ?></p>
        <p style="font-size: 10px; margin: 20px 50px 0px 0px;"><?php echo $_REQUEST['comment'] ?></p>

</div>