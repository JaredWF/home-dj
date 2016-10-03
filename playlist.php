<!DOCTYPE HTML>
<html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <?php
        $domain = getenv('api_url');
        $ui_url = getenv('ui_url');
        parse_str($_SERVER['QUERY_STRING']);


        $json_url = $domain . "/" . $hash . '/get-playlist-name';
        $cURL = curl_init( $json_url );
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);
        $playlist_name = curl_exec($cURL); // Getting jSON result string

        curl_close($cURL);
      ?>
      <title><?php echo $playlist_name; ?> | Crowd DJ</title>


      <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
      <!-- Bootstrap -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="css/search-style-bootstrap.css">
    </head>
  <body id="body">
    <div class="container">
      <div class="header row">
        <div class="playlist_title">
          <h1><?php echo $playlist_name; ?></h1>
        </div>

        <div>
          <a href=<?php echo $ui_url . "/playlist.php?hash=" . $hash; ?>><div class="col-xs-6 tab selected_tab"><h3>Playlist</h3></div></a>
          <a href=<?php echo $ui_url . "/search.php?hash=" . $hash ?>><div class="col-xs-6 tab"><h3>Search</h3></div></a>
        </div>
      </div>


      <div class="row">
        <table id="results" class="col-xs-12">
          <?php

    				$json_url = $domain . "/" . $hash . '/get-all-songs';
            //$json_url = 'home-dj.herokuapp.com/' . $hash . '/getAllSongs';
    				$cURL = curl_init( $json_url );
    				curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);
    				$result = curl_exec($cURL); // Getting jSON result string

    				curl_close($cURL);
    				$json_array = json_decode($result, true);
    				//var_dump($json_array);

    				foreach($json_array as $json){
    				  echo "<tr>
    				   		<td><img class='album_image' src='{$json['imageURL']}'></td>
    				   		<td class='song_text'>
    				   			<div class='song_title'><h3>{$json['name']}</h3></div>
    				   			<div class='artist_name'><h4>{$json['artist']}</h4></div>
    				   		</td>
    				   	</tr>"; // you can access your key value like this if result is array
    				   //echo $json->name; // you can access your key value like this if result is object
    				}

          ?>
        </table>

      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>