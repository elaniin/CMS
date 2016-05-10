<div class="sidebar clearfix">

<ul class="sidebar-panel nav">
  <li class="sidetitle">MAIN</li>

          <?php
            
            foreach ($allmodule as $key => $value) {
              if (in_array($key, $modulesthislevel)) {
                if ($allmodule[$key]["type"] == "single") {
                  echo "<li><a href='".$allmodule[$key]["url"]."'><span class='icon'><i class='fa fa-".$allmodule[$key]["icon"]."'></i></span>$key</a></li>";
                }
                if ($allmodule[$key]["type"] == "multiple") {
                  echo " 
                  <li><a href='#'><span class='icon'><i class='fa fa-".$allmodule[$key]["icon"]."'></i></span>$key<span class='caret'></span></a>
                    <ul>                  
                  ";
                  foreach ($allmodule[$key]["sublinks"] as $name => $data) {
                      echo "<li><a href='".$data["url"]."'>".$data["name"]."</a></li>";
                  }
                  echo "
                    </ul>
                  </li>
                  ";
                }
              }
            }
          ?>
</ul>
</div>