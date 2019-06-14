<?php
include 'include.php';
 $input_user = $_GET['username'];
	$fetchUInfo = $conn->prepare("SELECT * FROM users WHERE username=?");
	$fetchUInfo->bind_param("s", $input_user);
	$fetchUInfo->execute();
	$UInfo = $fetchUInfo->get_result();
	$UInfoArr = $UInfo->fetch_array();
 	$count = $UInfo->num_rows;
  if ( $count == 0 ) {
  error("User not found!");
  }
 ?>
 <center>
 <div class="w3-container">
  <div class="w3-card-4" style="width:95%">
    <header class="w3-container w3-light-grey">
      <h3><?php echo $UInfoArr['username']; ?></h3>
    </header>
    <div class="w3-container">
      <p style="word-wrap: break-word;"><?php echo $UInfoArr['blurb']; ?></p><br>
      <hr>
    </div>
    <?php
        $AlreadyExists = $conn->prepare("SELECT * FROM friends WHERE fromid=? AND toid=?");
    $AlreadyExists->bind_param("ii", $userid, $UInfoArr['id']);
    $AlreadyExists->execute();
    $AlreadyExistsResult = $AlreadyExists->get_result();
    if ( $UInfoArr['username'] != $username ) {
    if (mysqli_num_rows($AlreadyExistsResult) > 0) { ?>
       <a href="process.php?type=remove_friend&toid=<?php echo $UInfoArr['id'];?>"> <button class="w3-button w3-block w3-red">Unfollow</button></a>
        <?php } else { ?>
            <a href="process.php?type=add_friend&toid=<?php echo $UInfoArr['id'];?>"><button class="w3-button w3-block w3-green">Follow</button></a>
            <?php } } ?>
            <a href="followers.php?username=<?php echo $UInfoArr['username'];?>"><button class="w3-button w3-block w3-green">View followers</button></a>
  </div>
</div>
</center>
</body>
</html>