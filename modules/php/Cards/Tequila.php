<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Models\BrownCard;

class Tequila extends BrownCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_TEQUILA;
    $this->name = clienttranslate('Tequila');
    $this->text = clienttranslate('Regain or give one life point.');
    $this->symbols = [[SYMBOL_ADDITIONAL_CARD, SYMBOL_LIFEPOINT, SYMBOL_ANY]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['9C'],
    ];
    $this->effect = [
      'type' => LIFE_POINT_MODIFIER,
      'amount' => 1,
      'impacts' => ANY,
      'additional_card' => 1,
    ];
  }
}
