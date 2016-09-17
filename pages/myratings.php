<?php

global $table_rate;

if( !$requested_page_number || $requested_page_number == 1 )
{
	echo "<h4><font size='+2'>My Ratings</font></h4>";
}
else
{
	echo "<h4><font size='+2'>My Ratings (Page: " . $requested_page_number . ")</font></h4>";
}
	
	if ( $context[ 'user' ][ 'is_guest' ] )
	{
		echo "Dear " . $context[ 'user' ][ 'name' ] . ", you need to <a href='http://your-forum.example.com/index.php?action=login'>login</a> (or <a href='http://your-forum.example.com/index.php?action=register'>register</a>) before you can view your ratings.";
	}
	else
	{
		$total_rating_show = $website_myratingpage;
		
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
			
			$start_from = ( $page - 1 ) * $total_rating_show; 
	
			$query = "SELECT * FROM " . $table_rate . " WHERE rater_id=" . $context[ 'user' ][ 'id' ] . " AND `rate` <= " . $website_maxrating . " ORDER BY id DESC LIMIT " . $start_from . ", " . $total_rating_show;
			
			$result = mysql_query( $query ) or die( mysql_error( ) ) ;
			
			$IsRatingExist = mysql_num_rows( $result ); 
			
			$countratings = $start_from;
			
			if( $IsRatingExist )
			{
				if( $page == 1 )
				{
					//process of showing the user's rating.
					echo "Dear " . $context[ 'user' ][ 'name' ] . ", following are the instructors you have rated:<br><br>";
				}
			
				while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )  //h2h5p
				{ 
					$countratings++;
				
				?>
					<h4><?php echo "<a href='index.php?page=instructor&name="; insname( $row[ 'ins_id' ] ); echo "'><img src='style/open.gif'></a>     " . $countratings . ". "; insname( $row[ 'ins_id' ] ); ?></h4>
					
					<h5>Rated on <?php echo generatetime( $row[ 'time' ] );  ?></h5>
					
					 <?php generatestars( $row[ 'rate' ] ); ?>
	   
					<table style='width:100%; border-spacing:0; border: 1px solid black;'>
					
					<tr><th>List</th><th>Rating</th></tr>
					
					<tr><td><strong>Rate</strong> <i>(<?php echo $row[ 'rate' ] . " out of " . $website_maxrating; ?>)</i></td><td><?php echo getratename( $row[ 'rate' ] ); ?></td></tr>
					<tr><td><strong>Level of Difficulty</strong> <i>(<?php echo $row[ 'lod' ] . " out of " . $website_maxlod; ?>)</i></td><td><?php echo getlodname( $row[ 'lod' ] ); ?></td></tr>
					<tr><td><strong>Course you took with this instructor</strong></td><td><?php echo $row[ 'course_name' ]; ?></td></tr>
					<tr><td><strong>Will you take this instructor again?</strong></td><td><?php echo YesNo( $row[ 'takeagain' ] ); ?></td></tr>
					<tr><td><strong>Requires Textbook?</strong></td><td><?php echo YesNo( $row[ 'textbook' ] ); ?></td></tr>
					<tr><td><strong>Attendance</strong></td><td><?php echo Attendance( $row[ 'attendance' ] ); ?></td></tr>
			<?php /*		<tr><td><strong>Hot?</strong></td><td><?php echo YesNo( $row[ 'hotness' ] ); ?></td></tr> */?>
					<tr><td><strong>Grade Received</strong></td><td><?php echo generategrade( $row[ 'recgrade' ] ); ?></td></tr>
                    
                    <tr><td><strong>Test Pattern</strong></td><td><?php echo GetTestInfoNames( $row[ 'test_pattern' ] ); ?></td></tr>
					
				   
					<?php 
					
					$tag_one = gettagname( $row[ 'tag1' ] );
					$tag_two = gettagname( $row[ 'tag2' ] );
					$tag_three = gettagname( $row[ 'tag3' ] );
					
					$tag_array = array( $tag_one, $tag_two, $tag_three );
					
					$comment = $row[ 'comment' ];
					
					if( $comment == "" || is_null( $comment ) || empty( $comment ) )
					{
						$rcomment = "No comments.";
					}
					else
					{
						$rcomment = $comment;
					}
					
					
					?>
					<tr><td><strong>Tags</strong></td><td><?php echo join_string( $tag_array, ", " ) . "."; ?></td></tr>
					
					<tr><td><strong>Your comments:</strong></td><td><?php echo $rcomment; ?> </td></tr>
					
				   </table>
				   
								  
					<?php 
					
						if( $countratings < $IsRatingExist )
						{
							echo "<hr><br>";
						}
					
				}// while loop end
				
					$query = "SELECT rater_id FROM " . $table_rate . " WHERE rater_id=" . $context[ 'user' ][ 'id' ] . " AND `rate` <= " . $website_maxrating; 
					$result = mysql_query( $query ); 
					$total_records = mysql_num_rows( $result );
					$total_pages = ceil( $total_records / $total_rating_show );
				
			
					if( $total_pages > 1 )
					{ 
						 
						 if( $page > 1 )
						 {
							 $previouspage = $page - 1;
							 echo "<a href='index.php?page=myratings&p=" . $previouspage . "'>Prev</a> - ";
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
								echo "<a href='index.php?page=myratings&p=". $i . "'>". $i ."</a>  -  ";
							}
						} 
						
						if( $page < $total_pages )
						 {
							 $nextpage = $page + 1;
							 echo "<a href='index.php?page=myratings&p=" . $nextpage . "'>Next</a>";
						 }
					}
				
				echo "<br><br>";
					
				echo "* <i>You have rated <strong>" . $total_records . "</strong> " . AddS( $total_records, "instructor", "s" ) . " so far.</i>";	
				
				
			}
			else
			{
				echo "Dear " . $context[ 'user' ][ 'name' ] . ", You haven't rated any instructor yet.";
			}
		}
		
	}
			echo "</p>";		
					
?>