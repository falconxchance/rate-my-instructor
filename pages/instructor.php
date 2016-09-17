<?php 


global $table_instructors, $table_rate;
	

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// list of instructors /////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


	if( !$requested_ins_name || $requested_ins_name == "all" )
	{		 
	
		if( !$requested_page_number || $requested_page_number == 1 )
		{
			echo "<h4><font size='+2'>List of Instructors</font></h4>";
		}
		else
		{
			echo "<h4><font size='+2'>List of Instructors (Page: " . $requested_page_number . ")</font></h4>";
		}
	
	
		$total_instructor_show = $website_numberofinstructors;
		
		if ( is_numeric( $requested_page_number ) || !$requested_page_number )
		{
			if( $requested_page_number )
			{ 
				$page = $requested_page_number;
			}
			else
			{ 
				$page = 1; 
			}
			
			$start_from = ( $page - 1 ) * $total_instructor_show; 
	
		
	?>
					
        
       
	<?php
	
	
		
			$query = "SELECT id, ins_name, collegeof, email FROM " . $table_instructors . " ORDER BY ins_name LIMIT " . $start_from . ", " . $total_instructor_show;
	
			$result = mysql_query( $query ) or die( mysql_error( ) ) ;
			
			$IsInsExist = mysql_num_rows( $result ); 
			
			$countinstructors = $start_from;
			
			if( $IsInsExist )
			{
				echo "<table style='width:100%; border-spacing:0; border: 1px solid black;'>";
				
				echo "<tr><th><img src='style/man.gif'></th><th>Instructor</th><th>College</th><th>Email</th><th>Total Rating</th><th>Score</th><th>Overall</th><th>Rate</th><th>Show</th></tr>";
				
				while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) ) 
				{
					$countinstructors++;
					
					$instructor_id = $row[ 'id' ];
					$numberoftrates = NumberofRatesOfInstructor( $instructor_id );
					//$highest_rate = ModeOfRates( $instructor_id );
					$overallquality = OverallQuality( $instructor_id, 0 );
					
					$ins_name = $row[ 'ins_name' ];
					
					echo "<tr><td>" . $countinstructors . ". </td><td>" . $row[ 'ins_name' ] . "</td><td>" . CollegeOf( $row[ 'collegeof' ] ) . "</td><td>" . generateemail( $row[ 'email' ] ) . "</td><td>" . $numberoftrates . " " . AddS( $numberoftrates, "Rating", "s" ) . "</td><td>" . $overallquality . "</td><td>";
					
					 generatestars( round( $overallquality ) );
					 
					echo "</td><td><a href='index.php?page=rate&name=" . $ins_name . "' title='Rate " . $ins_name . " now'><img src='style/rate.gif'></a></td><td><a href='index.php?page=instructor&name=" . $ins_name . "' class='ids' title='Show " . $ins_name . "&#39;s rating'><img src='style/open.gif'></a></td></tr>";
					
				}
				
				echo "</table>";
				
			$query = "SELECT id FROM " . $table_instructors . ""; 
			$result = mysql_query( $query ); 
			$total_records = mysql_num_rows( $result );
			$total_pages = ceil( $total_records / $total_instructor_show );
				
			
			if( $total_pages > 1 )
			{ 
				 
				 if( $page > 1 )
				 {
					 $previouspage = $page - 1;
					 echo "<a href='index.php?page=instructor&p=" . $previouspage . "'>Prev</a> - ";
				 }
				 
				for ( $i = 1; $i <= $total_pages; $i++ ) 
				{
					if( $i == $page )
					{
						if( $i == $total_pages )
						{
							echo $i;
						}
						else
						{
							echo $i . " - ";
						}
					}
					else
					{
						echo "<a href='index.php?page=instructor&p=". $i . "'>". $i ."</a>  -  ";
					}
				} 
				
				if( $page < $total_pages )
				 {
					 $nextpage = $page + 1;
					 echo "<a href='index.php?page=instructor&p=" . $nextpage . "'>Next</a>";
				 }
			}
				
				echo "<br><br>";
				
				echo "There are <strong>" . $total_records . "</strong> " . AddS( $total_records, "instructor", "s" ) . " in the database.";
?>				<div class="form_settings" align="right">
				<form>
				<input class="submit" type="button" value="Add Instructors" onclick="window.location.href='index.php?page=suggestinstructor'" />
				</form>
					</div>
<?php				
			}
			else //if numrows return 0
			{
				echo "<br>Error: there are no instructors in this page.";
			}
			
		}
		else // if not numeric
		{
			echo "<br>Error: invalid page number.";
		}
	}
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// X instructor's rating page //////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	else// single instructor rating
	{		 
	
	
		$requested_ins_name = mysql_escape_string( $requested_ins_name );
		
		$requested_ins_name = html_entity_decode( $requested_ins_name );
		
		$requested_ins_name = mysql_real_escape_string( $requested_ins_name );	
		
		$query = "SELECT * FROM `" . $table_instructors . "` WHERE `ins_name` = '" . $requested_ins_name . "' LIMIT 1";
		
		$result = mysql_query( $query ) or die( mysql_error( ) ) ;
		
		$IsInstructorExist = mysql_num_rows( $result ); 
		
		$ins_name_ = ucwords( $requested_ins_name );
		
		
		echo "<h4><font size='+2'>" . $ins_name_ . "</font></h4>";
		
		if( $IsInstructorExist )
		{
			$row = mysql_fetch_assoc( $result ) or die( mysql_error( ) ) ;
			{
				$title = $row[ 'title' ];
				$instructor_id = $row[ 'id' ];
				$gender = $row[ 'ismale' ];
				
				$totalrates = NumberofRatesOfInstructor( $instructor_id );
				$totallods = NumberofLodsOfInstructor( $instructor_id );
				
				$overall_rating = OverAllRating( $instructor_id, $totalrates );
				
				echo "<h5>" . $title . " in College of " . CollegeOf( $row[ 'collegeof' ] ) . ".</h5>"; 
				
				
				echo '<table style="width:100%; border-spacing:0; border: 1px solid black;">';
				
				$courses_array = array( $row[ 'course_1' ], $row[ 'course_2' ], $row[ 'course_3' ], $row[ 'course_4' ], $row[ 'course_5' ]  );

				echo '<tr><th width="20%">Overall Quality</th><th width="20%">Email</th><th width="20%">Office</th><th width="20%">Courses</th><th width="20%">Department</th></tr>';
				
				echo '<tr><td width="20%">' . OverallQuality( $instructor_id ) . ' (' . OverallQuality( $instructor_id, 0 ) . ')</td><td width="20%">' . generateemail( $row[ 'email' ] ) . '</td><td width="20%">' . $row[ 'office' ] . '</td><td width="20%">' . join_string( $courses_array, ", " ) . '</td><td width="20%">' . $row[ 'department' ] . '</td></tr>';
			
	
				echo '</table>';
				
				echo "<p>";
				
				if( $totalrates > 0 )
				{
					
					$gethighestratesid = ModeOfRates( $instructor_id );
					$mostgrade = ModeofGrades( $instructor_id );
					$textbookreq = ModeOfTextbooks( $instructor_id );
					$attendancereq = ModeofAttendance( $instructor_id );
					$takeagainorno = ModeOfTakeAgain( $instructor_id );
					$mosttestpattern = ModeofTestPattern( $instructor_id );
					
					$mosttestpattern = GetTestInfoNames( $mosttestpattern );
					
					if( $textbookreq == 1 )
					{
						$textbookreq = "usually requires";
					}
					else
					{
						$textbookreq = "does not usually require";
					}
					
					if( $attendancereq == 1 )
					{
						$attendancereq = "always";
					}
					else
					{
						$attendancereq = "not";
					}
					
					if( $takeagainorno == 1 )
					{
						$takeagainorno = "would";
					}
					else
					{
						$takeagainorno = "would not";
					}
					
					echo "This " . strtolower( $title ) . " has been mostly rated <strong>" . strtolower( getratename( $gethighestratesid ) ) . "</strong>. ";
					
					echo "Moreover, students have mostly received <b>" . generategrade( $mostgrade )  . "</b> grade with " . HimorHer( $gender ) . ". ";
					
					echo ucwords( HeorShe( $gender ) ) . " <strong>" . $textbookreq . "</strong> textbook and attendance is <strong>" . $attendancereq . " mandatory</strong> in " . HisorHer( $gender ) . " classes. ";
					
					echo "Most of the students who have rated " . HimorHer( $gender ) . " <strong>" . $takeagainorno . "</strong> take this instructor again. ";
					
					echo ucwords( HisorHer( $gender ) ) . " usual test format is <b>" . strtolower( $mosttestpattern ) . "</b>. ";
					
					//echo "Following are further details of " . $ins_name_ . ".";
					
					
					$query = "SELECT rater_id FROM " . $table_rate . " WHERE ins_id = '" . $instructor_id . "' ORDER BY id DESC LIMIT 3";
			
					$result = mysql_query( $query ) or die( mysql_error( ) ) ;
				
					$IsRecentRatingExist = mysql_num_rows( $result ); 
					
					if( $IsRecentRatingExist )
					{
						$count = 0;
						while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) ) 
						{
							$count++;
							$_raterid[ $count ] = $row[ 'rater_id' ];
						}
						
						$rater1 = ratername( $_raterid[ 1 ] );
						$rater2 = ratername( $_raterid[ 2 ] );
						$rater3 = ratername( $_raterid[ 3 ] );
						
						$recent_array = array( $rater1, $rater2, $rater3 );
						
						echo "Recently rated by " . join_string( $recent_array, ", " ) . ".";
					}
					
					
					
					
				}
				else
				{
					$gethighestratesid = 0;
					
					echo "<u>This " . strtolower( $title ) . " has not been rated by anyone.</u> Therefore, it is not possible to show the rating data of this " . strtolower( $title ) . ". ";
					
					echo "Rate " . HimorHer( $gender ) . " now as it is your time to grade instructors now! Let's see how well they do in teaching us.";
					
				}
				
				echo "<br><hr>";
				
				?>
				<div class="form_settings" align="right">
				<form>
				<input class="submit" type="button" value="Rate Now!" onclick="window.location.href='index.php?page=rate&name=<?php echo $ins_name_; ?>'" />
				</form>
					</div>
				
				<?php
				
				
				
				if( $totalrates > 0 )
				{
					generatestars( round( $overall_rating ) );
				}
				else
				{
					generatestars( $totalrates );
				}
				
				
				echo "<br>";
				
				echo "<strong>Mostly rated</strong>: " . getratename( $gethighestratesid ) . " (" . $gethighestratesid . ")<br>";
				
				
				echo "<i>(" . $totalrates . " " . AddS( $totalrates, "Rating", "s" ) . ")</i>";
				
				echo "<center><h2>Rating: " . $overall_rating . " out of " . $website_maxrating . "</h2></center>";
				echo "<center><h5>Overall: " . getratename( round( $overall_rating ) ) . "</h5></center>";
		////////////////////////////////////////////////////////////
		//////////////////bar chart 1//////////////////////////
		////////////////////////////////////////////////////////////
				
				
			
				if( $totalrates > 0 )
				{
					
					echo '<div id="myBarChartRate"/></div>';
				}
				else
				{
					echo "<br>Rating Bar Chart is not available at the moment. Reason: No rates found.";
				}
				
				
				echo "<br><br><hr><br><br>";
				
				$overall_lod = OverAllLod( $instructor_id, $totallods );
				
				echo "<center><h2>Level of Difficulty: " . $overall_lod . " out of " . $website_maxlod . "</h2></center>";
				echo "<center><h5>Overall: " . getlodname( round( $overall_lod ) ) . "</h5></center>";
				
		////////////////////////////////////////////////////////////
		//////////////////pie chart 1 lod //////////////////////////
		////////////////////////////////////////////////////////////
				
				if( $totalrates > 0 )
				{
				
					echo '<center><div id="myPieChatLod" style="width:600; height:300" /></center>';
				
				}
				else
				{
					
					echo "<br>Level of Difficulty Pie Chart is not available at the moment. Reason: No rates found.<br><br>";
				}
		
				
				echo "<hr><br>";
				
				echo "<center><h2>Attendance, Textbook Requirement and Preference</h2></center><br>";
				
				echo "<center>";
				
				echo '<table style="width:50%; border-spacing:0; border: 1px solid black;">';
				echo '<tr><td><center></center></td><td><b><u>Yes</u></b></td><td><b><u>No</u></b></td><td><b><u>Conclusion</u></b></td></tr>';
				
				$red = "<img src='style/signs/thumbsdown.png' width='20'>";
				$green = "<img src='style/signs/thumbsup.png' width='20'>";
				
				$noa_yes = NumberofAttendance( $instructor_id, 1 );
				$noa_no = NumberofAttendance( $instructor_id, 0 );
				
				
				if( $noa_yes < $noa_no )
				{
					$color = $green;
				}
				else
				{
					$color = $red;
				}
				
				echo "<tr><td><b>Attendance Mandatory</b></td><td>" . $noa_yes . "</td><td>" . $noa_no . "</td><td><center>" . $color . "</center></td></tr>";
				
				$notx_yes = NumberofTextbooks( $instructor_id, 1 );
				$notx_no = NumberofTextbooks( $instructor_id, 0 );
				
				if( $notx_yes < $notx_no )
				{
					$color = $green;
				}
				else
				{
					$color = $red;
				}
				
				echo "<tr><td><b>Textbook Requirement</b></td><td>" . $notx_yes . "</td><td>" . $notx_no . "</td><td><center>" . $color . "</center></td></tr>";
				
				$nota_yes = NumberofTakeAgain( $instructor_id, 1 );
				$nota_no = NumberofTakeAgain( $instructor_id, 0 );
				
				$nota_total = $nota_no + $nota_yes;
				
				$nota_perc = $nota_yes / $nota_total;
				$nota_perc = $nota_perc * 100;
				$nota_perc = round( $nota_perc, 1 );
				
				if( $nota_yes > $nota_no )
				{
					$color = $green;
				}
				else
				{
					$color = $red;
				}
				
				echo "<tr><td><b>Take again</b></td><td>" . $nota_yes . "</td><td>" . $nota_no . "</td><td><center>" . $color . "</center></td></tr>";
				
				
				echo "</table>";
				
				echo "</center>";
				
				if( $totalrates < 1 )
				{
					$nota_perc = 0;
				}
				
				echo "<p><b>" . $nota_perc . "%</b> of students  would <b>take</b> this instructor <b>again</b>.</p>";
				
			}// end of professor's data echo
			
			// comments section
			
			echo "<hr>";
			
			echo "<center><h2>COMMENTS</h2></center>";
			
			echo "<a name='comments'></a>"; //anchor for jumping to comment section
			
			
			if( !$website_disablecomments ) // if comments are not disabled.
			{
			
				// comments and rates of other students. (border: 1px solid black;)
				
				
				//$requested_comment_page;      $website_numberofcomments;
				
				$total_comment_show = $website_numberofcomments;
		
				if ( is_numeric( $requested_comment_page ) || !$requested_comment_page )
				{
					if( $requested_comment_page )
					{ 
						$comment_page = $requested_comment_page;
					}
					else
					{ 
						$comment_page = 1; 
					}
					
					$start_comments_from = ( $comment_page - 1 ) * $total_comment_show; 
				
					
					$query = "SELECT * FROM `" . $table_rate . "` WHERE `ins_id` = '" . $instructor_id . "' AND rate <= " . $website_maxrating . " AND comment NOT LIKE '' ORDER BY id DESC LIMIT " . $start_comments_from . ", " . $total_comment_show;
					
					//echo "<br>" . $query;
			
					$result = mysql_query( $query ) or die( mysql_error( ) ) ;
					
					$IsCommentDataExist = mysql_num_rows( $result ); 
					
					$countcommentsinpage = $start_comments_from;
					
					if( $IsCommentDataExist )
					{
			
						while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
						{	
						
							$ratenumber = $row[ 'rate' ];
							$comment = $row[ 'comment' ];
							
							//if( $ratenumber <= $website_maxrating ) // only show valid comments...( !empty( $comment ) || $comment != "" ) && 
							//{		
							
							$raterid = $row[ 'rater_id' ];
							$lodid = $row[ 'lod' ];
							$course = $row[ 'course_name' ];
							$takeagain = $row[ 'take_again' ];
							$textbook = $row[ 'textbook' ];
							$attendance = $row[ 'attendance' ];
							//$hotness = $row[ 'hotness' ];
							$tag_array = array( strtoupper( gettagname( $row[ 'tag1' ] ) ), strtoupper( gettagname( $row[ 'tag2' ] ) ), strtoupper( gettagname( $row[ 'tag3' ] ) ) );
							$receivecgrade = $row[ 'recgrade' ];
							$time = $row[ 'time' ];
							
								$countcommentsinpage++;
										
								echo '<table style="width:100%; border-spacing:0; border: 1px solid black;">';
								
								$ratersname = ratername( $raterid );
						
								echo "<tr><td width='25%' bgcolor='#D6CDB0'>" . $countcommentsinpage . ". <center><strong> " . $ratersname . "</strong></center></td><td width='75%'>Rated on <i>" . generatetime( $time ) . "</i></td></tr>";
								
								echo "<tr><td width='25%' bgcolor='#D6CDB0'>";// sidebar data
								
								echo "<center>" . GenerateEmojiRate( $ratenumber ) . "<br><br>";
								
								echo "<b>" . strtoupper( getratename( $ratenumber ) ). "</b><br><br>";
								
								echo "</center>"; 
								echo "<b>Course</b>: " . $course . "<br>";
								echo "<b>Attendance</b>: " . Attendance( $attendance ) . "<br>";
								echo "<b>Take again</b>: " . YesNo( $takeagain ) . "<br>";
								echo "<b>Textbook required</b>: " . YesNo( $textbook ) . "<br>";
								echo "<b>Grade received</b>: " . generategrade( $receivecgrade ) . "<br>";
								
								echo "<br>";	
							
								//echo "<b>Hot</b>: " . YesNo( $hotness ) . "<br>";
								
								echo "<b>Level of Difficulty</b>: " . getlodname( $lodid ) . "<br><br>";
										
								
								echo "</td>"; 
								
								echo "<td style='word-break:normal' width='75%'>"; //comment box
								
								echo $comment;// actual comment goes here
								
								echo "<br><br>";// tags are below
		
								echo "</td>";
								
								echo "</tr>";
								
								echo '<tr><td width="1%"></td><td width="99%"><center><span class="tag_highlight">' . join_string(  $tag_array, "</span><span>,&nbsp; &nbsp;</span><span class='tag_highlight'>" ) . '</span></center></td></tr>';
								
								echo "</table>";
								
							}
						//}
						
						$query = "SELECT comment FROM `" . $table_rate . "` WHERE `ins_id` = '" . $instructor_id . "' 
AND rate <= " . $website_maxrating . " AND comment NOT LIKE ''";

						$result = mysql_query( $query ); 
						$total_comments = mysql_num_rows( $result );
						
					
						
						$total_pages = ceil( $total_comments / $total_comment_show ); //countcomments
							
						
						if( $total_pages > 1 )
						{ 
							 
							 if( $comment_page > 1 )
							 {
								 $previouspage = $comment_page - 1;
								 echo "<a href='index.php?page=instructor&name=" . $ins_name_ . "&c=" . $previouspage . "#comments'>Prev</a> - ";
							 }
							 
							for ( $i = 1; $i <= $total_pages; $i++ ) 
							{
								if( $i == $comment_page )
								{
									if( $i == $total_pages )
									{
										echo $i;
									}
									else
									{
										echo $i . " - ";
									}
								}
								else
								{
									echo "<a href='index.php?page=instructor&name=" . $ins_name_ . "&c=". $i . "#comments'>". $i ."</a>  -  ";
								}
							} 
							
							if( $comment_page < $total_pages )
							 {
								 $nextpage = $comment_page + 1;
								 echo "<a href='index.php?page=instructor&name=" . $ins_name_ . "&c=" . $nextpage . "#comments'>Next</a>";
							 }
						}
						
					}
					else
					{
						echo "There is no comment available.";
					}
				}
				else // if not numeric
				{
					echo "<br>Error: invalid comment page number.";
				}
			}
			else
			{
				echo "Sorry, comments are <strong>not available</strong> at the moment. (DISABLED)<br><br>";
				
				$total_records = "0";
			}
				
				if( empty( $total_comments ) )
				{
					$total_comments = 0;
				}
				
				echo "<br><br><center><strong>" . $ins_name_ . "</strong> has <strong>" . $total_comments . "</strong> " . AddS( $total_comments, "comment", "s" ) . " and <strong>" . $totalrates . "</strong> total ratings.</center><br><br><hr><br>";
		
	
			echo "<a href='index.php?page=instructor'>Click here</a> to view list of all instructors.";
			
			
			echo "</p>";
			
		}
		else
		{
			echo $requested_ins_name . " doesn't exist in the database.";
		}
		
		
	}
	
	
	?>