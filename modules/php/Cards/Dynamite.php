<?php

declare(strict_types=1);

namespace BANG\Cards;

use BANG\Core\Notifications;
use BANG\Managers\Cards;
use BANG\Managers\Players;
use BANG\Managers\Rules;
use BANG\Models\AbstractCard;
use BANG\Models\BlueCard;
use BANG\Models\Player;

class Dynamite extends BlueCard
{
  public function __construct(?array $params = null)
  {
    parent::__construct($params);
    $this->type = CARD_DYNAMITE;
    $this->name = clienttranslate('Dynamite');
    $this->text = clienttranslate(
      "At the start of your turn reveal top card from the deck. If it's Spades 2-9, you lose 3 life points. Else pass the Dynamite to the player on your left."
    );
    $this->symbols = [[SYMBOL_DYNAMITE, clienttranslate('Lose 3 life points. Else pass the Dynamite on your left.')]];
    $this->copies = [
      BASE_GAME => ['2H'],
      HIGH_NOON => [],
      DODGE_CITY => ['10C'],
    ];
  }

  /*
   * When activated at the start of turn, flip a card and resolve effect
   */
  public function startOfTurn(Player $player): void
  {
    if (!Rules::isIgnoreCardsInPlay()) {
      $player->addFlipAtom($this);
    }
  }

  public function resolveFlipped(AbstractCard $card, Player $player): void
  {
    $player->discardCard($card, true); // Discard a flipped card

    $copyValue = $card->getCopyValue();
    $suitOverrideInfo = Rules::getSuitOverrideInfo($card, 'S');
    // Between 2 & 9 of spades ? => kaboom
    if ($suitOverrideInfo['flipSuccessful'] && is_numeric($copyValue) && intval($copyValue) < 10) {
      Notifications::tell(clienttranslate('Dynamite explodes${flipEventMsg}'), $suitOverrideInfo);
      $player->discardCard($this, true); // Discard Dynamite itself
      $player->loseLife(3);
    } else {
      $next = $player;
      do {
        $next = Players::getNext($next);
        $hasDynamite = (bool)$next->getBlueCardsInPlay()->filter(function(AbstractCard $card) {
          return $card->getType() === CARD_DYNAMITE;
        })->count();
      } while ($next->getId() !== $player->getId() && $hasDynamite);

      if ($next->getId() === $player->getId()) {
        return;
      }
      Cards::equip($this->id, $next->getId());
      Notifications::moveCard($this, $player, $next);
    }
  }

  public function play(Player $player, array $args): void
  {
    Cards::equip($this->id, $player->getId());
  }
}
