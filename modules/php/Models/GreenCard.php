<?php
namespace BANG\Models;
use BANG\Managers\Cards;
use BANG\Managers\Rules;

/*
 * BlueCard:  class to handle blue cards
 */
abstract class GreenCard extends AbstractCard
{
  protected $border = 'green';

  public function getColor()
  {
    return GREEN;
  }

  public function isEquipment()
  {
    return true;
  }

  public function getPlayOptions($player)
  {
    foreach ($player->getCardsInPlay() as $card) {
      if ($card->type == $this->type) {
        return null;
      }
    }
    return Rules::isCanPlayBlueGreenCards() ? ['target_types' => [TARGET_NONE]] : null;
  }

  final public function play($player, $args)
  {
    if ($this->location === 'hand') {
      Cards::equip($this->id, $player->getId(), LOCATION_INPLAY_INACTIVE);
      return;
    }
    $this->play2();
  }

  abstract protected function play2(): void; // TODO rename need to be implemented in card itself
}
