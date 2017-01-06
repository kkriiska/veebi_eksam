<?php

	require("../../config.php");
	
	$signupEmailError="";
	$signupEmail = "";
	
	//kas on olemas
	if (isset ($_POST["signupEmail"])) {
		//oli olemas
		//tuhi?
		if (empty ($_POST["signupEmail"])) {
			//oli tuhi
			$signupEmailError = "See väli on kohustuslik";
		} else {
			//koik ok
			$signupEmail = $_POST["signupEmail"];
		}
	}
	
	$signupPasswordError = "";
	$signupPassword = "";
	
	//kas olemas
	if (isset ($_POST["signupPassword"])) {
		//oli olemas
		//kas tuhi?
		if (empty ($_POST["signupPassword"])) {
			//oli tuhi
			$signupPasswordError = "See väli on kohustuslik";
		} else {
			//midagi oli
			//kas ikka 8tm pikk?
			if (strlen ($_POST["signupPassword"]) < 8 ) {
				$signupPasswordError = "Parool peab olema vähemalt 8 tahemarki pikk";
			}
		}
	}

	if(isset($_POST["signupEmail"]) && isset($_POST["signupPassword"]) && $signupEmailError == "" && empty($signupPasswordError)) {
		echo "salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);

		echo "räsi ".$password."<br>";
		$User->signup($signupEmail,  $signupPassword);
	}
	
	$notice = "";
	if (	isset($_POST["loginEmail"]) && 
			isset($_POST["loginPassword"]) && 
			!empty($_POST["loginEmail"]) && 
			!empty($_POST["loginPassword"]) 
	) {
		$notice = $User->login($_POST["loginEmail"], $_POST["loginPassword"]);
		
		if(isset($notice->success)){
			header("Location: home.php");
			exit();
		}else {
			$notice = $notice->error;
			var_dump($notice->error);
		}
		
	}
?>

<!DOCTYPE html>
<html>
	<head>
	<style>
	
	input[type="submit"] {
		
		padding: 12px 20px;
		margin: 8px 0;
		box-sizing: border-box;
		border: none;
		background-color: #F08080;
		color: white;
	}
	
	input {
		
		padding: 12px 20px;
		margin: 8px 0;
		box-sizing: border-box;
		border: none;
		border-bottom: 2px solid LightGreen;
	}
	
		<title>Sisselogimise leht</title>
		</style>
	</head>
	<body>
		<h1 style="text-align:center;">Logi sisse</h1>
		<form method="POST" style = "text-align:center">
		
			<input placeholder = "E-mail" name="loginEmail" type="email">
			
			<br><br>
			
			<input placeholder = "Parool" name="loginPassword" type="password">
			
			<br><br>
			
			<input type="submit" value="Logi sisse">
			</form>
		<h1 style="text-align:center;">Loo kasutaja</h1>
		<form method="POST"  style = "text-align:center">
			
			<input placeholder="E-mail" name="signupEmail" type="email"> <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input placeholder="Parool" name="signupPassword" type="password"> <?php echo $signupPasswordError; ?>
			
			<br><br>
			
			<input type="submit" value="Loo kasutaja">