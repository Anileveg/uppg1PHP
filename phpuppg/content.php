<?php
 require ('dbconnect.php');
 $state = $pdo->query("SELECT * FROM posts WHERE id = {$_GET ['id']}");
 $posts = $state->fetchAll();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/public.css?v=<?php echo time(); ?>">
</head>
<body>
<a href= "public.php">✖ Close</a>
<br>

<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Author</th>
            <th>Published date</th>
        </tr>
    </thead>

    <?php 
    foreach ($posts as $post) :?>

<br>
<br>
        <div>
            <td><?=htmlentities($post['title'])?></td>
            <td><?=htmlentities($post['content'])?></td>
            <td><?=htmlentities($post['author'])?></td>
            <td><?=htmlentities($post['published_date'])?></td>
    </div>
   <?php endforeach;?>
</body>

