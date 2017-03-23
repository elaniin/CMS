<?php

if ($_GET) {
  $mode = $_GET["mode"];
  if ($mode=="restore") {
    //first we backup the current DB
    $functions->backup_tables($db->db_name);
    $filename = $_GET["filename"];
    $functions->restore($filename);
  }
}





?>
<!-- START CONTENT -->
<div class="content">

  <div class="row presentation">

      <div class="col-lg-8 col-md-6 titles">
        <span class="icon color2-bg"><i class="fa fa-database"></i></span>
        <h1><?=$lan["db_backups"]?></h1>
        <h4><?=$lan["db_backups_details"]?></h4>
        <h5><?=$lan["db_backups_details_2"]?></h5>
      </div>

      <div class="col-lg-4 col-md-6">

      </div>

  </div>  


<!-- START CONTAINER -->
<div class="container-default margin-b-50">
    <div class="row">
              <?php
                $datarow = $db->select("backups","id > 0 ORDER BY id DESC LIMIT 0,10");
                foreach ($datarow as $key => $value) {
                        $date = $datarow[$key]['date'];
                        $id = $datarow[$key]['id'];
                        $filename = $datarow[$key]['filename'];

              ?>
      <div class="col-md-4">
        <div class="panel panel-default">
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                    <h4><?=$date?></h4>
                    <a href="javascript:confirmDelete('<?=BASE_URL?>/m/general/db-backups&mode=restore&filename=<?=$filename?>')"><?=$lan["db_backups_restore"]?></a>
                  </div>
                </div>
              </div>
        </div>
      </div>              

              <?php

                }

              ?>                 

    </div>

</div>
<!-- END CONTAINER -->
