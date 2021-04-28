<?php

 namespace Hotel;

 use PDO;
 use DateTime;
 use Hotel\BaseService;


 class RoomType extends BaseService
 {
   public function getAllTypes()
     {

       //Get all roomtypes from db
       return $this->fetchAll('SELECT * FROM room_type');
     }

    public function getTitle($typeId)
    {
      $parameters = [
        ':type_id' => $typeId,
      ];
      return $this->fetch('SELECT * FROM room_type WHERE type_id = :type_id', $parameters);
    }
 }
