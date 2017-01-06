<?php
	session_start(); 
	
	$database = "if16_karokrii";
	
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