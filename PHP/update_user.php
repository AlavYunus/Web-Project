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
                print_r($array);
            } else {
                echo "No event found with ID: " . $id;
            }
        } else {
            echo "Error: " . mysqli_error($db);
        }
    } else {
        echo "Error in preparing statement: " . mysqli_error($db);
    }


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addEvent"])) {
    // Validate and sanitize inputs
   
    // ID'yi doğrudan POST'tan al
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
                echo "<div class='alert alert-success text-center'>The Activity was updated successfully</div>";
            } else {
                echo "<div class='alert alert-warning'>No changes were made or event not found</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error: " . mysqli_error($db) . "</div>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert alert-danger'>Error in preparing statement: " . mysqli_error($db) . "</div>";
    }
}
?>

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
                    <!-- Add more country options as needed -->
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
<?php  mysqli_close($db); ?>