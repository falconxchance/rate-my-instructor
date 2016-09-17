
<h4><font size='+2'>Admin Center</font></h4>

<?php

global $table_suggestinstructor;

if ( $context[ 'user' ][ 'is_logged' ] ) 
{
	if ( $context[ 'user' ][ 'is_admin' ] ) 
	{
	
		echo "<p>Welcome to admin center, " . $context[ 'user' ][ 'name' ] . ".</p>";
		
		echo "<br>";
		
		echo "<h4><font size='+2'>Recent Suggested Instructors</font></h4>";
		
		$query = "SELECT whosubmit, insname, insinfo, timestamp FROM " . $table_suggestinstructor;
	
			$result = mysql_query( $query ) or die( mysql_error( ) ) ;
			
			$IsExist = mysql_num_rows( $result ); 
			
			$count = 0;
			
			if( $IsExist )
			{
				echo "<table style='width:100%; border-spacing:0; border: 1px solid black;'>";
					
				echo "<tr><th>#</th><th>Suggested by</th><th>Instructor</th><th>Information</th><th>Time</th></tr>";
					
					
					
				while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) ) 
				{
					$count++;
					
					echo "<tr><td>" . $count . "</td><td>" . ratername( $row[ 'whosubmit' ] ) . "</td><td>" . $row[ 'insname' ] . "</td><td>" . CheckWords( $row[ 'insinfo' ] ) . "</td><td>" . generatetime( $row[ 'timestamp' ] ) . "</td></tr>";
				
					
				}
				
				echo "</table>";
				
				echo "<br>";
				echo "<p>There are <b>" . $IsExist . " suggested " . AddS( $IsExist, "instructor", "s" ) . "</b> in database.</p>";
			}
			else
			{
				echo "<p>Error: You there are no suggested instructor in database.</p>";
			}
	
	}
	else
	{

		echo "<p>You are not allowed to access this section. Please get back to the <a href='javascript:history.back()'>previous page</a></p>";
	}

}
else // if not logged in
{
	echo "<p>You are not allowed to access this section. Please get back to the <a href='javascript:history.back()'>previous page</a> or login if you're one of the administrators.</p>";
}



?>
        