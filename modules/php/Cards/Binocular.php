<?php

namespace BANG\Cards;

use BANG\Models\BlueCard;

class Binocular extends BlueCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_BINOCULAR;
    $this->name = clienttranslate('Binocular');
    $this->text = clienttranslate('You view others at distance -1');
    $this->symbols = [[$this->text]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['10D'],
    ];
    $this->effect = ['type' => RANGE_DECREASE];
  }
}
