<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Managers\Cards;
use BANG\Managers\Players;
use BANG\Models\AbstractCard;
use BANG\Models\BangActionCard;
use BANG\Models\BrownCard;
use BANG\Models\Player;

class Springfield extends BrownCard
{
  use BangActionCard;

  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_SPRINGFIELD;
    $this->name = clienttranslate('Springfield');
    $this->text = clienttranslate('Springfield is like Bang! to any player. Use additional card with it.'); // TODO official description
    $this->symbols = [[SYMBOL_ADDITIONAL_CARD, SYMBOL_BANG, SYMBOL_ANY]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['KS'],
    ];
    $this->effect = [
      'type' => BASIC_ATTACK,
      'range' => 0,
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
      'targets' => Players::getLivingPlayers($player->getId())->getIds(),
      'with_additional_card' => [
        'cards' => $player->getHand()->filter(function (AbstractCard $card) {
          return $card->getId() !== $this->getId();
        })->toArray(),
      ]
    ];
    return $options;
  }
}
