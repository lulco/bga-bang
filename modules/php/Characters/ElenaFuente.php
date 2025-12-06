<?php

declare(strict_types=1);

namespace BANG\Characters;

use BANG\Cards\Missed;
use BANG\Core\Stack;
use BANG\Managers\Rules;
use BANG\Models\AbstractCard;
use BANG\Models\Player;

class ElenaFuente extends Player
{
  public function __construct(?array $row = null)
  {
    $this->character = ELENA_FUENTE;
    $this->character_name = clienttranslate('Elena Fuente');
    $this->text = [clienttranslate('She can use any card as a Missed!')];
    $this->bullets = 3;
    $this->expansion = DODGE_CITY;
    parent::__construct($row);
  }

  public function getDefensiveOptions(): array
  {
    $defensiveOptions = parent::getDefensiveOptions();
    if (Rules::isAbilityAvailable()) {
      $amount = Stack::top()['missedNeeded'] ?? 1;
      $otherCards = $this->getHand()->filter(function (AbstractCard $card) {
        return !$card instanceof Missed;
      })->map(function ($card) use ($amount) {
        return [
          'id' => $card->getId(),
          'type' => $card->getType(),
          'location' => $card->getLocation(),
          'amount' => $amount,
          'options' => ['target_types' => [TARGET_NONE]],
        ];
      })->toArray();

      $defensiveOptions['cards'] = array_merge($defensiveOptions['cards'], $otherCards);
    }
    return $defensiveOptions;
  }
}
