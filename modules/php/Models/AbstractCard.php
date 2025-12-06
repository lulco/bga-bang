<?php

namespace BANG\Models;

use BANG\Cards\Barrel;
use BANG\Core\Stack;
use BANG\Managers\Cards;
use BANG\Core\Notifications;
use BANG\Managers\EventCards;
use JsonSerializable;

/**
 * AbstractCard: base class to handle actions cards
 *
 * @property-read int $id
 * @property-read int $color
 * @property-read int $value
 * @property-read int $type
 * @property-read string $name
 * @property-read string $text
 * @property-read array $symbols
 * @property-read array $effect array with type, impact and sometimes range
 * @property-read array $copies
 */
abstract class AbstractCard implements JsonSerializable
{
  /**
   * @param array{id: int|string, value?: int|string, color?: int}|null $params
   */
  public function __construct(?array $params = null)
  {
    if ($params !== null) {
      $this->id = (int) $params['id'];
      if (array_key_exists('value', $params)) {
        $this->value = $params['value'];
      }
      if (array_key_exists('color', $params)) {
        $this->color = $params['color'];
      }
      if (array_key_exists('location', $params)) {
        $locationParts = explode('_', $params['location']);
        $this->location = $locationParts[0] ?? null;
      }
    }
  }

  /*
   * Attributes
   */
  protected $id;
  protected $color;
  protected $value;
  protected $location;
  protected $border = '';

  // Static information about cards
  protected $type;
  protected $name;
  protected $text;
  protected $symbols;
  protected $effect; // array with type, impact and sometimes range
  protected $copies = [];

  /**
   * getUiData: used in frontend to display cards
   * @return array
   */
  public function getUIData()
  {
    return [
      'type' => $this->type,
      'name' => $this->name,
      'text' => $this->text,
    ];
  }

  /*
   * jsonSerialize: used in frontend to manipulate cards
   */
  public function jsonSerialize(): array
  {
    return [
      'id' => $this->id,
      'type' => $this->type,
      'color' => $this->color,
      'value' => $this->value,
      'border' => $this->border,
      'location' => $this->location,
    ];
  }

  /*
   * Getters
   */
  public function getId()
  {
    return $this->id;
  }

  public function getType()
  {
    return $this->type;
  }

  public function getLocation()
  {
    return $this->location;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getText()
  {
    return $this->text;
  }

  public function getEffect()
  {
    return $this->effect;
  }

  public function getSymbols()
  {
    return $this->symbols;
  }

  public function getCopies()
  {
    return $this->copies;
  }

  public function getCopy()
  {
    return $this->copy;
  }

  public function getColor()
  {
    return null; // Will be overwrite by Blue/Brown class
  }

  public function getSuit(bool $includingOverride = false)
  {
    if ($includingOverride === true) {
      $event = EventCards::getActive();
      return $event ? $event->getSuitOverride() : $this->color;
    }
    return $this->color;
  }

  public function getCopyValue()
  {
    return $this->value;
  }

  public function getEffectType()
  {
    return $this->effect['type'];
  }

  public function targetLocationAfterPlay(): string
  {
    return LOCATION_DISCARD;
  }

  public function isAction()
  {
    return false;
  }

  public function isWeapon()
  {
    return false;
  }
  public function getNameAndValue()
  {
    $colors = [
      'H' => clienttranslate('Hearts'),
      'C' => clienttranslate('Clubs'),
      'D' => clienttranslate('Diamonds'),
      'S' => clienttranslate('Spades'),
    ];
    return $this->name . ' (' . $colors[$this->color] . ' ' . $this->value . ')';
  }

  public function wasPlayed(): bool
  {
    return false;
  }

  public function discard(): void
  {
    Cards::discard($this);
  }

  /**
   * getPlayOption : default function to know which card can be played by $player
   * @return array{target_types?: int[], targets?: int[], status_bar_message?: string, confirmationMsg?: string, with_another_card?: array{strict: bool, cards: array, targets: int[]}}|null type of option and targets if any
   */
  public function getPlayOptions(Player $player): ?array
  {
    return [];
  }

  /**
   * play : default function to play a card that. Can be used for cards that have only symbols
   * return: null if the game should continue the play loop, "stateName" if another state need to be called
   */
  public function play(Player $player, array $args): void
  {
  }

  /**
   * @param Player $player
   * @return void
   */
  public function playCard($player)
  {
    Cards::play($this->id);
  }

  /**
   * getReactionOptions: default function to handle possible reaction (attack => defense)
   * return: list of options (cards/abilities) that can be used
   */
  public function getReactionOptions(Player $player): array
  {
    return $player->getDefensiveOptions();
  }

  /**
   * react: default function to handle reaction using a card
   */
  public function react(AbstractCard $card, Player $player): void
  {
    if (($this->effect['type'] ?? null) == BASIC_ATTACK) {
      if ($card instanceof Barrel && $card->getLocation() === LOCATION_INPLAY) {
        $card->activate($player);
      } elseif ($card->getColor() === BROWN || $player->getCharacter() === ELENA_FUENTE) { // I don't like this character check here
        $card->playCard($player);
        Notifications::cardPlayed($player, $card, ['targetLocation' => LOCATION_DISCARD]);
      } elseif ($card instanceof GreenCard) {
        $card->play($player, []);
        Notifications::cardPlayed($player, $card, ['targetLocation' => LOCATION_DISCARD]);
      } else {
        // E.g. reacting to Bang! using a barrel
        $card->activate($player);
      }
    }
  }

  /**
   * pass: default function to handle reaction by clicking "pass" button
   */
  public function pass(Player $player): void
  {
    if ($this->effect['type'] === BASIC_ATTACK) {
      Stack::unsuspendNext(ST_REACT);
      $targetCardId = Stack::getCtx()['targetCardId'] ?? null;
      if ($targetCardId) {
        $player->discardCard(Cards::get($targetCardId));
      } else {
        $player->loseLife();
      }
    }
  }

  /**
   * function to overwrite by blue cards like barrel, jail, dynamite
   */
  public function activate(Player $player, array $args = []): void
  {
  }

  public function startOfTurn(Player $player): void
  {
  }
}
