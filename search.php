<!DOCTYPE HTML>
<html class="fill">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
      $domain = getenv('api_url');
      $ui_url = getenv('ui_url');
      parse_str($_SERVER['QUERY_STRING']);


      $json_url = $domain . "/" . $hash . '/get-playlist-name';
      $cURL = curl_init( $json_url );
      curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);
      $playlist_name = curl_exec($cURL); // Getting jSON result string

      curl_close($cURL);
      echo "<p hidden id='hash'>{$hash}</p>";
      echo "<p hidden id='ui_url'>{$ui_url}</p>";
      echo "<p hidden id='api_url'>{$domain}</p>";
    ?>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $playlist_name; ?> | Crowd DJ</title>


    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/search-style-bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body id="body" <?php if(empty($_REQUEST['query'])) {
              echo "class='fill'";
            } ?>>
    <div <?php if(empty($_REQUEST['query'])) {
              echo "class='container fill'";
            } else {
              echo "class='container'";
            } ?>>

      <div id="snackbar">Song already in playlist</div>
      <div class="header row">
        <div class="playlist_title">
          <h1><?php echo $playlist_name ?></h1>
        </div>

        <div>
          <a href=<?php echo $ui_url . "/playlist.php?hash=" . $hash; ?>><div class="col-xs-6 tab"><h3>Playlist</h3></div></a>
          <a href=<?php echo $ui_url . "/search.php?hash=" . $hash; ?>><div class="col-xs-6 tab selected_tab"><h3>Search</h3></div></a>
        </div>


        <div class="col-lg-12 no_padding">
          <form action="search.php" method="GET">
            <div class="input-group input-group-lg">
              <input type="hidden" name="hash" value=<?php echo $hash; ?>>
              <input type="text" class="form-control" id="search" name="query" placeholder="Search">
              <span class="input-group-btn">
                <button class="btn" type="submit">Search</button>
              </span>
            </div><!-- /input-group -->
          </form>
        </div><!-- /.col-lg-6 -->
      </div><!-- /.header -->


      <div class="row">
        <table id="results" class="col-xs-12">

          <?php
            parse_str($_SERVER['QUERY_STRING']);

            if(empty($_REQUEST['query'])) {
              echo "<div style='text-align: center; color: white; padding-top: 20px'><i class='fa fa-search fa-5x' aria-hidden='true'></i></div>";
            } else {
              $json_url = "https://api.spotify.com/v1/search?type=track&q=" . filter_var($query, FILTER_SANITIZE_ENCODED);
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
                $id  = $track['uri'];

                echo "<tr>
                    <td><img class='album_image' src='{$albumImg}'></td>
                    <td class='song_text'>
                      <div class='song_title'><h3>{$track['name']}</h3></div>
                      <div class='artist_name'><h4>{$artist}</h4></div>
                    </td>
                    <td>
                      <button type='button' class='btn add_btn' id='{$id}'><i class='fa fa-plus fa-2x'></i></button>
                    </td>
                  </tr>";
              }
            }
          ?>
        </table>
      </div>

    </div><!-- container -->








    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="js/addSong.js"></script>
  </body>
</html>