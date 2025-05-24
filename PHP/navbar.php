<?php //require 'Functions.php';?>
  <!-- <link rel="stylesheet" href="../CSS/navbar.css"> -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

  <header>
    
            <nav class="navbar navbar-expand-lg bg-body-tertiary ">
                <div class="container-fluid">
                  <strong class="navbar-brand text-danger" href="index.php">ACTIVITY TRADER</strong>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                   
                     <?php if(isLoggedIn()): ?>
                       <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                          <div class="navbar-nav ">                            
                            <a class="nav-link btn-bg-darkactive" aria-current="page" href="index.php"><i class="fa-solid fa-house fa-sm"  aria-hidden="true" style="color: #720000;" ></i>  Home</a>
                            <a class="nav-link " href="profile.php"> <i class="fa fa-user-circle" aria-hidden="true" style="color: #720000;"></i> Profile</a>
                            <a class="nav-link" href="notices.php"><i class="fa fa-bell" aria-hidden="true" style="color: #720000;">
                              <?php 
                                $getNotice=CallDB("users");
                                //count number of notice
                                $lastCheck = $_SESSION['last_check_time'] ?? time();
                                $checkDate = date('Y-m-d H:i:s', $lastCheck);
                                $stmt = mysqli_prepare($getNotice, "SELECT COUNT(*) FROM bildirimler WHERE bildirim_tarihi > ?");
                                mysqli_stmt_bind_param($stmt, "s", $checkDate); 
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                $row = mysqli_fetch_row($result);
                                $newItems = $row[0];
                                mysqli_close($getNotice); 
                                if ($newItems > 0) {
                                    $_SESSION['last_check_time'] = time();
                                    echo "$newItems";

                                }?>
                            </i> Natification </a>
                           
                             <a class="nav-link" href="cart_page.php"> <i class="fa fa-cart-plus" aria-hidden="true" style="color: #720000;"></i> MyCart</a>
                            <a class="nav-link" href="logout.php"><i class="fa-solid fa-right-from-bracket"style="color: #720000;"> </i>  Exit </a>
                            

                          </div>
                       </div>
                      <?php else: ?>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                          <div class="navbar-nav ">
                            <a class="nav-link btn-bg-darkactive" aria-current="page" href="login.php"><i class="fa-solid fa-user" style="color: #770000;"></i></i> Sign in</a>
                            <a class="nav-link" href="signup.php"><i class="fa-solid fa-user-plus fa-bounce" style="color:rgb(114, 0, 0);"></i> Sign Up</a>
                         
                          </div>
                        </div>
                  <?php endif; ?> 
                
                
                </div>
              </nav>
        </header>
