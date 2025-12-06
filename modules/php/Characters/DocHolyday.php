<?php

declare(strict_types=1);

namespace BANG\Characters;

use BANG\Cards\Bang;
use BANG\Core\Globals;
use BANG\Core\Notifications;
use BANG\Core\Stack;
use BANG\Managers\Cards;
use BANG\Managers\Rules;
use BANG\Models\Player;

class DocHolyday extends Player
{
  public function __construct(?array $row = null)
  {
    $this->character = DOC_HOLYDAY;
    $this->character_name = clienttranslate('Doc Holyday');
    $this->text = [clienttranslate('During his turn, he may discard once 2 cards from the hand to shoot a BANG!')];
    $this->bullets = 4;
    $this->abilityUsageLimit = 1;
    $this->expansion = DODGE_CITY;
    parent::__construct($row);
  }

  public function getHandOptions(): array
  {
    return $this->addAbility(parent::getHandOptions());
  }

  private function addAbility(array $options): array
  {
    if (Rules::isAbilityAvailable() && $this->countHand() > 1 && $this->abilityUsedCount < $this->abilityUsageLimit) {
      $options['character'] = DOC_HOLYDAY;
      $playerIds = $this->getPlayersInRange();
      $playerIds = array_values(array_diff($playerIds, [$this->getId()]));
      $options['targets'] = $playerIds;
    }
    return $options;
  }

  public function useAbility(array $args): void
  {
    if (!Rules::isAbilityAvailable() || $this->abilityUsedCount >= $this->abilityUsageLimit) {
      return;
    }

    $cards = $args['cards'];

    Cards::discardMany($cards);
    if (Globals::getIsMustPlayCard() && in_array(Globals::getMustPlayCardId(), $cards)) {
      Globals::setIsMustPlayCard(false);
      Globals::setMustPlayCardId(0);
    }
    Notifications::discardedCards($this, $cards);
    $this->incrementAbilityUsage();

    $targetPlayers = $args['players'];

    Notifications::tell(
      clienttranslate('${player_name} uses the ability of Doc Holyday by discarding 2 cards to play BANG!'),
      ['player_name' => $this->name]
    );

    $msgActive = clienttranslate('${you} must react to a BANG! from Doc Holyday character');
    $msgInactive = clienttranslate('${actplayer} must react to a BANG! from Doc Holyday character');
    foreach ($targetPlayers as $targetPlayer) {
      $atom = Stack::newAtom(ST_REACT, [
        'pId' => $targetPlayer,
        'targetCardId' => null,
        'msgActive' => $msgActive,
        'msgInactive' => $msgInactive,
        'src_name' => $this->name,
        'target_card_name' => '',
        'src' => (new Bang())->jsonSerialize(),
        'attacker' => $this->id,
        'missedNeeded' => 1,
      ]);
      Stack::insertOnTop($atom);
    }
  }
}
