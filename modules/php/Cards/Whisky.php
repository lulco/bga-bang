<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Managers\Cards;
use BANG\Models\AbstractCard;
use BANG\Models\BrownCard;
use BANG\Models\Player;

class Whisky extends BrownCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_WHISKY;
    $this->name = clienttranslate('Whisky');
    $this->text = clienttranslate('Regain two life points.');
    $this->symbols = [[SYMBOL_ADDITIONAL_CARD, SYMBOL_LIFEPOINT, SYMBOL_LIFEPOINT]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['QD'],
    ];
    $this->effect = [
      'type' => LIFE_POINT_MODIFIER,
      'amount' => 2,
      'impacts' => NONE,
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
    $options = parent::getPlayOptions($player);
    $options['with_additional_card'] = [
      'cards' => $player->getHand()->filter(function (AbstractCard $card) {
          return $card->getId() !== $this->getId();
      })->toArray(),
    ];
    return $options;
  }
}
