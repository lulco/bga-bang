<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Models\BangActionCard;
use BANG\Models\GreenCard;

class BuffaloRifle extends GreenCard
{
  use BangActionCard;

  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_BUFFALO_RIFLE;
    $this->name = clienttranslate('Buffalo Rifle');
    $this->text = clienttranslate('Buffalo Rifle is like Bang! to any player.'); // TODO official description
    $this->symbols = [[SYMBOL_BANG, SYMBOL_ANY]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['QC'],
    ];
    $this->effect = [
      'type' => BASIC_ATTACK,
      'range' => 0,
      'impacts' => ANY,
    ];
  }
}
