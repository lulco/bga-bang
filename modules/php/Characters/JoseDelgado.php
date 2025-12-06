<?php

declare(strict_types=1);

namespace BANG\Characters;

use BANG\Core\Globals;
use BANG\Core\Notifications;
use BANG\Managers\Cards;
use BANG\Managers\Rules;
use BANG\Models\Player;

class JoseDelgado extends Player
{
  public function __construct(?array $row = null)
  {
    $this->character = JOSE_DELGADO;
    $this->character_name = clienttranslate('José Delgado');
    $this->text = [clienttranslate('Twice in his turn, he may discard a blue card from the hand to draw 2 cards.')];
    $this->bullets = 4;
    $this->abilityUsageLimit = 2;
    $this->expansion = DODGE_CITY;
    parent::__construct($row);
  }

  public function getHandOptions(): array
  {
    return $this->addAbility(parent::getHandOptions());
  }

  private function addAbility(array $options): array
  {
    if (!Rules::isAbilityAvailable() || $this->abilityUsedCount >= $this->abilityUsageLimit) {
      return $options;
    }

    $blueCards = $this->getHand()->filter(function ($card) {
      return $card->getColor() === BLUE;
    });
    if ($blueCards->count() > 0) {
      $options['character'] = JOSE_DELGADO;
    }
    return $options;
  }

  public function useAbility(array $args): void
  {
    if (!Rules::isAbilityAvailable() || $this->abilityUsedCount >= $this->abilityUsageLimit) {
      return;
    }

    // TODO check cards if they are blue
    $cards = $args['cards'];

    Notifications::tell(
      clienttranslate('${player_name} uses the ability of Jose Delgado by discarding 1 blue card to draw 2 cards'),
      ['player_name' => $this->name]
    );

    Cards::discardMany($cards);
    if (Globals::getIsMustPlayCard() && in_array(Globals::getMustPlayCardId(), $cards)) {
      Globals::setIsMustPlayCard(false);
      Globals::setMustPlayCardId(0);
    }
    Notifications::discardedCards($this, $cards);
    $this->drawCards(2);
    $this->incrementAbilityUsage();
  }
}
