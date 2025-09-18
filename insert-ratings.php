<?php

require "config.php";

if (isset($_POST["insert"])) {
    $rating = $_POST['rating'];
    $post_id = $_POST['post_id'];

    $insert = $conn->prepare("INSERT INTO rates(post_id, ratings) VALUES (:post_id, :rating)");

    $insert->execute([
        ':post_id' => $post_id,
        ':rating' => $rating
    ]);
}
