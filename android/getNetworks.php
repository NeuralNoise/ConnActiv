<? 
	include("../views/functions/config.php");

	$unique = getAllUniqueNetworks();
	foreach($unique as $un) {
		echo $un[1] .", ". $un[2]." | ".$un[3] ."&";
	}
?>