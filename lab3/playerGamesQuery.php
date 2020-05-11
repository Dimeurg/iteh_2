<?php

function console_log( $data ){
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
	$doc = new DOMDocument('1.0', 'UTF-8');
	$xmlResult = $doc->createElement('games');
	
	$meta = $doc->createElement('gamesMeta');
	for($i = 0; $i < $result->columnCount(); ++$i)
	{
		$name = $result->getColumnMeta($i)['name'];
		$meta->appendChild($doc->createElement($name, $name));
	}
	$xmlResult->appendChild($meta);
	
	while($row = $result->fetch(PDO::FETCH_NUM))
	{
		$game = $doc->createElement('game');
	
		for($i = 0; $i < $meta->childNodes->length; $i++)
		{
			$child = $meta->childNodes->item($i);
			$game->appendChild($doc->createElement($child->nodeValue, $row[$i]));
		}
	
		$xmlResult->appendChild($game);
	}
	
	$doc->appendChild($xmlResult);
	
	header('Content-type: application/xml');
	echo $doc->saveXML();

}

function getGames($playerName)
{
	$query = "Select distinct g.* from 
			Game g, Team t, Player p
			where (g.FID_Team1 = t.ID_Team or g.FID_Team2 = t.ID_Team)
			and p.FID_Team = t.ID_Team
			and p.name = '$playerName'";

	$result= executeQuery($query);
	printResult($result);
}

getGames($_REQUEST['playerName']);

?>
