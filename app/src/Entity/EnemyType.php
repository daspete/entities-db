<?php

namespace App\Entity;

enum EnemyType: string
{
    case WalkingEnemy = "WALKING_ENEMY";
    case FlyingEnemy = "FLYING_ENEMY";
    case ShootingEnemy = "SHOOTING_ENEMY";
}
