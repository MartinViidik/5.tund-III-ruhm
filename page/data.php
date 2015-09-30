<?php 
	require_once("../functions.php");
	//kui kasutaja on sisseloginud, suunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: data.php");
	}
	
	//kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}

?>	
<p>
	Hello, <?php echo $_SESSION["logged_in_user_username"];?>
	<a href="?logout=1"> Log out <a>