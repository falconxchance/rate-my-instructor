<?php

global $table_rate, $website_giverespect;

if ( !isset( $_POST[ 'submit' ] ) || $context[ 'user' ][ 'is_guest' ] )
{
	echo "<p>Error: You're not logged in or you've landed accidentaly to this page.</p>";
	echo "<meta http-equiv='Refresh' content='1;url=index.php?page=myratings' />";
}
else
{
	$instructorid = $_POST[ '_insid' ]; // req!!!!
	$raterid = $_POST[ '_raterid' ]; // reqq!!!!!!
	
	if( $raterid != $context[ 'user' ][ 'id' ] ) // hack proof
	{
		echo "FUCKING HACKER.";
		exit;
	}
	
	// check for existing rate
	
	$query = "SELECT rater_id FROM `" . $table_rate . "` WHERE `ins_id` = '" . $instructorid . "' AND `rater_id` = '" . $context[ 'user' ][ 'id' ] . "' LIMIT 1";
			
	$result = mysql_query( $query ) or die( mysql_error( ) ) ;
	$IsRateExist = mysql_num_rows( $result ); 
		
	if( $IsRateExist ) // we dont want more than 1 rate so
	{	
			echo "<h4><font size='+2'>Error: You can't rate "; insname( $instructorid ); echo ".</font></h4>";

			echo "You have already rated this instructor before.";
	}
	else
	{
		
		
		$rate = $_POST[ 'rate_group1' ] ;
		$lod = $_POST[ 'lod_group2' ];
		$textbook = $_POST[ 'textbook' ];
		$takeagain = $_POST[ 'takeagain' ];
		$attendance = $_POST[ 'attendance' ];
		$grades = $_POST[ 'grades' ];
		$tags = $_POST[ 'tags' ];
		$course = $_POST[ 'course' ];
		$comment = $_POST[ 'comment' ];
		$test_format = $_POST[ 'test_info_group3' ];
		
		$ipaddress = getUserIP();
		
		
		$error_text_1 = "<h4><font size='+2'>Error occured while rating ";
		
		ob_start( );
		
		insname( $instructorid );
			
		$str = ob_get_contents( );
		
		ob_end_clean( );
		
		//echo $str;
			
		$error_text_2 = ".</font></h4><br><br>";
		
		$error_text = $error_text_1 . $str . $error_text_2;
		
		//////////////
		
		if( !isset( $instructorid ) || !isset( $raterid ) ) // hack proof
		{
			echo "<p>Error: No instructor or rater found.</p>";
			echo "<meta http-equiv='Refresh' content='1;url=index.php?page=myratings' />";
		}
		elseif( !isset( $rate ) || $rate < 1 || $rate > $website_maxrating ) // ?? hack proof
		{
			echo $error_text;
			
			echo "<p>Please <a href='javascript:history.back()'>go back</a> and select one of the options from 'RATE'.</p>";
		}
		elseif( !isset( $lod ) || $lod < 1 || $lod > $website_maxlod ) // ?? hack proof
		{
			echo $error_text;
			
			echo "<p>Please <a href='javascript:history.back()'>go back</a> and select one of the options from 'LEVEL OF DIFFICULTY'.</p>";
		}
		elseif( !isset( $test_format ) || $test_format > 5 || $test_format < 1 )
		{
			echo $error_text;
			
			echo "<p>Please <a href='javascript:history.back()'>go back</a> and select <u>valid</u> option from 'Test Format'.</p>";
		}
		elseif( empty( $tags ) )
		{
			echo $error_text;
			
			echo "<p>Please <a href='javascript:history.back()'>go back</a> and select <u>atleast one</u> of the options from 'TAGS'.</p>";
		}
		elseif( count( $tags ) > 3 )
		{
			echo $error_text;
			
			echo "<p>Please <a href='javascript:history.back()'>go back</a> and select maximum of <u>three</u> options from 'TAGS'.</p>";
		}
		elseif( !empty( $comment ) && strlen( $comment ) < 10 )
		{
			echo $error_text;
			
			echo "<p>Please <a href='javascript:history.back()'>go back</a> and write atleast more than that in 'comment section' if you really want to; otherwise you can leave it empty.</p>";
		}
		elseif(  strlen( $comment ) > 199 )
		{
			echo $error_text;
			
			echo "You can't have more than 199 characters. <p>Please <a href='javascript:history.back()'>go back</a> and write less than that in 'comment section.'</p>";
		}
		else //if everything goes well
		{
			
			echo "<h4><font size='+2'>You have successfully rated ";
			insname( $instructorid );
			echo ".</font></h4>";
	
			echo "<p>Thank you for contributing. Your rating for this instructor will help and give idea to other students about this instructor.</p>";
			
			
			if( !isset( $textbook ) )
			{
				$textbook = 0; // no
			}
			
			if( !isset( $takeagain ) )
			{
				$takeagain = 0; // no
			}
				
			if( !isset( $attendance ) )
			{
				$attendance = 0; // no
			}
			
		/*	if( !is_numeric( $rate ) || !is_numeric( $lod ) || !is_numeric( $textbook ) || !is_numeric( $takeagain ) || !is_numeric( $attendance ) || !is_numeric( $grades ) || !is_numeric( $tags ) || !is_numeric( $test_format ) )
			{
				echo $error_text;
				echo "<p>Did you enter something invalid?</p>";
				return 1;
			}*/
			
			//	$numberoftags = count( $tags );
			
				
			//	echo "instructor id: " . $instructorid . "<BR>";
			//	echo "Rater id: " . $raterid . "<BR>"; 
			?>
			
			<table style='width:100%; border-spacing:0; border: 1px solid black;'>
							
			<tr><th>List</th><th>Rating</th></tr>
			
			<tr><td><strong>Rate</strong> <i>(<?php echo $rate . " out of " . $website_maxrating; ?>)</i></td><td><?php echo getratename( $rate ) . "   "; generatestars( $rate ); ?></td></tr>
			<tr><td><strong>Level of Difficulty</strong> <i>(<?php echo $lod . " out of " . $website_maxlod; ?>)</i></td><td><?php echo getlodname( $lod ); ?></td></tr>
			<tr><td><strong>Course you took with this instructor</strong></td><td><?php echo $course ?></td></tr>
			<tr><td><strong>Will you take this instructor again?</strong></td><td><?php echo YesNo( $takeagain ); ?></td></tr>
			<tr><td><strong>Requires Textbook?</strong></td><td><?php echo YesNo( $textbook ); ?></td></tr>
			<tr><td><strong>Attendance</strong></td><td><?php echo Attendance( $attendance ); ?></td></tr>
		<?php /*		<tr><td><strong>Hot?</strong></td><td><?php echo YesNo( $row[ 'hotness' ] ); ?></td></tr> */?>
			<tr><td><strong>Grade Received</strong></td><td><?php echo generategrade( $grades ); ?></td></tr>
            <tr><td><strong>Test Pattern</strong></td><td><?php echo GetTestInfoNames( $test_format ); ?></td></tr>
			
			<tr><td><strong>Tags</strong></td><td>
			
			<?php
			
				$_count = 0;
			
				if( 	!empty( $tags ) )
				{
					foreach( $tags as $check ) 
					{
						$_count++;
						
						$rtag[ $_count ] = $check;
						
						echo gettagname( $check ) . "; ";
					}
				}
				
				for( $counter = 1; $counter <=3; $counter++ )
				{
					if( is_null( $rtag[ $counter ] ) || empty( $rtag[ $counter ] ) || $rtag[ $counter ] == "" || $rtag[ $counter ] > NumberofTags( ) )
					{
						$rtag[ $counter ] = 0;
					}
				}
				
				if( $comment == "" || is_null( $comment ) || empty( $comment ) )
				{
					$rcomment = "No comments.";
				}
				else
				{
					$rcomment = $comment;
				}
				
				?>
				</td></tr>
				
			   
				
				<tr><td><strong>Your comments:</strong></td><td><?php echo $rcomment; ?> </td></tr>
				<tr><i><th><center><strong>Rated by:</strong> <?php echo $context[ 'user' ][ 'name' ]; ?></center></th><th><center><strong>Instructor:</strong> <?php echo "<a href='index.php?page=instructor&name="; insname( $instructorid ); echo "'>"; insname( $instructorid ); echo "</a>"; ?></center></th></i></tr>
			
				</table>
				
				<?php
				
				
			//	echo $rtag[ 1 ] . "<BR>";
			//	echo $rtag[ 2 ] . "<BR>";
			//	echo $rtag[ 3 ] . "<BR>";
			
			
				$comment = mysql_escape_string( $comment );
				$course = mysql_escape_string( $course );
				
				$query = "INSERT INTO " . $table_rate . " (rater_id, ins_id, rate, lod, course_name, take_again, textbook, attendance, tag1, tag2, tag3, comment, recgrade, ip, test_pattern) VALUES ('$raterid', '$instructorid', '$rate', '$lod', '$course', '$takeagain', '$textbook', '$attendance', '$rtag[1]', '$rtag[2]', '$rtag[3]', '$comment', '$grades', '$ipaddress', '$test_format')";
						
				$result = mysql_query( $query ) or die( mysql_error( ) ) ;
				
				GiveRespect( $raterid );
			
				echo "<p>You have <b>received (" . $website_giverespect . ") respect points</b> for rating this instructor. View all your ratings at <a href='index.php?page=myratings'>My Ratings</a> page.<br>";
				
				echo "</p>";
			
		
		}	
	}
}

?>