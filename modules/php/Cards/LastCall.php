<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Models\BrownCard;
use BANG\Models\Player;

class LastCall extends BrownCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_LAST_CALL;
    $this->name = clienttranslate('Last call');
    $this->text = clienttranslate('Regain one life point. May be played with only 2 players left, but never out of turn.');
    $this->symbols = [[SYMBOL_LIFEPOINT]];
    $this->copies = [
      VALLEY_OF_SHADOWS => ['8D']
    ];
    $this->effect = [
      'type' => LIFE_POINT_MODIFIER,
      'amount' => 1,
      'impacts' => NONE,
    ];
  }

  public function getPlayOptions(Player $player): ?array
  {
    $options = parent::getPlayOptions($player);
    if ($options !== null && $player->getBullets() === $player->getHp()) {
      $msg = clienttranslate('You have maximum amount of life points. Drinking a last call would currently have no effect. Do you still want to drink it?');
      $options['confirmationMsg'] = $msg;
    }
    return $options;
  }
}
