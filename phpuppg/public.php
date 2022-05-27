<?php
 require ('dbconnect.php');
 $state = $pdo->query("SELECT * FROM posts");
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
<a href= "admin.php">← Admin</a>

<h2> All blog-posts</h2>

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
        <tr>
            <td><?=htmlentities($post['title'])?></td>
            <td><?=htmlentities($post['author'])?></td>
            <td><?=htmlentities((substr($post['content'],0,100)))?>...<br><b><a href="content.php?id=<?=$post['id']?>">read more</a></td></b>
            <td><?=htmlentities($post['published_date'])?></td>
    </tr>
   <?php endforeach;?>

</body>

    
