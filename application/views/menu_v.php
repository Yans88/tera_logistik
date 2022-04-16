<!-- search form -->
<a href="<?php echo site_url();?>" class="logo">
			<!-- Add the class icon to your logo image or logo icon to add the margining -->
			 <div style="text-align:center; color:#01DF3A; font-weight:600;">Selamat Datang Dihalaman Administrator Tera Logistik</div>
		</a>
<!-- /.search form -->

<ul class="sidebar-menu">
<li class="hide <?php 
	 $menu_home_arr= array('home', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>home">
			<img height="20" src="<?php echo base_url().'assets/theme_admin/img/home.png'; ?>"> <span>Beranda</span>
		</a>
</li>


<li class="<?php 
	 $menu_home_arr= array('list_form', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>list_form">
			<i class="glyphicon glyphicon-stats"></i> <span>List Form</span>
		</a>
</li>
<li class="<?php 
	 $menu_home_arr= array('chat', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>chat">
			<i class="glyphicon glyphicon-stats"></i> <span>List Chat</span>
		</a>
</li>
<li class="<?php 
	 $menu_home_arr= array('user', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>user">
			<i class="glyphicon glyphicon-stats"></i> <span>User</span>
		</a>
</li>





</ul>