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
	
	$number_plate = $color = "";
	$number_plate_error = $color_error = "";
	
	if(isset($_POST["add_plate"])){
				
		if (empty($_POST["number_plate"]) ) {
			$number_plate_error = "This field is required";
		}else{
			$number_plate = cleanInput($_POST["number_plate"]);	
		}
		
		if (empty($_POST["color"]) ) {
			$color_error = "This field is required";		
		}else{
			$color = cleanInput($_POST["color"]);
		}
		
		if(	$number_plate_error == "" && $color_error == ""){
			addCarPlate($number_plate, $color);
			}
	}	
?>	
<p>
	Hello, <?php echo $_SESSION["logged_in_user_username"];?>
	<a href="?logout=1"> Log out <a>
</p>


<?php 	function cleanInput($data) {
		// võtab ära tühikud, enterid, tabid
		$data = trim($data);
		// tagurpidi kaldkriipsud
		$data = stripslashes($data);
		// teeb htm'li tekstiks 
		$data = htmlspecialchars($data);
		return $data;
}?>


<h2>Add car details</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="number_plate" >Car license plate</label><br>
	<input id="number_plate" name="number_plate" type="text" value="<?php echo $number_plate; ?>"> <?php echo $number_plate_error; ?><br><br>
	<label for="color">Color</label><br>
	<input id="color" name="color" type="text" value="<?php echo $color; ?>"> <?php echo $color_error; ?><br><br>
	<input type="submit" name="add_plate" value="Salvesta">
</form>
