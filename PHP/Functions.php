<?php 

include 'Functions.php';

 ob_start(); 

if(isset($_SESSION["message"])) {
  
  echo $_SESSION['message'];
  
}
if(isset( $_SESSION["notice"])) {
  echo  $_SESSION["notice"];
}
if(isset( $_SESSION["event"])) {
   echo $_SESSION["event"];
}

if(isset(  $_SESSION["addEvent"])) {
   echo $_SESSION["addEvent"];
}
$connectDb=CallDB("users");

$sql="SELECT * FROM users WHERE user_type='user' ORDER BY `users`.`admin_confirm` ASC ";
$users=mysqli_query($connectDb,$sql);
$acts="SELECT * FROM activity";
$events=mysqli_query($connectDb,$acts);
$sql = "SELECT * FROM bildirimler";
$currentNotices=mysqli_query($connectDb,$sql);


 ?>
<!Doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.72.0">
  <title>Activity Trader</title>

  <link rel="canonical" href="https://v5.getbootstrap.com/docs/5.0/examples/carousel/">

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

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
    integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

  <style>
 
  </style>


  <link href="carousel.css" rel="stylesheet">
  <link rel="stylesheet" href="../CSS/admin.css">
</head>

<body>

  <header>
            <nav class="navbar navbar-expand-lg bg-body-tertiary ">
                <div class="container-fluid">
                  <strong class="navbar-brand text-danger" href="admin.php">ACTTIVITY  TRADER</strong>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                   
             
                       <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                          <div class="navbar-nav ">                            
                           
                            <a class="nav-link btn-bg-darkactive mx-2" aria-current="page" href="profile.php"> <i class="fa fa-user-circle" aria-hidden="true" style="color: #720000;"></i> Profile </a>
                            <a class="nav-link mx-2" href="logout.php"> <i class="fa-solid fa-right-from-bracket"style="color: #720000;"> </i> Exit </a>
                          </div>
                       </div>
                  
                
                
                </div>
              </nav>
        </header>
   
  <main>

    <div id="myCarousel" class="carousel slide " data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active " id="carousel">
          <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"
            preserveAspectRatio="xMidYMid slice" role="img" focusable="false">
            <rect width="100%" height="100%" fill="#777" /></svg>

            <div class="container">
              <div class="carousel-caption text-left">
                <h1>Edit Activities</h1>
                <p>Edit events, add new events, delete events or update existing events.</p>
                <p><a class="btn btn-lg btn-primary" id="button1" href="#acts" role="button">Let's Edit</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" role="img" focusable="false">
              <rect width="100%" height="100%" fill="#777"></rect></svg>

            <div class="container">
              <div class="carousel-caption">
                <h1>  Create An  Announcement</h1>
                <p>Send notifications to users, inform users with a new notification or provide new information about the event.</p>
                <p><a class="btn btn-lg btn-primary"id="button2" href="#notice" role="button"><i class="fa fa-bell" aria-hidden="true"></i> Create An Notification</a></p>
              </div>
            </div>ç
          </div>
        <div class="carousel-item">
          <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"
            preserveAspectRatio="xMidYMid slice" role="img" focusable="false">
            <rect width="100%" height="100%" fill="#777" /></svg>

          <div class="container">
            <div class="carousel-caption text-right">
              <h1>Confirm The User </h1>
              <p>Confirm the users and view the  new users.</p>
              <p><a class="btn btn-lg btn-primary" id="button3" href="#userList" role="button">Show The Users</a></p>
            </div>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>


    <div class="container marketing mx-auto">
     

      <hr>
      <?php  require 'weather.php';  ?>
      <time id="time" style="font-size: xx-large; font: 25px;" class="text-center"></time>
      
      <hr>

      <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item" >
    <h2 class="accordion-header">
            <button class="accordion-button" id="userList" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
       Show The Users
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
      <div class="accordion-body" >
        <?php if(mysqli_num_rows($users)>0): ?>
          <div class="card-body row border border-danger  mt-2 mx-3 " >
                  <p class="card-text col-2">User No</p>
                   <p class="card-text col-2">User mail </p>
                  <p class="card-text col-2">Regist Date</p>
             </div>
          <?php while($user=mysqli_fetch_assoc($users)):?>
              <div class="card-body row border border-danger mt-2 mx-3 ">
              
                  <form action="user_confirm.php" method="post" class="row">
                    <p class="card-text col-2" name="id"><?php echo $user["id"]; ?></p>
                    <p class="card-text col-2"><?php echo $user["mail"]; ?></p>
                    <p class="card-text col-2"><?php echo $user["registDate"]; ?></p>
        
                    <input type="hidden" name="id" value="<?php echo $user["id"]; ?>"> 
                    <button type="submit" name="delete_user" class="btn btn-warning col-2 mr-4"> 
                        Delete
                    </button>

                    <?php if(!$user["admin_confirm"]):?>
                       <button type="submit" name="confirm_user" class="btn btn-primary col-2 ">
                        Confirm 
                    </button>
                    <?php endif;?>
                     
                   
                    
                </form>
                    
                  
         </div>
              <?php endwhile;?>             

          <?php endif; ?>
              
    </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" id="acts" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
       List The Activity
      </button>
    </h2>
    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse ">
      <div class="accordion-body" >

       <?php if(mysqli_num_rows($events)>0): ?>

          <?php while($event=mysqli_fetch_assoc($events)):?>
              <div class="card-body row border border-danger mt-2 mx-3 text-center " id="<?php echo $event['event_name']; ?>">
                    <small><?php echo $event['event_category']."/".$event['event_type']; ?></small>
                    <h4><?php echo $event['event_name']; ?></h4>
                    <h6><?php echo "Date: ".$event['event_date'].",".substr($event['event_time'],0,5); ?></h6>
                    <h5><?php echo"Place:". Shorter($event['place']); ?></h5>
                    <h5><?php echo"Address ".Shorter($event['address']); ?></h5>
                    <h5><?php echo $event['city']."/".$event['country']; ?></h5>
                       <a
                        name="price"
                        id="price"
                        class="btn btn-outline-danger col-4 text-center  m-auto "
                        default
                        href="#"
                        role="button"
                        ><big><i> <?php echo "Price: ". $event['price']." TL"; ?></i></big></a
                      >
                    
                     

                    <div >
                      <form action="event_edit.php" method="post">
                   
        
                    <input type="hidden" name="event_id" value="<?php echo $event["id"]; ?>"> 
                   
                   
                     <button
                      
                      type="submit"
                      name="update_event"
                      id="update"
                      class="btn btn-primary  m-2"
                    >
                      Update
                    </button>
                    <button
                      type="submit"
                      name="delete_event"
                      id="delete_event"
                      class="btn btn-warning  m-2"
                    >
                      Delete 
                    </button>
                   
                    
                </form>
                    
                    </div>
                    
                 
         </div>       
          
       
          <?php endwhile;?>             

          <?php endif; ?>
    </div>
    </div>
  </div>
   <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" id="addEvent" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
            CREATE AN EVENT
      </button>
    </h2>
    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
      <div class="accordion-body" >
      <?php require 'addEvent.php';?>
            
            
      </div>
    </div>
  </div>
 
   
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" id="notice" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
       SHOW THE NOTIFICATIONS
      </button>
    </h2>
    <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse">
      <div class="accordion-body" >
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
       
 

            
            
      </div>
    </div>
  </div>
 <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" id="shownotice" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false" aria-controls="panelsStayOpen-collapseFive">
       SEND A NOTIFICATION
      </button>
    </h2>
    <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse">
      <div class="accordion-body" >
      <?php include 'editor.php';?>
            
            
      </div>
    </div>
  </div>
</div>
           <?php include "footer.php";?>
   
  </main>
        

    <script>
    
       const Interval = setInterval(Time, 1000); //Time fonksiyonu saniyede bir çalışır


        function Time() {
            const date = new Date();
            const tm = document.getElementById("time");

            tm.innerHTML = date.toLocaleDateString() + "<br>" + date.toLocaleTimeString(); // Sistem saatini kullanır 
        }  
      
        </script>
</body>

</html>

 <?php mysqli_close($connectDb);?>