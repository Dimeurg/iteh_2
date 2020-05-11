lab1
<?php

function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

function changeText( $data ){
  echo '<script>';
  echo "$('#idtext').val(". json_encode( $data ) .")";
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

function addLeagues(){
	$query = "Select distinct league from Team";
	$result= executeQuery($query);
	
	foreach($result as $row)
	{
		echo '<option value="'.$row[league].'">'.$row[league].'</option>';
	}
}

function addPlayers(){
	$query = "Select name from Player";
	$result= executeQuery($query);
	
	foreach($result as $row)
	{
		echo '<option value="'.$row[name].'">'.$row[name].'</option>';
	}
}

function getGames($league){
	$query = "Select distinct * from 
			Game g, Team t
			where g.FID_Team1 = t.ID_Team
			or g.FID_Team2 = t.ID_Team 
			and t.league = $league";

	$result= executeQuery($query);
	
	foreach($result as $row)
	{
		echo $row;
	}
}

?>

<html><body>
<form action="leagueGamesQuery.php" method="post">
	league name
		<select name="leagueName">
			<?php addLeagues(); ?>
		</select><br>

    <input type="submit" name="submit" value="games for league" />
</form>

<form action="gamesBetweenTimesQuery.php" method="post">
	time start	
		<input type="text", name="timeStart">
	time end	
		<input type="text", name="timeEnd"><br>
	<input type="submit" name="submit" value="games between times" />
</form>

<form action="playerGamesQuery.php" method="post">
	player name
		<select id="playerName" name="playerName">
			<?php addPlayers(); ?>
		</select><br>
	<input type="submit" name="submit" value="games for player" />
</form>

</body></html>