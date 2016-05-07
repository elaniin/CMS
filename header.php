<!DOCTYPE html>
<html lang="<?=LANGUAGE?>">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=NAME?> - <?=SLOGAN?></title>
  <base href="<?=BASE_URL?>/" >
  <link href="assets/css/root.css" rel="stylesheet">
  <style>
    #top {
        background: <?=COLOR?>;
    }
  </style>

  </head>
  <body>
  <!-- Start Page Loading -->
  <div class="loading"><img src="img/loading.gif" alt="loading-img"></div>
  <!-- End Page Loading -->

  <div id="top" class="clearfix">

    <div class="applogo">
      <a href="<?=BASE_URL?>" class="logo"><?=NAME?></a>
    </div>

    <!-- Start Sidebar Show Hide Button -->
    <a href="#" class="sidebar-open-button"><i class="fa fa-bars"></i></a>
    <a href="#" class="sidebar-open-button-mobile"><i class="fa fa-bars"></i></a>
    <!-- End Sidebar Show Hide Button -->
    
    <?php
      if (file_exists("modules/general/topmenu.php")) {
        include_once("modules/general/topmenu.php");
      }
      else{
    ?>
    <ul class="top-right">


    <li class="dropdown link">
      <a href="#" data-toggle="dropdown" class="dropdown-toggle profilebox"><img src="<?=$avatar?>" alt="img"><b><?=$user->name?></b><span class="caret"></span></a>
        <ul class="dropdown-menu dropdown-menu-list dropdown-menu-right">
          <li role="presentation" class="dropdown-header"><?=$lan["profile"]?></li>
          <li><a href="<?=BASE_URL?>/myaccount"><i class="fa falist fa-wrench"></i><?=$lan["my_account"]?></a></li>
          <li class="divider"></li>
          <li><a href="<?=BASE_URL?>/logout"><i class="fa falist fa-power-off"></i><?=$lan["logout"]?></a></li>
        </ul>
    </li>

    </ul>
    <?php
      }
    ?>
  </div>
 