<?php
	//var_dump($_POST);
	// Connects to Database
	//mysql_connect("localhost", "xgamings_connact", "connactive123") or die(mysql_error()); //This is our database credentials
	mysql_connect("localhost", "root", "") or die(mysql_error()); 	//This is wamp database credentials
	mysql_select_db("xgamings_connactiv") or die(mysql_error()); 

include("functions_recommendations.php");

	function cookieExists(){
		//Check to see if user ID cookie exists
		if(isset($_COOKIE['ID_my_site']))
			return TRUE;
		else
			return FALSE;
	}
	function validCookie(){
		//Check to make sure the user ID cookie matches the password cookie
		$username = $_COOKIE['ID_my_site']; 
		$pass = $_COOKIE['Key_my_site'];
		$info = getDatabaseInfo("users", "email", $username);
		//while($info = getDatabaseInfo("users", "email", $username)) 	{ 		//Since we have unique cookies I do not think we need to have this
																//loop. Can anyone confirm?
			if ($pass != $info['PASSWORD']) {
				//ID cookie doesn't match password cookie
				return FALSE;
			}
			else{
				//ID cookie matches, password cookie
				return TRUE;
 			}
		//}
	}
	function login(){
		//This function logs in the user when they press the login button
		// makes sure they filled it in
		if(!$_POST['username'] | !$_POST['pass']) {
			die('You did not fill in a required field.');
		}
		// checks it against the database
		//if (!get_magic_quotes_gpc()) {
		//	$_POST['email'] = addslashes($_POST['email']);		//I do not know where this came from. Did you add it dave?
		//}
		$check = mysql_query("SELECT * FROM users WHERE email = '".$_POST['username']."'")or die(mysql_error());
		//Gives error if user dosen't exist
		$check2 = mysql_num_rows($check);
		if ($check2 == 0) {
			die('That user does not exist in our database. <a href=registration.php>Click Here to Register</a>');
		}
		while($info = mysql_fetch_array( $check )) 	
		{
			$_POST['pass'] = stripslashes($_POST['pass']);
			$info['PASSWORD'] = stripslashes($info['PASSWORD']);
			$_POST['pass'] = md5($_POST['pass']);
			//gives error if the password is wrong
			if ($_POST['pass'] != $info['PASSWORD']) {
				die('Incorrect password, please try again.');
			}
			else { 
			// if login is ok then we add a cookie 
			 $_POST['username'] = stripslashes($_POST['username']);
			 $hour = time() + 100000;
			setcookie('ID_my_site', $_POST['username'], $hour);
			setcookie('Key_my_site', $_POST['pass'], $hour);
			//then redirect them to the members area 
			header("Location: ../index.html");
			} 
		}
	}
	function register(){
	//This function registers the user when they press the register button
	//check to make sure the required fields were filled in.
		if(!$_POST['username'] || !$_POST['password'] || !$_POST['confirm'] ||!$_POST['city']) {
			die('You did not fill in a required field.');
		}
		//check to make sure the email is not already registered.
		$check = mysql_query("SELECT * FROM users WHERE email = '".$_POST['username']."'")or die(mysql_error());
		$check2 = mysql_num_rows($check);
		
		
		//if email has not been registered before
		if($check2 == 0){
			//check to make sure the password was confirmed			
			if(strcmp($_POST['password'], $_POST['confirm'])==0){			
				//check to make sure the password is longer than 6 characters, may want to use regexp to improve
				//security				
				
				//echo "inside the password length check";
				//get userid of new user since the user_id is auto incremented and will not be explicitly added.
				$userid = mysql_query("select max(user_id) from users") or die(mysql_error());
				$userid1 = mysql_fetch_array($userid);					
				$userid2 = (int)$userid1['0'] + 1;				
				//insert information into users tables.
				$query = "Insert into users(user_id, email,first_Name, last_Name, Street, city, state, zip, phone, interests, password)  values(".$userid2.",'".$_POST['username']."','".$_POST['firstName']."','".$_POST['lastName']."','".$_POST['street']."','".$_POST['city']."','".$_POST['state']."','".$_POST['zip']."','".$_POST['phone']."','".$_POST['interests']."','".md5($_POST['password'])."')";
				$insert = mysql_query($query) or die(mysql_error());
				
				//If the network doesn't already exist, add it to the networks table.
				$checkNetwork = mysql_query("Select network_id from networks where area = '".$_POST['city']."'") or die(mysql_error());				
				$checkNetwork1 = mysql_fetch_array($checkNetwork);
				var_dump($checkNetwork1);
				$networkid = (int)$checkNetwork1[0];
				if(mysql_num_rows($checkNetwork) == 0){
					addNetwork($_POST['city']);
				}	
				
				
				//insert all of the user selected activities into the user_activities table and unique networks if needed.	
				$acts = $_POST['activities'];
				var_dump($acts);							
				$i = 0;				
				while($i < sizeof($acts)){
					
					$activityid = mysql_query("select activity_id from activities where activity_name = '".$acts[$i]."'") or die(mysql_error());
					$activityid1 = mysql_fetch_array($activityid);
					
					addUserActivity($userid2, $activityid1[0]);
					
					
					

					//check and insert into unique networks table
					var_dump($activityid1);
					$checkUniqueNetworks = mysql_query("select unique_network_id from unique_networks where network_id = ".(int)$networkid." and activity_id = ".(int)$activityid1[0]) or die(mysql_error());
					$uniqueN = mysql_fetch_array($checkUniqueNetworks);
					$uniqueID = $uniqueN[0];
					//if there is no record for the unique network, insert it and overwrite the uniqueID variable
					if(mysql_num_rows($checkUniqueNetworks) == 0){
						
						addUniqueNetwork($networkid, $activityid1[0]);
					}
					//add to user_networks
					addUserNetwork($userid2, $uniqueID);
					
	
					$i++;					
					
								
				}

				//create cookie
				$_POST['username'] = stripslashes($_POST['username']); 
				$hour = time() + 100000; 
				setcookie(ID_my_site, $_POST['username'], $hour); 
				setcookie(Key_my_site, md5($_POST['password']), $hour);
				//redirect to home				
				header("Location: ../index.html");
				
			}	
			//if the passwords do not match ask them to enter the information again
			else{ die("the passwords do not match, please re-enter your information");}
		}
		//if the email is already registered then display message
		else{
			die('This email has already been registered.  click here if you forgot your password.');
		}
	}


	function addUserNetwork($userid, $uniqueID){
		$insert = mysql_query("insert into user_networks values(".$userid.",".$uniqueID.")") or die(mysql_error());

	}

	function addUniqueNetwork($networkID, $activityID){
		$getnextid = mysql_query("select max(unique_network_id) from unique_networks") or die(mysql_error());
		$nextID = mysql_fetch_array($getnextid);
		$uniqueID = (int)$nextID[0];
		$uniqueID++;
		$insertUN = mysql_query("insert into unique_networks values(".(int)$uniqueID.", ".(int)$networkID.", ".(int)$activityID.")") or die(mysql_error());
	}	

	function addNetwork($area){
		$getnextid = mysql_query("Select max(network_id) from networks") or die(mysql_error());
		$getnextid1 = mysql_fetch_array($getnextid);
		$networkid = (int)$getnextid1[0];
		$networkid++;
					
		$insert = mysql_query("insert into networks values(".$networkid.",'".$area."')") or die(mysql_error());		
	}
	function addUserActivity($userid, $activityid){
		$insert = mysql_query("Insert into user_activities(user_id, activity_id) values(".(int)$userid.",".(int)$activityid.")") or die(mysql_error());
}
	function postConnaction(){
	
	/*
	**
	* HEY ROBBBBBER ROB can you fix this so it takes the date the way datepicker inputs it? KCOOOOOL -Kim
	*
	**
	*/
	
		//This function will post the connaction to the database!
		$startTime = getCurYear()."-".getCurMonth(1)."-".$_POST['startDay']." ".$_POST['startHour'].":".$_POST['startMin'].":00";
		$endTime = getCurYear()."-".getCurMonth(1)."-".$_POST['endDay']." ".$_POST['endHour'].":".$_POST['endMin'].":00";
		
		
		$query = "INSERT INTO connactions(USER_ID, LOCATION, START_TIME, MESSAGE, END_TIME, ACTIVITY_ID, NETWORK_ID, IS_PRIVATE)
			VALUES ('".getUserID()."', '".$_POST['location']."', '".$startTime."', '".$_POST['message']."', '".$endTime."'
					, '".$_POST['activity']."', '".$_POST['network']."', '".$_POST['private']."')";
					
		$insert = mysql_query($query) or die(mysql_error());
		header("Location: ../index.html");
	}
	function getDatabaseInfo($table, $attribute, $value){
		//Returns an array of strings that corresponds to the fetched row
		$check = getResourceIDs($table, $attribute, $value); 
		
		return mysql_fetch_array($check);
	}
	function getResourceIDs($table, $attribute, $value){
		//This function returns resource IDs
		
		$check = mysql_query("SELECT * FROM $table WHERE $attribute = '$value'")or die(mysql_error()); //retuns true if you do not assign
		return $check;																				   //mysql_query() to a variable
	}
	function getResourceIDs2($table, $attribute1, $value1, $attribute2, $value2){
		//This function returns resource IDs
		
		$check = mysql_query("SELECT * FROM $table WHERE $attribute1 = '$value1' AND $attribute2 = '$value2'")or die(mysql_error()); //retuns true if you do not assign
		return $check;																				   //mysql_query() to a variable
	}
	function getName(){
		//This function returns the users First and Last name
		if(cookieExists())
		//if there is a username cookie, we need to check it against our password cookie
		{
			if (validCookie()) {
				//Cookie matches display their name
				$username = $_COOKIE['ID_my_site'];
				$info = getDatabaseInfo("users", "email", $username);
				return $info['FIRST_NAME'] . " " . $info['LAST_NAME'];
			}
		}
	}
	function getUserID(){
		//This function retusn the users ID
		if(cookieExists())
		//if there is a username cookie, we need to check it against our password cookie
		{
			if (validCookie()) {
				//Cookie matches display their name
				$username = $_COOKIE['ID_my_site'];
				$info = getDatabaseInfo("users", "email", $username);
				return $info['USER_ID'];
			}
		}
	}
	function getUserPic($userID){
		$info = getDatabaseInfo("users", "user_id", $userID);
		return $info['PROFILE_PIC'];
	}
	function getActivity($activityID){
		//This function returns the name of the inputed activity ID
		
		$activity = getDatabaseInfo("activities","activity_id", $activityID);
		$activityName = $activity['ACTIVITY_NAME'];
		
		return $activityName;
	}
	function getActivityID($activityName){
		//This function returns the ID value of the activity name that is inputed
		
		$activity = getDatabaseInfo("activities","activity_name", $activityName);
		$activityID = $activity['ACTIVITY_ID'];
		
		return $activityID;
	}
	function getActivityLevel($userID, $activityID, $num){
		//This returns an activity level of the given user in a given activity based on num
		//		0 = low level
		//		1 = high level
		//		2 = preferred
		//		3 = own level
		//		4 = all
		$activityLevels = array();
		
		$resourceID = getResourceIDs2("user_activities", "user_id", $userID, "activity_id", $activityID);
		$info = mysql_fetch_array($resourceID);
		$activityLevels[] = $info["LOW_LEVEL"];
		$activityLevels[] = $info["HIGH_LEVEL"];
		$activityLevels[] = $info["PREFERRED"];
		$activityLevels[] = $info["OWN_LEVEL"];
		if($num == 0){
			//return low level
			return $activityLevels[0];
		}
		else if($num == 1){
			//return high level
			return $activityLevels[1];
		}
		else if($num == 2){
			//return preferred
			return $activityLevels[2];
		}
		else if($num == 3){
			//return own level
			return $activityLevels[3];
		}
		else if($num == 4){
			//return all
			return $activityLevels;
		}
		else{
			//return error
			return "error";
		}
	}
	function getNetworkID($networkName){
		//This function returns the ID value of the network name that is inputed
		
		$network = getDatabaseInfo("networks","area", $networkName);
		$networkID = $network['NETWORK_ID'];
		
		return $networkID;
	}
	function getNetworkName($networkID){
		//This function retuns the network name of the network ID that is inputed
		
		$network = getDatabaseInfo("networks", "network_id", $networkID);
		$networkName = $network['AREA'];
		
		return $networkName;
	}
	function getNetworkNames(){
		//This function returns an array of user's network names
		$userID = getUserID();
		$networkName = array();
		$resourceID = getResourceIDs("user_networks", "user_id", $userID);
		while($info = mysql_fetch_array($resourceID)){
			$uniqueNetwork = getDatabaseInfo("unique_networks","unique_network_id", $info['UNIQUE_NETWORK_ID']);
			$networkID = $uniqueNetwork['NETWORK_ID'];
			$networkName[] = getNetworkName($networkID);
		}
		
		return $networkName;
	}
	function getAllNetworkActivites(){
		//This function returns an array of all network activities
		$networkNames = getNetworkNames();
		$networkActivities = array();
		
		for($i = 0; $i < count($networkNames); $i++){
			$networkID = $networkNames[$i];
			$resourceID = getResourceIDs("unique_networks", "network_id", $networkID);
			while($info = mysql_fetch_array($resourceID)){
				$activity = getDatabaseInfo("activities","activity_id", $info['ACTIVITY_ID']);
				$networkActivities[] = $activity['ACTIVITY_NAME'];
			}
		}
		return $networkActivities;
	}
	function getNetworkActivites($networkName){
		//This function returns an array of activities in a given network
		$networkActivities = array();
		$networkID = $networkName;
		$resourceID = getResourceIDs("unique_networks", "network_id", $networkID);
		while($info = mysql_fetch_array($resourceID)){
			$activity = getDatabaseInfo("activities","activity_id", $info['ACTIVITY_ID']);
				$networkActivities[] = $activity['ACTIVITY_NAME'];
		}
		return $networkActivities;
	}
	function getUserNetworkActivities(){
		//This function returns an array of the user's networks and activites
		$userID = getUserID();
		$userActivities = array();
		$oldNetwork = null;
		
		$resourceID = getResourceIDs("user_networks", "user_id", $userID);
		while($info = mysql_fetch_array($resourceID)){
			$uniqueNetworkID = getDatabaseInfo("unique_networks","unique_network_id", $info['UNIQUE_NETWORK_ID']);
			$networkID = $uniqueNetworkID['NETWORK_ID'];
			$network = getNetworkName($networkID);
			$activityID = $uniqueNetworkID['ACTIVITY_ID'];
			$activity = getActivity($activityID);
			if($oldNetwork != $network){
				//this prevents multiple network names to be stored in the array.
				$UsersNetworkActivities[] = $network;
			}
			$UsersNetworkActivities[] = $activity;
			
			$oldNetwork = $network;
			
		}
		return $UsersNetworkActivities;
		
	}
	function getUserActivities(){
		//This function returns an array of all the activities a user has
		$userID = getUserID();
		$userActivities = array();
		
		$resourceID = getResourceIDs("user_activities", "user_id", $userID);
		while($info = mysql_fetch_array($resourceID)){
			$activity = getDatabaseInfo("activities", "activity_id", $info['ACTIVITY_ID']);
			$userActivities[] = $activity['ACTIVITY_NAME'];
		}
		return $userActivities;
	}
	
	/*		///This function was replaced by the getConnactions functions
	function getConnactionUsers($n_aID, $option){
		//The option is whether the ID is network_ID or Activity_ID
		//0 = Activity_ID, 1 = network_ID
		//This function returns an array of all users names who posted a connaction
		$connactionUsers = array();
		
		if($option == 0){
			//ID is activity
			$resourceID = getResourceIDs("connactions", "activity_id", $n_aID);
			while($info = mysql_fetch_array($resourceID)){
				$connactionUsers[] = $info["USER_ID"];
			}
			return $connactionUsers;
		}
		else if($option == 1){
			//ID is network
			//print $n_aID;
			$resourceID = getResourceIDs("connactions", "network_id", $n_aID);
			while($info = mysql_fetch_array($resourceID)){
				$connactionUsers[] = $info["USER_ID"];
			}
			return $connactionUsers;
		}
		else{
			return "error";
		}
		
	}*/
	
	function getConnactions($n_aID, $option){
		//The option is whether the ID is network_ID or Activity_ID
		//0 = Activity_ID, 1 = network_ID
		//This function returns an array of all users names who posted a connaction
		$connactionUsers = array();
		
		if($option == 0){
			//ID is activity
			$resourceID = getResourceIDs("connactions", "activity_id", $n_aID);
			while($info = mysql_fetch_array($resourceID)){
				$connactionUsers[] = $info;
			}
			return $connactionUsers;
		}
		else if($option == 1){
			//ID is network
			//print $n_aID;
			$resourceID = getResourceIDs("connactions", "network_id", $n_aID);
			while($info = mysql_fetch_array($resourceID)){
				$connactionUsers[] = $info;
			}
			return $connactionUsers;
		}
		else{
			return "error";
		}
	}
	function printArray($array){
		//This function echos the passed in array
		for($i = 0; $i < count($array); $i++){
			echo $array[$i];
		}
	}
	function getCurYear(){
		$today = getdate();
		
		return $today["year"];
	}
	function getCurMonth($condition){
		//This function returns the current month
		// 0 = the word
		// 1 = the number
		$today = getdate();
		
		//return $today;
		if($condition == 0){
			return $today["month"];
		}
		else if($condition == 1){
			return $today["mon"];
		}
		else{
			return -1;
		}
	}
	function getCurDay(){
		//This function returns the current day
		$today = getdate();
		
		return $today["mday"];
	}
	function getCurHour(){
		//This function returns the current hour
		$today = getdate();
		
		return $today["hours"];
	}
	function getCurMin(){
		//This function returns the current hour
		$today = getdate();
		
		return $today["minutes"];
	}
	function getDays($month){
		//This function returns the total days in a month
		//30 sept april june nov
		if($month == 1){
			return 31;
		}
		else if($month == 2){
			return 28;
		}
		else if($month == 3){
			return 31;
		}
		else if($month == 4){
			return 30;
		}
		else if($month == 5){
			return 31;
		}
		else if($month == 6){
			return 30;
		}
		else if($month == 7){
			return 31;
		}
		else if($month == 8){
			return 31;
		}
		else if($month == 9){
			return 31;
		}
		else if($month == 10){
			return 31;
		}
		else if($month == 11){
			return 30;
		}
		else if($month == 12){
			return 31;
		}
		else{
			return -1;
		}
	}
?>