<!DOCTYPE HTML>
<html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <title>Choose Playlist | Crowd DJ</title>
      <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
      <!-- Bootstrap -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="css/start-authorize-style-bootstrap.css">
    </head>
  <body id="body">
    <div class="container">
      <div class="row">
        <h1>Choose a playlist</h1>
        <?php
          $domain = getenv('api_url');
          $ui_url = getenv('ui_url');
          parse_str($_SERVER['QUERY_STRING']);

          $json_url = $domain . '/finish-authorize?code=' . $code;
          $cURL = curl_init( $json_url );
          curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);
          $hash = curl_exec($cURL);
          curl_close($cURL);
          echo "<p hidden id='hash'>{$hash}</p>";
          echo "<p hidden id='ui_url'>{$ui_url}</p>";
          echo "<p hidden id='api_url'>{$domain}</p>";


          $json_url = $domain . '/' . $hash . "/get-playlists";
          $cURL = curl_init( $json_url );
          curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);
          $result = curl_exec($cURL); // Getting jSON result string

          curl_close($cURL);

          $json_array = json_decode($result, true);

          foreach($json_array as $json){
            echo "<div class='playlist_card col-xs-12 col-sm-6 col-md-4' id='{$json['id']}'>
                    <img class='album_image clickable' src='{$json['imageURL']}'>
                    <div class='playlist_text clickable'><h3>{$json['name']}</h3></div>
                    <div class='playlist_text clickable'>{$json['trackCount']} Songs</div>
                  </div>";
          }
        ?>
      </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="js/choosePlaylist.js"></script>
  </body>
</html>