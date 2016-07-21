<!DOCTYPE HTML>
<html>
    <head>
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="css/searchStyle.css">
        <title>DJ Station</title>
    </head>
  <body id="body">
  	<div id="title">Playlist Title</div>
  	<div>
  		<table id="tab_table">
  			<tr>
  				<td class="tab" id="selected_tab">
  					<a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']?>">Playlist</a>
  				</td>
  				<td class="tab">
            <a href="<?php 
              parse_str($_SERVER['QUERY_STRING']); 
              echo $_SERVER['HTTP_HOST'] . "/search.php?hash=" . $hash;
            ?>">Search</a>
          </td>
  			<tr>
  		</table>
  	</div>
    <table id="results">
      <?php
      	$domain = $_SERVER['HTTP_HOST'];
      	parse_str($_SERVER['QUERY_STRING']);


				$json_url = 'localhost:8080/' . $hash . '/getAllSongs';
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
				   			<div class='song_title'>{$json['name']}</div>
				   			<div class='artist_name'>{$json['artist']}</div>
				   		</td>
				   	</tr>"; // you can access your key value like this if result is array
				   //echo $json->name; // you can access your key value like this if result is object
				}

      ?>
    </table>
  </body>
</html>