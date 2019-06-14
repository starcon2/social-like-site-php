<?php
include 'include.php';

?>
<center>
<div class="w3-container" style="width:50%">
<div class="w3-card">
<div class="w3-container" style="width:80%">
<h1>Login</h1>
<form action="/process.php?type=login" method="post">
  Username:<br>
  <input class="w3-input" type="text" name="username" value="Username here..."><br>
  Password:<br>
  <input class="w3-input" type="password" name="password" value="Password!"><br><br>
  <input class="w3-btn w3-blue" type="submit" value="Submit">
</form>
</div>
</div>
</div>
</center>
</body>
</html>