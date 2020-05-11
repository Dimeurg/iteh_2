<?php

function console_log( $data )
{
	echo '<script>';
	echo 'console.log('. json_encode( $data ) .')';
	echo '</script>';
}

function executeQuery($query, $league)
{
	$driver = "mysql"; 
	$hostname = "localhost"; $port = "3307"; 
	$dbname = "db_lab";
	$dsn = "$driver:host=$hostname;port=$port;dbname=$dbname";
	
	try
	{
		$dbh = new PDO($dsn, "root", "root");		
		$sth = $dbh->prepare($query);
		$sth->execute(array($league));
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

function printResult($statement)
{
	$jsonResults = json_encode($statement->fetchAll(PDO::FETCH_ASSOC));
	header('Content-type: application/json');
	echo $jsonResults;	
}

function getGames($league)
{
	$query = "Select distinct g.* from 
			Game g, Team t
			where (g.FID_Team1 = t.ID_Team or g.FID_Team2 = t.ID_Team)
			and t.league = ?";

	$statement= executeQuery($query, $league);
	printResult($statement);
}

getGames($_REQUEST['leagueName']);
?>
