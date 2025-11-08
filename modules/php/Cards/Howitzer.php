<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Models\BangActionCard;
use BANG\Models\GreenCard;

class Howitzer extends GreenCard
{
  use BangActionCard;

  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_HOWITZER;
    $this->name = clienttranslate('Howitzer');
    $this->text = clienttranslate('A Bang to all other players');
    $this->symbols = [[SYMBOL_BANG, SYMBOL_OTHER]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['9S', '9S', '9S', '9S', '9S', '9S', '9S', '9S', '9S', '9S'],
    ];
    $this->effect = [
      'type' => BASIC_ATTACK,
      'range' => 0,
      'impacts' => ALL_OTHER,
    ];
  }
}
