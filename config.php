<?php
ini_set('display_errors', 0);
session_save_path('./session');
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 604800);
ini_set('session.cookie_lifetime', '604800');

define('DSN', 'mysql:host=localhost;dbname=hischeduler');
define('DB_USER', 'root');
define('DB_PASS', '');