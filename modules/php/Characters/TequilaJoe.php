<?php

declare(strict_types=1);

namespace BANG\Characters;

use BANG\Cards\Beer;
use BANG\Managers\Rules;
use BANG\Models\AbstractCard;
use BANG\Models\Player;

class TequilaJoe extends Player
{
  public function __construct(?array $row = null)
  {
    $this->character = TEQUILA_JOE;
    $this->character_name = clienttranslate('Tequila Joe');
    $this->text = [clienttranslate('Each time he plays a Beer, he regains 2 life points instead of 1.')];
    $this->bullets = 4;
    $this->expansion = DODGE_CITY;
    parent::__construct($row);
  }

  public function modifyCardEffect(AbstractCard $card): array
  {
    if (!Rules::isAbilityAvailable()) {
      return parent::modifyCardEffect($card);
    }
    if (!$card instanceof Beer) {
      return parent::modifyCardEffect($card);
    }
    $effect = $card->getEffect();
    $effect['amount'] = 2;
    return $effect;
  }
}
