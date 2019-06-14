<?php
// my global include file, just has basic shit i can use in all projects
function my_csrf_callback() {
    echo "CSRF Error";
}
function csrf_startup() {
    if (isset($_POST['ajax'])) csrf_conf('rewrite', false);
    csrf_conf('secret', 'ABCDEFG1234567');
    csrf_conf('rewrite-js', '/csrf-magic.js');
    csrf_conf('callback', 'my_csrf_callback');
    csrf_conf('allow-ip', false);
}
include_once 'csrf-magic.php';

session_set_cookie_params(0, //session cookie time -- 0 is for session time
'/', //session path from where it can access
'', //host blank will set the host of your site
false, //works only in ssl
true
//set true for httponly means it will access only from server side.
);

session_start();

$mysql_host = "localhost"; //mysql server host
$mysql_username = "root"; // mysql server username
$mysql_password = "null"; // mysql server password
$mysql_database = "all_main"; // database name ( not table)
$conn = mysqli_connect($mysql_host, $mysql_username, $mysql_password, $mysql_database); // connects, this uses mysqli btw
if (mysqli_connect_errno()) { // if errors
    echo "Database connection error! Error: " . mysqli_connect_error(); // show it dumbass
}

$uip = get_ip_address(); // gets ip, see pasted function way below

if (isset($_SESSION['id']) & isset($_SESSION['username']) & isset($_SESSION['power']) & isset($_SESSION['loggedin'])) { // sets main/global user vars
    $userid = $_SESSION['id'];
    $username = $_SESSION['username'];
    $power = $_SESSION['power'];
    $loggedin = $_SESSION['loggedin'];
} else {
// if that session shit doesnt exist, just make it all false and guest
    $userid = 0;
    $username = "Guest";
    $power = 0;
    $loggedin = false;
}


// navbar
if (!$loggedin) {
?>
  <html>
  <head>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
  <nav>
  <div class="w3-bar w3-border w3-green">
    <a href="#" class="w3-bar-item w3-button w3-padding-16">Home</a>
  <a href="login.php" class="w3-bar-item w3-button w3-padding-16 w3-right">Login</a>
  <a href="register.php" class="w3-bar-item w3-button w3-padding-16 w3-right">Register </a>
</div>
</nav>

<?php
} else {
?>
 <html>
  <head>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
  <nav>
  <div class="w3-bar w3-border w3-green">
    <a href="index.php" class="w3-bar-item w3-button w3-padding-16">Home</a>
    <a href="forum_global.php" class="w3-bar-item w3-button w3-padding-16">Forums</a>
  <a href="<?php echo "profile.php?username=$username"; ?>" class="w3-bar-item w3-button w3-padding-16 w3-right"><?php echo $username; ?></a>
    <a href="settings.php" class="w3-bar-item w3-button w3-padding-16 w3-right">Settings</a>
</div>
</nav>

<?php
}


function redirect($url) {
    echo "<script>window.location.replace('$url')</script>)";
} // redirect function, prevents header errors and just uses javascirpt
function error($text) { // wow a reverse success
    echo "  <center><div class='w3-container' style='width:69%'; > <div class='w3-panel w3-red'>
    <p>Error! $text</p>
  </div>
  </div>
  </center>
  ";
    die();
}
function success($text) { // what do you think this does dumbass
    echo "  <center><div class='w3-container' style='width:69%'; > <div class='w3-panel w3-green'>
    <p>Success! $text</p>
  </div>
  </div>
  </center>
  ";
    die();
}
function store_previous_request_time() { // call this if ratelimit = false
    $_SESSION['last_request_time'] = time();
}
function ratelimited() {
    $_SESSION['requests'] = $_SESSION['requests'] + 1;
    if ($_SESSION['requests'] > 4) {
        if ($_SESSION['last_request_time'] + 20 > time()) {
            // user is ratelimited
            return true;
        } else {
            $_SESSION['requests'] = 0;
            //user isnt ratelimited
            return false;
        }
    }
}

function get_ip_address() { // pasted from stackoverflow
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                if (validate_ip($ip))
                    return $ip;
            }
        }
        else {
            if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
        return $_SERVER['HTTP_X_FORWARDED'];
    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
        return $_SERVER['HTTP_FORWARDED_FOR'];
    if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
        return $_SERVER['HTTP_FORWARDED'];

    return $_SERVER['REMOTE_ADDR'];
}

function validate_ip($ip) { // also pasted from sof

    if (strtolower($ip) === 'unknown')
        return false;
        
    $ip = ip2long($ip);

    if ($ip !== false && $ip !== -1) {
        $ip = sprintf('%u', $ip);

        if ($ip >= 0 && $ip <= 50331647)
            return false;
        if ($ip >= 167772160 && $ip <= 184549375)
            return false;
        if ($ip >= 2130706432 && $ip <= 2147483647)
            return false;
        if ($ip >= 2851995648 && $ip <= 2852061183)
            return false;
        if ($ip >= 2886729728 && $ip <= 2887778303)
            return false;
        if ($ip >= 3221225984 && $ip <= 3221226239)
            return false;
        if ($ip >= 3232235520 && $ip <= 3232301055)
            return false;
        if ($ip >= 4294967040)
            return false;
    }
    return true;
}
       if ($loggedin) {
        $get_ip_toup = $conn->prepare("UPDATE users SET ip = ? WHERE username = ?");
        $get_ip_toup->bind_param('ss', $uip, $username);
        $get_ip_toup->execute();
       }
       
       
       function betterempty($input) {
       if ( strlen($input) == 0 ) {
       return true;
       }
       if ( empty($input) ) {
       return true;
       }
       if ( strlen($input) >= 1024 ) {
       return true;
       }
       
       }
       
       
function id_to_username($id) { // takes id as input, outputs username
 global $conn;
 	$IDToUsername = $conn->prepare("SELECT username FROM users WHERE id=?");
	$IDToUsername->bind_param("i", $id);
	$IDToUsername->execute();
	$USRNM = $IDToUsername->get_result();
	$USRNMARR = $USRNM->fetch_array();
 return $USRNMARR['username'];
 }
 function username_to_id($username) { // takes id as input, outputs username
 global $conn;
 	$UsernameToID = $conn->prepare("SELECT id FROM users WHERE username=?");
	$UsernameToID->bind_param("s", $username);
	$UsernameToID->execute();
	$USRNM = $UsernameToID->get_result();
	$USRNMARR = $USRNM->fetch_array();
 return $USRNMARR['id'];
 }
// and on

?>