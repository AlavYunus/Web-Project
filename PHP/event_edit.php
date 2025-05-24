<?php

include "Functions.php";
$db = CallDB("users");
$array = [];
$id = null;
if(!empty($_POST["event_id"]) && isset($_POST["update_event"])) {
    $id = $_POST["event_id"];
 
  }
// Fetch event data for update

    $acts = "SELECT * FROM activity WHERE id=?";
    
    if($stmt = mysqli_prepare($db, $acts)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if(mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            
            if(mysqli_num_rows($result) > 0) {
                $event = mysqli_fetch_assoc($result);
                $array = [
                    $event['event_name'],
                    $event['event_category'],
                    $event['event_type'],
                    $event['event_date'],
                    $event["event_time"],
                    $event['place'],
                    $event['address'],
                    $event['city'],
                    $event['country'],
                    $event['price'],
                    $event['quota'],
                    $id
                ];
            } else {
                ShowError("Event is not found : ") ;
            }
        } else {
            echo "Error: " . mysqli_error($db);
        }
    } else {
        echo "Error in preparing statement: " . mysqli_error($db);
    }


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addEvent"])) {
   
    // Get Event Id
    $id = $_POST["event_id"] ?? null;
    
    if(empty($id)) {
        die("Event ID is required");
    }
    $name = safety($_POST["name"] ?? '');
    $category = safety($_POST["category"] ?? '');
    $type = safety($_POST["event_type"] ?? '');
    $date = safety($_POST["event_date"] ?? '');
    $time = safety($_POST["time"] ?? '');
    $place = safety($_POST["place"] ?? '');
    $address = safety($_POST["address"] ?? '');
    $country = safety($_POST["country"] ?? '');
    $city = safety($_POST["city"] ?? '');
    $quota = safety($_POST["quota"] ?? 0);
    $price = safety($_POST["price"] ?? 0);

    // Validate required fields
    if(empty($city) || $city == "0") {
        $err = "Please fill all required fields";
        ShowError($err);
        exit();
    }

    // Prepare UPDATE statement with parameters
    $acts = "UPDATE `activity` SET 
                event_name = ?,
                event_date = ?,
                event_time = ?,
                price = ?,
                quota = ?,
                event_type = ?,
                event_category = ?,
                place = ?,
                address = ?,
                city = ?,
                country = ?,
                event_source = 'admin'
            WHERE id = ?";

    if($stmt = mysqli_prepare($db, $acts)) {
        mysqli_stmt_bind_param($stmt, "sssdsssssssi", 
            $name, $date, $time, $price, $quota, $type, 
            $category, $place, $address, $city, $country, $id);
        
        if(mysqli_stmt_execute($stmt)) {
            $affected_rows = mysqli_stmt_affected_rows($stmt);
            
            if($affected_rows > 0) {
                $_SESSION["event"]= "<div class='alert alert-success text-center'>The Activity was updated successfully</div>";
                header("Location:admin.php");
            } else {
                echo "<div class='alert alert-warning'>No changes were made or event not found</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error: " . mysqli_error($db) . "</div>";
        }
       
    } else {
        echo "<div class='alert alert-danger'>Error in preparing statement: " . mysqli_error($db) . "</div>";
    } 
}
if (isset($_POST["delete_event"]) && !empty($_POST["event_id"])) {
    $id = $_POST["event_id"];
    
   //Delete selected event
    $sql = "DELETE FROM `activity` WHERE id=?";
    
    if($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id); 
        
        if(mysqli_stmt_execute($stmt)) {
            if(mysqli_stmt_affected_rows($stmt) > 0) {
                $_SESSION["event"]="<div id='error' class='alert alert-body alert-danger text-center'>Activity deleted successfully</div> <br>";
                
                header("Location:admin.php");
            } else {
                ShowError("Activity is not found");
            }
        } else {
            echo "Error: " . mysqli_error($db);
        }
        mysqli_stmt_close($stmt);
    } else {
        ShowError("Error in preparing statement");
    }
} 
   mysqli_stmt_close($stmt);
    mysqli_close($db);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/event_edit.css">

</head>

<body>
    
    <div class="container my-5 bg-warning text-center " id="container">
        <h3>UPDATE THE EVENT</h3>
 <form method="post" action="">
    <?php if(!empty($array)): ?>
        <input type="hidden" name="event_id" value="<?php echo $array[11] ?? ''; ?>">
        
        <div class="form-floating mt-5">
            <input type="text" class="form-control mx-auto" name="name" value="<?php echo htmlspecialchars($array[0] ?? ''); ?>" id="name" required />
            <label for="name">Name</label>
        </div>
        
        <div class="container mt-2 bg-warning row mx-auto">
            <div class="form-floating mt-3 col-6">
                <input type="text" class="form-control" name="category" id="category" value="<?php echo htmlspecialchars($array[1] ?? ''); ?>" required />
                <label for="category">Category</label>
            </div>

            <div class="form-floating mt-3 col-6">
                <input type="text" class="form-control" name="event_type" id="event_type" value="<?php echo htmlspecialchars($array[2] ?? ''); ?>" required />
                <label for="event_type">Event Type</label>
            </div>
        </div>
        
        <div class="container mt-2 bg-warning row mx-auto">
            <div class="form-floating mt-3 col-6">
                <input type="date" class="form-control" name="event_date" id="event_date" value="<?php echo htmlspecialchars($array[3] ?? ''); ?>" required />
                <label for="event_date">Date</label>
            </div>
            <div class="form-floating mt-3 col-6">
                <input type="time" class="form-control" name="time" id="time" value="<?php echo htmlspecialchars($array[4] ?? ''); ?>" required />
                <label for="time">Time</label>
            </div>
        </div>
        
        <div class="container mt-2 bg-warning mx-auto">
            <div class="form-floating mt-3">
                <textarea class="form-control" name="place" id="place" required><?php echo htmlspecialchars($array[5] ?? ''); ?></textarea>
                <label for="place" style="background: none;">Place</label>
            </div>

            <div class="form-floating mt-3">
                <textarea class="form-control" name="address" id="address" required><?php echo htmlspecialchars($array[6] ?? ''); ?></textarea>
                <label for="address" style="background: none;">Address</label>
            </div>
        </div>

        <div class="container mt-2 bg-warning row mx-auto">
            <div class="form-floating mt-3 col-6">
                <select class="form-control" name="country" id="country" required>
                    <option value="Turkey" <?php echo ($array[8] ?? '') == 'Turkey' ? 'selected' : ''; ?>>Türkiye</option>
                </select>
                <label for="country">Country</label>
            </div>
            <div class="form-floating mt-3 col-6">
                <select class="form-control" name="city" id="cities" required>
                    <option value="<?php echo htmlspecialchars($array[7] ?? ''); ?>" selected><?php echo htmlspecialchars($array[7] ?? ''); ?></option>
                </select>
                <label for="city">City</label>
            </div>
        </div>
        
        <div class="container mt-2 bg-warning row">
            <div class="form-floating mt-3 col-6">
                <input type="number" class="form-control" id="quota" name="quota" value="<?php echo htmlspecialchars($array[9] ?? 0); ?>" min="0" required>
                <label for="quota">Number Of Tickets</label>
            </div>
            <div class="form-floating mt-3 col-6">
                <input type="number" class="form-control" name="price" id="price" value="<?php echo htmlspecialchars($array[10] ?? 0); ?>" min="0" step="0.01" required>
                <label for="price">Price</label>
            </div>
        </div>
        
        <div class="d-grid gap-2 col-10 mt-3 mb-5 mx-auto">
            <button type="submit" name="addEvent" id="addEvent" class="btn btn-secondary">
                UPDATE THE EVENT
            </button>
        </div>
    <?php endif; ?>
</form>

    </div>
  

    <script>
      
        var today = new Date();
        var minday = today.toISOString().split('T')[0].split(',');
        const date = document.getElementById("event_date");
        date.setAttribute("min", minday);//set min value for event day
        const dbDate = "<?php echo $event["event_date"]; ?>";

        date.value=dbDate;
const dbTime = "<?php echo $event["event_time"]; ?>";
const timeValue = dbTime.substr(0, 5); 

document.getElementById('time').value = timeValue;

 var day=dbDate.substr(6,4)+"-"+dbDate.substr(3,2)+"-"+dbDate.substr(0,2);
date.value=day;     
      

     

    
   

 </script>
 <script>
        const cityname = document.getElementById("cities");
        cityname.innerHTML = `
<option value="<?php echo $event["city"];  ?>"><?php echo $event["city"];  ?></option>
<option value="Adana">Adana</option>
<option value="Adıyaman">Adıyaman</option>
<option value="Afyonkarahisar">Afyonkarahisar</option>
<option value="Ağrı">Ağrı</option>
<option value="Amasya">Amasya</option>
<option value="Ankara">Ankara</option>
<option value="Antalya">Antalya</option>
<option value="Artvin">Artvin</option>
<option value="Aydın">Aydın</option>
<option value="Balıkesir">Balıkesir</option>
<option value="Bilecik">Bilecik</option>
<option value="Bingöl">Bingöl</option>
<option value="Bitlis">Bitlis</option>
<option value="Bolu">Bolu</option>
<option value="Burdur">Burdur</option>
<option value="Bursa">Bursa</option>
<option value="Çanakkale">Çanakkale</option>
<option value="Çankırı">Çankırı</option>
<option value="Çorum">Çorum</option>
<option value="Denizli">Denizli</option>
<option value="Diyarbakır">Diyarbakır</option>
<option value="Edirne">Edirne</option>
<option value="Elazığ">Elazığ</option>
<option value="Erzincan">Erzincan</option>
<option value="Erzurum">Erzurum</option>
<option value="Eskişehir">Eskişehir</option>
<option value="Gaziantep">Gaziantep</option>
<option value="Giresun">Giresun</option>
<option value="Gümüşhane">Gümüşhane</option>
<option value="Hakkâri">Hakkâri</option>
<option value="Hatay">Hatay</option>
<option value="Isparta">Isparta</option>
<option value="Mersin">Mersin</option>
<option value="İstanbul">İstanbul</option>
<option value="İzmir">İzmir</option>
<option value="Kars">Kars</option>
<option value="Kastamonu">Kastamonu</option>
<option value="Kayseri">Kayseri</option>
<option value="Kırklareli">Kırklareli</option>
<option value="Kırşehir">Kırşehir</option>
<option value="Kocaeli">Kocaeli</option>
<option value="Konya">Konya</option>
<option value="Kütahya">Kütahya</option>
<option value="Malatya">Malatya</option>
<option value="Manisa">Manisa</option>
<option value="Kahramanmaraş">Kahramanmaraş</option>
<option value="Mardin">Mardin</option>
<option value="Muğla">Muğla</option>
<option value="Muş">Muş</option>
<option value="Nevşehir">Nevşehir</option>
<option value="Niğde">Niğde</option>
<option value="Ordu">Ordu</option>
<option value="Rize">Rize</option>
<option value="Sakarya">Sakarya</option>
<option value="Samsun">Samsun</option>
<option value="Siirt">Siirt</option>
<option value="Sinop">Sinop</option>
<option value="Sivas">Sivas</option>
<option value="Tekirdağ">Tekirdağ</option>
<option value="Tokat">Tokat</option>
<option value="Trabzon">Trabzon</option>
<option value="Tunceli">Tunceli</option>
<option value="Şanlıurfa">Şanlıurfa</option>
<option value="Uşak">Uşak</option>
<option value="Van">Van</option>
<option value="Yozgat">Yozgat</option>
<option value="Zonguldak">Zonguldak</option>
<option value="Aksaray">Aksaray</option>
<option value="Bayburt">Bayburt</option>
<option value="Karaman">Karaman</option>
<option value="Kırıkkale">Kırıkkale</option>
<option value="Batman">Batman</option>
<option value="Şırnak">Şırnak</option>
<option value="Bartın">Bartın</option>
<option value="Ardahan">Ardahan</option>
<option value="Iğdır">Iğdır</option>
<option value="Yalova">Yalova</option>
<option value="Karabük">Karabük</option>
<option value="Kilis">Kilis</option>
<option value="Osmaniye">Osmaniye</option>
<option value="Düzce">Düzce</option>


        `;

    </script>
</body>

</html>


   
