<?php

/*API response codes*/
define('API_RES_STATUS_SUCCESS',201);
define('API_RES_STATUS_FAILED',400);

define('MAX_WIN_AMOUNT',20000);

/*Stake amount validation rule configurations*/
define('MINIMUM_STAKE_AMOUNT',0.3);
define('MAXIMUM_STAKE_AMOUNT',10000);
define('STAKE_AMOUNT_MAX_DECIMAL_POINTS',2);

/*Selections validation rule configurations*/
define('MINIMUM_SELECTIONS',1);
define('MAXIMUM_SELECTIONS',20);

/*Selections - odds validation rule configurations*/
define('MINIMUM_ODD_INTERVAL',1);
define('MAXIMUM_ODD_INTERVAL',10000);
define('ODD_INTERVAL_MAX_DECIMAL_POINTS',3);

define('PLAYER_DEFAULT_BALANCE_AMOUNT',1000);

include 'ErrorCodes.php';
