<?php 

// Path to your forum's SSI.php (SMF's "Server Side Include" bootstrap),
// used here to read the logged-in user/session for auth.
require( "/path/to/your/forum/SSI.php" );

require( "connect.php" );

require( "scripts/retrieve_script_data.php" );
require( "scripts/functions.php" );

/*if( !isset( $_SESSION[ 'login_url' ] ) )
{
	$_SESSION[ 'login_url' ] = curPageURL( );
}

if( !isset( $_SESSION[ 'logout_url' ] ) )
{
	$_SESSION[ 'logout_url' ] = curPageURL( );
}*/


$requested_page = $_GET[ 'page' ];

$requested_ins_name = $_GET[ 'name' ];

$requested_page_number = $_GET[ 'p' ];

$requested_comment_page = $_GET[ 'c' ];

if( !strcasecmp( $requested_page, "main" ) || !$requested_page )
{
	$page_title = "Recent Ratings";
}
elseif( !strcasecmp( $requested_page, "myratings" ) || !strcasecmp( $requested_page, "myrating" ) )
{
	if( is_numeric( $requested_page_number ) || !$requested_page_number )
	{
		if( !$requested_page_number || $requested_page_number == 1 )
		{
			$page_title = "My Ratings";
		}
		else
		{
			$page_title = "My Ratings (Page: " . $requested_page_number . ")";
		}
	}
	else
	{
		$page_title = "My Ratings (Page: ERROR)";
	}
}
elseif( !strcasecmp( $requested_page, "instructor" ) )
{
	if( !$requested_ins_name || $requested_ins_name == "all"  )
	{
		if( !$requested_page_number || $requested_page_number == 1 )
		{
			$page_title = "Instructors";
		}
		else
		{
			$page_title = "Instructor (Page: " . $requested_page_number;
		}
	}
	else
	{	
		$html_decode = html_entity_decode( $requested_ins_name );
		$page_title = ucwords( $html_decode );
	}
}
elseif( !strcasecmp( $requested_page, "rate" ) )
{
	if( !$requested_ins_name )
	{
		$page_title = "Rate: Unknown";
	}
	else
	{
		$html_decode = html_entity_decode( $requested_ins_name );
		$page_title = "Rate: " . ucwords( $html_decode );
	}
}
elseif( !strcasecmp( $requested_page, "search" ) )
{
	$page_title = "Search";
}
elseif( !strcasecmp( $requested_page, "finishrate" ) )
{
	$page_title = "Finish Rating";
}
elseif( !strcasecmp( $requested_page, "admin" ) )
{
	$page_title = "Admin Center";
}
elseif( !strcasecmp( $requested_page, "suggestinstructor" ) )
{
	$page_title = "Suggest Instructor";
}
elseif( !strcasecmp( $requested_page, "mysuggestedinstructors" ) )
{
	$page_title = "My Suggested Instructors";
}
else
{
	$page_title = "PAGE NOT FOUND";
}

?>

<!DOCTYPE HTML>
<html>

<head>
  <title><?php echo $page_title . " - " . $website_title; ?></title>
  <meta name="description" content="<?php echo $website_description ?>" />
  <meta name="keywords" content="<?php echo $website_keywords ?>" />
 <?php /* <meta http-equiv="content-type" content="text/html; charset=windows-1252" /><meta charset="utf-8"> */ ?>
 
 <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="style/style.css" />

<?php include( "scripts/loadcharts.php" ) ?>
  
</head>

<body>
  <div id="main">
    <div id="header">
      <div id="logo">
        <div id="logo_text">
          
          <h1></h1>
          <h2></h2>
        </div>
        <div id="contact_details">
        
        <?php /* ?>
        
          <p><a href="mailto:<?php echo $website_webmaster ?>"><?php echo $website_webmaster ?></a></p>
		  
		  */ ?>
        </div>
      </div>
      <div id="menubar">
        
          <?php require( "scripts/navbar.php" ); ?>
        
      </div>
    </div>
    <div id="site_content">
    
    <?php 
	
	if( $requested_page !== "instructor" ) 
  	{	
	
		if( $requested_page !== "admin" )
		{
	
	
	?>
    
      <div class="sidebar">
        
        
        <p>
           
   <?php 
								
			if ( $context[ 'user' ][ 'is_guest' ] )
			{
				echo "You must <a href='http://your-forum.example.com/index.php?action=login'>login</a> before you can rate any instructor.";
			}
			else
			{
				ssi_welcome( );
				
				$RespectPoints = GetRespectPoints( $context[ 'user' ][ 'id' ] );
				
				echo "<br><br>";
				
				echo "<b>Respect:</b> " . $RespectPoints;
				
				//echo " <a href='#'><img src='style/question.gif' title='What is Respect?'></a><br>";
				
				
				echo "<br>";
			
				$NumOfInsRated = GetTotalRatedInstructors( $context[ 'user' ][ 'id' ] );
				 
			
				echo "<b>Total Instructors Rated:</b> " . $NumOfInsRated;
				
				echo "<br><br>";
				
				echo "<a href='index.php?page=mysuggestedinstructors'><img src='style/suggest.gif' title='suggested instructors by you'> My Suggested Instructors</a>";
			
				
				
			}
			
			?>
            
        </p>
        
        <h3>Latest News</h3>
        
        <?php require( "scripts/s_latestnews.php"); ?>
        
        <p></p>
        
        
        <?php 
		
		
		/* ?>
        <h3>Search</h3>
        <form method="post" action="#" id="search_form">
          <p>
            <input class="search" type="text" name="search_field" value="Enter keywords..." />
            <input name="search" type="image" style="border: 0; margin: 0 0 -9px 5px;" src="style/search.png" alt="Search" title="Search" />
          </p>
        </form>
		css file
		text-transform: uppercase;
		
	*/	
	
	
	?>
    
    
      </div>
      
      <?php }
	  
	}
	   ?>
      
      <div id="content<?php if( $requested_page == "instructor" || $requested_page == "admin" ) { echo "_ins"; } ?>">
      
     
       
        
        <?php


				// main page	

				if( $requested_page == "main" || !$requested_page )
				{
					require( "pages/main.php" );
					
				}
				
				// my rating page
				
				elseif( $requested_page == "myratings" || $requested_page == "myrating" )
				{
					
                    require( "pages/myratings.php" );
					
				}
				
				// instructor page
				
				elseif( $requested_page == "instructor" )
				{
					
					require( "pages/instructor.php" );
					
				}
				
				// search page
				
				elseif( $requested_page == "search" )
				{ 
					require( "pages/search.php" );
				}
				
				// rate form
				
				elseif( $requested_page == "rate" )
				{
					require( "pages/rate.php" );
				}
				
				
				// finish rate process
				
				elseif( $requested_page == "finishrate" )
				{
					
					require( "pages/finishrate.php" );
					
				}
				
				
				// admin page
				
				elseif( $requested_page == "admin" )
				{
					require( "pages/admincenter.php" );
					
				}
				
				// suggest instructor
				
				elseif( $requested_page == "suggestinstructor" )
				{
					require( "pages/suggestinstructor.php" );
				}
				
				
				// my suggested instructors
				
				elseif( $requested_page == "mysuggestedinstructors" )
				{
					require( "pages/mysuggestedinstructors.php" );
				}
				
				
				// no page requested
				
				else
				{ ?>
				
				<h2>Page Not Found</h2>
				
				<p>Seems like you are lost. Please get back to the <a href="javascript:history.back()">previous page</a>.</p>
				
				
				
				<?php
				}


?>
        
       	<br><br>
        
        <center><table>
        
        <tr><td><b><?php echo $website_disclaimer; ?></b></td></tr>
        
        </table></center>
        
      </div>
    </div>
    <div id="footer">
      <?php echo "<b>" . $website_title . "</b> - " . $website_version; ?> | <?php echo $website_footer ?>
    </div>
  </div>
 
  
</body>
</html>
<?php
//<br><font size="-2">Inspired by RateMyProfessor (but not affiliated)</font>
?>