<?php

namespace BANG\Models;

/*
 * BrownCard: class to handle brown card
 */
abstract class BrownCard extends AbstractCard
{
  use CardPlayTrait;

  use CardPlayOptionsTrait;

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
   * getPlayOptions
   */
  public function getPlayOptions($player)
  {
    return $this->getCardPlayOptions($player);
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
