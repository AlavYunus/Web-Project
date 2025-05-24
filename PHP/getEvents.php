<?php
ClearDb();
$api="api code";
$json_url = "the url of source json page";
$json_data = file_get_contents($json_url);
$data = json_decode($json_data, true);
$events=array();
//get events from the api
if (isset($data["_embedded"]["events"])) {
    foreach ($data["_embedded"]["events"] as $event) {
        if (isset($event["_embedded"]["venues"])) {
            foreach ($event["_embedded"]["venues"] as $venue) {
                $price = rand(8, 20) * 50;
                $quota = rand(10, 15) * 10;
              
                if (isset($venue["address"]["line1"])) {
                    $date = $event["dates"]["start"]["localDate"];
                    $day = substr($date, 8, 2);
                    $month = substr($date, 5, 2);
                    $year = substr($date, 0, 4);
                    $date = $day.".".$month.".".$year;
                    
                    $event_type = isset($event["classifications"][0]["genre"]) 
                        ? $event["classifications"][0]["genre"]["name"] 
                        : $event["classifications"][0]["segment"]["name"];

                                $new_event = [
                                    'name' => $event["name"], 
                                    'date' =>$date,
                                    'time' => $event["dates"]["start"]["localTime"],
                                    'place' =>  $venue["name"],
                                    "address" => $venue["address"]["line1"],
                                    "city" => $venue["city"]["name"],
                                    "country" => $venue["country"]["name"],
                                    "category" =>$event["classifications"][0]["segment"]["name"],
                                    "type" => $event_type,
                                    "price" => $price,
                                    "quota" => $quota,
                                    "source"=>"json_file"
                                ];
    
                        array_push($events, $new_event);
                   
                }
            }
        }
    }
Resetid();
AddDB($events);
}