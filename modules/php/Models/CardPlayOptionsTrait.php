<?php

declare(strict_types=1);

namespace BANG\Models;

use BANG\Managers\Players;

/**
 * @mixin AbstractCard
 */
trait CardPlayOptionsTrait
{
  private function getCardPlayOptions(Player $player): ?array
  {
    $playOptions = [];
    switch ($this->effect['type']) {
      case BASIC_ATTACK:
        if (in_array($this->effect['impacts'], [INRANGE, SPECIFIC_RANGE, ANY])) {
          return [
            'target_types' => [TARGET_PLAYER],
            'targets' => $this->getTargetablePlayers($player),
          ];
        }
      case LIFE_POINT_MODIFIER:
        if (in_array($this->effect['impacts'], [NONE, ALL, ALL_OTHER])) {
          return ['target_types' => [TARGET_NONE]];
        }
        break;

      case DRAW:
      case DISCARD:
        $playOptions['targets'] = $this->getTargetablePlayers($player);
        if ($this->effect['impacts'] === NONE) {
          $playOptions['target_types'] = [TARGET_NONE];
        } else {
          $playOptions['target_types'] = [TARGET_CARD];
          $playOptions['status_bar_message'] = clienttranslate('You must choose a card in play or a player\'s hand');
        }
        break;

      case DEFENSIVE:
        return null;
      default:
        return ['target_types' => [TARGET_NONE]];
    }

    return $playOptions;
  }

  /**
   * getTargetablePlayers: return the player's id that can be targeted by this card, depending on effect and range
   * @param Player $player
   */
  public function getTargetablePlayers($player)
  {
    $playerIds = [];
    switch ($this->effect['impacts']) {
      case ALL_OTHER:
        $playerIds = Players::getLivingPlayerIdsStartingWith($player, false, $player->getId());
        break;
      case INRANGE:
        $playerIds = $player->getPlayersInRange();
        break;
      case SPECIFIC_RANGE:
        $playerIds = $player->getPlayersInRange($this->effect['range']);
        break;
      case ANY:
        $playerIds = Players::getLivingPlayers()->getIds();
        break;
      case NONE:
        $playerIds = [];
        break;
    }

    // Cannot bang myself
    if ($this->effect['type'] == BASIC_ATTACK) {
      $playerIds = array_values(array_diff($playerIds, [$player->getId()]));
    }

    return $playerIds;
  }
}