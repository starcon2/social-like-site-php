<?php
include 'include.php';
  $catid = $_GET['catid'];

  // this is actually for topics - riley
	$getForumCats = $conn->prepare("SELECT * FROM forum_topics WHERE catid = ? ORDER BY id DESC LIMIT 10;");
  $getForumCats->bind_param('i', $catid);
	$getForumCats->execute();
	$forumCats = $getForumCats->get_result();
 	$count = $forumCats->num_rows;
  if ( $count == 0 ) {
  error("No topics to show!");
  }
  ?>
  <center>
  <div class="w3-container" style="width:50%">
  <table class="w3-table-all">
    <thead>
     <tr class="w3-green">
             <th>ID</th>
             <th>Name</th>
        </tr>
        </thead>
  
  <?php
  while (($row = $forumCats->fetch_assoc())) {
    echo ' <tr><td>'.$row['id'].' </td><td><a href="forum_viewthread.php?id='.$row['id'].'">'.$row['name'].'</a></td></tr>';
    }
    
?>


  </table>
     <a href="forum_post.php?catid=<?php echo $catid;?>"><button class="w3-button w3-green">Post</button><a>
</div>
</center>
</body>
</html>