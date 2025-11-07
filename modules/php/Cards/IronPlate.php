<?php

namespace BANG\Cards;

use BANG\Models\GreenCard;

class IronPlate extends GreenCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_IRON_PLATE;
    $this->name = clienttranslate('Iron Plate');
    $this->text = clienttranslate('Discard to avoid an attack');
    $this->symbols = [[SYMBOL_MISSED]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['AD', 'QS'],
    ];
    $this->effect = ['type' => DEFENSIVE];
  }
}
