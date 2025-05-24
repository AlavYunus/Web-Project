<?php
include "Functions.php";
$user_id = "";

if (isLoggedIn()) {

    if(isset($_SESSION["firstEntry"])) {
        echo $_SESSION["firstEntry"];
    }
    $connectToDB = CallDB("users");
    $user_id = $_SESSION["id"];

    $password = $repassword = "";
    $passwordErr = $repasswordErr = "";

    if (isset($_POST["change"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate password
        if (empty($_POST["password"])) {
            $passwordErr = "Password field cannot be blank.";
        } else {
            $password = safety($_POST["password"]);
        }

        // Validate confirm password
        if (empty($_POST["repassword"])) {
            $repasswordErr = "Confirm password field cannot be blank.";
        } else {
            $repassword = safety($_POST["repassword"]);
        }

        // Check if passwords match
        if ($password !== $repassword) {
            $repasswordErr = "Password and confirm password must match.";
        }

        // If no errors, update password
        if (empty($passwordErr) && empty($repasswordErr)) {
            $sql = "UPDATE `users` SET password=? WHERE id=?";
            if ($stmt = mysqli_prepare($connectToDB, $sql)) {
                $param_password = password_hash($password, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "si", $param_password, $user_id);
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION["password_change"] = "<div id='error' class='alert alert-body alert-success text-center'>Your password has been changed successfully.</div>";
                    header("Location: index.php");
                    exit;
                } else {
                    ShowError( mysqli_error($connectToDB)."<br>An error occurred, please try again.");
                    
                }
                mysqli_stmt_close($stmt);
            }

        }
       
    }

    mysqli_close($connectToDB);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
<title>My Profie</title>
</head>
<body>

    <div
        class="container-sm"
    >
    <form  method="post" class="novalidate" >
    <div class="mb-3">
        <label for="" class="form-label">Mail Address</label>
        <input
            type="text"
            class="form-control"
            name="mymail"
            id="mymail"
            value="<?php echo $_SESSION["mail"]; ?>"
            default  
            readonly
              />
    </div>
<div id="repswrd">
    <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input
        type="password"
        class="form-control"
        name="password"
        id="password"
        placeholder="Enter New Password"
        
    />
    <?php if (!empty($passwordErr)) echo "<small class='text-danger'>{$passwordErr}</small>"; ?>
</div>
<div class="mb-3">
    <label for="repassword" class="form-label">Confirm</label>
    <input
        type="password"
        class="form-control"
        name="repassword"
        id="repassword"
        placeholder="Enter New Password Again"
        
    />
  
    <?php if (!empty($repasswordErr)) echo "<small class='text-danger'>{$repasswordErr}</small>"; ?>
</div>
    <button
        type="submit"
        class="btn btn-primary"
        name="change"
    >
       Change
    </button>
    
</div>


<div >
    <button
        type="button"
        name="change_password"
        id="change_password"
        class="btn btn-danger"
    >
       Click To Change Your Password
    </button>
      <a
        name="home"
        id="home"
        class="btn btn-primary col-3 mx-3 my-3"
        href="index.php"
        role="button"
        >Home Page</a
    >
    
</div>



</form>
</div>
<?php if(!isAdmin()) {include "user_interest.php";}?>

<script>
const change_password = document.getElementById("change_password");
const addText = document.getElementById("repswrd");

addText.style.display = "none";

change_password.addEventListener("click", () => {
  if (addText.style.display === "none") {
    addText.style.display = "block";
    change_password.style.display = "none"; // when page open hide password field
  } else {
<?php  if (empty($passwordErr) && empty($repasswordErr)) :?>
    addText.style.display = "none";
    change_password.style.display = "block";
  }
});
<?php endif; ?>
    
    


</script>
</body>
</html>