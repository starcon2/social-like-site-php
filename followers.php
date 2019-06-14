<?php
include 'include.php';
?>
<center>
<div class="w3-container" style="width:70%">
  <h2>Followers</h2>
  <ul class="w3-ul w3-card-4">

<?php
  $input_user = $_GET['username'];

	$UsernameToId = $conn->prepare("SELECT id FROM users WHERE username=?");
	$UsernameToId->bind_param("s", $input_user);
	$UsernameToId->execute();
	$ID = $UsernameToId->get_result();
	$IDArr = $ID->fetch_array();
 
 $countusrchk = $ID->num_rows;
 
   if ( $countusrchk == 0 ) {
  error("Invalid user!");
  }
  
  $input_userid = $IDArr['id'];
  
	$fetchFriends = $conn->prepare("SELECT * FROM friends WHERE toid=?");
	$fetchFriends->bind_param("i", $input_userid);
	$fetchFriends->execute();
	$Friends = $fetchFriends->get_result();
 	$count = $Friends->num_rows;
  if ( $count == 0 ) {
  error("You have no friends :(");
  }
  
  while (($row = $Friends->fetch_assoc())) {
 	$IDToUsername = $conn->prepare("SELECT username FROM users WHERE id=?");
	$IDToUsername->bind_param("i", $row['fromid']);
	$IDToUsername->execute();
	$USRNM = $IDToUsername->get_result();
	$USRNMARR = $USRNM->fetch_array();
    echo '    <li class="w3-bar">
      <div class="w3-bar-item"><a href="profile.php?username='.$USRNMARR['username'].'">'.$USRNMARR['username'].'</li></a>';
    }
 ?>
  </ul>
</div>
</center>
</body>
</html>