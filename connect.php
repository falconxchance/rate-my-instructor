<?php

$_dbserver = "localhost";
$_dbuser = "your_db_user";
$_dbpw = "CHANGE_ME";
$_dbdb = "your_db_name";

$_dbcon = mysql_connect( $_dbserver, $_dbuser, $_dbpw );

if ( !$_dbcon )
{
	die('Error: Could not connect | ' . mysql_error( ) );
}
else
{
	mysql_select_db( $_dbdb );

//  echo "connected to '" . $_dbdb . "'.";

}

$table_script = "rmi_script";
$table_rate = "rmi_rate";
$table_instructors = "rmi_instructors";
$table_tags = "rmi_tags";
$table_suggestinstructor = "rmi_addinstructor";

// Table with your members/auth data. Originally an SMF forum's
// `smf_members` table -- point this at your own users table
// (see db/schema.sql for the columns this script expects).
$smf_members = "smf_members";

// Base URL where this script is deployed, and the base URL of
// your forum/login system (used for login/register/logout links).
$website_url = "http://your-site.example.com/rate/";
$forum_url = "http://your-site.example.com";

?>
