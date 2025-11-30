<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Models\BangActionCard;
use BANG\Models\BrownCard;
use BANG\Models\Player;

class Tomahawk extends BrownCard
{
  use BangActionCard;

  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_TOMAHAWK;
    $this->name = clienttranslate('Tomahawk');
    $this->text = clienttranslate('Tomahawk is like Bang! to a player within range 2.'); // TODO official description
    $this->symbols = [[SYMBOL_BANG, SYMBOL_RANGE2]];
    $this->copies = [
      VALLEY_OF_SHADOWS => ['AD'],
    ];
    $this->effect = [
      'type' => BASIC_ATTACK,
      'range' => 2,
      'impacts' => SPECIFIC_RANGE,
    ];
  }

  public function getPlayOptions(Player $player): ?array
  {
    $playOptions = [
        'target_types' => [TARGET_PLAYER],
        'targets' => $this->getTargetablePlayers($player),
    ];
    return $playOptions;
  }
}
