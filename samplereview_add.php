<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$srid = $_GET['srid'];
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<span id="alert_action"></span>

	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><font color="#2775F5">Add New Review</font></h3>
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
			<form method="POST" id="samplereview_add_form" enctype="multipart/form-data">
			<table id="add_sample" class="table table-bordered table-striped">
				<tr>
					<td width=20%>Select Record</td>
					<td><select name="srid" id="srid" class="selectpicker" data-live-search="true" required>
                                    <option value="">Select Record</option>
                                    <?php echo samplerecord_option_list($dbconnect);?>
                    	</select></td>
				</tr>
            	<tr>
					<td>Image</td>
					<td><input type="file" name="uploadimage" id="uploadimage" onchange="previewImage()"class="form-control"><br>
					<img id="preview" src="" height="200" alt="Image preview..."></td>
				</tr>
				<tr>
					<td>Comments</td>
					<td><textarea rows="5" name="srecomment" id="srecomment" class="form-control" required ></textarea></td>
				</tr>
			</table>
			<div style="text-align:center">
				<input type="submit" name="Add" id="Add" class="btn btn-info" value="Add" />
            	<input type="reset" name="reset" id="reset" class="btn btn-warning" value="Reset" />
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

	$('#samplereview_add_form').submit(function(event){
        event.preventDefault();
        var data = new FormData(this);
    	data.append("action", "add");
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