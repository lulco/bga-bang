<?php

declare(strict_types=1);

namespace BANG\Characters;

use BANG\Core\Notifications;
use BANG\Core\Stack;
use BANG\Managers\Cards;
use BANG\Managers\Players;
use BANG\Managers\Rules;
use BANG\Models\AbstractCard;
use BANG\Models\Player;

class PatBrennan extends Player
{
  public function __construct(?array $row = null)
  {
    $this->character = PAT_BRENNAN;
    $this->character_name = clienttranslate('Pat Brennan');
    $this->text = [clienttranslate('He may draw only one card in play in front of any one player.')];
    $this->bullets = 4;
    $this->expansion = DODGE_CITY;
    parent::__construct($row);
  }

  public function getPhaseOneRules(int $defaultAmount, bool $isAbilityAvailable = true): array
  {
    if ($isAbilityAvailable) {
      return [
        RULE_PHASE_ONE_CARDS_DRAW_BEGINNING => 0,
        RULE_PHASE_ONE_PLAYER_ABILITY_DRAW => true,
        RULE_PHASE_ONE_CARDS_DRAW_END => 0,
      ];
    } else {
      return parent::getPhaseOneRules($defaultAmount);
    }
  }

  public function drawCardsPhaseOne()
  {
    // TODO : auto skip if argDrawCard only has 'deck' inside
    $ctx = Stack::getCtx();
    Stack::insertOnTop(Stack::newAtom(ST_ACTIVE_DRAW_CARD, [
      'pId' => $this->getId(),
      'storeResult' => isset($ctx['storeResult']) && $ctx['storeResult'],
    ]));
  }

  public function argDrawCard(): array
  {
    $otherPlayers = Players::getLivingPlayers($this->id);
    $inPlayCards = [];
    /** @var Player $player */
    foreach ($otherPlayers as $player) {
      $inPlayCards = array_merge($inPlayCards, $player->getCardsInPlay()->toArray());
    }

    $drawOptions = [
      'options' => [Rules::getDrawOrDiscardCardsLocation(LOCATION_DECK)]
    ];
    if ($inPlayCards !== []) {
      $drawOptions['options'][] = 'cards';
      $drawOptions['cards'] = $inPlayCards;
    }
    return $drawOptions;
  }

  public function useAbility($args)
  {
    if ($args['selected'] === LOCATION_DECK) {
      $cards = Cards::deal($this->id, 2);
      Notifications::drawCards($this, $cards);
    } else {
      /** @var AbstractCard $card */
      $card = Cards::get($args['selected']);

      $victim = Players::get($card->getOwner());
      Cards::move($card->getId(), LOCATION_HAND, $this->id);
      Notifications::stoleCard($this, $victim, $card, true);
    }
  }
}
