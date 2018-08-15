<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$sreid = $_GET['sreid'];
$srid; $oldname;
?>
<span id="alert_action"></span>

	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title">Review Update</h3>
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
			<?php
			$sql = "SELECT * FROM PD_SampleReview JOIN PD_DB_Account ON ReviewBy = AcctID WHERE SReID = $sreid";
			$samplefetch = $dbconnect->query($sql);
			while($row = $samplefetch->fetch_assoc()){
            	$srid = $row['SRID'];
            	$oldname = $row['SReImages'];
			?>
            <form method="POST" id="samplereview_update_form" enctype="multipart/form-data">
			<table id="samplereview_update_data" class="table table-bordered table-striped">
				<tr>
					<td width=12%>Sample Name</td>
					<td width=63%><select name="srid" id="srid" class="selectpicker" data-live-search="true" required>
                                    <option value="">Select Record</option>
                                    <?php echo samplerecord_option_list($dbconnect);?>
                    	</select></td>
            		<td width=25%>Image</td>
				</tr>
				<tr>
					<td>Comment</td>
            		<td><textarea rows="4" name="srecomment" id="srecomment" class="form-control" ><?php echo $row['SReComments'];?></textarea></td>
            		<td rowspan="4"><?php echo "<img id='preview' src='images/sample_review/". $row['SReImages']."' height='250' width='250'>"; ?></td>
				</tr>
            	<tr>
					<td>Replace Image</td>
					<td><input type="file" name="uploadimage" id="uploadimage" onchange="previewImage()" class="form-control"></td>
				</tr>
            	<tr>
					<td>Review By</td>
					<td><?php echo $row['username'] ;?></td>
				</tr>
            	<tr>
					<td>Last Modify</td>
            		<td><?php echo date('Y-m-d H:i', strtotime($row['ReviewDate'])) ;?></td>
				</tr>
			</table>
            <?php
            }
            ?>
            <div style="text-align:center">
				<input type="submit" name="Save" id="Save" class="btn btn-info" value="Save" />
            	<input type="button" name="reset" id="reset" class="btn btn-warning" value="Reset" onClick="window.location.reload()"/>
            </div>
            </form>
		</div>
	</div>

<script type="text/javascript">
function previewImage() {
  var preview = document.querySelector('#preview');
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
	
	$('#srid').val("<?php echo $srid?>");

	$('#samplereview_update_form').submit(function(event){
        event.preventDefault();
    	var sreid = "<?php echo $sreid ;?>";
    	var oldname = "<?php echo $oldname ;?>";
        var data = new FormData(this);
    	data.append("action", "save");
    	data.append("sreid", sreid);
    	data.append("oldname", oldname);
    	
        $.ajax({
           	type:"post",
           	url:"samplereview_action.php",
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