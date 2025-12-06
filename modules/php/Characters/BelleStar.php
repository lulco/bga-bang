<?php

declare(strict_types=1);

namespace BANG\Characters;

use BANG\Models\Player;

class BelleStar extends Player
{
  public function __construct(?array $row = null)
  {
    $this->character = BELLE_STAR;
    $this->character_name = clienttranslate('Belle Star');
    $this->text = [clienttranslate('During her turn, cards in play in front of other players have no effect.')];
    $this->bullets = 4;
    $this->expansion = DODGE_CITY;
    parent::__construct($row);
  }
}
