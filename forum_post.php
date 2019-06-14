<?php
include 'include.php';
$cid = $_GET['catid'];
if ( !$loggedin ) {
error("You have to be logged in to use this feature!");
}
?>
<center>
<div class="w3-container" style="width:50%">
<h1>Forum post topic</h1>
<form action="/process.php?type=forum_proc" method="post">
  Topic name:<br>
  <input class="w3-input" type="text" name="name" value="Topic name here!"><br>
  Topic content:<br>
  <input class="w3-input" type="text" name="content" value="Talk about something..."><br><br>
  <input hidden class="w3-input" type="catid" name="catid" value="<?php echo $cid; ?>" style="visibility: hidden;"><br><br>
  <input class="w3-btn w3-blue" type="submit" value="Submit">
</form>
</div>
</center>
</body>
</html>