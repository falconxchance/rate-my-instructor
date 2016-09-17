<?php

global $table_instructors;

echo "<h4><font size='+2'>Search</font></h4>";

echo "<p>In this page you will be able to search for instructors you are looking for.</p>";



	if ( !isset( $_POST[ 'submit' ] ) ) // show form if not submitted
    { 	
?>
        <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
        
            <div class="form_settings">
                        
                          
                <p><span>Type an instructor's name to search. (ex: Cader)</span><input type="text" name="search_kw"/></p>
        
        
                <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="submit" value="Search" /></p>
                
                </div>
        
        </form>
 <?php 
 	
		
	}
	else // process search query
	{
		$search_kw = $_POST[ 'search_kw' ];
		
		
		if( empty( $search_kw ) ) 
		{
			echo "<p>Error: Incomplete Information... Please <a href='javascript:history.back()'>go back</a> and fix it.</p>";
		}
		elseif( strlen( $search_kw ) < 3 ) 
		{
			echo "<p>Error: Instructor name too short. Please <a href='javascript:history.back()'>go back</a> and fix it.</p>";
			
		}
		elseif( strlen( $search_kw ) > 30 ) 
		{
			echo "<p>Error: Instructor name too long. Please <a href='javascript:history.back()'>go back</a> and fix it.</p>";
			
		}
		else // if everything goes well...
		{
			echo "<center><font size='+2'>You searched for <b><i>" . $search_kw . "</i></b></font></center>";
			
	?>
				<div class="form_settings" align="right">
				<form>
				
                
                	<input class="submit" type="button" value="Go Back" onclick="window.location.href='javascript:history.back()'" />
				
                
                </form>
				</div>
				
	<?php
			
			$search_kw = strip_tags( $search_kw ); 
			$search_kw = trim( $search_kw );
			
			$search_kw = mysql_escape_string( $search_kw );
			
			
			$query = "SELECT ins_name, email, department FROM " . $table_instructors . " WHERE ins_name LIKE '%" . $search_kw . "%' OR department LIKE '%" . $search_kw . "%' OR email LIKE '%" . $search_kw . "%'";
	
			$result = mysql_query( $query ) or die( mysql_error( ) ) ;
			
			$IsExist = mysql_num_rows( $result ); 
			
			$count = 0;
			
			if( $IsExist )
			{
			
			
				echo '<table style="width:100%; border-spacing:0; border: 1px solid black;">';
				
				echo "<tr><th>No.</th><th>Name</th><th>Department</th><th>Email</th></tr>";
			
			
				while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) ) 
				{
					$count++;
					
					echo "<tr><td><center>" . $count . "</center></td><td><a href='index.php?page=instructor&name=" . $row[ 'ins_name' ] . "' class='ids' title='Show " . $row[ 'ins_name' ] . "&#39;s rating'>" . $row[ 'ins_name' ] . "</a></td><td>" . $row[ 'department' ] . "</td><td>" . generateemail( $row[ 'email' ] ) . "</td></td>";
					
				}
			
			
				echo "</table>";
				
				echo "<p>We found <b>" . $count . "</b> " . AddS( $count, "instructor", "s" ) . " from given information.</p>";
			}
			else
			{
				echo "<p>Sorry but we couldn't find any instructor from the given information.</p>";
			}
				
		}
	
	}
        
        
?>