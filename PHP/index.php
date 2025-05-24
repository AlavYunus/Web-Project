<?php 
require 'Functions.php';
$connectToDb=CallDB('users');
$data="SELECT * FROM activity ORDER BY event_date,event_time  ASC" ; //Ordered By time 
$get_data=mysqli_query($connectToDb,$data);
//background imqge array
$imgArray = ["../Content/img1.webp","../Content/img2.webp","../Content/img3.jpeg","../Content/img4.jpeg","../Content/img5.webp","../Content/img6.webp","../Content/img7.webp"];

//Send A Notice When Pasword Is Changed
if(isset($_SESSION["password_change"])) {
    echo $_SESSION["password_change"];
}
if(isset($_SESSION['success_message'])) {
    echo $_SESSION['success_message'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- FontAwesome 6.2.0 CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css  "
     integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
     crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- (Optional) Use CSS or JS implementation -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="canonical" href="https://v5.getbootstrap.com/docs/5.0/examples/carousel/">
    <link rel="stylesheet" href="../CSS/index.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

    <title>Activity Trader</title>
  

</head>

<body>
<!-- Get Nav Menü -->
<?php require "navbar.php";?>
<!-- Get Weather Information -->
  <?php require "weather.php";?>
  <time id="time" style="font-size: xx-large; font: 25px; margin-left:7%;" ></time>
  <hr>
        <!-- Show Interested  Field -->
       <?php include 'show_interest.php';?>
    <center>
   
        <section id="acts">
            <?php $i=0; if(mysqli_num_rows($get_data)>0):?>
            <?php while($acts=mysqli_fetch_assoc($get_data)):  ?>
                <!-- Get Events -->
                <article id="<?php echo $acts['event_name']; ?>" style="background-image:url(<?php if($i%3==0) {$index=array_rand($imgArray,1); }echo $imgArray[$index];  $i++;  ?>); color:white; margin:3px;">
                    <small><?php echo $acts['event_category']."/".$acts['event_type']; ?></small>
                    <h1><?php echo $acts['event_name']; ?></h1>
                   <h5><?php echo "Date: ".$acts['event_date'].",".substr($acts['event_time'],0,5); ?></h5>
                    <h4><?php echo"Place:". $acts['place']; ?></h4>
                     <h4><?php echo"Address : ".$acts['address']; ?></h4>
                      <h5><?php echo $acts['city']."/".$acts['country']; ?></h5>
                      <a
                        name="price"
                        id="price"
                        class="btn btn-primary mb-3 "
                        href="#"
                        role="button"
                        ><big><i> <?php echo "Price: ". $acts['price']." TL"; ?></i></big></a
                      >
                      
                     
                        <form action="cart_page.php" method="post">
                            <input type="hidden" name="event_id" value="<?php echo $acts['id']; ?>">
                            <input type="hidden" name="event_name" value="<?php echo $acts['event_name']; ?>">
                            <input type="hidden" name="event_date" value="<?php echo $acts['event_date']; ?>">
                            <input type="hidden" name="event_time" value="<?php echo $acts['event_time']; ?>">
                            <input type="hidden" name="price" value="<?php echo $acts['price']; ?>">
                            <input type="hidden" name="quota" value="<?php echo $acts['quota']; ?>">
                            
                            <div class="d-grid gap-2">
                                <button
                                    type="submit"
                                    name="getTicket"
                                    id="getTicket"
                                    class="btn btn-warning col-6 m-auto "
                                >
                                    Get Ticket
                                </button>
                            
                            </div>
                        </form>
                        
                   
                </article>
           <?php endwhile;?>
           <?php else:?>
            <?php echo "There is no activity that is shown <br>"?>
            <?php endif;?>
        </section>
  
  
    </center>
    <?php include 'footer.php';?>
<script>
    
       const Interval = setInterval(Time, 1000); //Time Function Calls Per Second

        function Time() {
            const date = new Date();
            const tm = document.getElementById("time");
            var time=date.toLocaleDateString()+"\n"+date.toLocaleTimeString();
            tm.textContent = time;
              // Use System Time
        }  
      
        </script>
</body>

</html>
<?php  mysqli_close($connectToDb);?>