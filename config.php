<?php
error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );

header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
if (!defined('SET_TIME_LIMITS')) define('SET_TIME_LIMITS', 0);
@set_time_limit(SET_TIME_LIMITS);

$ext_arr = array ('PHP_SELF', '_ENV', '_GET', '_POST', '_FILES', '_SERVER', '_COOKIE', '_SESSION', '_REQUEST',
                  'HTTP_ENV_VARS', 'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_POST_FILES', 'HTTP_SERVER_VARS',
                  'HTTP_COOKIE_VARS', 'HTTP_SESSION_VARS', 'GLOBALS');
$ext_cnt = count($ext_arr);
for ($i=0; $i<$ext_cnt; $i++) {
    if (isset($_GET[$ext_arr[$i]]))  unset($_GET[$ext_arr[$i]]);
    if (isset($_POST[$ext_arr[$i]])) unset($_POST[$ext_arr[$i]]);
}

function path()
{
    $chroot = substr($_SERVER['SCRIPT_FILENAME'], 0, strpos($_SERVER['SCRIPT_FILENAME'], dirname(__FILE__)));
    $result['path'] = str_replace('\\', '/', $chroot.dirname(__FILE__));
    $server_script_name = preg_replace('/\/+/', '/', str_replace('\\', '/', $_SERVER['SCRIPT_NAME']));
    $server_script_filename = preg_replace('/\/+/', '/', str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']));
    $tilde_remove = preg_replace('/^\/\~[^\/]+(.*)$/', '$1', $server_script_name);
    $document_root = str_replace($tilde_remove, '', $server_script_filename);
    $pattern = '/' . preg_quote($document_root, '/') . '/i';
    $root = preg_replace($pattern, '', $result['path']);
    $port = ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443) ? '' : ':'.$_SERVER['SERVER_PORT'];
    $http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';
    $user = str_replace(preg_replace($pattern, '', $server_script_filename), '', $server_script_name);
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
    if(isset($_SERVER['HTTP_HOST']) && preg_match('/:[0-9]+$/', $host))
        $host = preg_replace('/:[0-9]+$/', '', $host);
    $host = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", '', $host);
    $result['url'] = $http.$host.$port.$user.$root;
    return $result;
}

$path = path();



include_once($path['path'].'/data/dbconfig.php');

include_once($path['path'].'/comm.php');

unset($path);

$connect_db = sql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die('MySQL Connect Error!!!');


$select_db  = sql_select_db(MYSQL_DB, $connect_db) or die('MySQL DB Error!!!');
$home['connect_db'] = $connect_db;
sql_set_charset('utf8', $connect_db);



session_save_path(SESSIONPATH);




ini_set("session.cache_expire", 10); // 세션 캐쉬 보관시간 (분)
ini_set("session.gc_maxlifetime", 3600); // session data의 garbage collection 존재 기간을 지정 (초)
ini_set("session.gc_probability", 1); // session.gc_probability는 session.gc_divisor와 연계하여 gc(쓰레기 수거) 루틴의 시작 확률을 관리합니다. 기본값은 1입니다. 자세한 내용은 session.gc_divisor를 참고하십시오.
ini_set("session.gc_divisor", 100); // session.gc_divisor는 session.gc_probability와 결합하여 각 세션 초기화 시에 gc(쓰레기 수거) 프로세스를 시작할 확률을 정의합니다. 확률은 gc_probability/gc_divisor를 사용하여 계산합니다. 즉, 1/100은 각 요청시에 GC 프로세스를 시작할 확률이 1%입니다. session.gc_divisor의 기본값은 100입니다.

session_set_cookie_params(0, '/');
ini_set("session.cookie_domain", COOKIE_DOMAIN);

@session_start();


//server conf add to $conf
$sql = "select * from server_conf";
$conf = sql_fetch($sql);
$hostname=$_SERVER["HTTP_HOST"]; //도메인명(호스트)명을 구합니다.
$uri= $_SERVER['REQUEST_URI']; //uri를 구합니다.
$query_string=getenv("QUERY_STRING"); // Get값으로 넘어온 값들을 구합니다.
$phpself=$_SERVER["PHP_SELF"]; //현재 실행되고 있는 페이지의 url을 구합니다.
$basename=basename($_SERVER["PHP_SELF"]); //현재 실행되고 있는 페이지명만 구합니다.


// 모바일 인지 결정 $_SERVER['HTTP_USER_AGENT']
define('G5_MOBILE_AGENT',   'phone|samsung|lgtel|mobile|[^A]skt|nokia|blackberry|BB10|android|sony');
function is_mobile()
{
    return preg_match('/'.G5_MOBILE_AGENT.'/i', $_SERVER['HTTP_USER_AGENT']);
}

$is_mobile = false;
$set_device = true;
if(defined('G5_SET_DEVICE') && $set_device) {
    switch(G5_SET_DEVICE) {
        case 'pc':
            $is_mobile  = false;
            $set_device = false;
            break;
        case 'mobile':
            $is_mobile  = true;
            $set_device = false;
            break;
        default:
            break;
    }
}
   if ($_REQUEST['device']=='pc')
       $is_mobile = false;
   else if ($_REQUEST['device']=='mobile')
       $is_mobile = true;
   else if (isset($_SESSION['ss_is_mobile']))
       $is_mobile = $_SESSION['ss_is_mobile'];
   else if (is_mobile())
       $is_mobile = true;



?>
