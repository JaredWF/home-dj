var resultList;
var domain;
var hash;
var tabNumber = 0;
var port = "8080";

window.onload = function () {
  var url = window.location.href;
  var domainOffset = url.indexOf("/", 7);
  domain = url.slice(7, domainOffset);

  var hashOffset = url.indexOf("hash") + 5
  hash = url.slice(hashOffset, hashOffset + 6);

  hookAddButtons();
};

function hookAddButtons() {
  var addButtons = document.getElementsByClassName("add_button")
  var arrayLength = addButtons.length;
  
  for (var i = 0; i < arrayLength; i++) {
    addButtons[i].addEventListener('click', function (e) {
      this.removeEventListener('click', arguments.callee, false);
      //this.src = "./CheckButton.png";
      var songId = this.id
      $.ajax({  
        type: "POST",  
        url: domain + ":" + port + "/" + hash + "/add",  
        data: JSON.stringify(
            {id: songId}
        ),
        contentType: "application/json",
        dataType   : "text",
        success: function(response){  
          alert(response);
        },
        error: function(xhr, status, error){  
          alert(status);
          alert(xhr.responseText);
          alert(error);
        }
      });
    });
  }
}