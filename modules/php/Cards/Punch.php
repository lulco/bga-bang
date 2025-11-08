<?php

namespace BANG\Cards;

use BANG\Models\BangActionCard;
use BANG\Models\BrownCard;

class Punch extends BrownCard
{
  use BangActionCard;

  public function __construct($params = null)
  {
    parent::__construct($params);
    $this->type = CARD_PUNCH;
    $this->name = clienttranslate('Punch');
    $this->text = clienttranslate('Punch is like Bang! to a player within range 1.'); // TODO official description
    $this->symbols = [[SYMBOL_BANG, SYMBOL_RANGE1]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['10S'],
    ];
    $this->effect = [
      'type' => BASIC_ATTACK,
      'range' => 1,
      'impacts' => SPECIFIC_RANGE,
    ];
  }

  public function getPlayOptions($player)
  {
    $playOptions = [
        'target_types' => [TARGET_PLAYER],
        'targets' => $this->getTargetablePlayers($player),
    ];
    return $playOptions;
  }
}
