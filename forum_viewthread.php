<?php
include 'include.php';
  $id = $_GET['id'];

  // this is actually for THREADS (x2) - riley
	$getForumCats = $conn->prepare("SELECT * FROM forum_topics WHERE id = ?");
  $getForumCats->bind_param('i', $id);
	$getForumCats->execute();
	$forumCats = $getForumCats->get_result();
 	$count = $forumCats->num_rows;
  
  // replies
  	$getForumReplies = $conn->prepare("SELECT * FROM forum_replies WHERE threadid = ?");
  $getForumReplies->bind_param('i', $id);
	$getForumReplies->execute();
	$forunReplies = $getForumReplies->get_result();
 	$countre = $forunReplies->num_rows;
  ?>
  <center>
  <div class="w3-container" style="width:50%">
  
  <?php
  while (($row = $forumCats->fetch_assoc())) {
	$details = $forumCats->fetch_array();
  $post_title = $row['name'];
  $post_description = $row['description'];
  $post_username = id_to_username($row['poster']);
  
  echo "
<div class='w3-card-4 w3-margin w3-white'>
    <div class='w3-container'>
      <h3><b>$post_title</b></h3>
      <h5>by <a href='profile.php?username=$post_username'>$post_username,</a> <span class='w3-opacity'>date 13, here 37</span></h5>
    </div>

    <div class='w3-container'>
      <p>$post_description</p>
      <div class='w3-row'>
        <div class='w3-col m4 w3-hide-small'>
          <p><span class='w3-padding-large w3-right'><b>Replies</b> 0</span></p>
        </div>
      </div>
    </div>
  </div>
  <hr>
  ";
  }

    while (($row = $forunReplies->fetch_assoc())) {
  $replie_content = $row['content'];
  $replie_username = id_to_username($row['poster']);
  
  echo "
<div class='w3-card-4 w3-margin w3-white'>
    <div class='w3-container'>
    </div>

    <div class='w3-container'>
      <p>$replie_content</p>
      <h5>by <a href='profile.php?username=$replie_username'>$replie_username, </a><span class='w3-opacity'>date 13, here 37</span></h5>
      <div class='w3-row'>
        <div class='w3-col m4 w3-hide-small'>
        </div>
      </div>
    </div>
  </div>
  <hr>
  ";
  }
  ?>

<?php
    if ( $countre == 0 ) {
  echo "<center><div class='w3-container' style='width:69%'; > <div class='w3-panel w3-red'>
    <p>No replies yet!</p>
  </div>
  </div>
  </center>";
  }
  ?>
  
  <form action="/process.php?type=forum_proc" method="post">
  Post a reply:<br>
  <input class="w3-input" type="text" name="reply" value="Reply...!"><br>
  <input hidden="hidden" class="w3-input" type="id" name="id" value="<?php echo $id; ?>" style="visibility: hidden;"><br><br>
  <input class="w3-btn w3-blue" type="submit" value="Submit">
</form>

</div>
</center>
</body>
</html>