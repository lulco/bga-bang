<?php

namespace BANG\Characters;

use BANG\Core\Notifications;
use BANG\Managers\Rules;
use BANG\Models\Player;

class ChuckWengam extends Player
{
  public function __construct($row = null)
  {
    $this->character = CHUCK_WENGAM;
    $this->character_name = clienttranslate('Chuck Wengam');
    $this->text = [clienttranslate('During his turn, he may choose to lose 1 life point to draw 2 cards')];
    $this->bullets = 4;
    $this->expansion = DODGE_CITY;
    parent::__construct($row);
  }


  public function getHandOptions()
  {
    return $this->addAbility(parent::getHandOptions());
  }

  private function addAbility($options)
  {
    if (Rules::isAbilityAvailable() && $this->hp > 1) {
        $options['character'] = CHUCK_WENGAM;
    }
    return $options;
  }

  public function useAbility($args)
  {
    Notifications::tell(
      clienttranslate('${player_name} uses the ability of Chuck Wengam by losing 1 life point to draw 2 cards'),
      ['player_name' => $this->name]
    );

    $this->loseLife(1);
    $this->drawCards(2);
  }
}
