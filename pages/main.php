<h4><font size='+2'>Welcome to RateMyInstructor</font></h4>

<p><?php echo $website_description; ?></p>
    
    <h4><font size='+2'>Recent Ratings</font></h4>
	<?php //h2h5p
	
	global $table_rate, $smf_members;
	
	$numberofrecentratings = $website_maxrecentratings;
	
	
	$query = "SELECT rater_id, ins_id, rate, lod FROM `" . $table_rate . "` WHERE `rate` <= " . $website_maxrating . " ORDER BY id DESC";
	
	$result = mysql_query( $query ) or die( mysql_error( ) ) ;
	
	$IsRatingExist = mysql_num_rows( $result ); 
	
	$countrecentratings = 0;
	
	if( $IsRatingExist )
	{
		$countrecentratings = $IsRatingExist;
		
		echo '<table style="width:100%; border-spacing:0; border: 1px solid black;">';
		echo '<tr><th>No.</th><th>Rated By</th><th>Instructor</th><th>Level of Difficulty</th><th>Rating</th><th></th></tr>';
		
		
		while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) ) 
		{
			if( $numberofrecentratings <= 0 )
			{
				break;
			}
			else
			{
				
				$ratedid = $row[ 'rate' ]; 
				
				if( $ratedid > $website_maxrating )
				{
					$ratedid = $website_maxrating;
				}
			
					?>
			
				<tr><td><?php echo $IsRatingExist; ?></td><td><?php echo ratername( $row[ 'rater_id' ] ); ?></td><td><a href="index.php?page=instructor&name=<?php echo insname( $row[ 'ins_id' ] ); ?>" class="ins"><?php insname( $row[ 'ins_id' ] ); ?></a></td><td><?php echo getlodname( $row[ 'lod' ] ); ?></td><td><?php echo getratename( $ratedid ); echo " (" . $ratedid . "/" . $website_maxrating . ")<br><br>"; ?></td><td><?php generatestars( $ratedid ); ?></td></tr>
			
			
					<?php 
		
				$numberofrecentratings--;
				$IsRatingExist--;
			
			}
			
			
		
		}
		
		echo "</table>";
	}
	else
	{
		//echo "There are no ratings in the database.";
	}
	
	
	
	//echo "There are <strong>" . $countrecentratings . "</strong> " . AddS( $countrecentratings, 'rating', 's' ) . " in database.
	
	//echo "<br>";
	
	
	
	echo "<h4><font size='+2'>Most Respected Members</font></h4>";
	
	echo "Following are the members who have contributed to this community the most.";
	
	
	$query = "SELECT id_member, real_name, karma_good, posts FROM " . $smf_members . " ORDER BY karma_good DESC LIMIT 5";
	
	$result = mysql_query( $query ) or die( mysql_error( ) ) ;
	
	$IsMemberExist = mysql_num_rows( $result ); 
	
	$count = 0;
	
	if( $IsMemberExist )
	{
		
		echo '<table style="width:100%; border-spacing:0; border: 1px solid black;">';
	//	echo '<table style="width:100%;">';
		echo '<tr><th>Rank #</th><th>Name</th><th>Respect Points</th><th>Total Posts</th><th>Total Instructors Rated</th></tr>';
		
		
		while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) ) 
		{
			$count++;
			
			echo "<tr><td><center>" . $count . "</center></td><td><a href='http://your-forum.example.com/index.php?action=profile;u=" . $row[ 'id_member' ] . "' class='ins'>" . $row[ 'real_name' ] . "</a></td><td>" . $row[ 'karma_good' ] . "</td><td>" . $row[ 'posts' ] . "</td><td><center>" . GetTotalRatedInstructors( $row[ 'id_member' ] ) . "</center></td></tr>";
			
			
		}
		
		echo "</table>";
	
	
	}
	else
	{
		echo "There are no respected members in database.";
	}
	
	//echo "<br>";
	
	echo "<h4><font size='+2'>Statistics</font></h4>";
	
	echo '<table style="width:100%; border-spacing:0; border: 1px solid black;">';
	
	echo '<tr><th>Stats</th><th>Info</th></tr>';
	
	echo "<tr><td><b>Total Number of Ratings</b></td><td>" . $countrecentratings . "</td></tr>";
	
	echo "<tr><td><b>Total Number of Instructors</b></td><td>" . TotalNumberofInstructors( ) . "</td></tr>";
	
	//echo "<tr><td><b>Lowest Score of an Instructor</b></td><td>" . TotalNumberofInstructors( ) . "</td></tr>";
	
	//echo "<tr><td><b>Highest Score of an Instructor</b></td><td>" . TotalNumberofInstructors( ) . "</td></tr>";
	
//	echo "<tr><td><b>Mostly Rated of an Instructor</b></td><td>" . TotalNumberofInstructors( ) . "</td></tr>";
	
	
	echo "</table>";
	
	?>