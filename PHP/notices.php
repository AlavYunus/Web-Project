<?php 

  include "Functions.php";


$getNotice=CallDB("users");
$sql = "SELECT * FROM bildirimler";
$currentNotices=mysqli_query($getNotice,$sql);

?>
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Notices</title>
   <!-- FontAwesome 6.2.0 CSS -->
   <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
   />
   
   <!-- (Optional) Use CSS or JS implementation -->
   <script
    src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"
    integrity="sha512-naukR7I+Nk6gp7p5TMA4ycgfxaZBJ7MO5iC3Fp6ySQyKFHOGfpkSZkYVWV5R7u7cfAicxanwYQ5D1e17EfJcMA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
   ></script>
   
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
 </head>
 <body>
  <?php  if(mysqli_num_rows($currentNotices)>0): ?>    
      <div class="card-body">
        <h5 class="card-title">NOTIFICATIONS</h5>
      
      </div>
    <?php  while($get=mysqli_fetch_assoc($currentNotices)):?>
     <div class="card">
        <div class="card-body bg bg-secondary text-white row">
            <p class="col-1"><i class="fa fa-bell " aria-hidden="true"></i></p>
            
            <p class="card-text col-8"><?php echo $get["bildirim"]; ?></p>
             <p class="card-text col-3"><?php echo $get["bildirim_tarihi"]; ?></p>
            
            
        </div>
    </div>

        <?php endwhile;?>
        <?php else:?>
        
            <div class="card bg bg-danger" >
              <div class="card-body ">
                <h5 class="card-title text-center col-12">There is no any notification </h5>
              </div>
            </div>
        <?php endif;?>
        <a
          name="home"
          id="home"
          class="btn btn-primary mt-5"
          href="index.php"
          role="button"
          >Home Page</a
        >
        
        <?php mysqli_close($getNotice);?>
 


</body>
 </html>     
        
<!-- 
$lastCheck = $_SESSION['last_check_time'] ?? time();

// Son eklenen kayıtları sorgula
$stmt = $db->prepare("SELECT COUNT(*) FROM tablo_adi WHERE created_at > ?");
$stmt->execute([date('Y-m-d H:i:s', $lastCheck)]);
$newItems = $stmt->fetchColumn();

if ($newItems > 0) {
    echo "$newItems yeni öğe eklendi!";
    $_SESSION['last_check_time'] = time();
}
           -->
