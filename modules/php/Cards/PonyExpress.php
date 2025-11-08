<?php

namespace BANG\Cards;

use BANG\Models\GreenCard;

class PonyExpress extends GreenCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_PONY_EXPRESS;
    $this->name = clienttranslate('Pony Express');
    $this->text = clienttranslate('Draw 3 cards.');
    $this->symbols = [[SYMBOL_DRAW, SYMBOL_DRAW, SYMBOL_DRAW]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['QD'],
    ];
    $this->effect = [
      'type' => DRAW,
      'amount' => 3,
      'impacts' => NONE,
    ];
  }
}
