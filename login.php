<?php
	// LOGIN.PHP
	// errori muutujad peavad enne if'i olemas olema :)
	
	// Kõik funktsioonid, kus tegeleme andmebaasiga
	require_once("../functions.php");
	
	// muutujad errorite jaoks
	$email_error = "";
	$password_error = "";
	$username_error = "";
	$reg_email_error = "";
	$reg_password_error = "";
	$reg_username_error = "";
	
	//muutujad andmebaasi väärtuste jaoks
	$username = ""; $email = ""; $password = "";
	$reg_username = ""; $reg_email = ""; $reg_password = "";
	
	//echo $_POST["email"];
	
	// kontrollime et keegi vajutas input nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		//************************************************************
		//echo "keegi vajutas login nuppu";
		
		//vajutas login nuppu
		//************************************************************
		if(isset($_POST["login"])){
				
			if (empty($_POST["email"]) ) {
				$email_error = "This field is required";
			}else{
				// kõik korras
				// test_input eemaldab pahatahltikud osad
				$email = clean_input($_POST["email"]);
				
				}
				
			if (empty($_POST["username"]) ) {
				$username_error = "This field is required";
				
			}else{
				
				$username = clean_input($_POST["username"]);
				
				}
				
			if (empty($_POST["password"]) ) {
				$password_error = "This field is required";
			}else{
			
				$password = clean_input($_POST["password"]);
				
			}
			// kontrollin et ei oleks ühtegi errorit
			if($email_error == "" && $password_error ==""){
				
			$hash = hash("sha512", $password);
			
			// kasutaja loomise fn, failist functions.php
				loginUser($username, $email, $password);
				
		
			}

		
		//*************************************************************
		// Keegi vajutas create nuppu
		//*************************************************************
		}elseif(isset($_POST["create"])){
			
			if (empty($_POST["reg_username"]) ) {
				$reg_username_error = "This field is required";
			}else{
				$reg_username = cleanInput($_POST["reg_username"]);
			}
			
			
			if (empty($_POST["reg_password"]) ) {
				$reg_password_error = "This field is required";
			}else {
				
				// kui oleme siia jõudnud, siis parool ei ole tühi enam
				// kontrollin, et oleks vähemalt 8 sümbolit pikk
				if(strlen($_POST["reg_password"]) < 8) {
					
					$reg_password_error = "Password must be at least 8 characters";
					
				}else{
					$reg_password = cleanInput($_POST["reg_password"]);
				}
			
			}
			if (empty($_POST["reg_email"]) ) {
				$reg_email_error = "This field is required";
			}else{
				$reg_email = cleanInput($_POST["reg_email"]);
			}
			
		
			if(	$reg_email_error == "" && $reg_password_error == "")
				
				// Räsi paroolist mis salvestame andmebaasi
				$hash = hash("sha512", $reg_password);
				
				// kasutaja loomise fn, failist functions.php
				createUser($reg_username, $reg_email, $reg_password);
				

		}
	}
	
	
	function cleanInput($data) {
		// võtab ära tühikud, enterid, tabid
		$data = trim($data);
		// tagurpidi kaldkriipsud
		$data = stripslashes($data);
		// teeb htm'li tekstiks 
		$data = htmlspecialchars($data);
		return $data;
}
	
	$page_title = "Sisselogimine";
	$page_file_name = "login.php";
	require_once("../header.php");
	
	// paneme ühenduse kinni
	$mysqli->close();
	
?>

	<h2>Log in</h2>
		
		<form action="login.php" method="post" >
			<input name="username" type="text" placeholder="username"> <?php echo $username_error; ?><br> <br>
			<input name="email" type="email" placeholder="email"> <?php echo $email_error; ?><br> <br>
			<input name="password" type="password" placeholder="Password"> <?php echo $password_error; ?> <br> <br>
			<input name="login" type="submit" value="Log in"> <br> <br>
		</form>
	
	<h2>Create user</h2>
	
		<form action="login.php" method="post" >
			<input name="reg_username" type="text" placeholder="username"> * <?php echo $reg_username_error; ?><br> <br>
			<input name="reg_email" type="email" placeholder="email"> * <?php echo $reg_email_error; ?><br> <br>
			<input name="reg_password" type="password" placeholder="Password"> * <?php echo $reg_password_error; ?> <br> <br>
			<input name="reg_password" type="password" placeholder="Insert password again"> * <?php echo $reg_password_error; ?> <br> <br>
			<input name="create" type="submit" value="Register"> <br> <br>
		</form>
	
	<?php require_once("../footer.php"); ?>