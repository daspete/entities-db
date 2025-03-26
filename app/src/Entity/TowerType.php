<?php

namespace App\Entity;

enum TowerType: string
{
    case SingleShotTower = "SINGLE_SHOT_TOWER";
    case MultiShotTower = "MULTI_SHOT_TOWER";
    case AoeTower = "AOE_TOWER";
}
