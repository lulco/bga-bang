<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Models\GreenCard;

class CanCan extends GreenCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_CAN_CAN;
    $this->name = clienttranslate('Can Can');
    $this->text = clienttranslate('Chosen player discards a card of your choice.');
    $this->symbols = [[SYMBOL_DISCARD, SYMBOL_ANY]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['JC'],
    ];
    $this->effect = [
      'type' => DISCARD,
      'amount' => 1,
      'impacts' => ANY,
    ];
  }
}
