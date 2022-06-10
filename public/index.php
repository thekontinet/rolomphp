<?php
// Load all constant
require_once '../system/config/constant.php';

// Load Database Connection
require_once CONFIGPATH . DIRECTORY_SEPARATOR . 'database.php';

// Load Helper Functions
require_once CONFIGPATH . DIRECTORY_SEPARATOR . 'functions.php';

// Load router configuration files, and configure router
define('ROUTER', require_once (CONFIGPATH . DIRECTORY_SEPARATOR . 'router.php'));
(require_once (APPPATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'routes.php'))(ROUTER);
ROUTER['resolve']();