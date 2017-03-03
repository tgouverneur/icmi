function ajaxRefreshDevice(id, xmlDoc)
{
		document.getElementById("d_hostname_" + id).innerHTML = xmlDoc.getElementsByTagName("hostname")[0].getAttribute('value')+ "." + xmlDoc.getElementsByTagName("domain")[0].getAttribute('value');
		document.getElementById("d_ip_" + id).innerHTML = xmlDoc.getElementsByTagName("address")[0].getAttribute('value');
		if (document.getElementById("d_ip_" + id).innerHTML == "") {
			document.getElementById("d_ip_" + id).innerHTML = "n/a";
		}
		document.getElementById("d_port_" + id).innerHTML = xmlDoc.getElementsByTagName("port")[0].getAttribute('value');
		document.getElementById("d_flavour_" + id).innerHTML = xmlDoc.getElementsByTagName("version")[0].getAttribute('flavour');
		document.getElementById("d_version_" + id).innerHTML = xmlDoc.getElementsByTagName("version")[0].getAttribute('ver');
		document.getElementById("d_cfgver_" + id).innerHTML = xmlDoc.getElementsByTagName("version")[0].getAttribute('cfg');

		if (xmlDoc.getElementsByTagName("use_ip")[0].getAttribute('value') == "1") {
			document.getElementById("d_uip_" + id).innerHTML = '<img src="img/tick.png" alt=""/>';
		} else {
			document.getElementById("d_uip_" + id).innerHTML = '<img src="img/cross.png" alt=""/>';
		}

		if (xmlDoc.getElementsByTagName("https")[0].getAttribute('value') == "1") {
			document.getElementById("d_https_" + id).innerHTML = '<img src="img/tick.png" alt=""/>';
		} else {
			document.getElementById("d_https_" + id).innerHTML = '<img src="img/cross.png" alt=""/>';
		}

		if (xmlDoc.getElementsByTagName("enabled")[0].getAttribute('value') == "1") {
			document.getElementById("d_enabled_" + id).innerHTML = '<img src="img/tick.png" alt=""/>';
		} else {
			document.getElementById("d_enabled_" + id).innerHTML = '<img src="img/cross.png" alt=""/>';
		}

		if (xmlDoc.getElementsByTagName("autobackup")[0].getAttribute('value') == "1") {
			document.getElementById("d_autobackup_" + id).innerHTML = '<img src="img/tick.png" alt=""/>';
		} else {
			document.getElementById("d_autobackup_" + id).innerHTML = '<img src="img/cross.png" alt=""/>';
		}

		if (xmlDoc.getElementsByTagName("changed")[0].getAttribute('value') == "") {
			document.getElementById("d_changed_" + id).innerHTML = "n/a";
		} else {
			document.getElementById("d_changed_" + id).innerHTML = xmlDoc.getElementsByTagName("changed")[0].getAttribute('value');
		}
		if (xmlDoc.getElementsByTagName("updated")[0].getAttribute('value') == "") {
			document.getElementById("d_updated_" + id).innerHTML = "n/a";
		} else {
			document.getElementById("d_updated_" + id).innerHTML = xmlDoc.getElementsByTagName("updated")[0].getAttribute('value');
		}
		// update online status
	
		if (xmlDoc.getElementsByTagName("online")[0].getAttribute('value') == "1") {
			document.getElementById("d_online_" + id).innerHTML = '<img src="img/accept.png" alt=""/> Device online';
		} else {
			document.getElementById("d_online_" + id).innerHTML = '<img src="img/cancel.png" alt=""/> Device offline';
		}

		document.getElementById("msgBox").style.display = "none";
}

function ajaxRemoveDevice(id, xmlDoc) {

        var scrolledX, scrolledY;
	var cb_infos;
	document.getElementById("confirmDelTitle").innerHTML = "Do you really want to delete " + xmlDoc.getElementsByTagName("hostname")[0].getAttribute('value')+ "." + xmlDoc.getElementsByTagName("domain")[0].getAttribute('value') + " ?";

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

	  document.getElementById("form_id").value = id;
	  fadeBGD('#A9A9A9');
	  document.getElementById("confirmDel").style.top = topOffset + "px";
	  document.getElementById("confirmDel").style.left = leftOffset + "px";
	  document.getElementById("confirmDel").style.display = "block";
}

function getDeviceInfos(id, callback) {

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
			callback(id, xmlDoc);
		}
	}
	params = "id=" + id;
        xmlhttp.open("POST","ajax/deviceDatas.php",true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.setRequestHeader("Content-length", params.length);
        xmlhttp.setRequestHeader("Connection", "close");
        xmlhttp.send(params);
        return true;
}

function ajaxEditDevice(id, xmlDoc) {

	document.getElementById("form_hostname").value = xmlDoc.getElementsByTagName("hostname")[0].getAttribute('value');
	document.getElementById("form_domain").value = xmlDoc.getElementsByTagName("domain")[0].getAttribute('value');
	document.getElementById("form_ipaddress").value = xmlDoc.getElementsByTagName("address")[0].getAttribute('value');
	document.getElementById("form_port").value = xmlDoc.getElementsByTagName("port")[0].getAttribute('value');
	if (xmlDoc.getElementsByTagName("use_ip")[0].getAttribute('value') == 1) {
		document.getElementById("form_useip").checked = true;
	} else {
		document.getElementById("form_useip").checked = false;
	}

	if (xmlDoc.getElementsByTagName("https")[0].getAttribute('value') == 1) {
		document.getElementById("form_https").checked = true;
	} else {
		document.getElementById("form_https").checked = false;
	}

	if (xmlDoc.getElementsByTagName("enabled")[0].getAttribute('value') == 1) {
		document.getElementById("form_enabled").checked = true;
	} else {
		document.getElementById("form_enabled").checked = false;
	}

	if (xmlDoc.getElementsByTagName("autobackup")[0].getAttribute('value') == 1) {
		document.getElementById("form_autobackup").checked = true;
	} else {
		document.getElementById("form_autobackup").checked = false;
	}
	document.getElementById("form_id").value = xmlDoc.getElementsByTagName("id")[0].getAttribute('value');


	var scrolledX, scrolledY;
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

	  var leftOffset = scrolledX + (centerX - 650) / 2;
	  var topOffset = scrolledY + (centerY - 550) / 2;

	  fadeBGD('#A9A9A9');

          document.getElementById("form_hostname").disabled = false;
          document.getElementById("form_domain").disabled = false;
          document.getElementById("form_ipaddress").disabled = false;
          document.getElementById("form_port").disabled = false;
          document.getElementById("form_useip").disabled = false;
          document.getElementById("form_https").disabled = false;
          document.getElementById("form_enabled").disabled = false;
          document.getElementById("form_autobackup").disabled = false;

	  document.getElementById("editPopup").style.top = topOffset + "px";
	  document.getElementById("editPopup").style.left = leftOffset + "px";
	  document.getElementById("editPopup").style.display = "block";
}

function saveDevice() {

  var id;
  var hostname;
  var domain;
  var ip;
  var port;
  var useip;
  var https;
  var enabled;
  var autobackup;

  document.getElementById("form_hostname").disabled = true;
  document.getElementById("form_domain").disabled = true;
  document.getElementById("form_ipaddress").disabled = true;
  document.getElementById("form_port").disabled = true;
  document.getElementById("form_useip").disabled = true;
  document.getElementById("form_https").disabled = true;
  document.getElementById("form_enabled").disabled = true;
  document.getElementById("form_autobackup").disabled = true;
 
  id = document.getElementById("form_id").value;
  hostname = document.getElementById("form_hostname").value;
  domain = document.getElementById("form_domain").value;
  ip = document.getElementById("form_ipaddress").value;
  port = document.getElementById("form_port").value;
  if (document.getElementById("form_useip").checked) {
    useip = 1;
  } else {
    useip = 0;
  }
  if (document.getElementById("form_https").checked) {
    https = 1;
  } else {
    https = 0;
  }
  if (document.getElementById("form_enabled").checked) {
    enabled = 1;
  } else {
    enabled = 0;
  }
  if (document.getElementById("form_autobackup").checked) {
    autobackup = 1;
  } else {
    autobackup = 0;
  }

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
       document.getElementById("editPopup").style.display="none"; 
       unfadeBGD();
       getDeviceInfos(document.getElementById("form_id").value, ajaxRefreshDevice);
     }
  }
  params = "id=" + id;
  params = params + "&hostname=" + hostname;
  params = params + "&domain=" + domain;
  params = params + "&ip=" + ip;
  params = params + "&port=" + port;
  params = params + "&useip=" + useip;
  params = params + "&https=" + https;
  params = params + "&enabled=" + enabled;
  params = params + "&autobackup=" + autobackup;

  xmlhttp.open("POST","ajax/deviceSave.php",true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.setRequestHeader("Content-length", params.length);
  xmlhttp.setRequestHeader("Connection", "close");
  xmlhttp.send(params);
  return true;
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
       document.getElementById("details_"+id).innerHTML = '';
       document.getElementById("confirmDel").style.display="none";
       unfadeBGD();
     }
  }
  params = "id=" + id;

  xmlhttp.open("POST","ajax/deviceRemove.php",true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.setRequestHeader("Content-length", params.length);
  xmlhttp.setRequestHeader("Connection", "close");
  xmlhttp.send(params);
  return true;

}
