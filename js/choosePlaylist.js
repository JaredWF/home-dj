var userHash;
var ui_url;
var api_url;

window.onload = function () {
  userHash = $("#hash").text();
  ui_url = $("#ui_url").text();
  api_url = $("#api_url").text();

  addClickHandlers();
};

function addClickHandlers() {
	$( ".clickable" ).click(function() {
		var id = $( this ).parent().attr("id");
		selectPlaylist(id);
	})
}

function selectPlaylist(playlistID) {
  $.ajax({  
    type: "POST",  
    url: api_url + "/" + userHash + "/choose-playlist",  
    crossDomain: true,
    data: JSON.stringify(
        {id: playlistID}
    ),
    contentType: "application/json",
    dataType   : "json",
    success: function(response){  
      console.log("playlist chosen");
      console.log(response);
      window.location.href = ui_url + "/playlist.php?hash=" + userHash;
    },
    error: function(xhr, status, error){  
      console.log(status);
      console.log(xhr.responseText);
      console.log(error);
    }
  });
}