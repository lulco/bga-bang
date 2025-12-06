<?php

declare(strict_types=1);

namespace BANG\Models;

interface OtherAttackingCard
{
  public function attack(Player $player, int $targetPlayerId): array;
}
