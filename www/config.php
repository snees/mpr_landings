<?php
define('BASE_URL', (isset($_SERVER['HTTPS'])?'https://':'http://').$_SERVER['HTTP_HOST']);
define('INC_URL', BASE_URL.'/inc');
define('LANDING_URL', BASE_URL.'/page');

// install_db

?>