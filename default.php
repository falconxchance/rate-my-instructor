<?php 

// Path to your forum's SSI.php (SMF's "Server Side Include" bootstrap),
// used here to read the logged-in user/session for auth.
require( "/path/to/your/forum/SSI.php" );
require( "connect.php" );

require( "scripts/retrieve_script_data.php" );

$requested_page = $_GET[ 'page' ];

$requested_ins_name = $_GET[ 'name' ];

if( !strcasecmp( $requested_page, "main" ) || !$requested_page )
{
	$page_title = "Recent Ratings";
}
elseif( !strcasecmp( $requested_page, "myratings" ) || !strcasecmp( $requested_page, "myrating" ) )
{
	$page_title = "My Ratings";
}
elseif( !strcasecmp( $requested_page, "instructors" ) )
{
	if( !$requested_ins_name )
	{
		$page_title = "Instructors";
	}
	else
	{	
		$html_decode = html_entity_decode( $requested_ins_name );
		$page_title = ucwords( $html_decode );
	}
}
elseif( !strcasecmp( $requested_page, "search" ) )
{
	$page_title = "Search";
}
else
{
	$page_title = "PAGE NOT FOUND";
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <link rel="stylesheet" type="text/css" href="style.css">
        
		<title><?php echo $page_title . " - " . $website_title; ?></title>
	 
	
	</head>
	
	<body>
		<div id="wrapper">
		
			<main>
				<div id="content">
					<div class="innertube">
                    
						<center><h1><?php echo $website_title; ?></h1>
                        
                        <?php echo $website_description; ?>
						
                       <p> <?php 
						
						require( "scripts/navbar.php" ); 
						
						echo "</center><h2>" . $page_title . "</h2><HR><BR>";
						
						require( "scripts/pages.php" );
						
						?>
                        
                        </p>
                      
                      
					</div>
				</div>
			</main>
			
			<nav id="nav">
				<div class="innertube">
                    
                
                        <p>
                        
                        <img src="style/logo.png" width="200" ><BR>
                        	<?php 
								
								if ( $context[ 'user' ][ 'is_guest' ] )
                                {
                                    echo "You must <a href='http://your-forum.example.com/index.php?action=login'>login</a> before you can rate any instructor.<BR>";
                                }
                                else
                                {
                                    ssi_welcome( );
                                } 
								
								ssi_menubar( );
								?>
                        </p>
                        
                       
				</div>
			</nav>
			
		</div>
        <div class="innertube">
         <p><?php echo $website_title . " " . $website_version; ?> | <a href="http://your-forum.example.com/index.php/page,imprint.html">Imprint</a> | <a href="http://your-forum.example.com/index.php/board,4.0.html">Changelog</a> | <a href="http://your-forum.example.com/index.php/page,disclaimer.html">Disclaimer</a></p>
         </div>
	</body>
    
</html>

<?php mysql_close( $_dbcon ); ?>