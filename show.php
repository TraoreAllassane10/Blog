<?php require "includes/header.php"; ?>
<?php require "config.php"; ?>

<?php

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $onePost = $conn->query("SELECT * FROM posts WHERE id = $id");
    $onePost->execute();

    $post = $onePost->fetch(PDO::FETCH_OBJ);
}

$comments = $conn->query("SELECT * FROM comments WHERE post_id = $id");
$comments->execute();

$comment = $comments->fetchAll(PDO::FETCH_OBJ);

?>

<div class="card mt-3">
    <div class="card-body">
        <h5 class="card-title"><?php echo $post->title; ?></h5>
        <p class="card-text"><?php echo $post->body; ?></p>

        <form id="form-data" method="post">
            <div class="my-rating"></div>
            <input type="text" id="rating" name="rating">
            <input type="text" id="post_id" name="post_id" value="<?php echo $post->id; ?>">
        </form>

    </div>
</div>

<div>
    <form method="POST" id="comment_data">

        <div class="form-floating">
            <input name="username" type="hidden" value="<?php if (isset($_SESSION["username"])) echo $_SESSION["username"]; ?>" class="form-control" id="comment">
        </div>

        <div class="form-floating">
            <input name="post_id" type="hidden" value="<?php echo $post->id; ?>" class="form-control" id="post_id">
        </div>

        <div class="form-floating mt-3">
            <textarea rows="9" name="comment" id="comment" class="form-control"></textarea>
            <label for="floatingPassword">Comment</label>
        </div>

        <button name="submit" id="submit" class="w-100 mt-5 btn btn-lg btn-primary" type="submit">Create Comment</button>


    </form>

    <div id="msg" class="nothing mt-3"></div>
</div>

<?php foreach ($comment as $singleComment) : ?>
    <div class="card mt-5">
        <div class="card-body">
            <h5 class="card-title"><?php echo $singleComment->username; ?></h5>
            <p class="card-text"><?php echo $singleComment->comment; ?></p>

            <?php if (isset($_SESSION['username']) and $_SESSION['username'] == $singleComment->username) : ?>
                <button id="delete-btn" value="<?php echo $singleComment->id; ?>" class="btn btn-danger mt-3">Delete</button>
            <?php endif; ?>

        </div>
    </div>
<?php endforeach; ?>

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
                    $("#comment").val(null);
                    $("#username").val(null);
                    $("#post_id").val(null);

                    $("#msg").html("Added Successfully").toggleClass("alert alert-success bg-success text-white");

                    fetch();
                }
            })

        });


        $("#delete-btn").on("click", function(e) {
            // alert("form submitted");
            e.preventDefault();

            let id = $(this).val();

            $.ajax({
                type: "POST",
                url: "delete-comments.php",
                data: {
                    delete: "delete",
                    id: id
                },

                success: function() {

                    $("#msg").html("Deleted Successfully").toggleClass("alert alert-danger bg-danger text-white");

                    fetch();
                }
            })

        });

        function fetch() {
            setInterval(() => {
                $("body").load("show.php?id=<?php echo $_GET['id']; ?>");
            }, 3000);
        }

        // Rating system
        $(".my-rating").starRating({
            starSize: 25,
            callback: function(currentRating, $el) {
                $('#rating').val(currentRating);
            }
        });

        $(".my-rating").click(function(e) {
            e.preventDefault();

            let formdata = $("#form-data").serialize() + "&insert=insert";

            $.ajax({
                type: "POST",
                url: "insert-ratings.php",
                data: formdata, 

                success: function() {
                    alert(formdata)
                }
            });

        });

    });
</script>