<?php

class Configuration {
  protected static $items = [];

  public function getItems(): array {
    return self::$items;
  }

  public function setItems(array $items){
    self::$items = $items;
  }
}
