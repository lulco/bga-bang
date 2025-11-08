<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Models\GreenCard;

class Conestoga extends GreenCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_CONESTOGA;
    $this->name = clienttranslate('Conestoga');
    $this->text = clienttranslate('Draw 1 card from any player.');
    $this->symbols = [[SYMBOL_DRAW, SYMBOL_ANY]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['9D'],
    ];
    $this->effect = [
      'type' => DRAW,
      'amount' => 1,
      'impacts' => ANY,
    ];
  }
}
