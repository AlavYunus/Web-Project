<?php
include "Functions.php";

$db = CallDB("users");

if (isset($_POST["confirm_user"]) && !empty($_POST["id"])) {
    $id = $_POST["id"];
    
    $sql = "UPDATE `users` SET admin_confirm='1' WHERE id=?";
    
    if($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id); 
        
        if(mysqli_stmt_execute($stmt)) {
            if(mysqli_stmt_affected_rows($stmt) > 0) {
                $_SESSION["message"]="<div id='error' class='alert alert-body alert-primary text-center'>User confirmed successfully</div> <br>";
                header("Location:admin.php");
            } else {
                ShowError("User is not found");
            }
        } else {
            echo "Error: " . mysqli_error($db);
        }
        mysqli_stmt_close($stmt);
    } else {
        ShowError("Error in preparing statement");
    }
}
if (isset($_POST["delete_user"]) && !empty($_POST["id"])) {
    $id = $_POST["id"];
    
    $sql = "DELETE FROM `users`  WHERE id=?";
    
    if($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id); 
        
        if(mysqli_stmt_execute($stmt)) {
            if(mysqli_stmt_affected_rows($stmt) > 0) {
                $_SESSION["message"]="<div id='error' class='alert alert-body alert-danger text-center'>User deleted successfully</div> <br>";
                header("Location:admin.php");
            } else {
                ShowError("User is not found");
            }
        } else {
            echo "Error: " . mysqli_error($db);
        }
        mysqli_stmt_close($stmt);
    } else {
        ShowError("Error in preparing statement");
    }
}
 mysqli_close($db);
?>

