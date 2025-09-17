<?php 

require "config.php";

if(isset($_POST['delete'])) {
   $id = $_POST['id'];

   $delete = $conn->prepare("DELETE FROM comments WHERE id = $id");
   $delete->execute();
}

?>