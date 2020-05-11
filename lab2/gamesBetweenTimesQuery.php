<?php
require "vendor/autoload.php";

function console_log( $data )
{
	echo '<script>';
	echo 'console.log('. json_encode( $data ) .')';
	echo '</script>';
}

function printResult($result)
{
	$htmlResult = "<table border='1'>";
	$htmlResult = $htmlResult."<tr>";
		
		$htmlResult = $htmlResult."<td>"."league"."</td>";
		$htmlResult = $htmlResult."<td>"."date"."</td>";
		$htmlResult = $htmlResult."<td>"."place"."</td>";
		$htmlResult = $htmlResult."<td>"."team1"."</td>";
		$htmlResult = $htmlResult."<td>"."team2"."</td>";
		$htmlResult = $htmlResult."<td>"."score1"."</td>";
		$htmlResult = $htmlResult."<td>"."score2"."</td>";
		
	$htmlResult = $htmlResult."</tr>";
	foreach ($result as $entry) {
		$date = $entry['date']->toDateTime()->format(\DateTime::ISO8601);
		
		$htmlResult = $htmlResult."<tr>";
			$htmlResult = $htmlResult."<td>".$entry['league']."</td>";
			$htmlResult = $htmlResult."<td>".$date."</td>";
			$htmlResult = $htmlResult."<td>".$entry['place']."</td>";
			$htmlResult = $htmlResult."<td>".$entry['teams'][0]."</td>";
			$htmlResult = $htmlResult."<td>".$entry['teams'][1]."</td>";
			$htmlResult = $htmlResult."<td>".$entry['score'][0]."</td>";
			$htmlResult = $htmlResult."<td>".$entry['score'][1]."</td>";
		$htmlResult = $htmlResult."</tr>";
	}
	
	$htmlResult = $htmlResult."</table>";
	
	header('Content-type: application/html');
	echo $htmlResult;	
}

function getGames($timeStart, $timeEnd)
{
	$client = new MongoDB\Client("mongodb://127.0.0.1:27017");
	$db = $client->dbforlab;
	$collectionGames = $db->games;

	$result = $collectionGames->find(['date' => ['$gte' => new MongoDB\BSON\UTCDateTime(strtotime($timeStart) * 1000), '$lt' => new MongoDB\BSON\UTCDateTime(strtotime($timeEnd) * 1000)]]);

	printResult($result);
}

getGames($_REQUEST['timeStart'], $_REQUEST['timeEnd']);

?>
