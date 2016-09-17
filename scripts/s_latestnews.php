<?php

$BlogsToShow = 3;
$limitchars = 20; //18
$BlogBoard = 1.0;
$LengthBody = 100;

$lol = ssi_boardNews( $BlogBoard, $BlogsToShow, null, $LengthBody, 'array' );

//$lol = ssi_recentTopics( $BlogsToShow, null, $BlogBoard, 'array' );

	foreach ( $lol as $news_ )
	{
			
		$short_subject = ( strlen( $news_[ 'subject' ] ) > $limitchars ) ? substr( $news_[ 'subject' ], 0, $limitchars ) . '...' : $news_[ 'subject' ];
		
		echo "<h4>" . $short_subject . "</h4>";
		echo "<h5>" . $news_[ 'time' ] . "</h5>";
		
		echo "<p>" . $news_[ 'body' ] . "<a href=" . $news_[ 'href' ] . ">..</a></p>";
		
	}
    
	
	
	
	
	/*

echo "<br><br><hr><br><br>";

$receive = 1000000;
$years = 10;
$increase = 590000;
$interestrate = 1.069;

$sum = $receive;
$increment = 0; 
$addval = 0;

echo '<table style="width:100%; border-spacing:0; border: 1px solid black;">';
echo '<tr><th>Year (' . $years . ')</th><th>Sum (' . $receive . ' += ' . $increase . ')</th><th>Present Value (sum/' . $interestrate . '^eachyear)</th></tr>';

for( $count = 1; $count <= $years; $count++ )
{
	$increment++; // 1
	$sum += $increase; // 1590000
	
	echo "<tr><td>" . $increment . "</td><td>" . $sum . "</td>";
	$val = $sum / ( $interestrate ) ** $increment; 
	echo "<td>" . round( $val, 2 ) . "</td></tr>";
	
 	$addval += $val;
	
}
	echo "</table>";

	echo "<br><br>";
	
	$addedval = round( $addval, 2 );
	$answer = 1000000 + $addedval;
	echo "Answer: " . $receive . " + " . $addedval . " = <b>" . $answer . "</b>";

	

?>

<br><br><hr><br><br>

<?php

*/
	
	
	
	
    ?>