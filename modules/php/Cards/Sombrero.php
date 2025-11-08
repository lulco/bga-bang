<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Models\GreenCard;

class Sombrero extends GreenCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_SOMBRERO;
    $this->name = clienttranslate('Sombrero');
    $this->text = clienttranslate('Discard to avoid an attack');
    $this->symbols = [[SYMBOL_MISSED]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['7C'],
    ];
    $this->effect = ['type' => DEFENSIVE];
  }
}
