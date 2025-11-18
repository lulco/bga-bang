<?php

declare(strict_types=1);

namespace BANG\Characters;

use BANG\Models\Player;

class DocHolyday extends Player
{
  public function __construct(?array $row = null)
  {
    $this->character = DOC_HOLYDAY;
    $this->character_name = clienttranslate('Doc Holyday');
    $this->text = [clienttranslate('During his turn, he may discard once 2 cards from the hand to shoot a BANG!')];
    $this->bullets = 4;
    $this->expansion = DODGE_CITY;
    parent::__construct($row);
  }
}
