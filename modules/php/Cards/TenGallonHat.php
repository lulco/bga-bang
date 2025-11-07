<?php

namespace BANG\Cards;

use BANG\Models\GreenCard;

class TenGallonHat extends GreenCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_TEN_GALLON_HAT;
    $this->name = clienttranslate('Ten Gallon Hat');
    $this->text = clienttranslate('Discard to avoid an attack');
    $this->symbols = [[SYMBOL_MISSED]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['JD'],
    ];
    $this->effect = ['type' => DEFENSIVE];
  }
}
