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
	$( ".add_btn" ).click(function() {
    $(this).find('i').addClass("fa-circle-o-notch").addClass("fa-spin").removeClass("fa-plus");
    addSong($(this).attr('id'), $(this).find('i'));
	})
}

function addSong(songID, button) {
  $.ajax({  
    type: "POST",  
    url: api_url + "/" + userHash + "/add",  
    crossDomain: true,
    data: JSON.stringify(
        {uri: songID}
    ),
    contentType: "application/json",
    dataType   : "text",
    success: function(response){  
      button.removeClass("fa-circle-o-notch").removeClass("fa-spin").addClass("fa-check");
    },
    error: function(xhr, status, error){  
      console.log(status);
      console.log(xhr.responseText);
      console.log(error);
      button.removeClass("fa-circle-o-notch").removeClass("fa-spin").addClass("fa-plus");
      if (xhr.responseText == "Song already in playlist") {
        var toast = $("#snackbar");
        toast.addClass("show");
        setTimeout(function(){ toast.removeClass("show"); }, 3000);
      }
    }
  });
}