<?php
namespace BANG\Models;
use BANG\Managers\Players;
use BANG\Managers\Cards;
use BANG\Core\Notifications;
use BANG\Managers\Rules;

/*
 * BrownCard: class to handle brown card
 */
abstract class BrownCard extends AbstractCard
{
  use CardPlayTrait;

  protected $border = 'brown';

  public function getColor()
  {
    return BROWN;
  }

  public function isAction()
  {
    return true;
  }

  /**
   * getTargetablePlayers: return the player's id that can be targeted by this card, depending on effect and range
   * @param Player $player
   */
  public function getTargetablePlayers($player)
  {
    $player_ids = [];
    switch ($this->effect['impacts']) {
      case ALL_OTHER:
        $player_ids = Players::getLivingPlayerIdsStartingWith($player, false, $player->getId());
        break;
      case INRANGE:
        $player_ids = $player->getPlayersInRange();
        break;
      case SPECIFIC_RANGE:
        $player_ids = $player->getPlayersInRange($this->effect['range']);
        break;
      case ANY:
        $player_ids = Players::getLivingPlayers()->getIds();
        break;
      case NONE:
        $player_ids = [];
        break;
    }

    // Cannot bang myself
    if ($this->effect['type'] == BASIC_ATTACK) {
      $player_ids = array_values(array_diff($player_ids, [$player->getId()]));
    }

    return $player_ids;
  }

  /*
   * getPlayOptions
   */
  public function getPlayOptions($player)
  {
    $playOptions = [];
    switch ($this->effect['type']) {
      case BASIC_ATTACK:
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
   * @param Player $player
   * @param array $args
   * @return void
   */
  public function play($player, $args)
  {
    $this->cardPlay($player, $args);
  }
}
