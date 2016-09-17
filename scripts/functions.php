<?php

// functions

/*function curPageURL() 
{
		 $pageURL = 'http';
		 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		 $pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 return $pageURL;
	}*/
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// retrieve names //////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


	function insname( $insuserid ) // retrieve instructor name through instructor id
	{
		global $table_instructors;
		
		if ( is_numeric( $insuserid ) )
		{
			$query = "SELECT ins_name FROM `" . $table_instructors . "` WHERE id=" . $insuserid . " LIMIT 1";
		
			$result = mysql_query( $query ) or die( mysql_error( ) ) ;
			$IsInsNameExist = mysql_num_rows( $result ); 
			
			if( $IsInsNameExist )
			{
				$row = mysql_fetch_array( $result ) or die( mysql_error( ) ) ;
				{
					echo $row[ 'ins_name' ];
				}
			}
			else
			{
				echo "Not found";
			}
		}
		else
		{
			echo "Invalid ID";
		}
	}
	
	function nametoid( $ins_name ) // retreives id of an instructor through his name
	{
		global $table_instructors;
		
		$ins_name = mysql_escape_string( $ins_name );
		
		$ins_name = html_entity_decode( $ins_name );
		
		$ins_name = mysql_real_escape_string( $ins_name );	
		
		$query = "SELECT id FROM `" . $table_instructors . "` WHERE `ins_name` = '" . $ins_name . "' LIMIT 1";
		
		$result = mysql_query( $query ) or die( mysql_error( ) ) ;
		
		$IsInstructorExist = mysql_num_rows( $result ); 
		
		if( $IsInstructorExist )
		{
			$row = mysql_fetch_assoc( $result ) or die( mysql_error( ) );
			{
				return $row[ 'id' ];
			}
		}
		else
		{
			return "Error";
		}
	}
	
	function ratername( $raterid ) // retreive rater's name through user_id of the forum
	{
		global $context;
		
		if( is_numeric( $raterid ) )
		{
			if( $raterid == $context[ 'user' ][ 'id' ] )
			{
				return "<b>You</b>"; // link to my ratings page
			}
			else
			{
				$userdata = ssi_fetchMember( $raterid, $output_method = 'array' );
				return $userdata[ $raterid ][ 'name' ]; // link to the profile of this user.
			}
		}
		else
		{
			//return "Invalid ID";
		}
	}
	
	function gettagname( $tag_id ) // retreive single tag's name through tag id
	{
		global $table_tags;
		
		if( is_numeric( $tag_id ) )
		{
			$query = "SELECT * FROM " . $table_tags . " WHERE id=" . $tag_id . " LIMIT 1";
	
			$result = mysql_query( $query ) or die( mysql_error( ) ) ;
			$IsTagExist = mysql_num_rows( $result ); 
			
			if( $IsTagExist )
			{
				$row = mysql_fetch_array( $result ) or die( mysql_error( ) ) ;
				
				return $row[ 'names' ];
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return "Error";
		}
	}
	
	function getinscourses( $insid, $courseid ) // get course names from ins_ids
	{
		
		global $table_instructors;
		
		if( is_numeric( $courseid ) && is_numeric( $insid ) )
		{
			if( $courseid > 0 && $courseid < 6 )
			{
				$query = "SELECT course_" . $courseid . " FROM " . $table_instructors . " WHERE id=" . $insid . " LIMIT 1";
		
				$result = mysql_query( $query ) or die( mysql_error( ) ) ;
				$IsInsExist = mysql_num_rows( $result ); 
				
				if( $IsInsExist )
				{
					$row = mysql_fetch_array( $result ) or die( mysql_error( ) ) ;
					
					return $row[ 'course_' . $courseid ];
				}
				else
				{
					return "Error: not exist";
				}
			}
			else
			{
				return "Error: wrong number";
			}
		}
		else
		{
			return "Error: invalid number";
		}
	}
	
	function getratename( $rate_number ) // retreive rate's name (good, bad, worst) through rate number (1-5)
	{
		global $website_maxrating, $website_ratename_1, $website_ratename_2, $website_ratename_3, $website_ratename_4, $website_ratename_5;
		
		if( is_numeric( $rate_number ) )
		{
			if( $rate_number > $website_maxrating )
			{
					$rate_number = $website_maxrating;
			}
			
			switch( $rate_number )
			{
				case 1:
				{
					return $website_ratename_1;
					break;
				}
				case 2:
				{
					return $website_ratename_2;
					break;
				}
				case 3:
				{
					return $website_ratename_3;
					break;
				}
				case 4:
				{
					return $website_ratename_4;
					break;
				}
				case 5:
				{
					return $website_ratename_5;
					break;
				}
				default:
				{
					return "Unknown";
				}
			}
		}
		else
		{
			return "Invalid ID";
		}
	}
	
	
	function getlodname( $lod_number ) // retreive lod's name (hard, easy a) through lod number (1-5)
	{
		global $website_maxlod, $website_lodname_1, $website_lodname_2, $website_lodname_3, $website_lodname_4, $website_lodname_5;
		
		if( is_numeric( $lod_number ) )
		{
			
			if( $lod_number > $website_maxlod )
			{
					$lod_number = $website_maxlod;
			}
			
			switch( $lod_number )
			{
				case 1:
				{
					return $website_lodname_1;
					break;
				}
				case 2:
				{
					return $website_lodname_2;
					break;
				}
				case 3:
				{
					return $website_lodname_3;
					break;
				}
				case 4:
				{
					return $website_lodname_4;
					break;
				}
				case 5:
				{
					return $website_lodname_5;
					break;
				}
				default:
				{
					return "Unknown";
				}
			}
		}
		else
		{
			return "Invalid ID";
		}
	}
	
	function getUserIP()
	{
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];
		
		if(filter_var($client, FILTER_VALIDATE_IP))
		{
			$ip = $client;
		}
		elseif(filter_var($forward, FILTER_VALIDATE_IP))
		{
			$ip = $forward;
		}
		else
		{
			$ip = $remote;
		}
		
		return $ip;
	}
	
function GetTestInfoNames( $id )
{
	if( is_numeric( $id ) )
	{
		switch( $id )
		{
			case 0:
			{
				return "N/A";
				break;
			}
			case 1:
			{
				return "Multiple Choice Questions";
				break;
			}
			case 2:
			{
				return "Short Q/As";
				break;
			}
			case 3:
			{
				return "Essays";
				break;
			}
			case 4:
			{
				return "True / False";
				break;
			}
			case 5:
			{
				return "Test bank";
				break;
			}
			default:
			{
				return "Unknown";
				break;
			}
		}
				
	}
	else
	{
		return "Error";
	}
}

function GetRespectPoints( $memberid )
{
	global $smf_members;
	
	if( is_numeric( $memberid ) )
	{
		$query = "SELECT karma_good FROM `" . $smf_members . "` WHERE id_member = '" . $memberid . "' LIMIT 1";
	
		$result = mysql_query( $query ) or die( mysql_error( ) ) ;
	
		$row = mysql_fetch_array( $result ) or die( mysql_error( ) ) ;
		
		$RespectPoints = $row[ 'karma_good' ];
		
		return $RespectPoints;
	}
	else
	{
		return "Error";
	}
	
}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// generate images, time and data //////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	
	function generatestars( $numberofstars ) // numberofstars = purple stars.
	{
		global $website_maxrating;
		
		if( is_numeric( $numberofstars ) )
		{
			if( $numberofstars > $website_maxrating )
			{
				$numberofstars = $website_maxrating;
			}
			if( $numberofstars >= 1 )
			{
				for( $counter = 1; $counter <= $numberofstars; $counter++ ) 
				{
					echo "<img src='style/starr.gif' title='" . getratename( $numberofstars ) . "'>";
				}
				
				$remainingstars = $website_maxrating - $numberofstars;
				
				if( $remainingstars >= 1 )
				{
					for( $counter = 1; $counter <= $remainingstars; $counter++ ) 
					{
						echo "<img src='style/starr_.gif' title='" . getratename( $numberofstars ) . "'>";
					}
				}
			}
			else
			{
				for( $counter = 1; $counter <= $website_maxrating; $counter++ ) 
				{
					echo "<img src='style/starr_.gif' title='" . getratename( $numberofstars ) . "'>";
				}
			}
		}
		else
		{
			echo "invalid number";
		}
	}
	
	
	function generateemail( $mail ) // makes any string into mailto:string@example.edu format
	{
		//if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false)
		return "<a href='mailto:" . $mail . "@example.edu' class='email' title='Click to send an email to " . $mail . "@example.edu'>" . $mail . "</a>";
		
	}
	
	function GenerateEmojiRate( $rate_id ) // shows the emoji image through rate id
	{
		global $website_maxrating;
		
		if( is_numeric( $rate_id ) )
		{
			if( $rate_id > $website_maxrating )
			{
				$rate_id = $website_maxrating;
			}
				
			switch( $rate_id )
			{
				case 1:
				{
					return "<img src='style/signs/thumbsdown.png' title='" . getratename( $rate_id ) . "'>";
					break;
				}
				case 2:
				{
					return "<img src='style/signs/tongueout.png' title='" . getratename( $rate_id ) . "'>";
					break;
				}
				case 3:
				{
					return "<img src='style/signs/thumbsup.png' title='" . getratename( $rate_id ) . "'>";
					break;
				}
				case 4:
				{
					return "<img src='style/signs/okhandsign.png' title='" . getratename( $rate_id ) . "'>";
					break;
				}
				case 5:
				{
					return "<img src='style/signs/loveeyes.png' title='" . getratename( $rate_id ) . "'>";
					break;
				}
				default:
				{
					return "<img src='style/signs/nuetral.png' title='" . getratename( $rate_id ) . "'>";
					break;
				}
			}
		}
		else
		{
			return "Emoji Error";
		}
	}
	
	function generatetime( $time, $short = 0 ) // generate short or long time through timestamp of mysql
	{
		if( $short )
		{
			return date( "d M y h:ia", strtotime( $time ) );
		}
		else
		{
			return date( "jS F Y h:ia", strtotime( $time ) );
		}
	}
	
	function generategrade( $number ) // generates grade through grade number (1-11)
	{
		if( is_numeric( $number ) )
		{
			switch( $number )
			{
				case 0:
				{
					return "N/A";
					break;
				}
				case 1:
				{
					return "A";
					break;
				}
				case 2:
				{
					return "A-";
					break;
				}
				case 3:
				{
					return "B+";
					break;
				}
				case 4:
				{
					return "B";
					break;
				}
				case 5:
				{
					return "B-";
					break;
				}
				case 6:
				{
					return "C+";
					break;
				}
				case 7:
				{
					return "C";
					break;
				}
				case 8:
				{
					return "C-";
					break;
				}
				case 9:
				{
					return "D";
					break;
				}
				case 10:
				{
					return "F";
					break;
				}
				case 11:
				{
					return "W";
					break;
				}
				default:
				{
					return "N/A";
					break;
				}
			}
		}
		else
		{
			return "Error";
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Bools - Yes/no, malefemale, 0/1 /////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function YesNo( $bool_val )
	{
		return $bool_val == 1 ? 'Yes' : 'No';
	}
	
	function MaleFemale( $bool_val )
	{
		return $bool_val == 1 ? 'Male' : 'Female';
	}
	
	function HisorHer( $bool_val )
	{
		return $bool_val == 1 ? 'his' : 'her';
	}
	
	function HimorHer( $bool_val )
	{
		return $bool_val == 1 ? 'him' : 'her';
	}
	
	function HeorShe( $bool_val )
	{
		return $bool_val == 1 ? 'he' : 'she';
	}
	
	function Attendance( $bool_val )
	{
		return $bool_val == 1 ? 'Mandatory' : 'Not Mandatory';
	}
	
	function CollegeOf( $bool_val )
	{
		return $bool_val == 1 ? 'Arts and Sciences' : 'Business and Economics';
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// finding percentage //////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function FindPercentageRate( $rate_id, $instructor_id ) // allvotesofthisrates / totalratesofins * 100 = %
	{
		global $website_maxrating, $table_rate;
		
		if( is_numeric( $rate_id ) && is_numeric( $instructor_id ) )
		{
			if( $rate_id > $website_maxrating )
			{
				$rate_id = $website_maxrating;
			}
			
			$query = "SELECT rate FROM `" . $table_rate . "` WHERE `ins_id` = '" . $instructor_id . "' AND `rate` <= " . $website_maxrating;
		
			$result = mysql_query( $query ) or die( mysql_error( ) ) ;
			
			$IsRateExist = mysql_num_rows( $result ); 
		
			$CountTotalRates = 0;
			$CountOnlyThisRate = 0;
			
			if( $IsRateExist )
			{
				while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )  //h2h5p
				{
					if( $row[ 'rate' ] == $rate_id )
					{
						$CountOnlyThisRate++;
					}
					
					$CountTotalRates++;
				}
				
				$resultis = $CountOnlyThisRate / $CountTotalRates * 100;
				
				return round( $resultis, 2 );
	
				
			}
			else
			{
				return "0";
			}
		}
		else
		{
			return "Error"; 
		}
	}
	
	
	function FindPercentageGrade( $grade_id, $instructor_id ) // allgradesofthisid / totalgradesofins * 100 = %
	{
		global $table_rate;
		
		if( is_numeric( $grade_id ) && is_numeric( $instructor_id ) )
		{
			$query = "SELECT recgrade FROM `" . $table_rate . "` WHERE `ins_id` = " . $instructor_id;
		
			$result = mysql_query( $query ) or die( mysql_error( ) ) ;
			
			$IsGradeExist = mysql_num_rows( $result ); 
		
			$CountTotalGrades = 0;
			$CountOnlyThisGrade = 0;
			
			if( $IsGradeExist )
			{
				while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )  //h2h5p
				{
					if( $row[ 'recgrade' ] == $grade_id )
					{
						$CountOnlyThisGrade++;
					}
					
					$CountTotalGrades++;
				}
				
				$resultis = $CountOnlyThisGrade / $CountTotalGrades * 100;
				
				return round( $resultis, 2 );
	
				
			}
			else
			{
				return "0";
			}
		}
		else
		{
			return "Error"; 
		}
	}
	
	function FindPercentageLod( $lod_id, $instructor_id ) // alllodsofthisid / totallodsofins * 100 = %
	{
		global $table_rate;
		
		if( is_numeric( $lod_id ) && is_numeric( $instructor_id ) )
		{
			$query = "SELECT lod FROM `" . $table_rate . "` WHERE `ins_id` = " . $instructor_id;
		
			$result = mysql_query( $query ) or die( mysql_error( ) ) ;
			
			$IsLodExist = mysql_num_rows( $result ); 
		
			$CountTotalLods = 0;
			$CountOnlyThisLod = 0;
			
			if( $IsLodExist )
			{
				while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )  //h2h5p
				{
					if( $row[ 'lod' ] == $lod_id )
					{
						$CountOnlyThisLod++;
					}
					
					$CountTotalLods++;
				}
				
				$resultis = $CountOnlyThisLod / $CountTotalLods * 100;
				
				return round( $resultis, 2 );
	
				
			}
			else
			{
				return "0";
			}
		}
		else
		{
			return "Error"; 
		}
	}
	
	function FindPercentageTestPattern( $test_pattern_id, $instructor_id ) // allTPsofthisid / totalTPsofins * 100 = %
	{
		global $table_rate;
		
		if( is_numeric( $test_pattern_id ) && is_numeric( $instructor_id ) )
		{
			$query = "SELECT test_pattern FROM `" . $table_rate . "` WHERE `ins_id` = " . $instructor_id;
		
			$result = mysql_query( $query ) or die( mysql_error( ) ) ;
			
			$IsTestPatternExist = mysql_num_rows( $result ); 
		
			$CountTotalTps = 0;
			$CountOnlyThisTp = 0;
			
			if( $IsTestPatternExist )
			{
				while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )  //h2h5p
				{
					if( $row[ 'test_pattern' ] == $test_pattern_id )
					{
						$CountOnlyThisTp++;
					}
					
					$CountTotalTps++;
				}
				
				$resultis = $CountOnlyThisTp / $CountTotalTps * 100;
				
				return round( $resultis, 2 );
	
				
			}
			else
			{
				return "0";
			}
		}
		else
		{
			return "Error"; 
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// numberof x ////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	function NumberofRatesOfInstructor( $ins_id ) // total number of rates of x instructor
	{
		global $website_maxrating, $table_rate;
		
		if( is_numeric( $ins_id ) )
		{
			$query = "SELECT rate FROM `" . $table_rate . "` WHERE `ins_id` = '" . $ins_id . "' AND `rate` <= " . $website_maxrating ;
		
			$result = mysql_query( $query ) or die( mysql_error( ) ) ;
			
			$IsRateExist = mysql_num_rows( $result ); 
			
			if( $IsRateExist )
			{
				//$row = mysql_fetch_assoc( $result ) or die( mysql_error( ) ) ;
				
				return $IsRateExist;
				
			}
			else
			{
				return "0";
			}
		}
		else
		{
			return "Error";
		}
	}
	
function NumberofLodsOfInstructor( $ins_id ) // total number of lods of x instructor
{
	global $website_maxlod, $table_rate;
	
	if( is_numeric( $ins_id ) )
	{
		$query = "SELECT lod FROM `" . $table_rate . "` WHERE `ins_id` = '" . $ins_id . "' AND `lod` <= " . $website_maxlod;
	
		$result = mysql_query( $query ) or die( mysql_error( ) ) ;
		
		$IsLodExist = mysql_num_rows( $result ); 
		
		if( $IsLodExist )
		{
			//$row = mysql_fetch_assoc( $result ) or die( mysql_error( ) ) ;
			
			return $IsLodExist;
			
		}
		else
		{
			return "0";
		}
	}
	else
	{
		return "Error";
	}
}
	
	
function NumberOfSpecificRate( $rate_id, $ins_id ) // find total votes of x rateid of x instructor
{
	global $website_maxrating, $table_rate; 
	
	if( is_numeric( $rate_id ) && is_numeric( $ins_id ) )
	{
		if( $rate_id > $website_maxrating )
		{
			$rate_id = $website_maxrating;
		}	
		
		$query = "SELECT rate FROM `" . $table_rate . "` WHERE `ins_id` = '" . $ins_id . "' AND `rate` = '" . $rate_id . "'";
		
		$result = mysql_query( $query ) or die( mysql_error( ) ) ;
		
		$IsRateExist = mysql_num_rows( $result ); 
		
		if( $IsRateExist )
		{
			return $IsRateExist;
		}
		else
		{
			return "0";
		}
		
	}
	else 
	{
		return "Error";
	}
}

function NumberOfSpecificLod( $lod_id, $ins_id ) // find total number of x lodid of x instructor
{
	global $website_maxlod, $table_rate; 
	
	if( is_numeric( $lod_id ) && is_numeric( $ins_id ) )
	{
		if( $lod_id > $website_maxlod )
		{
			$lod_id = $website_maxlod;
		}	
		
		$query = "SELECT lod FROM `" . $table_rate . "` WHERE `ins_id` = '" . $ins_id . "' AND `lod` = '" . $lod_id . "'";
		
		$result = mysql_query( $query ) or die( mysql_error( ) ) ;
		
		$IsLodExist = mysql_num_rows( $result ); 
		
		if( $IsLodExist )
		{
			return $IsLodExist;
		}
		else
		{
			return "0";
		}
		
	}
	else 
	{
		return "Error";
	}
}

function NumberofAttendance( $ins_id, $yesno ) // total number of attendance of x instructor/ $yesno is 1/0
{
	global $table_rate; 
	
	if( is_numeric( $ins_id ) && is_numeric( $yesno ) )
	{
		$query = "SELECT attendance FROM `" . $table_rate . "` WHERE `ins_id` = '" . $ins_id . "' AND `attendance` = '" . $yesno . "'";
	
		$result = mysql_query( $query ) or die( mysql_error( ) ) ;
		
		$IsAttendanceExist = mysql_num_rows( $result ); 
		
		if( $IsAttendanceExist )
		{	
			return $IsAttendanceExist;
			
		}
		else
		{
			return "0";
		}
	}
	else
	{
		return "Error";
	}
}

function NumberofTakeAgain( $ins_id, $yesno ) // total number of takeagain of x instructor/ $yesno is 1/0
{
	global $table_rate;
	
	if( is_numeric( $ins_id ) && is_numeric( $yesno ) )
	{
		$query = "SELECT take_again FROM `" . $table_rate . "` WHERE `ins_id` = '" . $ins_id . "' AND `take_again` = '" . $yesno . "'";
	
		$result = mysql_query( $query ) or die( mysql_error( ) ) ;
		
		$IsTakeAgainExist = mysql_num_rows( $result ); 
		
		if( $IsTakeAgainExist )
		{	
			return $IsTakeAgainExist;
			
		}
		else
		{
			return "0";
		}
	}
	else
	{
		return "Error";
	}
}

function NumberofTextbooks( $ins_id, $yesno ) // total number of textbook of x instructor/ $yesno is 1/0
{
	global $table_rate;
	
	if( is_numeric( $ins_id ) && is_numeric( $yesno ) )
	{
		$query = "SELECT textbook FROM `" . $table_rate . "` WHERE `ins_id` = '" . $ins_id . "' AND `textbook` = '" . $yesno . "'";
	
		$result = mysql_query( $query ) or die( mysql_error( ) ) ;
		
		$IsTextbookExist = mysql_num_rows( $result ); 
		
		if( $IsTextbookExist )
		{
			
			return $IsTextbookExist;
			
		}
		else
		{
			return "0";
		}
	}
	else
	{
		return "Error";
	}
}

function NumberofTags( )
{
	global $table_tags;
	
	$query = "SELECT id FROM `" . $table_tags . "`";
	
	$result = mysql_query( $query ) or die( mysql_error( ) ) ;
	
	$IsTagExist = mysql_num_rows( $result ); 
	
	return $IsTagExist;
	
}

function GetTotalRatedInstructors( $memberid )
{
	global $table_rate;
	
	if( is_numeric( $memberid ) )
	{
		$query = "SELECT id FROM `" . $table_rate . "` WHERE rater_id = '" . $memberid . "'";
	
		$result = mysql_query( $query ) or die( mysql_error( ) ) ;

		$NumOfInsRated = mysql_num_rows( $result ); 
		
		return $NumOfInsRated;
	}
	else
	{
		return "Error";
	}
}

function TotalNumberofInstructors( )
{
	global $table_instructors;
	
	$query = "SELECT id FROM `" . $table_instructors . "`";
	
	$result = mysql_query( $query ) or die( mysql_error( ) ) ;

	$NumberOfIns = mysql_num_rows( $result ); 
	
	return $NumberOfIns;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// overall / avaerage of data ///////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


function OverAllRating( $instructor_id, $totalrates ) // find average of all rates
{
	global $website_maxrating;
	
	if( is_numeric( $instructor_id ) )
	{
		if( $totalrates > 0 )
		{
			$count_rates = 0;
			
			for( $counter = 1; $counter <= $website_maxrating; $counter++ )
			{
				$count_rates += NumberOfSpecificRate( $counter, $instructor_id ) * $counter;
			}
			
			$overall = $count_rates / $totalrates;
			
			return round( $overall, 1 );
		}
		else
		{
			return 0;
		}	
	}
	else
	{
		return "Error";
	}
}

function OverAllLod( $instructor_id, $totallod ) // find average of all lods
{
	global $website_maxlod;
	
	if( is_numeric( $instructor_id ) )
	{
		if( $totallod > 0 )
		{
			$count_lods = 0;
			
			for( $counter = 1; $counter <= $website_maxlod; $counter++ )
			{
				$count_lods += NumberOfSpecificLod( $counter, $instructor_id ) * $counter;
			}
			
			$overall = $count_lods / $totallod;
			
			return round( $overall, 1 );
		}
		else
		{
			return 0;
		}	
	}
	else
	{
		return "Error";
	}
}

//overall quality has lod and rate both averages.

function OverallQuality( $instructor_id, $nameornumber = 1 ) // 1 = name / 0 = number
{
	//OVERALL QUALITY (GOOD: 3.5-5, AVERAGE: 2.5-3.4, POOR: 1-2.4)

	global $website_maxrating, $website_maxlod;
	
	if( is_numeric( $instructor_id ) && is_numeric( $nameornumber ) )
	{
		
		$tnumberoflod = NumberofLodsOfInstructor( $instructor_id );
		$tnumberofrate = NumberofRatesOfInstructor( $instructor_id );
		
		$overall_rate = OverAllRating( $instructor_id, $tnumberofrate );
		$overall_lod = OverAllLod( $instructor_id, $tnumberoflod );
		
		
	/*	if( $overall_lod == $website_maxlod )
		{
			$overall_lod -= 0.1;
		}
	*/	
		$fix_lod = $website_maxlod - $overall_lod;
		
		$take_avg = $overall_rate + $fix_lod;
		$take_avg = $take_avg / 2;
		
		$overall_quality = $take_avg;
		
		if( $nameornumber ) // if name
		{
			if( $overall_lod == 0 || $overall_rate == 0 )
			{
				return "Unknown";
			}
			elseif( $overall_quality > 0 && $overall_quality <= 2.4 )
			{
				return "Poor";
			}
			elseif( $overall_quality >= 2.5 && $overall_quality <= 3.4 )
			{
				return "Average";
			}
			elseif( $overall_quality >= 3.5 && $overall_quality <= 5 )
			{
				return "Good";
			}
			else
			{
				return "Unknown";
			}
		}
		else
		{
			if( $overall_lod == 0 || $overall_rate == 0 )
			{
				return "N/A";
			}
			else
			{
				$result = round( $overall_quality, 1 );
				
				if( !is_decimal( $result ) )
				{
					$result = $result . ".0";
				}
				
				return $result;
			}
		}
		
	}
	else
	{
		return "Error";
	}
	
}

function is_decimal( $val )
{
    return is_numeric( $val ) && floor( $val ) != $val;
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// modes of data ///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

function ModeOfRates( $ins_id ) // find most voted rate through ins_id
{
	global $website_maxrating;
	
	if( is_numeric( $ins_id ) )
	{
		$highest = 0;
		$rate_id = 0;
		
		for( $ratestart = 1; $ratestart <= $website_maxrating; $ratestart++ )
		{
			$number = FindPercentageRate( $ratestart, $ins_id );
			
			if( $number > $highest )
			{
				$highest = $number;
				$rate_id = $ratestart;
			}
			
			
		}
		//return $highest;
		return $rate_id;
	}
	else
	{
		return "Error";
	}
}

function ModeofGrades( $ins_id ) // find most received grade through ins_id
{	
	if( is_numeric( $ins_id ) )
	{
		$highest = 0;
		$grade_id = 0;
		
		$max_grade_number = 11;
		
		for( $gradestart = 1; $gradestart <= $max_grade_number; $gradestart++ )
		{
			$number = FindPercentageGrade( $gradestart, $ins_id );
			
			if( $number > $highest )
			{
				$highest = $number;
				$grade_id = $gradestart;
			}
			
			
		}
		//return $highest;
		return $grade_id;
	}
	else
	{
		return "Error";
	}
}

function ModeOfTextbooks( $ins_id ) // (highest number of yes/no) returns 0 if more notextbooks and 1 if more yes
{
	global $table_rate;
	
	if( is_numeric( $ins_id ) )
	{
		$countyes = 0;
		$countno = 0;
		
		$query = "SELECT textbook FROM `" . $table_rate . "` WHERE `ins_id` = '" . $ins_id . "'";
		
		$result = mysql_query( $query ) or die( mysql_error( ) ) ;
		
		$IsAvail = mysql_num_rows( $result ); 
		
		if( $IsAvail )
		{
			while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
			{
				if( $row[ 'textbook' ] == 0 )
				{
					$countno++;
				}
				else
				{
					$countyes++;
				}
			}
			
			if( $countno > $countyes )
			{
				return "0";
			}
			else
			{
				return "1";
			} 
			
		}
		else
		{
			return "Error";
		}
	}
	else
	{
		return "Error";
	}
}

function ModeOfAttendance( $ins_id )// (highest number of yes/no) returns 0 if more attendance and 1 if more yes
{
	global $table_rate;
	
	if( is_numeric( $ins_id ) )
	{
		$countyes = 0;
		$countno = 0;
		
		$query = "SELECT attendance FROM `" . $table_rate . "` WHERE `ins_id` = '" . $ins_id . "'";
		
		$result = mysql_query( $query ) or die( mysql_error( ) ) ;
		
		$IsAvail = mysql_num_rows( $result ); 
		
		if( $IsAvail )
		{
			while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
			{
				if( $row[ 'attendance' ] == 0 )
				{
					$countno++;
				}
				else
				{
					$countyes++;
				}
			}
			
			if( $countno > $countyes )
			{
				return "0";
			}
			else
			{
				return "1";
			} 
			
		}
		else
		{
			return "Error";
		}
	}
	else
	{
		return "Error";
	}
}

function ModeOfTakeAgain( $ins_id )// (highest number of yes/no) returns 0 if more takeagain and 1 if more yes
{
	global $table_rate;
	
	if( is_numeric( $ins_id ) )
	{
		$countyes = 0;
		$countno = 0;
		
		$query = "SELECT take_again FROM `" . $table_rate . "` WHERE `ins_id` = '" . $ins_id . "'";
		
		$result = mysql_query( $query ) or die( mysql_error( ) ) ;
		
		$IsAvail = mysql_num_rows( $result ); 
		
		if( $IsAvail )
		{
			while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
			{
				if( $row[ 'take_again' ] == 0 )
				{
					$countno++;
				}
				else
				{
					$countyes++;
				}
			}
			
			if( $countno > $countyes )
			{
				return "0";
			}
			else
			{
				return "1";
			} 
			
		}
		else
		{
			return "Error";
		}
	}
	else
	{
		return "Error";
	}
}

function ModeofLod( $ins_id ) // // find most voted lod through ins_id 
{
	global $website_maxlod;
	
	if( is_numeric( $ins_id ) )
	{
		$highest = 0;
		$lod_id = 0;
		
		for( $lodstart = 1; $lodstart <= $website_maxlod; $lodstart++ )
		{
			$number = FindPercentageLod( $lodstart, $ins_id );
			
			if( $number > $highest )
			{
				$highest = $number;
				$lod_id = $lodstart;
			}
			
			
		}
		//return $highest;
		return $lod_id;
	}
	else
	{
		return "Error";
	}
}

function ModeofTestPattern( $ins_id ) // // find most voted test_pattern through ins_id 
{
	if( is_numeric( $ins_id ) )
	{
		$highest = 0;
		$test_pattern_id = 0;
		
		for( $testpatternstart = 1; $testpatternstart <= 5; $testpatternstart++ )
		{
			$number = FindPercentageTestPattern( $testpatternstart, $ins_id );
			
			if( $number > $highest )
			{
				$highest = $number;
				$test_pattern_id = $testpatternstart;
			}
		}
		//return $highest;
		return $test_pattern_id;
	}
	else
	{
		return "Error";
	}
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////// UPDATE //////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

function GiveRespect( $memberid )
{
	global $website_giverespect, $smf_members;
	
	if( is_numeric( $memberid ) )
	{
		$query = "UPDATE " . $smf_members . " SET karma_good = karma_good + " . $website_giverespect . " WHERE id_member = '" . $memberid . "'";
		
		$result = mysql_query( $query ) or die( mysql_error( ) ) ;
	}
	else
	{
		return "<br>Error: Couldn't update respect points.";
	}
	
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// string functions: join, singular/plural /////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


function join_string( $array, $comma ) // joins an array with commas or own splitter | it excludes empty strings
{
    return implode( $comma, array_filter( $array ) );
} 

function AddS( $number, $string, $_ ) // makes a word plural or singular (es/s) or present, past (ed)
{
	if( empty( $number ) )
	{
		$number = 0;
	}
	if( is_numeric( $number ) && !empty( $string ) && !empty ( $_ ) )
	{
		if( $number <= 1 )
		{
			return $string;
		}
		else
		{
			return $string . $_;
		}
	}
	else
	{
		return "Error";
	}
}

function CheckWords( $variable )
{
	//return preg_replace('/([a-zA-Z]{25})(?![^a-zA-Z])/', '$1 ', $variable); 

	//return wordwrap( $variable, 65, "<br>", true );
	
	return preg_replace('/([^\s]{22})/', '$1 ', $variable);
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// CHART DATA //////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


function CreateLodDataForPieChart( $instructor_id ) // lod data
{	
	global $website_maxlod;
	
	$piedata = array( );
	
	for( $lodstart = 1; $lodstart <= $website_maxlod; $lodstart++ )
	{
		$name = getlodname( $lodstart );
		$numberoflods = NumberOfSpecificLod( $lodstart, $instructor_id );
		
		$piedata[ ] = array( $name, $numberoflods );
	}
	
	return $piedata;
}



function CreateRateDataForBarChart( $instructor_id ) // bar data for rates
{	

	global $website_maxrating;
	
	for( $ratestart = 1; $ratestart <= $website_maxrating; $ratestart++ )
	{
		$percentage = FindPercentageRate( $ratestart, $instructor_id );
		
		$name = getratename( $ratestart );
		
		$numberofrates = NumberOfSpecificRate( $ratestart, $instructor_id );
		
		$colorofbars = "color: #3d9970";
	
		
		echo "['" . $name . "', " . $numberofrates . ", '" . $percentage . "%', '" . $colorofbars . "']";
		
		if( $ratestart != $website_maxrating )
		{
			echo ",";
		}
		
	} 
}




?>