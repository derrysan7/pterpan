<?php

	session_start();
	
	require_once 'classes/class.user.php';
	$session = new USER();
	
	// if user session is not active(not loggedin) this page will help 'home.php and profile.php' to redirect to login page
	// put this file within secured pages that users (users can't access without login)
	$userId = $_SESSION['user_session'];
      
      $stmt = $session->runQuery("SELECT * FROM users WHERE userId=:userId");
      $stmt->execute(array(":userId"=>$userId));
      
      $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

      if(!$session->is_loggedin() or $userRow['NamaPermission'] != "isAdmin")
      {
      	$session->redirect('index.php');
      } 