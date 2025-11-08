<?php

namespace BANG\Cards;

use BANG\Models\GreenCard;

class Canteen extends GreenCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_CANTEEN;
    $this->name = clienttranslate('Canteen');
    $this->text = clienttranslate('Regain one life point.');
    $this->symbols = [[SYMBOL_LIFEPOINT]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['7H'],
    ];
    $this->effect = [
      'type' => LIFE_POINT_MODIFIER,
      'amount' => 1,
      'impacts' => NONE,
    ];
  }
}
