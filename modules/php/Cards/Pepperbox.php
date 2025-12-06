<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Models\BangActionCard;
use BANG\Models\GreenCard;

class Pepperbox extends GreenCard
{
  use BangActionCard;

  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_PEPPERBOX;
    $this->name = clienttranslate('Pepperbox');
    $this->text = clienttranslate('Pepperbox is like Bang! to any player in range.'); // TODO official description
    $this->symbols = [[SYMBOL_BANG, SYMBOL_INRANGE]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['AH'],
    ];
    $this->effect = [
      'type' => BASIC_ATTACK,
      'range' => 0,
      'impacts' => INRANGE,
    ];
  }
}
