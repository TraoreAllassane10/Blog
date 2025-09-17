<?php require "includes/header.php"; ?>
<?php require "config.php"; ?>

<?php


    
    if(isset($_POST['submit'])) {

      if($_POST['title'] == '' OR $_POST['body'] == '') {
        echo "some inputs are empty";
        
      } else {


        $title = $_POST['title'];
        $body = $_POST['body'];
        $username = $_SESSION['username'];

        $insert = $conn->prepare("INSERT INTO posts(title, body, username) 
         VALUES (:title, :body, :username)");

         $insert->execute([
          ':title' => $title,
          ':body' => $body,
          ':username' => $username,
         ]);

         header("Location: index.php");
      }
    }


?>

<main class="form-signin w-50 m-auto">
    <form method="POST" action="create.php">

        <h1 class="h3 mt-5 fw-normal text-center">Create Post</h1>

        <div class="form-floating">
            <input name="title" type="text" class="form-control" id="floatingInput" placeholder="title">
            <label for="floatingInput">Title</label>
        </div>

        <div class="form-floating">
            <input name="username" type="hidden" class="form-control" id="floatingInput" placeholder="username">
        </div>

        <div class="form-floating mt-3">
            <textarea rows="9" name="body" id="" class="form-control"></textarea>
            <label for="floatingPassword">Description</label>
        </div>

        <button name="submit" class="w-100 mt-5 btn btn-lg btn-primary" type="submit">Create</button>
        

    </form>
</main>

<?php require "includes/footer.php" ?>