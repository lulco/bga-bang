<?php
namespace BANG\Helpers;

use bang;

class GameOptions
{
  public static function chooseCharactersManually()
  {
    return (int) bang::get()->getGameStateValue('optionCharacters') === CHARACTERS_CHOOSE;
  }

  public static function getExpansions()
  {
    $expansions = [];
    switch ((int) bang::get()->getGameStateValue('optionExpansions')) {
      case OPTION_HIGH_NOON_ONLY:
        $expansions = [HIGH_NOON];
        break;
      case OPTION_FISTFUL_OF_CARDS_ONLY:
        $expansions = [FISTFUL_OF_CARDS];
        break;
      case OPTION_HIGH_NOON_AND_FOC:
        $expansions = [HIGH_NOON, FISTFUL_OF_CARDS];
        break;
      case OPTION_HIGH_NOON_OR_FOC:
        $expansionIndex = bga_rand(0, 1);
        $chosenExpansion = [HIGH_NOON, FISTFUL_OF_CARDS][$expansionIndex];
        $expansions = [$chosenExpansion];
        break;
    }

    if ((bool)bang::get()->getGameStateValue('optionDodgeCity')) {
      $expansions[] = DODGE_CITY;
    }

    return $expansions;
  }

  /**
   * Are we playing with events which resurrect players at some point?
   * @return boolean
   */
  public static function isResurrection()
  {
    $highNoonWithGhosts = self::getOption('optionExpansions') === OPTION_HIGH_NOON_ONLY &&
      self::getOption('optionHighNoon') === OPTION_HIGH_NOON_WITH_GHOST_TOWN;
    $fistfulWithGhosts = self::getOption('optionExpansions') === OPTION_FISTFUL_OF_CARDS_ONLY &&
      self::getOption('optionFistful') === OPTION_FISTFUL_OF_CARDS_WITH_DEAD_MAN;
    $bothWithGhosts = self::getOption('optionExpansions') === OPTION_HIGH_NOON_AND_FOC &&
      self::getOption('optionHighNoonAndFistful') === OPTION_BOTH_EVENTS_WITH_GHOSTS;
    $singleWithGhosts = self::getOption('optionExpansions') === OPTION_HIGH_NOON_OR_FOC &&
      self::getOption('optionHighNoonAndFistful') === OPTION_BOTH_EVENTS_WITH_GHOSTS;
    return $highNoonWithGhosts || $fistfulWithGhosts || $bothWithGhosts || $singleWithGhosts;
  }

  private static function getOption($optionName)
  {
    return (int) bang::get()->getGameStateValue($optionName);
  }

  /**
   * isEvents: are events enabled for this game?
   * @return string
   */
  public static function isEvents()
  {
    return count(array_intersect([HIGH_NOON, FISTFUL_OF_CARDS], self::getExpansions())) > 0;
  }
}
