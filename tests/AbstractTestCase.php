<?php

declare(strict_types=1);

namespace Bang\Tests;

use BANG\Managers\EventCards;
use BANG\Managers\Rules;
use Bang\Tests\Mocks\PlayerMockerAndFaker;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
  use PlayerMockerAndFaker;

  protected function setUp(): void
  {
    // no event card in play by default, can be overridden in some tests
    EventCards::setActiveForTest();

    // no current player, can be overridden in some tests
    Rules::setCurrentPlayer();
  }
}
