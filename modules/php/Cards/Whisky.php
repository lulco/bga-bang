<?php

namespace BANG\Cards;

use BANG\Core\Notifications;
use BANG\Managers\Cards;
use BANG\Managers\Players;
use BANG\Managers\Rules;
use BANG\Models\AbstractCard;
use BANG\Models\BrownCard;
use BANG\Models\Player;

class Whisky extends BrownCard
{
  public function __construct($id = null)
  {
    parent::__construct($id);
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

  public function play($player, $args)
  {
    if (!isset($args['secondCardId'])) {
      return;
    }

    $card = Cards::get($args['secondCardId']);
    $card->discard();
    Notifications::discardedCard($player, $card);

    parent::play($player, $args);
  }

  /**
   * @param Player $player
   */
  public function getPlayOptions($player)
  {
    $options = parent::getPlayOptions($player);
    $options['with_another_card'] = [
      'strict' => true,
      'cards' => $player->getHand()->filter(function (AbstractCard $card) {
          return $card->getId() !== $this->getId();
      })->toArray(),
    ];
    return $options;
  }
}
