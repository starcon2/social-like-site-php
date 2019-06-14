<?php
include 'include.php';

if ( !$loggedin ) {
error("You must be logged in to view this page!");
}

?>
<center>
<div class="w3-container" style="width:83%">
  <div class="w3-panel w3-card">
<h1>Settings</h1>
<form action="/process.php?type=settings_change" method="post">
  Blurb:<br>
  <input class="w3-input" type="text" name="blurb" value="Blurb here..."><br>
  <hr>
  <h2>Change password</h2>
  Current Password:<br>
  <input class="w3-input" type="password" name="password" value=""><br><br>
    New Password:<br>
  <input class="w3-input" type="password" name="newpwd" value=""><br><br>
    Repeat new Password:<br>
  <input class="w3-input" type="password" name="newpwd2" value=""><br><br>
  <input class="w3-btn w3-blue" type="submit" value="Change">
</form>
<a href="viewdata.php"><h5>View the data we've collected(on you)</h5></a>
</div>
</div>
</center>
</body>
</html>