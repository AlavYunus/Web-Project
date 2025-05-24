<?php 
$db=CallDB("users");
$sql="SELECT event_type FROM `activity` GROUP BY event_type";
$user_interest=mysqli_query($db,$sql);
if(isset($_POST["select"]) && ($_SERVER["REQUEST_METHOD"]=="POST")) {
    $interests = isset($_POST['interests']) ? $_POST['interests'] : [];
    $expiry = time() + (3600 * 24 * 365);
    if (!empty($interests)) {
    $interestsJSON = json_encode($interests);
    setcookie('user_interests', $interestsJSON, $expiry, '/');
    header("Location: index.php");
    exit();
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>İnterested in</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</head>
<body>
    <form method="post">
        <div class="card text-start mx-auto">
        <div class="card-body mx-auto">
            <h4 class="card-title">Please Select Your Interests</h4>
           <?php if(mysqli_num_rows($user_interest)>0): $i=0; ?>
        <?php while($like=mysqli_fetch_row($user_interest)): ?>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="<?php echo $like[0];?>" id="intereseted<?php echo ++$i;?>" name="interests[]" />
            <label class="form-check-label" for="intereseted<?php echo ++$i;?>"> <?php echo $like[0];?> </label>
        </div>
       <?php endwhile; ?>
    <?php endif; ?>
    <div class="d-grid gap-2">
        <button
            type="submit"
            name="select"
            id="select"
            class="btn btn-primary"
        >
            SELECT
        </button>
    </div>
    
     </div>
    </div>
    </form>
    
</body>
</html>
<?php  mysqli_close($db); ?>