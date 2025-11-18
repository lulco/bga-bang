<?php

declare(strict_types=1);

namespace BANG\Characters;

use BANG\Managers\Rules;
use BANG\Models\Player;

class HerbHunter extends Player
{
  public function __construct(?array $row = null)
  {
    $this->character = HERB_HUNTER;
    $this->character_name = clienttranslate('Herb Hunter');
    $this->text = [clienttranslate('Each time another player is eliminated, he draws 2 extra cards.')];
    $this->bullets = 4;
    $this->expansion = DODGE_CITY;
    parent::__construct($row);
  }

  public function onPlayerEliminated(Player $player): void
  {
    if (!Rules::isAbilityAvailable()) {
      return;
    }
    $this->drawCards(2);
  }
}
