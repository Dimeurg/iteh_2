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

echo $_POST['playerName'];
echo "<br>";
getGames($_POST['playerName']);

?>
