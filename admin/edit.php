<?php

  session_start();

  require '../config/config.php';

  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('Location: login.php');
  }

  if($_POST){
      $id = $_POST['id'];
      $title = $_POST['title'];
      $content = $_POST['content'];

      if($_FILES['image']['name'] != null){
        $file = 'images/'.($_FILES['image']['name']);
        $imageType = pathinfo($file,PATHINFO_EXTENSION);
  
        if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg'){
          echo "<script>alert('image must be jpg,jpeg,png');</script>";
        }else{
          
          $image = $_FILES['image']['name'];
          move_uploaded_file($_FILES['image']['tmp_name'],$file);
  
          $stmt = $pdo->prepare("UPDATE posts SET title='$title', content='$content', image='$image' WHERE id='$id'");
          $result = $stmt->execute();
          if ($result) {
            echo "<script>alert('Successfully updated');window.location.href='index.php';</script>";
          }
        }
      }else{
        $stmt = $pdo->prepare("UPDATE posts SET title='$title', content='$content' WHERE id='$id'");
        $result = $stmt->execute();
        if ($result) {
            echo "<script>alert('Successfully updated');window.location.href='index.php';</script>";
          }
      }
  }
  
  $stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
  $stmt->execute();
  $result = $stmt->fetchAll();

  


?>
<?php include('header.html');?>


    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">             
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" value="<?php echo $result[0]['title']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>                        
                            <textarea cols="30" rows="10" class="form-control" name="content" required><?php echo $result[0]['content']; ?></textarea>
                          </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <img src="images/<?php echo $result[0]['image']?>" alt="" width="150" height="70"><br><br>
                            <input type="file" name="image" value="">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-warning" value="Submit">
                            <a href="index.php" class="btn btn-default" >Back</a>
                        </div>

                    </form>
                </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
         
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

 <?php

    include('footer.html');

 ?>
