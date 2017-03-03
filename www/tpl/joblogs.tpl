    <div id="page">
     <input type="hidden" name="form_id" value=""/>
     <h3>Scheduled Jobs results</h3>
     <div class="blocklist">
<?php
       $cnt = count($data["joblogs"]);
       if(!$cnt) {
?>
       <p>There is no job logs entries...</p>
<?php
       }
       $i=0;
       foreach ($data["joblogs"] as $j) {
?>
       <div class="blockelem<?php if ($i % 2) { echo 1; } else { echo 2; } ?>">
         <div id="details_<?php echo $j->id; ?>">
	  <div class="blockleft">
           <dl>
 	    <dt>Name:</dt><dd id="d_name_<?php echo $j->id; ?>"><?php echo $j->name; ?> </dd>
	    <dt>Function:</dt><dd id="d_function_<?php echo $j->id; ?>"><?php if (empty($j->function)) { echo "n/a"; } else { echo $j->function; } ?></dd>
	    <dt>Return code:</dt><dd id="d_rc_<?php echo $j->id; ?>"><?php echo $j->rc; ?> </dd>
           </dl>
          </div>
          <div class="blockright">
           <dl>
	    <dt>Elapsed Time:</dt><dd id="d_elapsed_<?php echo $d->id; ?>"><?php echo $j->elapsed_time; ?> seconds</dd>
	    <dt>Started Time:</dt><dd id="d_started_<?php echo $d->id; ?>"><?php echo date("Y/m/d H:i:s", $j->started_time); ?> </dd>
           </dl>
          </div>
         </div>
         <div class="blockactions">
          <button class="negative" type="button" onclick="ajaxRemoveJoblog(<?php echo $j->id; ?>);"><img src="img/delete.png" alt=""/> Del.</button>
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
     <input name="form_id" id="form_id" type="hidden"/>
     <h3 id="confirmDelTitle" class="popupTitle">Do you really want to delete this entry ?</h3>
     <div class="blocklist">
       <div class="confirmActions">
        <button type="button" class="negative" onclick='document.getElementById("confirmDel").style.display="none"; unfadeBGD();'><img src="img/cross.png" alt=""/> No!</button>
        <button type="button" class="positive" onclick='confirmRemove();'><img src="img/tick.png" alt=""/> Yes!</button>
       </div>
     </div>
   </div>
