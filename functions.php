<?php
	require("../../config.php");
	
	session_start(); 
	
	$database = "if16_karokrii";
	
	function signup($email, $password) {
		
		$mysqli = new mysqli(
		
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"],  
		$GLOBALS["serverPassword"],  
		$GLOBALS["database"]
		
		);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password );
		if ( $stmt->execute() ) {
			echo "salvestamine õnnestus";	
		} else {	
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	function login($email, $password) {
		
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email, password FROM user WHERE email = ?");
		
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb);
		$stmt->execute();
		if ($stmt->fetch()) {
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				echo "Kasutaja ".$id." logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				header("Location: data.php");
				exit();
			} else {
				$notice = "Vale parool!";
			}
		} else {
			$notice = "Sellist emaili ei ole!";
		}
		
		return $notice;
	}
	
	function saveMusic($title, $lyrics, $keywords) {
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO music (title, lyrics, keywords) VALUES (?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("sss", $title, $lyrics, $keywords );
		if ( $stmt->execute()) {
			echo "salvestamine õnnestus";	
		} else {	
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
	}
	
	function getAllMusic() {
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, title, lyrics, ketword FROM music");
		echo $mysqli->error;
		
		$stmt->bind_result($id, $title, $lyrics, $keywords);
		$stmt->execute();
		
		$result = array();
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}
		
		
		
		
?>