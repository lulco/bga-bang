<?php

namespace BANG\Models;

use BANG\Core\Stack;
use BANG\Managers\Cards;
use BANG\Core\Notifications;
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
  public function jsonSerialize()
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

  public function getSuit()
  {
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

  public function wasPlayed()
  {
  }

  public function discard()
  {
    Cards::discard($this);
  }

  /**
   * getPlayOption : default function to know which card can be played by $player
   * return: type of option and targets if any
   */
  public function getPlayOptions($player)
  {
    return [];
  }

  /**
   * play : default function to play a card that. Can be used for cards that have only symbols
   * return: null if the game should continue the play loop, "stateName" if another state need to be called
   */
  public function play($player, $args)
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
  public function getReactionOptions(Player $player)
  {
    return $player->getDefensiveOptions();
  }

  /**
   * react: default function to handle reaction using a card
   */
  public function react($card, $player)
  {
    if (($this->effect['type'] ?? null) == BASIC_ATTACK) {
      if ($card->getColor() == BROWN) {
        $card->playCard($player);
        Notifications::cardPlayed($player, $card);
      } else {
        // E.g. reacting to Bang! using a barrel
        $card->activate($player);
      }
    }
  }

  /**
   * pass: default function to handle reaction by clicking "pass" button
   * @param Player $player
   */
  public function pass($player)
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
  public function activate($player, $args = [])
  {
  }

  public function startOfTurn($player)
  {
  }
}
