
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url()?>admin/dashboard" class="brand-link">
      <img src="<?= base_url()?>public/logo.png" alt="Order it Logo" class="brand-image elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><?= APP_NAME;?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- Sidebar Menu -->
      <nav class="mt-2">
       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
       <li class="nav-item <?php if($menu=='dashboard'){ echo 'menu-open'; }?>">
				<a href="<?= base_url()?>admin/dashboard" class="nav-link">
				  <i class="nav-icon fas fa-home"></i>
				  <p>  Dashboard </p>
				</a>
			  </li>

        <li class="nav-item <?php if($menu=='slider'){ echo 'menu-open'; }?>">
            <a href="<?= base_url()?>admin/slider" class="nav-link">
              <i class="nav-icon fas fa-user-alt"></i>
              <p>
                Slider
              </p>
            </a>
          </li>

        
          <li class="nav-item <?php if($menu=='unite'){ echo 'menu-open'; }?>">
            <a href="<?= base_url()?>admin/unite" class="nav-link">
              <i class="nav-icon fas fa-user-alt"></i>
              <p>
                Product Unite
              </p>
            </a>
          </li>

          <li class="nav-item <?php if($menu=='user'){ echo 'menu-open'; }?>">
            <a href="<?= base_url()?>admin/user" class="nav-link">
              <i class="nav-icon fas fa-user-alt"></i>
              <p>
                Users list
              </p>
            </a>
          </li>

           <li class="nav-item <?php if($menu=='category'){ echo 'menu-open'; }?>">
            <a href="<?= base_url()?>admin/category" class="nav-link">
              <i class="nav-icon fas fa-user-alt"></i>
              <p>
                Category
              </p>
            </a>
          </li>

          <li class="nav-item <?php if($menu=='product'){ echo 'menu-open'; }?>">
            <a href="<?= base_url()?>admin/product" class="nav-link">
              <i class="nav-icon fas fa-user-alt"></i>
              <p>
                Products List
              </p>
            </a>
          </li>

          <li class="nav-item <?php if($menu=='order'){ echo 'menu-open'; }?>">
            <a href="<?= base_url()?>admin/order" class="nav-link">
              <i class="nav-icon fas fa-user-alt"></i>
              <p>
                Order List
              </p>
            </a>
          </li>
		      
          <li class="nav-item has-treeview <?php if($menu=='staff'){ echo 'menu-open'; }?>">
            <a href="<?= base_url()?>admin/staff" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                 Staff
              </p>
            </a>
          </li> 

           <li class="nav-item has-treeview <?php if($menu=='notification'){ echo 'menu-open'; }?>">
            <a href="<?= base_url()?>admin/notification" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                 Notification
              </p>
            </a>
          </li>
          
          
            
         <li class="nav-item has-treeview <?php if($menu=='setting'){ echo 'menu-open'; }?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fas fa-cog"></i>
              <p>
                Setting
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url()?>admin/setting/password" class="nav-link <?php if($child_menu=='password'){ echo 'active'; }?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Change Password</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url()?>admin/setting" class="nav-link <?php if($child_menu=='profile'){ echo 'active'; }?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profile</p>
                </a>
              </li>
              
            </ul>
          </li> 
		   
          <li class="nav-item">
            <a href="<?= base_url()?>admin/login/logout" class="nav-link">
              <i class="nav-icon far fa-user"></i>
              <p>
               Logout
              </p>
            </a>
          </li>
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>