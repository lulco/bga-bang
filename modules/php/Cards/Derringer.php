<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Models\BangActionCard;
use BANG\Models\GreenCard;
use BANG\Models\Player;

class Derringer extends GreenCard
{
  use BangActionCard;

  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_DERRINGER;
    $this->name = clienttranslate('Derringer');
    $this->text = clienttranslate('Derringer is like Bang! to a player within range 1. Then draw 1 card.'); // TODO official description
    $this->symbols = [[SYMBOL_BANG, SYMBOL_RANGE1], [SYMBOL_DRAW]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['7S'],
    ];
    $this->effect = [
      'type' => BASIC_ATTACK,
      'range' => 1,
      'impacts' => SPECIFIC_RANGE,
    ];
  }

  protected function playEquipment(Player $player, array $args): void
  {
    parent::playEquipment($player, $args);
    $player->drawCards(1);
  }
}
