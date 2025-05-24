<?php
include "Functions.php";
$connectToDB=CallDB("users");

$emailErr = $passwordErr = $repasswordErr = "";
$email = $password = $repassword = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(empty($_POST["email"])) {
        $emailErr = "You don't field email blank";
    } elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) { //if html part can not check
        $emailErr = "You have entered the wrong email format...";
    } else {
        $sql = "SELECT id FROM users WHERE mail=?";
        if($stmt = mysqli_prepare($connectToDB, $sql)) {
            $param_email = trim($_POST["email"]);
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            if(mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1) {
                    $emailErr = "This mail is already used.<br>";
                  
                } else {
                    $email = safety($param_email);
                }
            } else {
                echo mysqli_error($connectToDB);
                echo "An Error Occurred,Try Again";
            }
            mysqli_stmt_close($stmt);
        }
    }

    if(empty($_POST["password"])) {
        $passwordErr = "You don't field password blank.";
    } else {
        $password = safety($_POST["password"]);
    }

    if($_POST["password"] !== $_POST["repassword"]) {
        $repasswordErr = "Password and confirm part must be the same .";
    } else {
        $repassword = safety($_POST["repassword"]);
    }

    if(empty($emailErr) && empty($passwordErr) && empty($repasswordErr)) {
        $sql = "INSERT INTO users (mail, password) VALUES (?, ?)";
        if($stmt = mysqli_prepare($connectToDB, $sql)) {
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ss", $email, $param_password);
            if(mysqli_stmt_execute($stmt)) {
                  session_start();
                  $_SESSION["newuser"]="Your acount is created succesfuly<br> Waiting for admin approval to log in<i class='fa-thin fa-spinner fa-spin' style='color: #ffffff;'></i>";
                  $_SESSION["change_password"]="<script> alert('Please Change Your Password'); </script>";

                  header("Location: login.php");   
                  exit; 
            } else {
                echo mysqli_error($connectToDB);
                echo "<br>An Error is Ocured ,Please Try Again.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($connectToDB);
}
ShowError($emailErr);
ShowError($passwordErr);
ShowError($repasswordErr);
    

?>

<!DOCTYPE html>
<html>
<header>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
  <!-- FontAwesome 6.2.0 CSS -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
 
  />
  
  <!-- (Optional) Use CSS or JS implementation -->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"
    integrity="sha512-naukR7I+Nk6gp7p5TMA4ycgfxaZBJ7MO5iC3Fp6ySQyKFHOGfpkSZkYVWV5R7u7cfAicxanwYQ5D1e17EfJcMA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  ></script>
  <link rel="stylesheet" href="../CSS/signup.css">
  
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  <title>Activity Trader</title>

</header>

<body>
  <center>

    <form id="form" action="signup.php" method="post">
      <div id="login">
        <div id="account" class="row">
          <ul>
            <li id="link1" class="col-6"><a href="login.php">Sign in </a></li>
            <li id="link2"class="col-6"><a href="signup.php">Sign up </a></li>

          </ul>
        </div>
    
        <br>

        <div class="form-floating mb-3 mt-5 ">
          <input type="email" class="form-control "  id="floatingInput" name="email" placeholder="Enter Your Email" required>
          <label for="floatingInput"><i class="fa-regular fa-envelope"></i> Email address</label>
        </div>
        
        <div class="form-floating ">
          <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
          <label for="floatingPassword"><i class="fa fa-key" aria-hidden="true"></i> Password</label>

        </div>
        <div class="form-floating row-3" >
          <input type="password" class="form-control " id="confirmp" name="repassword"  placeholder="Confirm Password" required>
          <label for="confirmp"><i class="fa fa-key" aria-hidden="true"></i> Confirm Password</label>
       

        </div>
        <div>
          <input type="checkbox" id="cbox" required class="row">
          <label for="cbox"class="col-10" style="color: rgb(0, 0, 0);">I accep <a class=" text-danger active"
              data-bs-toggle="modal" data-bs-target="#generalTerms">General Terms and Conditions </a>
          </label>
        </div>

        <div class="d-grid gap-1">
          <button class="btn btn-success  text-white">Sign Up</button>
          <br>
        </div>


    </form>

    </div>
  <?php include "terms.php"; ?>

  </center>
</body>

</html>