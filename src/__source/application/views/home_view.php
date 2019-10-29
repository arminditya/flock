<?php foreach($menus as $menu){?>
      <!-- ================== LOOP THIS SECTION WITH ROLE MENU============================= -->
        <li class="treeview">
          <a href="<?php echo $this->config->base_url();?>index.php/content/get_content/<?php echo $menu->UrlMenu ?>">
            <i class="<?php echo $menu->IconMenu ?>"></i> <span><?php echo $menu->NamaMenuWeb ?></span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
            <li><a href="../forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
            <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
          </ul>
         

        </li>
     <!-- ================================================================================= -->
     <?php } ?>