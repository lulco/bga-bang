<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Models\BangActionCard;
use BANG\Models\GreenCard;

class Knife extends GreenCard
{
  use BangActionCard;

  public function __construct($params = null)
  {
    parent::__construct($params);
    $this->type = CARD_KNIFE;
    $this->name = clienttranslate('Knife');
    $this->text = clienttranslate('Knife is like Bang! to a player within range 1.'); // TODO official description
    $this->symbols = [[SYMBOL_BANG, SYMBOL_RANGE1]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['8H'],
    ];
    $this->effect = [
      'type' => BASIC_ATTACK,
      'range' => 1,
      'impacts' => SPECIFIC_RANGE,
    ];
  }
}
