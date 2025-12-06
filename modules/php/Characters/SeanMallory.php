<?php

declare(strict_types=1);

namespace BANG\Characters;

use BANG\Managers\Rules;
use BANG\Models\Player;

class SeanMallory extends Player
{
  public function __construct(?array $row = null)
  {
    $this->character = SEAN_MALLORY;
    $this->character_name = clienttranslate('Sean Mallory');
    $this->text = [clienttranslate('He may hold in his hand up to 10 cards.')];
    $this->bullets = 3;
    $this->expansion = DODGE_CITY;
    parent::__construct($row);
  }

  public function getMaxCards(): int
  {
    if (!Rules::isAbilityAvailable()) {
      return parent::getMaxCards();
    }
    return 10;
  }
}
