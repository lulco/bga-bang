<?php

declare(strict_types=1);

namespace BANG\Characters;

use BANG\Core\Notifications;
use BANG\Managers\EventCards;
use BANG\Managers\Rules;
use BANG\Models\AbstractCard;
use BANG\Models\Player;

class ApacheKid extends Player
{
  public function __construct(?array $row = null)
  {
    $this->character = APACHE_KID;
    $this->character_name = clienttranslate('Apache Kid');
    $this->text = [clienttranslate('Cards of Diamonds played by other players do not affect him.')];
    $this->bullets = 3;
    $this->expansion = DODGE_CITY;
    parent::__construct($row);
  }

  public function checkAttack(AbstractCard $card): bool
  {
    if (!Rules::isAbilityAvailable()) {
      return true;
    }

    if ($card->getSuit(true) !== 'D') {
      return true;
    }

    return false;
  }

  public function postAttack(AbstractCard $card): void
  {
    if (!Rules::isAbilityAvailable()) {
      return;
    }

    if ($card->getSuit() !== 'D') {
      return;
    }

    Notifications::tell('Diamond cards have no effect against Apache Kid');
  }
}
