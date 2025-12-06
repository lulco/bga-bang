<?php

declare(strict_types=1);

namespace BANG\Characters;

use BANG\Managers\Rules;
use BANG\Models\Player;

class GregDigger extends Player
{
  public function __construct(?array $row = null)
  {
    $this->character = GREG_DIGGER;
    $this->character_name = clienttranslate('Greg Digger');
    $this->text = [clienttranslate('Each time another player is eliminated, he regains 2 life points.')];
    $this->bullets = 4;
    $this->expansion = DODGE_CITY;
    parent::__construct($row);
  }

  public function onPlayerEliminated(Player $player): void
  {
    if (!Rules::isAbilityAvailable()) {
      return;
    }
    $this->gainLife(2);
  }
}
