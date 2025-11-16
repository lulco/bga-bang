<?php

declare(strict_types=1);

namespace Bang\Tests\Mocks;

use BANG\Helpers\Collection;
use BANG\Managers\Cards;
use BANG\Models\Player;
use BgaVisibleSystemException;
use PHPUnit\Framework\MockObject\MockObject;

trait PlayerMockerAndFaker
{
  private array $playerData = [
    'player_id' => 123,
    'player_no' => 1,
    'player_name' => 'Test',
    'player_color' => 'red',
    'player_eliminated' => 0,
    'player_zombie' => 0,
    'player_role' => RENEGADE,
    'player_score' => 0,
    'player_autopick_general_store' => true,
    'player_alt_character' => -1,
    'player_unconscious' => FULLY_ALIVE,
    'player_agreed_to_disclaimer' => 1,
  ];

  protected function getPlayerData(array $override = []): array
  {
    return array_merge($this->playerData, $override);
  }

  protected function createPlayerMock(array $row, array $handCards = [], array $cardsInPlay = []): Player
  {
    return new class($row, $handCards, $cardsInPlay) extends Player
    {
      private array $handCards;

      private array $cardsInPlay;

      public function __construct(array $row, array $handCards, array $cardsInPlay)
      {
        parent::__construct($row);
        $this->handCards = $handCards;
        $this->cardsInPlay = $cardsInPlay;
      }

      public function getHand()
      {
        return new Collection($this->handCards);
      }

      public function getCardsInPlay()
      {
        return new Collection($this->cardsInPlay);
      }
    };
  }

  protected function createPlayerMockWithNoCardsInPlay(int $character): Player
  {
      $player = $this->createPlayerMock($this->getPlayerData(['player_character' => $character, 'player_hp' => 4, 'player_bullets' => 4]));
      return $player;
  }

  /**
   * @param int[] $cardTypes list of card types in play
   * @throws BgaVisibleSystemException
   */
  protected function createPlayerMockWithCardsInPlay(int $character, array $cardTypes = []): Player
  {
    $cards = [];
    foreach ($cardTypes as $cardType) {
      $cards[] = Cards::getCardByType($cardType);
    }
    $player = $this->createPlayerMock($this->getPlayerData(['player_character' => $character, 'player_hp' => 4, 'player_bullets' => 4]), [], $cards);
    return $player;
  }
}
