<!DOCTYPE HTML>
<html>
    <head>
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="css/searchStyle.css">
        <script src="js/jquery-2.2.0.js"></script>
        <script src='js/Search.js'></script>
        <title>DJ Station</title>
    </head>
  <body id="body">
  	<div id="title">Playlist Title</div>
  	<div>
  		<table id="tab_table">
  			<tr>
  				<td class="tab">
            <a href="<?php 
              parse_str($_SERVER['QUERY_STRING']); 
              echo "http://localhost/playlist.php?hash=" . $hash;
            ?>">Playlist</a>
  				</td>
  				<td class="tab" id="selected_tab">
            <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']?>">Search</a>
          </td>
  			</tr>
  		</table>
      <form action="search.php" method="get">
        <div id="search_bar">
          <input type="hidden" name="hash" value="<?php 
              parse_str($_SERVER['QUERY_STRING']); 
              echo $hash; ?>" /> 
          <input type="text" id="search_text" name="query"/>
          <input id="search_button" value="Search" type="submit" />
        </div>
      </form>
  	</div>
    <table id="results">
      <?php
      	parse_str($_SERVER['QUERY_STRING']);

        if(empty($_REQUEST['query'])) {
          echo "<img id='new_search_image' src='images/NewSearchMessage.png'/>";
        } else {
          $json_url = "https://api.spotify.com/v1/search?type=track&q=" . $query;
          $add_url = "localhost:8080/" . $hash . "/add";

          $cURL = curl_init();
          curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($cURL, CURLOPT_URL,$json_url);

          $result = curl_exec($cURL); // Getting jSON result string

          curl_close($cURL);
          $json_root = json_decode($result, true);
          //var_dump($json_root["tracks"]["items"]);

          foreach($json_root["tracks"]["items"] as $track){
            $albumList = $track["album"]["images"];
            $albumImg = $albumList[count($albumList) - 1]["url"];
            $artist = "";
            foreach($track["artists"] as $art) {
              $artist = $artist . $art["name"] . ", ";
            }
            $artist = rtrim($artist, ", ");

            echo "<tr>
                <td><img class='album_image' src='{$albumImg}'></td>
                <td class='song_text'>
                  <div class='song_title'>{$track['name']}</div>
                  <div class='artist_name'>{$artist}</div>
                </td>
                <td>
                  <img class='add_button' id='{$track['id']}' src='images/AddButton.png' border='0'/>
                </td>
              </tr>";
          }
        }
      ?>
    </table>
  </body>
</html>