<?php
include 'include.php';

if ( !$loggedin ) {
error("You need to be logged in to view your data ;) ");
}


  	$userstable = $conn->prepare("SELECT * FROM users WHERE id=?");
	$userstable->bind_param("i", $userid);
	$userstable->execute();
	$userstablearr = $userstable->get_result();
	$userstablearrary = $userstablearr->fetch_array();
  //$userstablearrary['username']; how to call it

?>
<center>
<div class="w3-container" style="width: 90%">
  <div class="w3-panel w3-red">
    <h3>Read!</h3>
    <p>This page has all the data we've collected on you, and ways for us to delete it!</p>
    <p>Some of this data wasnt even personalized, but we value your privacy and here's everything!</p>
    <p>This page will be updated often(as we collect more data, or less data). We won't show some data for privacy reasons (aka your password, and some basic data such as forum data and non personally identifiable data.</p>
  </div>
</div> 


<div class="w3-container">
  <div class="w3-card-4" style="width:85%;">
    <header class="w3-container w3-green">
      <h1>Data from table "users"</h1>
    </header>

    <div class="w3-container">
     id: <?php echo $userstablearrary['id']; ?> 
     <hr>
     username: <?php echo $userstablearrary['username']; ?>
     <hr>
     power: <?php echo $userstablearrary['power']; ?>
     <hr>
     cool: <?php echo $userstablearrary['cool']; ?>
     <hr>
     blurb: <?php echo $userstablearrary['blurb']; ?>
     <hr>
     ip: <?php echo $userstablearrary['ip']; ?>
     <hr>
     signup_ip: <?php echo $userstablearrary['signup_ip']; ?>
     <hr>
    </div>

    <footer class="w3-container w3-green">
      <h5>End of data from table "users"</h5>
    </footer>
  </div>
</div>
</center>