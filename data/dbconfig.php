<?php
date_default_timezone_set("Asia/Seoul");

define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', '0000');
define('MYSQL_PASSWORD', '0000');
define('MYSQL_DB', '0000');
define('MYSQL_SET_MODE', false);
define('DISPLAY_SQL_ERROR', true);
define('SERVER_TIME',    time());
define('TIME_YMDHIS',    date('Y-m-d H:i:s', SERVER_TIME));
define('TIME_YMD',       substr(TIME_YMDHIS, 0, 10));
define('TIME_HIS',         substr(TIME_YMDHIS, 11, 8));
define('ESCAPE_FUNCTION', 'sql_escape_string');
define('MOBILE_AGENT',   'phone|samsung|lgtel|mobile|[^A]skt|nokia|blackberry|BB10|android|sony');
define('ESCAPE_PATTERN',  '/(and|or).*(union|select|insert|update|delete|from|where|limit|create|drop).*/i');

define('DOMAIN','');
define('COOKIE_DOMAIN','');

define('STRING_ENCRYPT_FUNCTION', 'investment_db');

?>
