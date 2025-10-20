<?php

namespace BANG\Characters;

use BANG\Managers\Rules;

class SeanMallory extends \BANG\Models\Player
{
  public function __construct($row = null)
  {
    $this->character = SEAN_MALLORY;
    $this->character_name = clienttranslate('Sean Mallory');
    $this->text = [clienttranslate('He may hold in his hand up to 10 cards.')];
    $this->bullets = 3;
    $this->expansion = DODGE_CITY;
    parent::__construct($row);
  }

  public function getMaxCards()
  {
    if (!Rules::isAbilityAvailable()) {
      return parent::getMaxCards();
    }
    return 10;
  }
}
