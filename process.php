<?php
include 'include.php';
if (!isset($_GET['type'])) {
    echo "Needs arguments!";
    die();
}
// riley aka drifttwo here
// im really mixed with this style of coding
// like, process.php
// redirects and fluid-UX is hard like this, but its easier to manage
// also, lots of my code isnt pretty, its fast though


$process_type = $_GET['type'];
if ($process_type == "login") {
    if (ratelimited()) {
        error("Slow down! Wait a few seconds before doing this again!");
    }
    $uname = $_POST['username'];
    $upass = $_POST['password'];
    
        if ( betterempty($uname) ) {
    error("Please input a username!");
    }
    if ( betterempty($upass) ) {
    error("Please input a password!");
    }
    
    $uname = strip_tags($uname);
    $doLoginQuery = $conn->prepare("SELECT * FROM users WHERE username=?");
    $doLoginQuery->bind_param("s", $uname);
    $doLoginQuery->execute();
    $doLoginResult = $doLoginQuery->get_result();
    $doLoginArr = $doLoginResult->fetch_array();
    $count = $doLoginResult->num_rows;
    // if uname and pwd are correct = we are all good
    if (password_verify($upass, $doLoginArr['password']) && $count == 1) {
        $_SESSION['id'] = $doLoginArr['id'];
        $_SESSION['username'] = $doLoginArr['username'];
        $_SESSION['power'] = $doLoginArr['power'];
        $_SESSION['loggedin'] = true;
        store_previous_request_time();
        redirect("index.php");
    } else {
        error("Incorrect password!");
    }
}
//
//
if ($process_type == "register") {
    if (ratelimited()) {
        error("Slow down! Wait a few seconds before doing this again!");
    }
    $uname = $_POST['username'];
    $upass = $_POST['password'];
    $uname = preg_replace("/[^a-zA-Z0-9]+/", "", $uname);
        if ( betterempty($uname) ) {
    error("Please have a username!");
    }
    if ( betterempty($upass) ) {
    error("Please have a password!");
    }
    
    if (strlen($uname) > 12) {
        error("Username too long!");
    }
    if (strlen($uname) == 0) {
        error("Username too short!");
    }
    $AlreadyExists = $conn->prepare("SELECT username FROM users WHERE username=?");
    $AlreadyExists->bind_param("s", $uname);
    $AlreadyExists->execute();
    $AlreadyExistsResult = $AlreadyExists->get_result();
    if (mysqli_num_rows($AlreadyExistsResult) > 0) {
        error("Username taken!");
    }
    $uname = strip_tags($uname);
    $upass = password_hash($upass, PASSWORD_DEFAULT);
    $registerQuery = $conn->prepare("INSERT INTO users (username, password, signup_ip)  VALUES (?, ?, ?)");
    $registerQuery->bind_param("sss", $uname, $upass, $uip);
    $registerQuery->execute();
    store_previous_request_time();
    redirect("login.php");
}
if ($process_type == "settings_change") {
    if (isset($_POST['blurb'])) {
        if (ratelimited()) {
            error("Slow down! Wait a few seconds before doing this again!");
        }
        if ( betterempty($_POST['blurb']))  {
error("Please input blurb content!");
}
        $change_blurb = $conn->prepare("UPDATE users SET blurb = ? WHERE username = ?");
        $clean_blurb = strip_tags($_POST['blurb']);
        $change_blurb->bind_param('ss', $clean_blurb, $username);
        $change_blurb->execute();
        store_previous_request_time();
        success("Succesfully changed blurb");
    }
    if (isset($_POST['newpwd']) & isset($_POST['password']) & $_POST['password'] != "") {
        if (ratelimited()) {
            error("Slow down! Wait a few seconds before doing this again!");
        }
        if ($_POST['newpwd'] != $_POST['newpwd2']) {
            error("Passwords don't match!");
        } else {
            $get_password = $conn->prepare("SELECT password FROM users WHERE username=?");
            $get_password->bind_param("s", $username);
            $get_password->execute();
            $pinf = $get_password->get_result();
            $pwdarr = $pinf->fetch_array();
            if (password_verify($_POST['password'], $pwdarr['password'])) {
                $change_password = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
                $hashed_newpwd = password_hash($_POST['newpwd'], PASSWORD_DEFAULT);
                $change_password->bind_param('ss', $hashed_newpwd, $username);
                $change_password->execute();
                store_previous_request_time();
                success("Succesfully changed password");
            } else {
                error("Current password doesn't match!");
            }
        }
    }
}


if ($process_type == "add_friend") {
//$fromid = $_GET['fromid'];
$toid = $_GET['toid'];
    if (ratelimited()) {
    error("Slow down! Wait a few seconds before doing that again.");
    }
    $friendAddQuery = $conn->prepare("INSERT INTO friends (fromid, toid)  VALUES (?, ?)");
    $friendAddQuery->bind_param("ii", $userid, $toid);
    $friendAddQuery->execute();
    store_previous_request_time();
}

if ($process_type == "remove_friend") {
//$fromid = $_GET['fromid'];
$toid = $_GET['toid'];
    if (ratelimited()) {
    error("Slow down! Wait a few seconds before doing that again.");
    }
    $friendAddQuery = $conn->prepare("DELETE FROM friends WHERE fromid = ? AND toid = ?");
    $friendAddQuery->bind_param("ii", $userid, $toid);
    $friendAddQuery->execute();
    store_previous_request_time();
}

if ( $process_type == "forum_proc" ) {
if ( !$loggedin ) {
error("You have to be logged in to use this feature!");
}
if (isset($_POST['reply'])) {
if ( !$loggedin ) {
error("You have to be logged in to use this feature!");
}
$reply = strip_tags($_POST['reply']);
$poster = $userid;
$id = $_POST['id'];

if ( betterempty($reply) ) {
error("Please input reply content!");
}

    if (ratelimited()) {
    error("Slow down! Wait a few seconds before doing that again.");
    }
    $forumReplyQueue = $conn->prepare("INSERT INTO forum_replies (threadid, content, poster)  VALUES (?, ?, ?)");
    $forumReplyQueue->bind_param("isi", $id, $reply, $poster);
    $forumReplyQueue->execute();
    store_previous_request_time();
    redirect("forum_viewthread.php?id=$id");

}
if (isset($_POST['name'])) {
if ( !$loggedin ) {
error("You have to be logged in to use this feature!");
}
$name = strip_tags($_POST['name']);
$poster = $userid;
$content = strip_tags($_POST['content']);
$catid = $_POST['catid'];


if ( betterempty($name) ) {
error("Please input a topic name!");
}
if ( betterempty($content) ) {
error("Please input content!");
}

    if (ratelimited()) {
    error("Slow down! Wait a few seconds before doing that again.");
    }
    $forumThreadQueue = $conn->prepare("INSERT INTO forum_topics (catid, name, description, poster)  VALUES (?, ?, ?, ?)");
    $forumThreadQueue->bind_param("issi", $catid, $name, $content, $poster);
    $forumThreadQueue->execute();
    store_previous_request_time();
    redirect("forum_catview.php?catid=$catid");

}
}
?>