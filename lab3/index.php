ajax
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

<html>
<head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript">

	function parseJsonForLeague(json)
	{
		responseTable = "<table border='1'>";
		responseTable += "			"
			+ "<tr>					"
			+ "	<td>ID_Game</td>	"
			+ "	<td>date</td>       "
			+ "	<td>place</td>      "
			+ "	<td>FID_Team1</td>  "
			+ "	<td>FID_Team2</td>  "
			+ "</tr>                ";
			
		for (var i = 0; i < json.length; i++) 
		{
			responseTable += ""
			+ "<tr>"
			+ "	<td>" + json[i].ID_Game + "</td>"
			+ "	<td>" + json[i].date  	 + "</td>"
			+ "	<td>" + json[i].place    + "</td>"
			+ "	<td>" + json[i].FID_Team1+ "</td>"
			+ "	<td>" + json[i].FID_Team2+ "</td>"
			+ "</tr>";
		}
		responseTable += "</table>";
		
		return responseTable;
	}
	
	function parseXMLForPlajet(xml)
	{
		responseTable = "<table border='1'>";
		
		var metaData = xml.getElementsByTagName("gamesMeta");
		for(i = 0; i < metaData.length; i++) 
		{
			metaRow = metaData[i].childNodes;
			responseTable += "<tr>";
			
			for(j = 0; j < metaRow.length; j++)
			{
				responseTable += "<td>" + metaRow[j].firstChild.nodeValue  + "</td>"
			}
			responseTable += "</tr>";
		}
			
		var games = xml.getElementsByTagName("game");
		for(i = 0; i < games.length; i++) 
		{
			game = games[i].childNodes;
			
			responseTable += "<tr>";
			for(j = 0; j < game.length; j++)
			{
				responseTable += "<td>" + game[j].firstChild.nodeValue  + "</td>"
			}
			responseTable += "</tr>";
		}
		responseTable += "</table>";
		
		return responseTable;
	}

	$( document ).ready(function()
	{
		$("button[id=buttonLeague]").click(
			function(e)
			{
				e.preventDefault();
				$.ajax
				({					
					type: "get",
					url: "leagueGamesQuery.php",
					data: $("#formLeague").serialize(),
					
					success: function(data) 
					{
						$('#result_form').html(parseJsonForLeague(data));
					}
				});
			}
		);
		
		$("button[id=buttonBetweenTimes]").click(
			function(e)
			{
				e.preventDefault();
				$.ajax
				({					
					type: "get",
					url: "gamesBetweenTimesQuery.php",
					data: $("#formBetweenTimes").serialize(),
					
					success: function(data) 
					{
						$('#result_form').html(data);
					}
				});
			}
		);
		
		$("button[id=buttonPlayer]").click(
			function(e)
			{
				e.preventDefault();
				$.ajax
				({					
					type: "get",
					url: "playerGamesQuery.php",
					data: $("#formPlayer").serialize(),
					
					success: function(data) 
					{
						console.log("xml");
						console.log(data);
						$('#result_form').html(parseXMLForPlajet(data));
					}
				});
			}
		);
	});
	
</script>
</head>

<body>
<form id = "formLeague">
	league name
		<select name="leagueName">
			<?php addLeagues(); ?>
		</select><br>

    <button id = "buttonLeague">games for league</button>
</form>

<form id = "formBetweenTimes">
	time start	
		<input type="text", name="timeStart">
	time end	
		<input type="text", name="timeEnd"><br>
	<button id = "buttonBetweenTimes">games between times</button>
</form>

<form id = "formPlayer">
	player name
		<select id="playerName" name="playerName">
			<?php addPlayers(); ?>
		</select><br>
	<button id = "buttonPlayer">games for player</button>
</form>

<div id="result_form"></div> 

</body></html>