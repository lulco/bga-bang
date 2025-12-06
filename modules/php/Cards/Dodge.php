<?php

namespace BANG\Cards;

use BANG\Models\BrownCard;

class Dodge extends BrownCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_DODGE;
    $this->name = clienttranslate('Dodge');
    $this->text = clienttranslate('Discard to avoid an attack and draw one card'); // TODO official description
    $this->symbols = [[SYMBOL_MISSED, SYMBOL_DRAW], [SYMBOL_DRAW]]; // TODO just test how it will look like
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['7D', 'KH'],
    ];
    $this->effect = ['type' => DEFENSIVE];
  }

  public function playCard($player)
  {
    parent::playCard($player);
    $player->onChangeHand();
    $player->drawCards(1);
  }
}
