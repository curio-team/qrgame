<?php
return [
    'default_cooldown_minutes' => 10,
    'max_nickname_length'      => 24,
    'session_cookie_days'      => 30,
    'scoreboard_top_n'         => 20,
    'scan_session_key'         => 'qr_player_token',
    'group_session_key'        => 'qr_group_id',
    'steal_percent'            => 0.10, // steal 10% of leader's score
    'underdog_threshold_rank'  => 3,    // apply underdog bonus if rank >= this
    'speed_bonus_minutes'      => 2,    // bonus if scanned within X minutes of game start
    'rarity_weights' => [
        'common'    => 50,
        'rare'      => 30,
        'epic'      => 15,
        'legendary' => 4,
        'cursed'    => 1,
    ],
];
