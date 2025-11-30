<?php

declare(strict_types=1);

namespace Bang\Tests\CardsGetPlayOptions;

use BANG\Cards\Tomahawk;
use BANG\Managers\Players;
use BANG\Managers\Rules;

final class TomahawkPlayOptionsTest extends AbstractCardsGetPlayOptionsTest
{
  public function testTomahawkWithAllInRangeDistances(): void
  {
    $player1 = $this->createPlayerMockWithNoCardsInPlay(PAUL_REGRET);
    $player2 = $this->createPlayerMockWithNoCardsInPlay(ROSE_DOOLAN);
    $player3 = $this->createPlayerMockWithNoCardsInPlay(SLAB_THE_KILLER);
//    Rules::setAvailableRulesForTest([RULE_BEER_AVAILABLE]);
    Players::setPlayersForTest([
      $player1,
      $player2,
      $player3
    ]);

    $card = new Tomahawk();
    $playOptions = $card->getPlayOptions($player1);
    $expectedPlayOptions = [
      'target_types' => [TARGET_PLAYER],
      'targets' => [$player2->getId(), $player3->getId()],
    ];
    $this->assertSame($expectedPlayOptions, $playOptions);
  }

  public function testTomahawkOneDistanceOutOfRange(): void
  {
    $player1 = $this->createPlayerMockWithNoCardsInPlay(SLAB_THE_KILLER);
    $player2 = $this->createPlayerMockWithNoCardsInPlay(ROSE_DOOLAN);
    $player3 = $this->createPlayerMockWithCardsInPlay(PAUL_REGRET, [CARD_MUSTANG, CARD_HIDEOUT]);
//    Rules::setAvailableRulesForTest([RULE_BEER_AVAILABLE]);
    Players::setPlayersForTest([
      $player1,
      $player2,
      $player3
    ]);

    $card = new Tomahawk();
    $playOptions = $card->getPlayOptions($player1);
    $expectedPlayOptions = [
      'target_types' => [TARGET_PLAYER],
      'targets' => [$player2->getId()],
    ];
    $this->assertSame($expectedPlayOptions, $playOptions);
  }
}
