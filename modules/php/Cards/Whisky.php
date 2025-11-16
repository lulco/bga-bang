<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Models\BrownCard;

class Whisky extends BrownCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_WHISKY;
    $this->name = clienttranslate('Whisky');
    $this->text = clienttranslate('Regain two life points.');
    $this->symbols = [[SYMBOL_ADDITIONAL_CARD, SYMBOL_LIFEPOINT, SYMBOL_LIFEPOINT]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['QD'],
    ];
    $this->effect = [
      'type' => LIFE_POINT_MODIFIER,
      'amount' => 2,
      'impacts' => NONE,
      'additional_card' => 1,
    ];
  }
}
