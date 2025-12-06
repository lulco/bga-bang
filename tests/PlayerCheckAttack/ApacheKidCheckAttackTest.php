<?php

declare(strict_types=1);

namespace Bang\Tests\PlayerCheckAttack;

use BANG\Cards\Bang;
use BANG\Cards\Events\Blessing;
use BANG\Cards\Events\Curse;
use BANG\Characters\ApacheKid;
use BANG\Managers\EventCards;
use BANG\Managers\Rules;
use Bang\Tests\AbstractTestCase;

final class ApacheKidCheckAttackTest extends AbstractTestCase
{
  public function testNoSuitOverrideAbilityAvailable(): void
  {
    $player = new ApacheKid();
    Rules::setAvailableRulesForTest([RULE_ABILITY_AVAILABLE => '1']);

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'H']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'C']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'S']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'D']);
    $this->assertFalse($player->checkAttack($card));
  }

  public function testNoSuitOverrideAbilityUnavailable(): void
  {
    $player = new ApacheKid();
    Rules::setAvailableRulesForTest([RULE_ABILITY_AVAILABLE => '0']);

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'H']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'C']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'S']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'D']);
    $this->assertTrue($player->checkAttack($card));
  }

  public function testHeartSuitOverrideAbilityAvailable(): void
  {
    $player = new ApacheKid();
    EventCards::setActiveForTest(new Blessing());
    Rules::setAvailableRulesForTest([RULE_ABILITY_AVAILABLE => '1']);

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'H']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'C']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'S']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'D']);
    $this->assertTrue($player->checkAttack($card));
  }

  public function testHeartSuitOverrideAbilityUnavailable(): void
  {
    $player = new ApacheKid();
    EventCards::setActiveForTest(new Blessing());
    Rules::setAvailableRulesForTest([RULE_ABILITY_AVAILABLE => '0']);

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'H']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'C']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'S']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'D']);
    $this->assertTrue($player->checkAttack($card));
  }


  public function testSpadesSuitOverrideAbilityAvailable(): void
  {
    $player = new ApacheKid();
    EventCards::setActiveForTest(new Curse());
    Rules::setAvailableRulesForTest([RULE_ABILITY_AVAILABLE => '1']);

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'H']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'C']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'S']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'D']);
    $this->assertTrue($player->checkAttack($card));
  }

  public function testSpadesSuitOverrideAbilityUnavailable(): void
  {
    $player = new ApacheKid();
    EventCards::setActiveForTest(new Curse());
    Rules::setAvailableRulesForTest([RULE_ABILITY_AVAILABLE => '0']);

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'H']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'C']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'S']);
    $this->assertTrue($player->checkAttack($card));

    $card = new Bang(['id' => 0, 'value' => 1, 'color' => 'D']);
    $this->assertTrue($player->checkAttack($card));
  }
}
