<?php 
$events = [];  
 function AddEvent(&$events, $event_name, $event_date, $event_time, $event_place, 
                 $event_address, $event_city, $event_country, $event_category, 
                 $event_type, $event_price, $event_quota,$source) {

    $new_event = [
        'name' => $event_name, 
        'date' => $event_date,
        'time' => $event_time,
        'place' => $event_place,
        "address" => $event_address,
        "city" => $event_city,
        "country" => $event_country,
        "category" => $event_category,
        "type" => $event_type,
        "price" => $event_price,
        "quota" => $event_quota,
        "source"=>$source
    ];
    
    array_push($events, $new_event);  // Add The Event To The Array
}
?>
<?php
// include 'getEvents.php';
$name = $category = $type =$date=$time=$place=$address=$country=$city=$quota=$price="";

if($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_POST) ) {
    $name = $category = $type =$date=$time=$place=$address=$country=$city=$quota=$price="";
    $name=safety($_POST["name"]);
    $category=safety($_POST["category"]);
    $type=safety($_POST["event_type"]);
    $date=safety($_POST["event_date"]);
    $time=safety($_POST["time"]);
    $place=safety($_POST["place"]);
    $address=safety($_POST["address"]);
    $country=safety($_POST["country"]);
    $city=safety($_POST["city"]);
    $quota=safety($_POST["quota"]);
    $price=safety($_POST["price"]);
    if(!empty($city) && $city<>"0" ) {
           AddEvent($events, $name,$date ,$time,$place,$address,$city,$country,$category,$type,$price,$quota,"admin");
            AddDB($events);

            $_SESSION["addEvent"]= "<div id='error' class='alert alert-body alert-success text-center'>The Activity is created successfully</div>"."<br>";

    }
    else {
        $err="Please Fill The All Blank";
        ShowError($err);
    }
 
    
}
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">


   <link rel="stylesheet" href="../CSS/addEvent.css">
</head>

<body>
    
    <div class="container my-5 bg-warning text-center " id="container">
        <h3>CREATE A NEW EVENT</h3>
  <form method="post">
        
            <div class="form-floating mt-5">
                <input type="text" class="form-control mx-auto" name="name" id="name" required />
                <label for="name">Name</label>
            </div>

            <div class="container mt-2 bg-warning row mx-auto">
                <div class="form-floating mt-3 col-6">
                    <input type="text" class="form-control" name="category" id="category" required />
                    <label for="category">Category</label>
                </div>

                <div class="form-floating mt-3 col-6">
                    <input type="text" class="form-control" name="event_type" id="event_type" required />
                    <label for="event_type">Event Type</label>
                </div>
            </div>
                <div class="container mt-2 bg-warning row mx-auto">
                    <div class="form-floating mt-3 col-6">
                        <input type="date" class="form-control" name="event_date" id="event_date" required />
                        <label for="event_date">Date</label>
                    </div>
                    <div class="form-floating mt-3 col-6">
                        <input type="time" class="form-control" name="time" id="time" required />
                        <label for="event_type">Time</label>
                    </div>
                </div>
                    <div class="container mt-2 bg-warning mx-auto">
                        <div class="form-floating mt-3">
                            <textarea class="form-control" name="place" id="place" required > </textarea>
                            <label for="place" style="background: none;">Place</label>
                        </div>

                        <div class="form-floating mt-3">
                            <textarea class="form-control" name="address" id="address" required ></textarea>
                            <label for="address"  style="background: none;">Adress</label>
                        </div>
                    </div>

                    <div class="container mt-2 bg-warning row mx-auto">
                        <div class="form-floating mt-3 col-6">
                            <select class="form-control" name="country" id="country" required default>
                                <option value="Turkey" selected>Türkiye</option>
                            </select>

                            <label for="country">Country</label>
                        </div>
                        <div class="form-floating mt-3 col-6">
                            <select class="form-control" name="city" id="cities" required>
                            </select>

                            <label for="city">City</label>
                        </div>

                    </div>
                    <div class="container mt-2 bg-warning row">
                        <div class="form-floating mt-3 col-6">
                            <input type="number" class="form-control" id="quota" name="quota"  min="0"required >
                            <label for="quota">Number Of Ticket</label>
                        </div>
                        <div class="form-floating mt-3 col-6">
                            <input type="number" class="form-control" name="price" id="price" min="0" required>

                            <label for="price">Price</label>
                        </div>

                    </div>
                    <div class="d-grid gap-2 col-10 mt-3 mb-5 mx-auto">
                        <button
                            type="submit"
                            name="addEvent"
                            id="addEvent"
                            class="btn btn-secondary"
                        >
                            CREATE THE EVENT
                        </button>
                    </div>
               <p>





               </p>

                
    </form>

    </div>
  

    <script>
        var today = new Date();
        var minday = today.toISOString().split('T')[0].split(',');
        const date = document.getElementById("event_date");
        date.setAttribute("min", minday);
    </script>

 <script>
        const cityname = document.getElementById("cities");
        cityname.innerHTML = `
                      
      <option value="0" >-select-</option>
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


   
