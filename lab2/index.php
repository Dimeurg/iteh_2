mongo
<?php

require "vendor/autoload.php";
$client = new MongoDB\Client("mongodb://127.0.0.1:27017");
$db = $client->dbforlab;

function getQueryFromStorage($expected_key)
{
	foreach ($GLOBALS["local_storage"] as $key => $value) {
		if($key == $expected_key){
			return value;
		}
	}
	return "";
}

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

function addLeagues(){

	$collection = $GLOBALS["db"]->games;
	$result = $collection->distinct('league');
	foreach ($result as $entry) {
		echo '<option value="'.$entry.'">'.$entry.'</option>';
	}
}

function addPlayers(){
	$collection = $GLOBALS["db"]->teams;
	$result = $collection->find()->toArray();
	
	foreach ($result as $entry) {
		foreach($entry['players'] as $player){
			echo '<option value="'.$player.'">'.$player.'</option>';
		}
	}
}

?>

<html>
<head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript">

	//local_storage = new Map();

	$( document ).ready(function()
	{
		$("button[id=buttonLeague]").click(
			function(e)
			{
				e.preventDefault();
				dateValue = $("#formLeague").serialize();
				
				$.ajax
				({					
					type: "get",
					url: "leagueGamesQuery.php",
					data: dateValue,
					
					success: function(data) 
					{
						console.log("from database");
						localStorage.setItem(dateValue, data);
						$('#result_form').html(data);
					}
				});
				
			}
		);
		
		$("button[id=buttonBetweenTimes]").click(
			function(e)
			{
				e.preventDefault();
				
				dateValue = $("#formBetweenTimes").serialize();

				$.ajax
				({					
					type: "get",
					url: "gamesBetweenTimesQuery.php",
					data: dateValue,
					
					success: function(data) 
					{
						console.log("from database");
						localStorage.setItem(dateValue, data);
						$('#result_form').html(data);
					}
				});
				
			}
		);
		
		$("button[id=buttonPlayer]").click(
			function(e)
			{
				e.preventDefault();
				dateValue = $("#formPlayer").serialize();

				$.ajax
				({					
					type: "get",
					url: "playerGamesQuery.php",
					data: dateValue,
					
					success: function(data) 
					{
						console.log("from database");
						localStorage.setItem(dateValue, data);
						$('#result_form').html(data);
					}
				});
			}
		);
		
		$("button[id=buttonPlayerStorage]").click(
			function(e)
			{
				e.preventDefault();
				dateValue = $("#formPlayer").serialize();
				$('#local').html(localStorage.getItem(dateValue));
			}
		);
		
		$("button[id=buttonBetweenTimesStorage]").click(
			function(e)
			{
				e.preventDefault();
				dateValue = $("#formBetweenTimes").serialize();
				$('#local').html(localStorage.getItem(dateValue));
			}
		);
		
		$("button[id=buttonLeagueStorage]").click(
			function(e)
			{
				e.preventDefault();
				dateValue = $("#formLeague").serialize();
				$('#local').html(localStorage.getItem(dateValue));
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
	<button id = "buttonLeagueStorage">get data from storage</button>
</form>

<form id = "formBetweenTimes">
	time start	
		<input type="text", name="timeStart">
	time end	
		<input type="text", name="timeEnd"><br>
	<button id = "buttonBetweenTimes">games between times</button>
	<button id = "buttonBetweenTimesStorage">get data from storage</button>
</form>

<form id = "formPlayer">
	player name
		<select id="playerName" name="playerName">
			<?php addPlayers(); ?>
		</select><br>
	<button id = "buttonPlayer">games for player</button>
	<button id = "buttonPlayerStorage">get data from storage</button>
</form>

<div id="result_form"></div> 
<div id="local"></div> 

</body></html>