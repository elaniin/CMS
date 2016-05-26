<?php
require_once 'version.php'; 
?>
<!-- Start Footer -->
<div class="row footer">
  <div class="col-md-6 text-left">
   <?=COPYRIGHT?>
  </div>
  <div class="col-md-6 text-right">
    Built using <a href="https://github.com/elaniin/CMS" target="_blank">CMS</a>.
  </div> 
</div>
<!-- End Footer -->


</div>
<!-- End Content -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 




<!-- ================================================
jQuery Library
================================================ -->
<script type="text/javascript" src="<?=BASE_URL?>/assets/js/jquery.min.js"></script>

<!-- ================================================
Bootstrap Core JavaScript File
================================================ -->
<script src="<?=BASE_URL?>/assets/js/bootstrap/bootstrap.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="<?=BASE_URL?>/assets/js/plugins.js"></script>

<!-- ================================================
Data Tables
================================================ -->
<script src="<?=BASE_URL?>/assets/js/datatables/datatables.min.js"></script>

<!-- ================================================
Bootstrap Select
================================================ -->
<script type="text/javascript" src="<?=BASE_URL?>/assets/js/bootstrap-select/bootstrap-select.js"></script>

<!-- ================================================
Bootstrap Toggle
================================================ -->
<script type="text/javascript" src="<?=BASE_URL?>/assets/js/bootstrap-toggle/bootstrap-toggle.min.js"></script>

<!-- ================================================
Moment.js
================================================ -->
<script type="text/javascript" src="<?=BASE_URL?>/assets/js/moment/moment.min.js"></script>

<!-- ================================================
Bootstrap Date Range Picker
================================================ -->
<script type="text/javascript" src="<?=BASE_URL?>/assets/js/date-range-picker/daterangepicker.js"></script>

<!-- ================================================
Custom
================================================ -->
<script type="text/javascript" src="<?=BASE_URL?>/custom/custom.js"></script>

 
 <script>
function confirmDelete(delUrl) {
  if (confirm("<?=$lan["are_you_sure"]?>")) {
    document.location = delUrl;
  }
}

$(document).ready(function()
{

<?php

  	//get jquery/scripts for current module
  	foreach ($allmodule as $key => $value) {
        $folder = $allmodule[$key]["folder"];
        if ($folder == $module) {
        	$scripturl = $allmodule[$key]["script"];
	        if ($scripturl <> "") {
	        	require_once($scripturl);
	        }
        }
  	}


     

?>

});      

</script>


</body>
</html>