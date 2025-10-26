<?php

namespace BANG\Characters;

use BANG\Core\Notifications;
use BANG\Managers\EventCards;
use BANG\Managers\Rules;
use BANG\Models\AbstractCard;
use BANG\Models\Player;

class ApacheKid extends Player
{
  public function __construct($row = null)
  {
    $this->character = APACHE_KID;
    $this->character_name = clienttranslate('Apache Kid');
    $this->text = [clienttranslate('Cards of Diamonds played by other players do not affect him.')];
    $this->bullets = 3;
    $this->expansion = DODGE_CITY;
    parent::__construct($row);
  }

  public function getDefensiveOptions($attackingCard)
  {
    $reactOptions = parent::getDefensiveOptions($attackingCard);
    return $this->addAbility($reactOptions, $attackingCard);
  }

  public function getBangCards($attackingCard, $options = [])
  {
    $reactOptions = parent::getBangCards($attackingCard, $options);
    return $this->addAbility($reactOptions, $attackingCard);
  }

  /**
   * @param array{cards: array, character: ?int} $reactOptions
   * @param AbstractCard $attackingCard
   * @return array{cards: array, character: ?int}
   */
  private function addAbility($reactOptions, $attackingCard)
  {
    if (!Rules::isAbilityAvailable()) {
      return $reactOptions;
    }

    $event = EventCards::getActive();
    $suit = $event ? $event->getSuitOverride() : $attackingCard->getSuit();

    if ($suit === 'D') {
      $reactOptions['character'] = APACHE_KID;
    }
    return $reactOptions;
  }

  public function useAbility($args)
  {
    Notifications::tell(
      clienttranslate('${player_name} uses the ability of Apache Kid. Diamonds cards played by other players do not affect him.'),
      ['player_name' => $this->name]
    );
  }
}
