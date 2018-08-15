<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$sid =$_GET['sid'];
$status; $oldname;
?>


<div class="panel panel-default">
  <div class="panel-heading">
    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
      <div class="row">
        <h3 class="panel-title"><font color="#2775F5">Sample Update</font></h3>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
      <div class="row" align="right">
        <button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.history.back()">Back</button> 	
      </div>
    </div>
    <div style="clear:both"></div>
  </div>
  <div class="panel-body">
    <form method="POST" id="sample_update_form" enctype="multipart/form-data">
    <?php
    $sql = "SELECT * FROM PD_Sample JOIN PD_DB_Account ON SModifyBy = AcctID WHERE SID = $sid";
    $samplefetch = $dbconnect->query($sql);
    while($row = $samplefetch->fetch_assoc()){
      $status = $row['SStatus'];
      $oldname = $row['SImages'];
    ?>
      <table id="sample_data" class="table table-bordered table-striped">
        <tr>
          <td width=10%>Sample Name</td>
          <td width=60%><input type="text" name="sname" id="sname" value="<?php echo $row['SName'];?>" class="form-control" required/></td>
          <td width=30%>Image</td>
        </tr>
        <tr>
          <td >Description</td>
          <td><textarea rows="4" name="sdescription" id="sdescription" class="form-control" ><?php echo $row['SDescription'];?></textarea></td>
          <td rowspan="5"><?php echo "<img id='previewim' src='images/sample/". $row['SImages']."' height='300' width='300'>"; ?></td>
        </tr>
        <tr>
          <td>Replace Image</td>
          <td><input type="file" name="uploadimage" id="uploadimage" onchange="previewImage()"class="form-control"></td>
        </tr>
        <tr>
          <td width=10%>Location</td>
          <td width=60%><input type="text" name="slocation" id="slocation" value="<?php echo $row['SLocation'];?>" class="form-control"/></td>
        </tr>
        <tr>
          <td>Status</td>
          <td><input type="checkbox" name="sstatus" id="sstatus" value="status"> Active</td>
        </tr>
        <tr>
          <td >Last Modify By</td>
          <td ><?php echo $row['username'] ;?></td>
        </tr>
        <tr>
          <td >Last Modify On</td>
          <td><?php echo date('Y-m-d H:i', strtotime($row['SModifyDate'])) ;?></td>
        </tr>
      </table>
    <?php
    }
    ?>
      <div style="text-align:center">
        <span id="alert_action"></span>
        <input type="submit" name="Save" id="Save" class="btn btn-info" value="Save" />
        <input type="button" name="Reset" id="Reset" class="btn btn-warning" value="Reset" onClick="window.location.reload()"/>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">
function previewImage() {
  var preview = document.querySelector('#previewim');
  var file    = document.querySelector('#uploadimage').files[0];
  var reader  = new FileReader();

  reader.addEventListener("load", function () {
    preview.src = reader.result;
  }, false);

  if (file) {
    reader.readAsDataURL(file);
  }
}
</script>

<script>
$(document).ready(function(){
  var status = "<?php echo $status; ?>";
  if(status == "Active"){
      $('#sstatus').prop("checked", true);
    }
  else{
      $('#sstatus').prop("checked", false);
    }
    
	// disable ' key, so that query won't get crash
	/*$('#slocation, #sname, #sdescription').keypress(function(e){
    	if(e.which == 39 ){
    		return false;
    	}
  	});*/
	
	$('#sample_update_form').submit(function(event){
        event.preventDefault();
    	var sid = "<?php echo $sid ;?>";
    	var oldname = "<?php echo $oldname ;?>";
        var data = new FormData(this);
    	data.append("action", "update");
    	data.append("sid", sid);
    	data.append("oldname", oldname);
    	
        $.ajax({
           	type:"post",
           	url:"sample_action.php",
           	data:data,
           	contentType: false,
        	cache: false,
   			processData:false,
           	success: function(mess){
               	$('#alert_action').fadeIn().html('<div class="alert alert-info">'+mess+'</div>');
                window.setTimeout(function(){location.reload()},2000)
           	}
        });
    });

});
</script>

<?php
include ('footer.php');
?>