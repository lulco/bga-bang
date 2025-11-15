<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Managers\Cards;
use BANG\Managers\Players;
use BANG\Models\AbstractCard;
use BANG\Models\BrownCard;
use BANG\Models\Player;

class Tequila extends BrownCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_TEQUILA;
    $this->name = clienttranslate('Tequila');
    $this->text = clienttranslate('Regain or give one life point.');
    $this->symbols = [[SYMBOL_ADDITIONAL_CARD, SYMBOL_LIFEPOINT, SYMBOL_ANY]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['9C'],
    ];
    $this->effect = [
      'type' => LIFE_POINT_MODIFIER,
      'amount' => 1,
      'impacts' => ANY,
    ];
  }

  public function play(Player $player, array $args): void
  {
    if (!isset($args['additionalCardId'])) {
      return;
    }

    $additionalCard = Cards::get($args['additionalCardId']);
    $player->discardCard($additionalCard);

    parent::play($player, $args);
  }

  public function getPlayOptions(Player $player): ?array
  {
    $options = [
      'target_types' => [TARGET_PLAYER],
      'targets' => Players::getLivingPlayers()->getIds(),
      'with_additional_card' => [
        'cards' => $player->getHand()->filter(function (AbstractCard $card) {
          return $card->getId() !== $this->getId();
        })->toArray(),
      ]
    ];
    return $options;
  }
}
