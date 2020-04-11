<?php 
	include_once("db.php");

	if (isset($_POST["username"]) && !empty($_POST["username"]) && 
		isset($_POST["password"]) && !empty($_POST["password"])){

		Login($_POST["username"], $_POST["password"]);
	}

	function Login($username, $password){
		GLOBAL $con;

		$sql = "SELECT id,username FROM users WHERE username=? AND password=?";
		$st=$con->prepare($sql);

		$st->execute(array($username, sha1($password)));//encrypt password
		$all=$st->fetchAll();
		if (count($all) == 1){
			echo "SERVER: ID#".$all[0]["id"]." - ".$all[0]["username"];
			exit();
		}

		//if username or password are empty strings
		echo "SERVER: error, invalid username or password";
		exit();
	}

	//if username or password is null (not set)
	echo "SERVER: error, enter a valid username & password";

	//exit():  means end server connection (don't execute the rest)
?>