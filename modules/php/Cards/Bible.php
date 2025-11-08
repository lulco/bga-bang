<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Models\GreenCard;
use BANG\Models\Player;

class Bible extends GreenCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_BIBLE;
    $this->name = clienttranslate('Bible');
    $this->text = clienttranslate('Discard to avoid an attack and draw one card'); // TODO official description
    $this->symbols = [[SYMBOL_MISSED, SYMBOL_DRAW], [SYMBOL_DRAW]]; // TODO just test how it will look like
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['10H'],
    ];
    $this->effect = ['type' => DEFENSIVE];
  }

  protected function playEquipment(Player $player, array $args): void
  {
    parent::playEquipment($player, $args);
    $player->drawCards(1);
  }
}
