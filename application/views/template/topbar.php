<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
	<?php if(!isset($no_visible_elements) || !$no_visible_elements)	{ ?>
	<!-- topbar starts -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<h1><a class="brand" href="">Dashboard</a></h1>
				
				<!-- user dropdown starts -->
				<div class="btn-group pull-right" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-user"></i><span class="hidden-phone"> <?=$this->session->userdata('first_name');?> </span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?=site_url();?>profile">Profile</a></li>
						<li class="divider"></li>
						<li><a href="<?=site_url();?>logout">Logout</a></li>
					</ul>
				</div>
				<!-- user dropdown ends -->
			</div>
		</div>
	</div>
	<!-- topbar ends -->
	<?php }

/* End of file topbar.php */
/* Location: ./application/views/template/topbar.php */