<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Models\GreenCard;
use BANG\Models\Player;

class Canteen extends GreenCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_CANTEEN;
    $this->name = clienttranslate('Canteen');
    $this->text = clienttranslate('Regain one life point.');
    $this->symbols = [[SYMBOL_LIFEPOINT]];
    $this->copies = [
      BASE_GAME => [],
      HIGH_NOON => [],
      DODGE_CITY => ['7H'],
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
    if ($options !== null && $player->getBullets() == $player->getHp()) {
      $msg = clienttranslate('You have maximum amount of life points. Drinking a canteen would currently have no effect. Do you still want to drink it?');
      $options['confirmationMsg'] = $msg;
    }
    return $options;
  }
}
