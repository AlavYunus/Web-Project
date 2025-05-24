<?php

use BcMath\Number;

include "Functions.php";
$num=0;

if(isset(  $_SESSION['error_message'] )) {
    echo   $_SESSION['error_message'] ;
}
if(isset($_POST["ticketType"])) {
    echo $_POST["ticketType"];
}
if(isset($_POST["getTicket"]) && ($_SERVER["REQUEST_METHOD"]=="POST"))
{
    if(isLoggedIn())
     {

        $event_id = $_POST['event_id'];
        $event_name = $_POST['event_name'];
        $event_date = $_POST['event_date'];
        $event_time=$_POST['event_time'];
        $price = $_POST['price'];
        $quota=$_POST["quota"];

        // check the session is set 
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Check if the added event is in the cart
        $is_exist = false;
        foreach ($_SESSION['cart'] as $item) {
            if ($item['event_id'] == $event_id) {
                $is_exist = true;
                break;
            }
        }
        if (!$is_exist) {
    
            array_push($_SESSION['cart'], array(
                'event_id' => $event_id,
                'event_name' => $event_name,
                'event_date' => $event_date,
                'event_time' => $event_time,
                'quota' => $quota,
                'price' => $price
            ));
            
        }
    }
    else {
        header("Location:login.php");
    }   
}
//Assign the cart to list events
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$_SESSION['cartevent']=array();//send the event info to payment page
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Cart</title>
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
    <?php require "navbar.php";?>
    <?php if(!empty($_SESSION['cart'])): ?>
    
    <h1 class="mx-auto text-center">Cart Page</h1>
     <div class="container-sm row border border-solid mx-auto">
            <p class="col-3 my-auto"><big>Event Time</big></p>
            <p class="col-3 my-auto"><big>Event Name</big></p>
            <p class="col-3 my-auto"><big>Ticket Category</big></p>
            <p class="col-2 my-auto"><big>Price</big></p>
            <p class="col-1 my-auto"><big>Number Of Ticket</big></p>
        </div>
  <form action="pay_page.php" method="post">
    <?php foreach ($cart as $index => $item): ?>        
        <div class="container-sm row border border-solid m-auto">
            <div class="col-3 my-auto">
                <p class="row"><?php echo $item['event_date']; ?></p>
                <p class="row"><?php echo $item['event_time']; ?></p>
            </div>
            <input type="hidden" name="id<?php echo ++$num; ?>" value="<?php echo $item['event_id']; ?>">
            <p class="col-3 my-auto"><?php echo $item['event_name']; ?></p>
            <div class="col-3 my-auto">
                 <select 
                name="ticketType<?php echo $num; ?>" 
                class="form-select ticketTypeSelector mr-5 ml-0"
            >
                <option value="1.5">Category 1 (Front Of Stage Ticket)</option>
                <option value="1" selected>Category 2</option>
                <option value="0.75">Category 3 (Back Row)</option>
            </select>
            </div>
           
            
            <input 
                type="hidden" 
                name="newPrice<?php echo $num; ?>" 
                id="newPrice<?php echo $num; ?>"
                value="<?php echo intval($item['price']); ?>"
            >
            
            <p 
                class="col-2 my-auto price-display" 
                data-base-price="<?php echo intval($item['price']); ?>"
            >
                <?php echo intval($item['price']); ?>
            </p>
            
            <div class="col-1 my-auto">
                <input 
                    type="number" 
                    name="numberofticket<?php echo $num; ?>" 
                    value="1"  
                    min="1" 
                    max="10"
                >
            </div>
            
            <input type="hidden" name="quota<?php echo $num; ?>" value="<?php echo $item['quota']; ?>">
            
            <div class="d-grid gap-2 col-1 mb-0">
                <a
                    name="delete_cart"
                    id="<?php echo $index;?>"
                    class="btn  mb-0"
                    href="DeleteCart.php?id=<?php echo $index; ?>"
                    role="button"
                >
                    <i class="fa-solid fa-trash" style="color: #d22d2d;"></i>
                </a>
            </div>
        </div>
    <?php endforeach; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.ticketTypeSelector').forEach(function(select) {
                select.addEventListener('change', function() {
                    updatePrice(this);
                });
            });
        });

        function updatePrice(select) {
            const priceDisplay = select.closest('.row').querySelector('.price-display');
            const basePrice = parseFloat(priceDisplay.getAttribute('data-base-price'));
            const selectedValue = parseFloat(select.value);
            const newPrice = basePrice * selectedValue;
            
            // Update the display
            priceDisplay.textContent = newPrice;
            
            // Update the hidden input
            const hiddenPriceInput = document.getElementById('newPrice' + select.name.replace('ticketType', ''));
            hiddenPriceInput.value = newPrice;
        }
    </script>
            
            <div class="container-sm row mx-auto mt-4">
            <input type="hidden" name="numberofticket" value="<?php echo $num;  ?>" >
            <button type="submit" class="btn btn-primary mx-auto col-5" id="buy" name="buy">
                Buy The Ticket
            </button>
        </div>
    </form>
   
    <?php else: ?>
        <div class="card m-auto mt-5" style="max-width: 540px;">
            <div class="row g-0">
                <div class="card-body">
                    <h5 class="card-title">Your Cart Is Empty</h5>
                    <p class="card-text mx-auto">
                       <a href="index.php" title="home"><i class="fa fa-cart-plus  fa-2xl" aria-hidden="true" style="color: #1477c2;"></i></a> 
                    </p>
                    
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>