<?php

declare(strict_types=1);

namespace Bang\Tests;

use BANG\Managers\EventCards;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
  protected function setUp(): void
  {
    // no event card in play by default, can be overriden in some tests
    EventCards::setActiveForTest();
  }
}
