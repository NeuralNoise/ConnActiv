<? include_once("config.php"); ?>

<!DOCTYPE HTML>
<html>
<head>
<title>ConnActiv | The place for activ people.</title>

<link rel="shortcut icon" type="image/x-icon" href="../public/images/favicon.ico">


<script type="text/javascript" src="../js/jquery.min.js"></script>
<link type="text/css" rel="stylesheet" href="../styles/defaults.css"/>

<link type="text/css" rel="stylesheet/less" href="../styles/style.less"/>
<link type="text/css" rel="stylesheet/less" href="../styles/posts.less"/>
<link type="text/css" rel="stylesheet/less" href="../styles/sidebar.less"/>
<link type="text/css" rel="stylesheet" href="../styles/demo_table.css"/>
<link type="text/css" rel="stylesheet" href="../styles/validationEngine.jquery.css" />

<script type="text/javascript" src="../js/less.min.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.mini.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine-en.js" charset="utf-8"></script>
<script type="text/javascript" src="../js/jquery.validationEngine.js" charset="utf-8"></script>

<link href='http://fonts.googleapis.com/css?family=Reenie+Beanie' rel='stylesheet' type='text/css'>

<script type="text/javascript">
	$(document).ready(function(){
		$('#side').load('sidebar.php');
	});
</script>

</head>
<body>

<div id="container">

	<header>

	<a id="user_login" href="#"><? echo getName(); ?>&nbsp;&raquo;</a>
	
	<div id="user_menu" class="signout_opt" style="display:inline; padding: 2px 2px; width: 60px; text-align: left; color: #fff;">
		<a href="logout.php" id="logout">Sign out</a>
	</div>

			<span id="top-nav">
				<ul id="nav">
					<li class="headerlink" id="link_home"><a class="top_links" id="home" href="home.php">Home</a></li>
					<li class="headerlink" id="link_profile"><a class="top_links" id="profile" href="profile.php">Profile</a></li>
					<li class="headerlink" id="link_requests"><a class="top_links" id="requests" href="requests.php">Requests</a></li>
					<li class="headerlink" id="link_settings"><a class="top_links" id="settings" href="settings.php">Settings</a></li>
				</ul>
			</span>

	</header>
		
	<div id="side">
	</div><!-- end #side -->
	
	<div id="content">