<?php

declare(strict_types=1);

namespace BANG\Characters;

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
}
