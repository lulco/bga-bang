<?php

declare(strict_types=1);

namespace Bang\Tests\CardsGetPlayOptions;

use BANG\Cards\Beer;
use BANG\Cards\LastCall;
use BANG\Managers\Players;
use BANG\Managers\Rules;

final class LastCallGetPlayOptionsTest extends AbstractCardsGetPlayOptionsTest
{
  public function testFullHpBeerAvailable(): void
  {
    $player = $this->createPlayerMockWithNoCardsInPlay(PAUL_REGRET);

    Rules::setAvailableRulesForTest([RULE_BEER_AVAILABLE]);
    Players::setPlayersForTest([
      $player,
      $this->createPlayerMockWithNoCardsInPlay(ROSE_DOOLAN),
      $this->createPlayerMockWithNoCardsInPlay(SLAB_THE_KILLER),
    ]);

    $card = new LastCall();
    $playOptions = $card->getPlayOptions($player);
    $expectedPlayOptions = [
      'target_types' => [TARGET_NONE],
      'confirmationMsg' => 'You have maximum amount of life points. Drinking a last call would currently have no effect. Do you still want to drink it?',
    ];
    $this->assertSame($expectedPlayOptions, $playOptions);
  }

  public function testFullHpBeerAvailableOnlyTwoPlayers(): void
  {
    $player = $this->createPlayerMockWithNoCardsInPlay(PAUL_REGRET);

    Rules::setAvailableRulesForTest([RULE_BEER_AVAILABLE]);
    Players::setPlayersForTest([
      $player,
      $this->createPlayerMockWithNoCardsInPlay(ROSE_DOOLAN),
    ]);

    $card = new LastCall();
    $playOptions = $card->getPlayOptions($player);
    $expectedPlayOptions = [
      'target_types' => [TARGET_NONE],
      'confirmationMsg' => 'You have maximum amount of life points. Drinking a last call would currently have no effect. Do you still want to drink it?',
    ];
    $this->assertSame($expectedPlayOptions, $playOptions);
  }

  public function testFullHpBeerNotAvailable(): void
  {
    $player = $this->createPlayerMockWithNoCardsInPlay(PAUL_REGRET);

    Rules::setAvailableRulesForTest([]);
    Players::setPlayersForTest([
      $player,
      $this->createPlayerMockWithNoCardsInPlay(ROSE_DOOLAN),
      $this->createPlayerMockWithNoCardsInPlay(SLAB_THE_KILLER),
    ]);

    $card = new LastCall();
    $playOptions = $card->getPlayOptions($player);
    $expectedPlayOptions = [
      'target_types' => [TARGET_NONE],
      'confirmationMsg' => 'You have maximum amount of life points. Drinking a last call would currently have no effect. Do you still want to drink it?',
    ];
    $this->assertSame($expectedPlayOptions, $playOptions);
  }


  public function testFullHpBeerNotAvailableOnlyTwoPlayers(): void
  {
    $player = $this->createPlayerMockWithNoCardsInPlay(PAUL_REGRET);

    Rules::setAvailableRulesForTest([]);
    Players::setPlayersForTest([
      $player,
      $this->createPlayerMockWithNoCardsInPlay(ROSE_DOOLAN),
    ]);

    $card = new LastCall();
    $playOptions = $card->getPlayOptions($player);
    $expectedPlayOptions = [
      'target_types' => [TARGET_NONE],
      'confirmationMsg' => 'You have maximum amount of life points. Drinking a last call would currently have no effect. Do you still want to drink it?',
    ];
    $this->assertSame($expectedPlayOptions, $playOptions);
  }

  public function testHalfHpBeerAvailable(): void
  {
    $player = $this->createPlayerMockWithNoCardsInPlay(PAUL_REGRET, 2);

    Rules::setAvailableRulesForTest([RULE_BEER_AVAILABLE]);
    Players::setPlayersForTest([
      $player,
      $this->createPlayerMockWithNoCardsInPlay(ROSE_DOOLAN),
      $this->createPlayerMockWithNoCardsInPlay(SLAB_THE_KILLER),
    ]);

    $card = new LastCall();
    $playOptions = $card->getPlayOptions($player);
    $expectedPlayOptions = [
      'target_types' => [TARGET_NONE],
    ];
    $this->assertSame($expectedPlayOptions, $playOptions);
  }

  public function testHalfHpBeerAvailableOnlyTwoPlayers(): void
  {
    $player = $this->createPlayerMockWithNoCardsInPlay(PAUL_REGRET, 2);

    Rules::setAvailableRulesForTest([RULE_BEER_AVAILABLE]);
    Players::setPlayersForTest([
      $player,
      $this->createPlayerMockWithNoCardsInPlay(ROSE_DOOLAN),
    ]);

    $card = new LastCall();
    $playOptions = $card->getPlayOptions($player);
    $expectedPlayOptions = [
      'target_types' => [TARGET_NONE],
    ];
    $this->assertSame($expectedPlayOptions, $playOptions);
  }

  public function testHalfHpBeerNotAvailable(): void
  {
    $player = $this->createPlayerMockWithNoCardsInPlay(PAUL_REGRET, 2);

    Rules::setAvailableRulesForTest([]);
    Players::setPlayersForTest([
      $player,
      $this->createPlayerMockWithNoCardsInPlay(ROSE_DOOLAN),
      $this->createPlayerMockWithNoCardsInPlay(SLAB_THE_KILLER),
    ]);

    $card = new LastCall();
    $playOptions = $card->getPlayOptions($player);
    $expectedPlayOptions = [
      'target_types' => [TARGET_NONE],
    ];
    $this->assertSame($expectedPlayOptions, $playOptions);
  }

  public function testHalfHpBeerNotAvailableOnlyTwoPlayers(): void
  {
    $player = $this->createPlayerMockWithNoCardsInPlay(PAUL_REGRET, 2);

    Rules::setAvailableRulesForTest([]);
    Players::setPlayersForTest([
      $player,
      $this->createPlayerMockWithNoCardsInPlay(ROSE_DOOLAN),
    ]);

    $card = new LastCall();
    $playOptions = $card->getPlayOptions($player);
    $expectedPlayOptions = [
      'target_types' => [TARGET_NONE],
    ];
    $this->assertSame($expectedPlayOptions, $playOptions);
  }
}
