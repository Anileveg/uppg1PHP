<?php
 require ('dbconnect.php');

$titleMessage   ="";
$contentMessage ="";
$authorMessage  ="";
$updateSuccess  ="";
    if (isset($_POST['updatePostBtn'])) {
    $title   = trim($_POST['title']);
    $content = trim($_POST['content']);
    $author  = trim($_POST['author']);
  
    if ((empty($title))or (empty($content))or (empty($author))) {
        if(empty($title)){
          $titleMessage='<div class="alert alert-danger">
          Title can not be empty!
        </div>';
          
  
        } if(empty($content)){
          $contentMessage='<div class="alert alert-danger">
          Content can not be empty!
        </div>';
  
        } if(empty($author)){
          $authorMessage='<div class="alert alert-danger">
          Author can not be empty!
        </div>';
  
  
        }
      }
       else {
        $sql = "UPDATE posts
        SET title = :title, content = :content, author = :author
        WHERE id= :id"; 

      $state = $pdo->prepare($sql);
      $state->bindParam(':title', $_POST["title"]);
      $state->bindParam(':content', $_POST["content"]);
      $state->bindParam(':author', $_POST["author"]);
      $state->bindParam(':id', $_POST['id']);
      $state->execute();
      $updateSuccess = 'Succes! The post is now updated!
      ';}
    }

    $newTitleMessage="";
    $newContentMessage="";
    $newAuthorMessage="";
    $addSuccess="";

    if (isset($_POST['addPost'])) {
    $titleNew  = trim($_POST['title']);
    $contentNew = trim($_POST['content']);
    $authorNew  = trim($_POST['author']);
  
    if ((empty($titleNew))or (empty($contentNew))or (empty($authorNew))) {
      if(empty($titleNew)){
        $newTitleMessage='<div class="alert alert-danger">
        Title is empty!
      </div>';
        

      } if(empty($contentNew)){
        $newContentMessage='<div class="alert alert-danger">
        Content is empty!
      </div>';

      } if(empty($authorNew)){
        $newAuthorMessage='<div class="alert alert-danger">
        Author is empty!
      </div>';


      }
    }
      

       else {
        $sql = "INSERT INTO posts (title, content, author) 
        VALUES (:title, :content, :author)";
        $state = $pdo->prepare($sql);
        $state->bindParam(":title", $_POST['title']);
        $state->bindParam(":content", $_POST['content']);
        $state->bindParam(":author", $_POST['author']);
        $state->execute();
        $addSuccess = 'Succes! A new post is now added';
       }
    }
    
 if (isset($_POST['blogId'])) {
     $sql = "DELETE FROM posts WHERE id = :id";
     $state = $pdo->prepare($sql);
     $state->bindParam(":id", $_POST['blogId']);
     $state->execute();
}

    $state = $pdo->query("SELECT * FROM posts");
    $posts = $state->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body class="back-body">

<a href= "public.php" class="adminLink">All blog-posts →</a>

<table id="blog-posts">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Author</th>
            <th>Published date</th>
            <th>Manage</th>
        </tr>
    </thead>

    <h2> Create a new blog-post</h2>

    <div id="post-form">
    <form action="" method= "POST">
    <input type="text" name ="title" placeholder="Titel" class="title-box"><br>
    <textarea type="text" name ="content" placeholder="Content" id= "content"></textarea><br>
    <input type="text" name ="author" placeholder="Author" class ="author-box"><br>
    <input type="submit" name ="addPost" value="Publish post" class ="submit-btn">
    <br>
    <?=$addSuccess?>
    <?=$updateSuccess?>
      </form>
</div>

      <div class="messages">
    <?=$newTitleMessage?>
    <?=$newContentMessage?>
    <?=$newAuthorMessage?>
</div>

      <h2>All blog-posts</h2>

    <tbody> 
      <?php foreach ($posts as $post):?>
        <div>
            <td><?=htmlentities($post['id']) ?></td>
            <td><?=htmlentities($post['title']) ?></td>
            <td><?=htmlentities($post['content']) ?></td>
            <td><?=htmlentities($post['author']) ?></td>
            <td><?=htmlentities($post['published_date']) ?></td>
            <td>
                 <form action="" method="POST">
                 <input type="hidden" name="blogId" value="<?=$post['id'] ?>">
                 <div class="buttons"> 
                 <button id= "delete-btn">Delete</button>
                 </form>
                 <button type="button" id="update-btn" data-toggle="modal" data-target="#updateModalbtn" data-title="<?=htmlentities($post['title'])?>"
                 data-content="<?=htmlentities($post['content'])?>" data-author="<?=htmlentities($post['author'])?>" 
                 data-id="<?=htmlentities($post['id'])?>">Update</button>
      </div> 
      </div> 
           </tr>
           <?php endforeach;?>
    </tbody>

<div class="modal fade" id="updateModalbtn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update post</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="" method="POST">
            <div class="modal-body">
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Title</label>
                <input type="text" class="form-control" name="title">
                <input type="hidden" name="id">
                <div class="form-group">
                <label for="message-text" class="col-form-label">Content</label>
                <input class="form-control" id="message-text" name="content"></input>
              </div>

            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Author</label>
                <input type="text" class="form-control" name="author">
                <input type="hidden" name="id">
              </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" name="updatePostBtn" value="Update" class="btn btn-success">
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="messages">
        <?=$titleMessage?>
        <?=$contentMessage?>
        <?=$authorMessage?>
      </div>

       <script>
       if ( window.history.replaceState ) {
       window.history.replaceState( null, null, window.location.href );
       }
   </script>

   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

       <script>
       $('#updateModalbtn').on('show.bs.modal', function (event) {
       var button = $(event.relatedTarget)
       var title = button.data('title');
       var content = button.data('content');
       var author = button.data('author');        
       var id = button.data('id');

       var modal = $(this)
        modal.find('.modal-body input[name="title"]').val(title);
        modal.find('.modal-body input[name="content"]').val(content);
        modal.find('.modal-body input[name="author"]').val(author);
        modal.find('.modal-body input[name="id"]').val(id);
      })

</script>

</body>
</html>