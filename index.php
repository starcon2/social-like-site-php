<?php
include 'include.php';

//echo $userid;
//echo $username;
//echo $loggedin;
?>
<?php if (  $loggedin ) { ?>
<center>
<div class="w3-container">

  <div class="w3-card-4" style="width:77%;">
    <header class="w3-container w3-green">
      <h1>Hello, <?php echo $username; ?>!</h1>
    </header>

    <div class="w3-container">
      <p>See what your friends are doing today!</p>
    </div>
  </div>
</div>
</center>
<?php } else { ?>
<body>

<!-- Header -->
<header class="w3-container w3-green w3-center" style="padding:128px 16px">
  <h1 class="w3-margin w3-jumbo">JOIN TODAY!</h1>
  <p class="w3-xlarge">Join other users today, and innovate today!</p>
 <a href="register.php"> <button class="w3-button w3-black w3-padding-large w3-large w3-margin-top">Join</button></a>
</header>




<?php } ?>
</body>
</html>