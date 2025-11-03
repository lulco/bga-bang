<?php

declare(strict_types=1);

namespace BANG\Models;

use BANG\Core\Notifications;
use BANG\Managers\Cards;
use BANG\Managers\Players;
use BgaVisibleSystemException;

/**
 * @mixin AbstractCard
*/
trait CardPlayTrait
{
  /**
   * @throws BgaVisibleSystemException
   */
  private function cardPlay(Player $player, array $args): void
  {
    $effect = $player->modifyCardEffect($this);

    // Played card always go to the discard
    $this->discard();

    switch ($effect['type']) {
      case BASIC_ATTACK:
        $ids = $effect['impacts'] == ALL_OTHER ? $player->getOrderedOtherPlayers() : [$args['player']];
        $targetCardId = $args['type'] === LOCATION_INPLAY ? (int) $args['arg'] : null;
        $player->attack($this, $ids, $targetCardId, !!$args['secondCardId']);
        if ($args['secondCardId']) {
          $card = Cards::get($args['secondCardId']);
          if (!in_array($card->getType(), $player->getBangCardTypes())) {
            throw new BgaVisibleSystemException('Incorrect card type to play with Bang: ' . $card->getType());
          }
          $card->discard();
          Notifications::discardedCard($player, $card);
        }
        break;
      case DRAW:
      case DISCARD:
        // Drawing from deck
        if (!isset($args['type'])) {
          $player->drawCards($effect['amount']);
          return;
        }

        // Drawing/discarding from someone's hand/inplay
        $victim = Players::get($args['player']);
        $card = $args['type'] == 'player' ? $victim->getRandomCardInHand() : Cards::get($args['arg']);
        // TODO: Support Panic yourself more elegantly
        if ($effect['type'] == DRAW) {
          Cards::stole($card, $player);
          Notifications::stoleCard($player, $victim, $card, $args['type'] == LOCATION_INPLAY);
        } else {
          $victim->discardCard($card);
        }
        $victim->onChangeHand();
        break;
      case LIFE_POINT_MODIFIER:
        $targets = [];
        if ($effect['impacts'] == ALL) {
          $targets = Players::getLivingPlayers();
        } else {
          $targets[] = !isset($args['player']) || is_null($args['player']) ? $player : Players::get($args['player']);
        }

        foreach ($targets as $target) {
          $target->gainLife($effect['amount']);
        }
        break;
    }
  }
}