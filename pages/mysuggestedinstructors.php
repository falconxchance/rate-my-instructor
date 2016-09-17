
<h4><font size='+2'>My Suggested Instructors</font></h4>

<?php

global $table_suggestinstructor;

if ( $context[ 'user' ][ 'is_logged' ] ) 
{
			$query = "SELECT insname, insinfo, timestamp FROM " . $table_suggestinstructor . " WHERE whosubmit = " . $context[ 'user' ][ 'id' ];
	
			$result = mysql_query( $query ) or die( mysql_error( ) ) ;
			
			$IsExist = mysql_num_rows( $result ); 
			
			$count = 0;
			
			if( $IsExist )
			{
				echo "<table style='width:100%; border-spacing:0; border: 1px solid black;'>";
					
				echo "<tr><th>#</th><th>Instructor</th><th>Information</th><th>Time</th></tr>";
					
					
					
				while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) ) 
				{
					$count++;
					
					echo "<tr><td>" . $count . "</td><td>" . $row[ 'insname' ] . "</td><td>" . CheckWords( $row[ 'insinfo' ] ) . "</td><td>" . generatetime( $row[ 'timestamp' ], 1 ) . "</td></tr>";
				
					
				}
				
				echo "</table>";
				
				echo "<br>";
				echo "<p>You have suggested <b>" . $count . " " . AddS( $count, "instructor", "s" ) . "</b>. Thank you for contributing :)</p>";
			}
			else
			{
				echo "<p>Error: You have not suggested any instructor yet. <a href='index.php?page=suggestinstructor'>Click here</a> to suggest instructors.</p>";
			}

}
else // if not logged in
{
	echo "<p>Error: You need to login or register before you can view your suggested instructors.</p>";
}



?>
        