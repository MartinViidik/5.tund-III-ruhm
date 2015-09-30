<?php 

	// Loon andmebaasi ühenduse
	require_once("../../config_global.php");
	$database = "if15_martin";
	
	// tekitakse sessioon, mida hoitakse serveris 
	// kõik session muutujad on kättesaadavad kuni viimase brauseriakna sulgemiseni
	session_start();

	// võtab andmed ja sisestab andmebaasi
	function createUser($reg_username, $reg_email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt =  $mysqli->prepare("INSERT INTO martin_login2 (email, username, password) VALUES (?,?,?)");
		$stmt->bind_param("sss", $reg_email, $reg_username, $hash);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();
		
	}
	
	function loginUser($username, $email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email, username FROM martin_login2 WHERE email=? AND username=? AND password=?");
		$stmt->bind_param("sss",$email, $username, $hash);
		$stmt->bind_result($id_from_db, $username_from_db, $email_from_db);
		$stmt->execute();
		
		if($stmt->fetch()){
			//andmebaasis oli midagi
			echo "Email, username ja parool õiged, kasutaja id=".$id_from_db;
			
			// tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_username"] = username_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			//suunan data.php lehele
			header("Location: data.php");
			
		}else{
			// ei leidnud
			echo "Valed andmed!";
		}
			
		$stmt->close();
			
		$mysqli->close();
		
	}

	
	
?>