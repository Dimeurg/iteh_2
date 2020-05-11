<?php

function console_log( $data )
{
	echo '<script>';
	echo 'console.log('. json_encode( $data ) .')';
	echo '</script>';
}

function executeQuery($query)
{
	$driver = "mysql"; $hostname = "localhost"; $port = "3307"; $dbname = "db_lab";
	$dsn = "$driver:host=$hostname;port=$port;dbname=$dbname";
	
	try
	{
		$dbh = new PDO($dsn, "root", "root");		
		$sth = $dbh->query($query);
		if(!$sth)
		{
			console_log("Bad query<br>");
		}
		
		else
		{
			return $sth;
		}
	}
	
	catch(PDOException $e)
	{
		console_log("Error!: " . $e->getMessage() . "<br/>");
	}		
}

function printResult($result)
{
	
	$htmlResult = "<table border='1'>";
	
	$htmlResult = $htmlResult."<tr>";
	for($i = 0; $i < $result->columnCount(); ++$i)
	{
		$htmlResult = $htmlResult."<td>".$result->getColumnMeta($i)['name']."</td>";
	}
	$htmlResult = $htmlResult."</tr>";
	
	while($row = $result->fetch(PDO::FETCH_NUM))
	{
		$htmlResult = $htmlResult."<tr>";
		for($i = 0; $i < $result->columnCount(); ++$i)
		{
			$htmlResult = $htmlResult."<td>".$row[$i]."</td>";
		}
		$htmlResult = $htmlResult."</tr>";
	}
	
	$htmlResult = $htmlResult."</table>";
	
	header('Content-type: application/html');
	echo $htmlResult;	
}

function getGames($timeStart, $timeEnd)
{
		
	$query = "Select distinct * from Game
		where date between 
		'$timeStart' and '$timeEnd'";

	$result= executeQuery($query);
	printResult($result);
}

getGames($_REQUEST['timeStart'], $_REQUEST['timeEnd']);

?>
