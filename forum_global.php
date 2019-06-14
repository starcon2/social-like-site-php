<?php
include 'include.php';


	$getForumCats = $conn->prepare("SELECT * FROM forum_cat");
	$getForumCats->execute();
	$forumCats = $getForumCats->get_result();
 	$count = $forumCats->num_rows;
  if ( $count == 0 ) {
  error("No forums to show!");
  }
  ?>
  <center>
  <div class="w3-container" style="width:50%">
  <table class="w3-table-all">
    <thead>
     <tr class="w3-green">
             <th>ID</th>
             <th>Name</th>
             <th>Description</th>
        </tr>
        </thead>
  
  <?php
  while (($row = $forumCats->fetch_assoc())) {
    echo '<tr><td>'.$row['id'].' </td><td><a href="forum_catview.php?catid='.$row['id'].'">'.$row['name'].'</a></td><td>'.$row['description'].' </td></tr>';
    }
?>


  </table>
</div>
</center>
</body>
</html>