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

function printResult($result)
{
	echo "<table border='1'>";
	
	echo "<tr>";
	for($i = 0; $i < $result->columnCount(); ++$i)
		{
			echo "<td>".$result->getColumnMeta($i)['name']."</td>";
		}
	echo "</tr>";
	
	while($row = $result->fetch(PDO::FETCH_NUM))
	{
		echo "<tr>";
		for($i = 0; $i < $result->columnCount(); ++$i)
		{
			echo "<td>".$row[$i]."</td>";
		}
		echo "</tr>";
	}
	
	echo "</table>";
}

function getGames($league)
{
	$query = "Select distinct g.* from 
			Game g, Team t
			where (g.FID_Team1 = t.ID_Team or g.FID_Team2 = t.ID_Team)
			and t.league = ?";

	$result= executeQuery($query, $league);
	printResult($result);
}

echo $_POST['leagueName'];
echo "<br>";
getGames($_POST['leagueName']);

?>
