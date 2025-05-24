<?php 
    $host="localhost";
     $username="root";
     $password="";
     $database="users";

     $db=mysqli_connect($host , $username , $password ,$database );
    if(mysqli_connect_errno() > 0 ) {
        die("Error: ".mysqli_connect_errno());
    }
        

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    if(empty($_POST["text"])) {
        echo "You don't field text blank";
    } 
    else {
        $notification=$_POST["text"];
        $sql = "INSERT INTO bildirimler(bildirim) VALUES (?)";
        if($stmt = mysqli_prepare($db, $sql)) {
         
            mysqli_stmt_bind_param($stmt,"s",$notification);
            
            if(mysqli_stmt_execute($stmt)) {
                session_start();
                 $_SESSION["notice"]= "<div id='error' class='alert alert-body alert-success text-center'>Notification is created</div>"."<br>";
                    header("Location: admin.php");
                  exit; 
            } else {
                echo mysqli_error($db);
                echo "<br>An Error is Ocured ,Please Try Again.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($db);
}



?>
 <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<form class="row " action="editor.php" method="post">
  <div class="mb-3">
    <label for="" class="form-label"></label>
    <textarea class="form-control" name="text" id="editor" rows="3"></textarea>
  </div>
  
  <div class="col-12">
    <button class="btn btn-primary" type="submit" name="submit">CREATE</button>
  </div>
</form>
 <script>ClassicEditor.create(document.querySelector('#editor'));</script>