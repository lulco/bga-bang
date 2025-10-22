<?php

namespace BANG\Characters;

use BANG\Core\Notifications;
use BANG\Managers\Cards;
use BANG\Managers\Rules;
use BANG\Models\Player;

class JoseDelgado extends Player
{
  public function __construct($row = null)
  {
    $this->character = JOSE_DELGADO;
    $this->character_name = clienttranslate('José Delgado');
    $this->text = [clienttranslate('Twice in his turn, he may discard a blue card from the hand to draw 2 cards.')];
    $this->bullets = 4;
    $this->abilityUsageLimit = 2;
    $this->expansion = DODGE_CITY;
    parent::__construct($row);
  }

  public function getHandOptions($lastCardOnly = false)
  {
    return $this->addAbility(parent::getHandOptions());
  }

  private function addAbility($t)
  {
    if (!Rules::isAbilityAvailable() || $this->abilityUsedCount >= $this->abilityUsageLimit) {
      return $t;
    }

    $blueCards = $this->getHand()->filter(function ($card) {
      return $card->getColor() === BLUE;
    });
    if ($blueCards->count() > 0) {
      $t['character'] = JOSE_DELGADO;
    }
    return $t;
  }

  /**
   * @return void
   */
  public function useAbility($args)
  {
    if (!Rules::isAbilityAvailable() || $this->abilityUsedCount >= $this->abilityUsageLimit) {
      return;
    }

    // TODO check card if it is blue

    Notifications::tell(
      clienttranslate('${player_name} uses the ability of Jose Delgado by discarding 1 blue card to draw 2 cards'),
      ['player_name' => $this->name]
    );

    Cards::discardMany($args);
    Notifications::discardedCards($this, $args);
    $this->drawCards(2);
    $this->incrementAbilityUsage();
  }
}
