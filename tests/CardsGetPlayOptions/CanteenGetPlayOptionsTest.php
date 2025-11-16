<?php

declare(strict_types=1);

namespace Bang\Tests\CardsGetPlayOptions;

use BANG\Cards\Canteen;
use BANG\Characters\PaulRegret;
use BANG\Managers\EventCards;
use PHPUnit\Framework\TestCase;

final class CanteenGetPlayOptionsTest // extends TestCase
{
  public function testFullHpFromHand(): void
  {
    $player = $this->createMock(PaulRegret::class);
    $player->method('getCardsInPlay')->willReturn([]);

    EventCards::setActiveForTest();

    $card = new Canteen(['id' => 0, 'value' => 7, 'color' => 'H', 'location' => LOCATION_HAND]);
    $playOptions = $card->getPlayOptions($player);

    $expectedPlayOptions = [

    ];
    $this->assertSame($expectedPlayOptions, $playOptions);
  }

  public function testHalfHpFromHand(): void
  {
    $player = $this->createMock(PaulRegret::class);
    $player->method('getCardsInPlay')->willReturn([]);

    EventCards::setActiveForTest();

    $card = new Canteen(['id' => 0, 'value' => 7, 'color' => 'H', 'location' => LOCATION_HAND]);
    $playOptions = $card->getPlayOptions($player);

    $expectedPlayOptions = [

    ];
    $this->assertSame($expectedPlayOptions, $playOptions);
  }

  public function testFullHpFromTable(): void
  {
    $player = $this->createMock(PaulRegret::class);
    $player->method('getCardsInPlay')->willReturn([]);

    EventCards::setActiveForTest();

    $card = new Canteen(['id' => 0, 'value' => 7, 'color' => 'H', 'location' => LOCATION_INPLAY]);
    $playOptions = $card->getPlayOptions($player);

    $expectedPlayOptions = [
      'confirmationMsg' => 'You have maximum amount of life points. Drinking a canteen would currently have no effect. Do you still want to drink it?'
    ];
    $this->assertSame($expectedPlayOptions, $playOptions);
  }

  public function testHalfHpFromTable(): void
  {
    $player = $this->createMock(PaulRegret::class);
    $player->method('getCardsInPlay')->willReturn([]);

    EventCards::setActiveForTest();

    $card = new Canteen(['id' => 0, 'value' => 7, 'color' => 'H', 'location' => LOCATION_INPLAY]);
    $playOptions = $card->getPlayOptions($player);

    $expectedPlayOptions = [
      'confirmationMsg' => 'You have maximum amount of life points. Drinking a canteen would currently have no effect. Do you still want to drink it?'
    ];
    $this->assertSame($expectedPlayOptions, $playOptions);
  }

  public function testFromTableWhenInPlayCardsAreNotPlayable(): void
  {
    $player = $this->createMock(PaulRegret::class);
    $player->method('getCardsInPlay')->willReturn([]);

    EventCards::setActiveForTest();

    $card = new Canteen(['id' => 0, 'value' => 7, 'color' => 'H', 'location' => LOCATION_INPLAY]);
    $playOptions = $card->getPlayOptions($player);

    $expectedPlayOptions = [
      'confirmationMsg' => 'You have maximum amount of life points. Drinking a canteen would currently have no effect. Do you still want to drink it?'
    ];
    $this->assertSame($expectedPlayOptions, $playOptions);
  }
}
