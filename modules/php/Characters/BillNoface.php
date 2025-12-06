<?php

declare(strict_types=1);

namespace BANG\Characters;

use BANG\Models\Player;

class BillNoface extends Player
{
  public function __construct(?array $row = null)
  {
    $this->character = BILL_NOFACE;
    $this->character_name = clienttranslate('Bill Noface');
    $this->text = [clienttranslate('He draws 1 card, plus 1 card for each wound he has.')];
    $this->bullets = 4;
    $this->expansion = DODGE_CITY;
    parent::__construct($row);
  }

  public function defaultCardsToDraw(): int
  {
    return $this->bullets - $this->hp + 1;
  }
}
