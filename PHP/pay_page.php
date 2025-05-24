<?php 

include "Functions.php";

// Veritabanı bağlantısı
$db = CallDB("users");
$totalPrice=0;
$current=array();
if(isset($_SESSION['cartevent'])) {
  $current=$_SESSION['cartevent'];
}

if (isset($_POST["buy"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['update'] = array(); // Clear the session

    $num_tickets = floatval($_POST["numberofticket"] ?? 0);

    for ($i = 1; $i <= $num_tickets; $i++) {
        $ticket_count = floatval($_POST["numberofticket" . $i] ?? 0);
        $newPrice=floatval($_POST["newPrice".$i] ?? 0);    
        $totalPrice += $newPrice * $ticket_count;        

        $quota = floatval($_POST["quota" . $i] ?? 0);
        $id = floatval($_POST["id" . $i] ?? 0);
        
        if ($id > 0 && $quota >= $ticket_count ) {
            //Add new quota and id info  to session 
            $_SESSION['update'][] = array(
                'id' => $id,
                'quota' => $quota - $ticket_count
            );
        }
    }
    // header("Location: pay_page.php");
}
//  echo "<h5 class='mx-auto'>Total Price: " .number_format($totalPrice, 2) . "</h5>";

if (isset($_POST["pay"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from the session
    $updateQuota = $_SESSION['update'] ?? array();
    
    if (!empty($updateQuota)) {
        foreach ($updateQuota as $update) {
            $id = floatval($update['id']);
            $new_quota = floatval($update['quota']);
            
            // Check the quota is greater then 0
            if ($new_quota < 0) $new_quota = 0;

            // Upddate the quota info
            $sql = "UPDATE activity SET quota = ? WHERE id = ?";
            $stmt = mysqli_prepare($db, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ii", $new_quota, $id);

                if (mysqli_stmt_execute($stmt)) {
                    if (mysqli_stmt_affected_rows($stmt) == 0) {
                        $_SESSION['error_message'] = "The Event was not found please try again: $id";
                        mysqli_stmt_close($stmt);
                        header("Location: cart_page.php");
                        exit();
                    }
                } else {
                    $_SESSION['error_message'] = "An Error Occured: " . mysqli_error($db);
                    mysqli_stmt_close($stmt);
                    header("Location: cart_page.php");
                    exit();
                }
                mysqli_stmt_close($stmt);
            } else {
                $_SESSION['error_message'] = "An Error Occured" . mysqli_error($db);
                header("Location: cart_page.php");
                exit();
            }
        }
        // Clear the session and cart page
        unset($_SESSION['cart']);
        unset($_SESSION['update']);
        //if everything ok send a message
        $_SESSION['success_message'] = "<div class='alert alert-body alert-success text-center'>TICKET PURCHASE HAS BEEN SUCCESSFUL<br>THANK YOU FOR CHOOSING US</div>";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error_message'] = "<div class='alert alert-body alert-danger text-center'>No More Quota For The Event</div>";
        exit();
    }
}

if ($db) {
    mysqli_close($db);
}

if(isset($_SESSION['error_message'])) {
    echo $_SESSION['error_message'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Page</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</head>
<body>
    <center>
       <div class="card m-auto" style="width:40rem; ">
  <div class="card-body  m-auto mt-5" >
    <h5 class="card-title">Payment Page </h5>
        <p class="my-3"><big><i><b>Total Price: <?php echo number_format($totalPrice, 2);?> ₺</b></i></big></p>
        <form method="post">
            <div class="row">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="card" id="1" />
                <label class="form-check-label" for="1"> Debit Card </label>
            </div>
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="card"
                    id="2"
                    checked
                    
                />
                <label class="form-check-label" for="2">
                    Credit Card
            </label>

            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="card" id="2" />
                <label class="form-check-label" for="1"> PayPal </label>
            </div>
        </div>
            <div class="my-3">
                <label for="card_name" class="form-label">Name On Card</label>
                <input
                    type="text"
                    class="form-control"
                    name="card_ame"
                    id="card_name"
                    aria-describedby="helpId"
                    required
                    />
                <small id="helpId" class="form-text text-muted">Full Name as displayed on card</small>
            </div>
            
            <div class="mb-3">
                <label for="card_number" class="form-label">Card Number</label>
                <input
                    type="tel"
                    class="form-control"
                    name="card_number"
                    id="card_number"
                    required
                   pattern="[0-9]{13,19}" 
                   placeholder="1234 5678 9012 3456"
                    />

            </div>
            <div class="row">
                 <div class="mb-3 col-6">
                <label for="expiration" class="form-label">Expiration</label>
                <input
                    type="tel"
                    class="form-control"
                    name="expiration"
                    id="expiration"
                    required
                    pattern="(0[1-9]|1[0-2])/(0[0-9]|1[0-9]|2[0-9]|3[0-1])" 
                    placeholder="12/25"
                    />

            </div>
            
            <div class="mb-3 col-6">
                <label for="cww" class="form-label">CWW</label>
                <input
                    type="tel"
                    class="form-control"
                    name="cww"
                    id="cww"
                    required
                     pattern="[0-9]{3}" 
                      placeholder="123"
                    />

            </div>
            
            </div>
           
            
            <div class="d-grid gap-2">
                <button
                    type="submit"
                    name="pay"
                    id="pay"
                    class="btn btn-primary col-6"
                >
                    Pay
                </button>
            </div>
            


        </form>
  </div>
</div> 
    </center>


</body>
</html>