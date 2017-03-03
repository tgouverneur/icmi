function ajaxRemoveJoblog(id) {

        var scrolledX, scrolledY;
	var cb_infos;

	if( self.pageYOffset ) {
	  scrolledX = self.pageXOffset;
	  scrolledY = self.pageYOffset;
	} else if( document.documentElement && document.documentElement.scrollTop ) {
	  scrolledX = document.documentElement.scrollLeft;
	  scrolledY = document.documentElement.scrollTop;
	} else if( document.body ) {
	  scrolledX = document.body.scrollLeft;
	  scrolledY = document.body.scrollTop;
	}

	var centerX, centerY;
	if( self.innerHeight ) {
	  centerX = self.innerWidth;
	  centerY = self.innerHeight;
	} else if( document.documentElement && document.documentElement.clientHeight ) {
	  centerX = document.documentElement.clientWidth;
	  centerY = document.documentElement.clientHeight;
	} else if( document.body ) {
	  centerX = document.body.clientWidth;
	  centerY = document.body.clientHeight;
	}

	  var leftOffset = scrolledX + (centerX - 400) / 2;
	  var topOffset = scrolledY + (centerY - 100) / 2;

	  fadeBGD('#A9A9A9');
          document.getElementById("form_id").value = id;
	  document.getElementById("confirmDel").style.top = topOffset + "px";
	  document.getElementById("confirmDel").style.left = leftOffset + "px";
	  document.getElementById("confirmDel").style.display = "block";
}

function confirmRemove() {

  var id = document.getElementById("form_id").value;

  /* send the request to save the device */
  var params;
  var xmlDoc;
  var xmlhttp = buildXMLHTTP();
  if (xmlhttp === false) {
  return false;
  }

  xmlhttp.onreadystatechange=function()
  {
     if(xmlhttp.readyState==4) {
       xmlDoc = xmlhttp.responseXML;
       txtDoc = xmlhttp.responseText;
       var id = document.getElementById("form_id").value;
       document.getElementById("details_" + id).innerHTML = '';
       document.getElementById("confirmDel").style.display="none";
       unfadeBGD();
     }
  }
  params = "id=" + id;

  xmlhttp.open("POST","ajax/joblogRemove.php",true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.setRequestHeader("Content-length", params.length);
  xmlhttp.setRequestHeader("Connection", "close");
  xmlhttp.send(params);
  return true;

}

