<?php 
	// Connects to Database
	//mysql_connect("localhost", "xgamings_connact", "connactive123") or die(mysql_error()); //This is our database credentials
	mysql_connect("localhost", "root", "") or die(mysql_error()); 	//This is wamp database credentials
	mysql_select_db("xgamings_connactiv") or die(mysql_error()); 

	//Checks if there is a login cookie
	if(isset($_COOKIE['ID_my_site']))
	//if there is, it logs you in and directes you to the home page
	{ 
		$username = $_COOKIE['ID_my_site']; 
		$pass = $_COOKIE['Key_my_site'];
 	 	$check = mysql_query("SELECT * FROM users WHERE email = '$username'")or die(mysql_error());
		while($info = mysql_fetch_array( $check )) 	{
			if ($pass != $info['PASSWORD']) {
				//Cookie doesn't match password go to index";
				header("Location: ../index.html"); 
			}
			else{
				//Cookie matches, show what they want.";
				?>
				<script type="text/javascript">
				$('a.join').click(function() {
					t = confirm("Are you sure you want to join?");
					t == true? alert("Your request to join has been sent! The user will contact you if he/she approves.") : alert('No join request made.');
				});

				$('a.stream').click(function() {
					type = $(this).attr('id');
					alert("STUB: Sorting to display " +type.toUpperCase()+ " stream only");
				});

				$('div.post-author').click(function() {
					auth = $(this).text().trim();
					alert("STUB: Going to profile of " +auth.toUpperCase());
				});

				$('.top_links').removeClass('active');
				$('#home').addClass('active');

				</script>
					
				<div class="page">
					
					<h3>
					<a class="stream" id="public" href="#public-stream">Public Stream</a> | 
					<a class="stream" id="buddy" href="#buddy-stream">Buddy Stream</a>
					</h3>
					
						
					<div class="main feeds-container">
						<ul class="feeds">
							<li id="link_feeds_all"><a href="#">All</a></li>
							<li id="link_feeds_run"><a href="#">Running</a></li>
							<li id="link_feeds_pgh"><a href="#">Pittsburgh</a></li>
							<li id="link_feeds_bike"><a href="#">Biking</a></li>
							<li id="link_feeds_swim"><a href="#">Swimming</a></li>
							<li id="link_feeds_climb"><a href="#">Climbing</a></li>
						</ul>
						
							<div class="post"> <!-- begin post -->
								<div class="post-author">
									<img src="public/images/face1.png" height="120" /><br/>
									Anita Napp
								</div>
								<div class="post-body">
									<p>Needs a running buddy for tmw morning!  8am anyone?</p>
								<div class="post-levels">
									<p>I am a 6-7 seeking levels 4-8 accepting levels 3-8.</p>
									<p>Open to joiners | <a class="join" href="#">Ask to join</a></p>					
								</div><!-- begin tags -->
								<br/>
										Tags:
										<ul class="tags">
											<li>Running</li>
											<li>Pittsburgh</li>
										</ul><!-- end tags -->
								</div><!-- end post-body -->
							</div><!-- end post -->
						
							<div class="post"><!-- begin post -->
								<div class="post-author">
									<img src="public/images/face2.png" height="120"/><br/>
									Bob Kelly
								</div>
								<div class="post-body">
									<p>Going to the gym early tomorrow. Gonna get in a great morning workout!</p>
								<!-- begin tags -->
								<br/>
										Tags:
										<ul class="tags">
											<li>Gym</li>
											<li>Pittsburgh</li>
										</ul><!-- end tags -->
								</div><!-- end post-body -->
							</div><!-- end post -->
							
							
								<div class="post"> <!-- begin post -->
								<div class="post-author">
									<img src="public/images/face1.png" height="120"/><br/>
									Foo Bar
								</div>
								<div class="post-body">
									<p>Wants to play squash tomorrow morning at 10. Looking for a partner.</p>
								<div class="post-levels">
									<p>I am a 6-7 seeking levels 4-8 accepting levels 3-8.</p>
									<p>Open to joiners | <a class="join" href="#">Ask to join</a></p>			
								</div><!-- begin tags -->
								<br/>
										Tags:
										<ul class="tags">
											<li>Squash</li>
											<li>Minneapolis</li>
										</ul><!-- end tags -->
								</div><!-- end post-body -->
							</div><!-- end post -->
							
							
					</div><!-- end feed container -->
					
				</div><!-- end page-->
 			<?php
			}
 		}
	}
	else {	 
		//if they are not logged in";
		header("Location: ../index.html");
	}
?>