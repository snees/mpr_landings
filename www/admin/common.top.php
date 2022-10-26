<?php

// ↓ 기본 경로 세팅
// include_once trim($_SERVER['DOCUMENT_ROOT'])."/admin/session.php";
function cb_path()
{
    $chroot = substr($_SERVER['SCRIPT_FILENAME'], 0, strpos($_SERVER['SCRIPT_FILENAME'], dirname(__FILE__)));
    $result['path'] = str_replace('\\', '/', $chroot.dirname(__FILE__));
    $tilde_remove = preg_replace('/^\/\~[^\/]+(.*)$/', '$1', $_SERVER['SCRIPT_NAME']);
    $document_root = str_replace($tilde_remove, '', $_SERVER['SCRIPT_FILENAME']);
    $pattern = '/' . preg_quote($document_root, '/') . '/i';
    $root = preg_replace($pattern, '', $result['path']);
    $port = ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443) ? '' : ':'.$_SERVER['SERVER_PORT'];
    $http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';
    $user = str_replace(preg_replace($pattern, '', $_SERVER['SCRIPT_FILENAME']), '', $_SERVER['SCRIPT_NAME']);
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
    if(isset($_SERVER['HTTP_HOST']) && preg_match('/:[0-9]+$/', $host))
        $host = preg_replace('/:[0-9]+$/', '', $host);
    $host = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", '', $host);
    $result['url'] = $http.$host.$port.$user.$root;
    return $result;
}

$cb_path = cb_path();

define('CB_URL', $cb_path['url']);
define('CB_ADMIN_URL', $cb_path['url']);

define('CB_PATH', $cb_path['path']);

//---- define('CB_SESSION', trim($_SERVER['DOCUMENT_ROOT']).'/data/session');
define('CB_USERIP', $_SERVER['REMOTE_ADDR']);

define('CB_SERVERTIME', time());
define('CB_YMDHIS', date('Y-m-d H:i:s', CB_SERVERTIME));
define('CB_YMD', substr(CB_YMDHIS, 0, 10));
define('CB_HIS', substr(CB_YMDHIS, 11, 8));

@ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
@ini_set("url_rewriter.tags","");		 // 링크에 PHPSESSID가 따라다니는것을 무력화

define('CB_IMG', CB_URL.'/dist/img');
define('CB_JS',  CB_URL.'/dist/js');
define('CB_CSS',  CB_URL.'/dist/css');
define('CB_PLUGIN',  CB_URL.'/plugins');

//==============================================================================
// SESSION 설정
//------------------------------------------------------------------------------
@ini_set("session.use_trans_sid", 0);       // PHPSESSID를 자동으로 넘기지 않음
@ini_set("url_rewriter.tags","");           // 링크에 PHPSESSID가 따라다니는것을 무력화함

session_save_path(dirname($_SERVER['DOCUMENT_ROOT']).'/session');

if (isset($SESSION_CACHE_LIMITER))
    @session_cache_limiter($SESSION_CACHE_LIMITER);
else
    @session_cache_limiter("no-cache, must-revalidate");

@ini_set("session.cache_expire", 180);
@ini_set("session.gc_maxlifetime", 10800);
@ini_set("session.gc_probability", 1);
@ini_set("session.gc_divisor", 100);

session_set_cookie_params(0, '/');

ini_set("display_startup_errors", 1);
ini_set("display_errors", 1);
error_reporting(E_ALL ^ E_NOTICE);

date_default_timezone_set('Asia/Seoul');

header("Content-Type: text/html; charset=UTF-8");

// 세션 등록 시 처리
// session_start();
//------------------------------------------------------------------------------

include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";

// ↓↓↓ 로그인 여부 체크, 그에 따른 처리

?>
