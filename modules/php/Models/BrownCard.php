<?php

namespace BANG\Models;

use BgaVisibleSystemException;

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

  /*
   * getPlayOptions
   */
  public function getPlayOptions(Player $player): ?array
  {
    return $this->getCardPlayOptions($player);
  }

  /**
   * @throws BgaVisibleSystemException
   */
  public function play(Player $player, array $args): void
  {
    $this->cardPlay($player, $args);
  }
}
