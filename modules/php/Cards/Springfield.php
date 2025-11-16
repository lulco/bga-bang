<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Models\BangActionCard;
use BANG\Models\BrownCard;

class Springfield extends BrownCard
{
  use BangActionCard;

  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_SPRINGFIELD;
    $this->name = clienttranslate('Springfield');
    $this->text = clienttranslate('Springfield is like Bang! to any player. Use additional card with it.'); // TODO official description
    $this->symbols = [[SYMBOL_ADDITIONAL_CARD, SYMBOL_BANG, SYMBOL_ANY]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['KS'],
    ];
    $this->effect = [
      'type' => BASIC_ATTACK,
      'range' => 0,
      'impacts' => ANY,
      'additional_card' => 1,
    ];
  }
}
