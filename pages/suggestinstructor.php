
<h4><font size='+2'>Suggest an Instructor</font></h4>



<?php

global $table_suggestinstructor, $website_giverespect, $website_respectsuggest;

if ( $context[ 'user' ][ 'is_logged' ] ) 
{
	$respect = GetRespectPoints( $context[ 'user' ][ 'id' ] );
	
	if( $respect < $website_respectsuggest )
	{
		$rem = $website_respectsuggest - $respect;
		
		
		echo "<br><p>Dear " . $context[ 'user' ][ 'name' ]  . ", your total respect is (<b>" . $respect . "</b>) and you need <b><u>" . $rem . "</u></b> more respect points before you can suggest an instructor. Rate more instructors in order to receive more respect points. You receive <b>" . $website_giverespect . "</b> for rating an instructor and you can also give/take respect points in <a href='http://your-forum.example.com/index.php?action=forum'>discussion</a> forum.</p>";
		
		
		return 1;
	}
	

        if ( !isset( $_POST[ 'submit' ] )) // show form if not submitted
        { 			
				$query = "SELECT `waittime` FROM `" . $table_suggestinstructor . "` WHERE `whosubmit` = '". $context[ 'user' ][ 'id' ] . "' ORDER BY `timestamp` DESC LIMIT 1";
			
				$result = mysql_query( $query ) or die( mysql_error( ) ) ;
				$IsSubmitExist = mysql_num_rows( $result ); 
				
				if( $IsSubmitExist ) // we want this guy to wait
				{
					$row = mysql_fetch_assoc( $result ) or die( mysql_error( ) ) ;
					{
						$waittime = $row[ 'waittime' ];
						
					}
					
					$currenttime = time( ) ;
					
					$checktime = $currenttime - $waittime;
					
					//echo "$checktime: $currenttime - $waittime";
					
					$howlongwait = 1800; // 30min * 60sec = 30 minutes = 1800 seconds
					
					$actualmin = $howlongwait - $checktime;
					
					$actualmin = $actualmin / 60;
					
					$actualmin = round( $actualmin, 1 );
					
					if ( $checktime <= $howlongwait )
					{
						echo "<p>You must wait " . $actualmin . " minute(s) before you can submit another information.</p>";
						return 1;
					}
					
					
					
				}
		?>
			
                    <p>Here you can submit information about instructor you would like to add to the database. We will add them once we approve your submission. Try to add as much information as you can about the instructor in order to have more chances to get them added. Following are the information you should consider submitting:</p>
                    
                  <ul>
                  <li>E-mail</li>
                  <li>Office Room</li>
                  <li>Courses they teach</li>
                  <li>Department</li>
                  <li>College of B/E or A/S</li>
                  <li>Male or Female etc...</li>
                </ul>
                    
                    
                    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
                
                  <div class="form_settings">
                  
                  
                    <p><span>Your ID</span><input type="text" name="userid" value="<?php echo $context[ 'user' ][ 'id' ] ?>" readonly /></p>
                    <p><span>Instructor's name</span><input type="text" name="insname" value="" /></p>
                    <p><span>Information about the instructor</span><textarea rows="15" cols="50" name="insinfo"></textarea></p>
                    
                    <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="submit" value="Submit" /></p>
                  
                  
                  </div>
                
                </form>
            
		
		
<?php  	}
        else// process into mysql
		{
			
			$whosubmit = $_POST[ 'userid' ];
			$insname = $_POST[ 'insname' ];
			$insinfo = $_POST[ 'insinfo' ];
			$ip = getUserIP( );
			
			if( empty( $whosubmit ) || empty( $insname ) || empty( $insinfo ) ) 
			{
				echo "<p>Error: Incomplete Information... Please <a href='javascript:history.back()'>go back</a> and fix it.</p>";
			}
			elseif( strlen( $insname ) < 5 ) 
			{
				echo "<p>Error: Instructor name too short. Please <a href='javascript:history.back()'>go back</a> and fix it.</p>";
				
			}
			elseif( strlen( $insname ) > 30 ) 
			{
				echo "<p>Error: Instructor name too long. Please <a href='javascript:history.back()'>go back</a> and fix it.</p>";
				
			}
			elseif( strlen( $insinfo ) < 55 )
			{
				echo "<p>Error: Instructor information too short. Please <a href='javascript:history.back()'>go back</a> and fix it.</p>";
				
			}
			elseif( strlen( $insinfo ) > 245 )
			{
				echo "<p>Error: Instructor information too long. Please <a href='javascript:history.back()'>go back</a> and fix it.</p>";
				
			}
			else // after passing through the above filter;
			{
				
				echo '<table style="width:100%; border-spacing:0; border: 1px solid black;">';
				
				echo '<tr><td><strong>Instructor Name:</strong></td><td>' . $insname . '</td></tr>';
				echo "<tr><td><strong>Information</strong></td><td>" . $insinfo . "</td></tr>";
				
				echo "</table>";
				
					/*	$due_date = strtotime('July 4, 2014 00:33 PM');

						if($due_date > time()) 
						{
							$rem = $due_date - time();
							$day = floor($rem / 86400);
							$hr  = floor(($rem % 86400) / 3600);
							$min = floor(($rem % 3600) / 60);
							$sec = ($rem % 60);
					echo "$day Days $hr Hours $min Minutes $sec Seconds Remaining..."; // Timer still has time to go.
						} 
						else 
						{
					echo "0 Days 0 Hours 0 Minutes 0 Seconds Remaining..."; // Timer is finished, now at 00:00:00
						}*/
				
				
				$insname = mysql_escape_string( $insname );
				$insinfo = mysql_escape_string( $insinfo );
				
				$time = time( );
	
				$query = "INSERT INTO " . $table_suggestinstructor . " (whosubmit, insname, insinfo, ip, waittime) VALUES ('$whosubmit', '$insname', '$insinfo', '$ip', '$time')";
						
				$result = mysql_query( $query ) or die( mysql_error( ) ) ;
				
				GiveRespect( $whosubmit );
				
				
				echo "<p>You have <b>received (" . $website_giverespect . ") respect points</b> for suggesting this instructor.";
				
				echo " <b>Thank you</b> for submitting this information. We will survey your information and upon approval, your suggested instructor will be added.</p>";
			
			}
        
		}

}
else // if not logged in
{
	echo "<p>Error. You need to login or register before you can add instructors.</p>";
}



?>
        