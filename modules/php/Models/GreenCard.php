<?php

namespace BANG\Models;

use BANG\Managers\Cards;
use BANG\Managers\Rules;

/*
 * GreenCard: class to handle green cards
 */
abstract class GreenCard extends AbstractCard
{
  use CardPlayTrait;
  use CardPlayOptionsTrait;

  protected $border = 'green';

  public function getColor()
  {
    return GREEN;
  }

  public function targetLocationAfterPlay(): string
  {
    if ($this->location === LOCATION_HAND) {
      return LOCATION_INPLAY_INACTIVE;
    }
    return LOCATION_DISCARD;
  }

  public function getPlayOptions($player)
  {
    if ($this->location === LOCATION_INPLAY) {
      return $this->getCardPlayOptions($player);
    }

    foreach ($player->getCardsInPlay() as $card) {
      if ($card->type === $this->type) {
        return null;
      }
    }
    return Rules::isCanPlayBlueGreenCards() ? ['target_types' => [TARGET_NONE]] : null;
  }

  final public function play($player, $args)
  {
    if ($this->location === LOCATION_HAND) {
      Cards::equip($this->id, $player->getId(), LOCATION_INPLAY_INACTIVE);
      return;
    }
    $this->playEquipment($player, $args);
  }

  protected function playEquipment(Player $player, array $args): void
  {
    $this->cardPlay($player, $args);
  }
}
