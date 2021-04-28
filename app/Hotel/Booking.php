<?php

 namespace Hotel;

 use Hotel\BaseService;
 use \DateTime;

 class Booking extends BaseService
 {

  public function getListByUser($userId)
  {
    $parameters = [
      ':user_id' => $userId,
    ];
    return $this->fetchAll('SELECT booking.*, room.*, room_type.title as room_type
        FROM booking 
        INNER JOIN room ON booking.room_id = room.room_id
        INNER JOIN room_type ON room.type_id = room_type.type_id
        WHERE user_id = :user_id', $parameters);
  }

   public function insert($roomId, $userId, $checkInDate, $checkOutDate) 
   {
       //Step 1, begin transaction 
       $this->getPdo()->beginTransaction();

       //Step 2, get room info 
       $parameters = [
           ':room_id' => $roomId,
       ];
       $roomInfo = $this->fetch('SELECT * FROM room WHERE room_id = :room_id', $parameters);
       
       $price = $roomInfo['price'];

       // Step 3, Calculate final price (from dates)
       $checkInDateTime = new DateTime($checkInDate);
       $checkOutDateTime = new DateTime($checkOutDate);
       $daysDiff = $checkOutDateTime->diff($checkInDateTime)->days;
       $totalPrice = $price * $daysDiff;

       // Step 4, Book room 
       $parameters = [
        ':room_id' => $roomId,
        ':user_id' => $userId,
        ':total_price' => $totalPrice,
        ':check_in_date' => $checkInDate,
        ':check_out_date' => $checkOutDate,
      ];
  
      $this->execute('INSERT INTO booking (room_id, user_id, total_price, check_in_date, check_out_date) 
                            VALUES (:room_id, :user_id, :total_price, :check_in_date, :check_out_date)', $parameters);
                            
      // Step 5, commit 
      return $this->getPdo()->commit();
   }
   
   public function isBooked($roomId, $checkInDate, $checkOutDate)
   {
    $parameters = [
        ':room_id' => $roomId,
        ':check_in_date' => $checkInDate,
        ':check_out_date' => $checkOutDate,
      ];
      
      $rows = $this->fetchAll('SELECT room_id
               FROM booking
               WHERE room_id = :room_id AND check_in_date <= :check_out_date AND check_out_date >= :check_in_date', 
                    $parameters);

      return count($rows) > 0;
   }
 
}