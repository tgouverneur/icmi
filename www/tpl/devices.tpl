    <div id="page">
     <input type="hidden" name="form_id" value=""/>
     <h3>Device list</h3>
     <div class="blocklist">
<?php
       $cnt = count($data["devices"]);
       $i=0;
       foreach ($data["devices"] as $d) {
?>
       <div class="blockelem<?php if ($i % 2) { echo 1; } else { echo 2; } ?>">
         <div id="details_<?php echo $d->id; ?>">
	  <div class="blockleft">
           <dl>
 	    <dt>Hostname:</dt><dd id="d_hostname_<?php echo $d->id; ?>"><?php echo $d->hostname.".".$d->domain; ?> </dd>
	    <dt>IP Address:</dt><dd id="d_ip_<?php echo $d->id; ?>"><?php if (empty($d->address)) { echo "n/a"; } else { echo $d->address; } ?></dd>
	    <dt>Port:</dt><dd id="d_port_<?php echo $d->id; ?>"><?php echo $d->port; ?> </dd>
	    <dt>Flavour:</dt><dd id="d_flavour_<?php echo $d->id; ?>"><?php echo $d->o_version->flavour; ?> </dd>
	    <dt>Version:</dt><dd id="d_version_<?php echo $d->id; ?>"><?php echo $d->o_version->version; ?> </dd>
	    <dt>Updated:</dt><dd id="d_updated_<?php echo $d->id; ?>"><?php echo $d->updated; ?> </dd>
           </dl>
          </div>
          <div class="blockright">
           <dl>
	    <dt>Use IP:</dt><dd id="d_uip_<?php echo $d->id; ?>"><img src="img/<?php if ($d->use_ip) { echo "tick"; } else { echo "cross"; } ?>.png" alt=""/></dd>
	    <dt>HTTPS:</dt><dd id="d_https_<?php echo $d->id; ?>"><img src="img/<?php if ($d->https) { echo "tick"; } else { echo "cross"; } ?>.png" alt=""/></dd>
	    <dt>Enabled:</dt><dd id="d_enabled_<?php echo $d->id; ?>"><img src="img/<?php if ($d->enabled) { echo "tick"; } else { echo "cross"; } ?>.png" alt=""/></dd>
	    <dt>Auto Backup:</dt><dd id="d_autobackup_<?php echo $d->id; ?>"><img src="img/<?php if ($d->autobackup) { echo "tick"; } else { echo "cross"; } ?>.png" alt=""/></dd>
	    <dt>CFG Version:</dt><dd id="d_cfgver_<?php echo $d->id; ?>"><?php echo $d->o_version->cfg_version; ?> </dd>
	    <dt>Changed:</dt><dd id="d_changed_<?php echo $d->id; ?>"><?php echo $d->changed; ?> </dd>
           </dl>
          </div>
         </div>
         <div class="blockactions">
          <button type="button" onclick="getDeviceInfos('<?php echo $d->id; ?>', ajaxRefreshDevice);"><img src="img/arrow_refresh.png" alt=""/> Refresh</button>
          <button type="button" onclick="getDeviceInfos('<?php echo $d->id; ?>', ajaxEditDevice);"><img src="img/application_form_edit.png" alt=""/> Edit</button>
          <button class="negative" type="button" onclick="getDeviceInfos('<?php echo $d->id; ?>', ajaxRemoveDevice);"><img src="img/delete.png" alt=""/> Del.</button>
          <button class="positive" type="button" onclick="ajaxDownloadConfig('<?php echo $d->id; ?>');"><img src="img/arrow_down.png" alt=""/> Download Config</button>
          <button class="positive" type="button" onclick="ajaxUploadConfig('<?php echo $d->id; ?>');"><img src="img/arrow_up.png" alt=""/> Upload Config</button>
          <span id="d_online_<?php echo $d->id; ?>" class="blockstatus"><img src="img/<?php if ($d->online) { echo "accept"; } else { echo "cancel"; } ?>.png" alt=""/> Device <?php if ($d->online) { echo "online"; } else { echo "offline"; } ?></span>
         </div>
       </div>
<?php 
	$i++;
       }
?>
     </div>
    </div>
   </div>
<!-- Ajax items -->
 <!-- MSG -->
   <div id="msgBox">
     <h3 class="popupTitle"><span id="msgTitle"></span></h3>
   </div>
 <!-- Delete confirmation -->
   <div id="confirmDel">
     <h3 id="confirmDelTitle" class="popupTitle">Do you really want to delete this device ?</h3>
     <div class="blocklist">
       <div class="confirmActions">
        <button type="button" class="negative" onclick='document.getElementById("confirmDel").style.display="none"; unfadeBGD();'><img src="img/cross.png" alt=""/> No!</button>
        <button type="button" class="positive" onclick='confirmRemove();'><img src="img/tick.png" alt=""/> Yes!</button>
       </div>
     </div>
   </div>
 <!-- Edit Popup -->
   <div id="editPopup">
     <h3 class="popupTitle">Device Edition</h3>
      <div id="formFields">
       <input type="hidden" id="form_id" name="form_id"/>
       <label>Hostname:</label><input type="text" value="" id="form_hostname" name="form_hostname"/><br/>
       <label>Domain:</label><input type="text" value="" id="form_domain" name="form_domain"/><br/>
       <label>IP Address:</label><input type="text" id="form_ipaddress" name="form_ipaddress"/><br/>
       <label>Port:</label><input type="text" id="form_port" name="form_port"/><br/>
       <label>Use IP:</label><input type="checkbox" id="form_useip" name="form_useip"/><br/>
       <label>HTTPS:</label><input type="checkbox" id="form_https" name="form_https"/><br/>
       <label>Enabled:</label><input type="checkbox" id="form_enabled" name="form_enabled"/><br/>
       <label>Auto-backup:</label><input type="checkbox" id="form_autobackup" name="form_autobackup"/><br/>
      </div>
     <div class="blocklist">
      <div class="popupActions">
       <button type="button" class="negative" onclick='document.getElementById("editPopup").style.display="none"; unfadeBGD();'><img src="img/cross.png" alt=""/> Close</button>
       <button type="button" class="positive" onclick="saveDevice();"><img src="img/tick.png" alt=""/> Save</button>
      </div>
     </div>
   </div>
