<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Models\BrownCard;

class RagTime extends BrownCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_RAG_TIME;
    $this->name = clienttranslate('Rag time');
    $this->text = clienttranslate('Draw 1 card from a any player.');
    $this->symbols = [[SYMBOL_ADDITIONAL_CARD, SYMBOL_DRAW, SYMBOL_ANY]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['9H'],
    ];
    $this->effect = [
      'type' => DRAW,
      'amount' => 1,
      'impacts' => ANY,
      'additional_card' => 1,
    ];
  }
}
