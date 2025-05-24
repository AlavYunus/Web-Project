<?php

$db =CallDB("users") ;
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get interests with cookie
$user_interests = isset($_COOKIE['user_interests']) ? json_decode($_COOKIE['user_interests'], true) : [];

// Kullanıcının ilgi alanlarına uygun etkinlikleri çek
if (!empty($user_interests)) {
    $safe_interests = array_map(function ($item) use ($db) {
        return mysqli_real_escape_string($db, $item);
    }, $user_interests);

    $query = "SELECT event_name, event_date, event_time FROM activity WHERE event_type IN ('" . implode("', '", $safe_interests) . "')";
    $result = mysqli_query($db, $query);

    $recommended_events = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $recommended_events[] = [
            'event_name' => $row['event_name'],
            'event_date' => $row['event_date'],
            'event_time' =>$row['event_time']
        ];
    }
} else {
    $recommended_events = [];
}


mysqli_close($db);
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Suggested Activities</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="../CSS/show_interest.css">
</head>
<body>
  <div class="container">
    <?php if (isLoggedIn()): ?>
      <?php if (empty($recommended_events)): ?>
        <a href="profile.php"><p>Click To Select Your Interest Part</p></a>
      <?php else: ?>
        <h2 class="text-center mb-5">Suggested Activities</h2>

        <div id="recommendedEventsCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <?php foreach ($recommended_events as $index => $event): ?>
              <div class="carousel-item <?php if ($index == 0) echo 'active'; ?>">
                <div class="carousel-caption">
                  <h5><?php echo htmlspecialchars($event['event_name']); ?></h5>
                  <p>Date: <?php echo htmlspecialchars($event['event_date']); ?></p>
                  <p>Time: <?php echo htmlspecialchars($event['event_time']); ?></p>
                  <p><a class="btn btn-md btn-primary" href="#<?php echo urlencode($event['event_name']); ?>" role="button">More Details</a></p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#recommendedEventsCarousel" data-bs-slide="prev" style="border:none">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#recommendedEventsCarousel" data-bs-slide="next" style="border:none">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>

  <!-- Bootstrap JS ve Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>