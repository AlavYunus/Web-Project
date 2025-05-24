<?php
    include 'Functions.php';
    $connectToDB=CallDB("users");

  if(isset($_SESSION["newuser"]) & isset($_SESSION) ) {
      echo "<div id='error' class='alert alert-body alert-success text-center'>".$_SESSION['newuser']."</div>"."<br>";        
        
    }
 
    $mail = $password = "";
    $mailErr = $passwordErr = $loginErr = "";

    if(isset($_POST["login"])) {
        
        if(empty($_POST["mail"])) {
         $emailErr = "You don't field email blank";

        } else {
            $mail =safety($_POST["mail"]);
        }

        if(empty($_POST["password"])) {
            $passwordErr ="You don't field password blank";

        } else {
            $password = safety($_POST["password"]);
        }

        if(empty($mailErr) && empty($passwordErr)) {
            $sql = "SELECT id, mail, password,user_type, admin_confirm	from users WHERE mail=?";
         
            if($stmt = mysqli_prepare($connectToDB, $sql)) {
                mysqli_stmt_bind_param($stmt, "s" ,$mail);

                if(mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if(mysqli_stmt_num_rows($stmt) == 1) {
                      
                        mysqli_stmt_bind_result($stmt, $id, $mail, $hashed_password,$user_type ,$admin_confirm	);
                         if(mysqli_stmt_fetch($stmt)) {
                            if(password_verify($password, $hashed_password)) {   // password control
                                $_SESSION["loggedIn"] = $admin_confirm	;
                                $_SESSION["id"] = $id;  
                                $_SESSION["mail"] = $mail; 
                                $_SESSION["user_type"] = $user_type; 
                                if(isLoggedIn() && isset($_SESSION["newuser"])  ) {
                                   $_SESSION["firstEntry"]="<div  class='alert alert-body alert-secondary text-center'>Please Change Your Password </div>";   
                                           setcookie('user_interests', $interestsJSON, time() - (3600 * 24 * 365), '/');


                                   header("Location: profile.php");
                                }
                                elseif(isAdmin()) {
                                  header("Location: admin.php");
                                }
                                elseif(isLoggedIn() && !isset($_SESSION["newuser"]) )
                                {
                                  header("Location: index.php");
                                }
                               
                                elseif(!$_SESSION["loggedIn"]=!"1" &&   $_SESSION["user_type"]=="user")
                                {                                  
                                  $_SESSION["newuser"]= "<div id='error' class='alert alert-body alert-success text-center'>Your acount is created succesfuly<br> Waiting for admin approval to log in<i class='fa-thin fa-spinner fa-spin' style='color: #ffffff;'></i></div>";   
                                  echo $_SESSION["newuser"];                                   
                                }
                             
                                
                            } else {
                                $loginErr ="Wrong Password ";
                            }
                        }
                    } else {
                        $loginErr = "Mail is not found";
                    }
                } else {
                    $loginErr = "An Error Occured";
                }
            }
            mysqli_stmt_close($stmt);
            mysqli_close($connectToDB);
        }
        
    }
    ShowError($mailErr);
    ShowError($loginErr);
    ShowError($passwordErr);
    
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
   
    ></script>
    <link rel="stylesheet" href="../CSS/login.css">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script> 
   <title>Activity Trader</title>



</header>

<body>
  <center>

    
    

    <form id="form" action="login.php" method="post">
      <div id="login" class="text-center m-5 ">
        <div id="account" class="row">
          <ul>
            <li id="link1" class="col-6"><a href="signup.php">Sign up </a></li>
            <li id="link2"><a href="login.php">Sign in </a></li>

          </ul>
        </div>
       
        <br>
        <div class="form-floating mb-3 my-5 " >
          <input type="email" class="form-control" id="floatingInput" name="mail" placeholder="Enter Your Email" required>
          <label for="floatingInput"><i class="fa-regular fa-envelope"></i> Email address</label>
        </div>
        <div class="form-floating">
          
          <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
          <label for="floatingPassword"><i class='fa fa-key' aria-hidden='true'></i> Password</label>
          <div class="d-grid gap-1">
            <button class="btn btn-success text-white" type="submit" name="login">Sign in</button>
          </div>
    </form>

    </div>
  </center>
</body>

</html>