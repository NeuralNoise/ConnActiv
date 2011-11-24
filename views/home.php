<?php 
	include("config.php");

	if(cookieExists() && validCookie()):
	
		if (isset($_POST['postConnaction'])) {
			postConnaction();
		} else if (isset($_POST['joinRequest'])) { 
			joinRequest();
		}
	?>
	<script type="text/javascript">
		$('header').show();
		$('#side').show();
		$('#restOfBoxes').hide();

		$('a.stream').click(function() {
		type = $(this).attr('id');
		alert("STUB: Sorting to display " +type.toUpperCase()+ " stream only");
		});

		$('input.button').click(function() {
		alert("ConnAction submited to database! If it was to the Oakland network you can view it here: \nhttp://localhost/ConnActiv/views/connactions.php");
		});

		$('div.post-author').click(function() {
		auth = $(this).text().trim();
		alert("STUB: Going to profile of " +auth.toUpperCase());
		});

		$('.top_links').removeClass('active');
		$('#home').addClass('active');

		$('#startDate').datepicker();
		$('#endDate').datepicker();

		$('.joinExpander').click(function(){
		$(this).siblings('.expand').toggle();
		});

		$('#messageBox').click(function(){
			$('#restOfBoxes').slideDown();
		});
	</script>
				
			<div class="page">
				
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
			<div id="postConnaction">
				<div id="postHeader">
					<h2>Post a ConnAction</h2>
				</div>
				<div id="postBoxes">
					<div id="messageBox">
						Message: <textarea id="message" name="message" placeholder="Say what you're up to!" maxlength="4000"/>
					</div>
					<div id="restOfBoxes">
						Location: <textarea class="small" id="location" placeholder="Where?" name="location" maxlength="255"/>
						<br><br>
						Start Time: <input type="text" id="startDate"/> <select name="startHour">
							<option value="-1">Hour:</option>
							<?php
								for($i = 1; $i < 24; $i++){
									echo "<option value=\"",$i,"\">", $i, "</option>";
								}
							?>
							</select>:<select name="startMin">
							<option value="-1">Min:</option>
								<?php
								for($i = 1; $i < 60; $i++){
									echo "<option value=\"",$i,"\">", $i, "</option>";
								}
								?>
							</select>
						<br><br>
						End Time: <input id="endDate" type="text"/> <select name="endHour">
							<option value="-1">Hour:</option>
							<?php
								for($i = 1; $i < 24; $i++){
									echo "<option value=\"",$i,"\">", $i, "</option>";
								}
							?>
							</select>:<select name="endMin">
							<option value="-1">Min:</option>
								<?php
								for($i = 1; $i < 60; $i++){
									echo "<option value=\"",$i,"\">", $i, "</option>";
								}
								?>
							</select>
						<br><br>
						<select name="network">
							<option value="-1">Network:</option>
							<?php
								$networks = getNetworkNames();
								for($i = 0; $i < count($networks); $i++){
									echo "<option value=\"",getNetworkID($networks[$i]), "\">", $networks[$i], "</option>";
								}
							?>
						</select>
						<select name="activity">
							<option value="-1">Activity:</option>
							<?php
								$activities = getUserActivities();
								for($i = 0; $i < count($activities); $i++){
									echo "<option value=\"",getActivityID($activities[$i]), "\">", $activities[$i], "</option>";
								}
							?>
						</select>
						<select name="private">
							<option value="-1">Private:</option>
							<option value="0">No</option>
							<option value="1">Yes</option>
						</select>
						<td colspan="4"><input class="button" type="submit" name="postConnaction" value="Post this connaction!"/>
					</div>
				</div>
			</div>
			</form>
				
				<br/><br/>
				<h2>Stream</h2>				
					
				<div class="main feeds-container">
					<ul class="feeds">
						<li id="link_feeds_all"><a href="#">All</a></li>
						<?
						$networkNames = getNetworkNames();
						foreach ($networkNames as $network){
							?>
							<li id="link_feeds_<? $network; ?>"><a href="#"><? echo $network; ?></a></li>
							<?
						//}
						?>
					</ul>
					
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
					
					<? 
					$connactions = getConnactions(getNetworkID($network), 1);
					
					if ($connactions) {
					
					foreach($connactions as $post){
						$connactionID = $post[0];
						$userID = $post[1];
						$location = $post[2];
						$startTime = $post[3];
						$message = $post[4];
						$endTime = $post[5];
						$activityID = $post[6];
						$networkID = $post[7];
						$isPrivate = $post[8];
					?>					
						<div class="post"> <!-- begin post -->
							<div class="post-author">
								<img src="<? echo getUserPic($userID); ?>" height="120" /><br/>
								<? echo getName($userID) ?>
							</div>
							<div class="post-body">
								<p class="quote"><? echo $message; ?></p>
								<? echo date('l, F jS, Y h:i a'); ?>
							<div class="post-levels">
									I am a level <?php echo getActivityLevel($userID,$activityID, 3); ?>.
									I prefer level <?php echo getActivityLevel($userID,$activityID, 2); ?>.
									I accept levels <?php echo getActivityLevel($userID,$activityID, 0); ?>-
									<? echo getActivityLevel($userID,$activityID, 1); ?>.
								<br/>
								Open to joiners&nbsp;&raquo; 
										<span class="clickable joinExpander">Ask to join</span>
										<div class="expand" style="display:none">
											<input type="hidden" name="connactionID" value="<?= $connactionID?>"/>
											<input type="hidden" name="postingUserID" value="<?= $userID?>"/>
											<textarea name="message" maxlength="255" style="width:80%;" class="small" placeholder="Hi! I was hoping to join your activity."></textarea>
											<input type="submit" class="join" name="joinRequest" value="Send"/>
										</div>
									</form>					
							</div><!-- begin tags -->
							<br/>
									Tags:
									<ul class="tags">
										<li><?php echo getActivity($activityID); ?></li>
										<li><?php echo getNetworkName($networkID); ?></li>
									</ul><!-- end tags -->
							</div><!-- end post-body -->
						</div><!-- end post -->
		<?		}		//end foreach($post) ?> 				
				</div><!-- end feed container -->		
			</div><!-- end page-->
	<?  } // end foreach($network)
		else echo "<br/>No connactions yet!<br/><br/>";
	}
endif; ?>