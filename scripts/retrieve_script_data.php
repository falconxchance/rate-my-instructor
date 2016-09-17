<?php


$query = "SELECT * FROM " . $table_script . " LIMIT 1";

$result = mysql_query( $query ) or die( mysql_error( ) ) ;

$row = mysql_fetch_array( $result, MYSQL_ASSOC );

  $website_title = $row[ 'title' ];
  $website_description = $row[ 'description' ];
  $website_version = $row[ 'version' ];
  $website_keywords = $row[ 'keywords' ];
  $website_webmaster = $row[ 'webmaster' ];
  $website_footer = $row[ 'footer' ];
  
  $website_maxrating = $row[ 'maxrating' ];
  $website_maxlod = $row[ 'maxlod' ];
  $website_maxrecentratings = $row[ 'maxrecentratings' ];
  
  $website_ratename_1 = $row[ 'rate_name_1' ];
  $website_ratename_2 = $row[ 'rate_name_2' ];
  $website_ratename_3 = $row[ 'rate_name_3' ];
  $website_ratename_4 = $row[ 'rate_name_4' ];
  $website_ratename_5 = $row[ 'rate_name_5' ];
  
  $website_lodname_1 = $row[ 'lod_name_1' ];
  $website_lodname_2 = $row[ 'lod_name_2' ];
  $website_lodname_3 = $row[ 'lod_name_3' ];
  $website_lodname_4 = $row[ 'lod_name_4' ];
  $website_lodname_5 = $row[ 'lod_name_5' ];
  
  $website_myratingpage = $row[ 'myratingpage' ];
  
  $website_numberofinstructors = $row[ 'numberofinstructors' ];
  
  $website_disablecomments = $row[ 'disablecomments' ];
  
  $website_numberofcomments = $row[ 'numberofcomments' ];
  
  $website_disclaimer = $row[ 'disclaimer' ];
  
  $website_giverespect = $row[ 'giverespect' ];
  
  $website_respectsuggest = $row[ 'respectsuggest' ];
  
 

?>