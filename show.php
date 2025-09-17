<?php require "includes/header.php"; ?>
<?php require "config.php"; ?>

<?php

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $onePost = $conn->query("SELECT * FROM posts WHERE id = $id");
    $onePost->execute();

    $post = $onePost->fetch(PDO::FETCH_OBJ);
}

?>

<div class="card mt-3">
    <div class="card-body">
        <h5 class="card-title"><?php echo $post->title; ?></h5>
        <p class="card-text"><?php echo $post->body; ?></p>
    </div>
</div>

<div>
    <form method="POST" id="comment_data">

        <div class="form-floating">
            <input name="username" type="hidden" value="<?php echo $_SESSION["username"]; ?>" class="form-control" id="floatingInput" >
        </div>

        <div class="form-floating">
            <input name="post_id" type="hidden" value="<?php echo $post->id; ?>" class="form-control" id="floatingInput">
        </div>

        <div class="form-floating mt-3">
            <textarea rows="9" name="comment" id="comment" class="form-control"></textarea>
            <label for="floatingPassword">Comment</label>
        </div>

        <button name="submit" id="submit" class="w-100 mt-5 btn btn-lg btn-primary" type="submit">Create Comment</button>


    </form>
</div>

<?php require "includes/footer.php"; ?>

<script>
    $(document).ready(function() {


        $(document).on("submit", function(e) {
            // alert("form submitted");
            e.preventDefault();
            let formdata = $("#comment_data").serialize() + "&submit=submit";

            $.ajax({
                type: "POST",
                url: "insert_comments.php",
                data: formdata,

                success: function() {
                    // $("#comment").text(null);
                }
            })

        });
    });
</script>