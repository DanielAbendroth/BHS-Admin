<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

	<div class="container-fluid">
		<div class="row-fluid">
		<?php if(!isset($no_visible_elements) || !$no_visible_elements) { ?>
		
			<!-- left menu starts -->
			<div class="span2 main-menu-span">
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a class="ajax-link" href="dashboard"><i class="icon-home"></i><span class="hidden-tablet"> Dashboard</span></a></li>
						<li><a class="ajax-link" href="files"><i class="icon-folder-open"></i><span class="hidden-tablet"> File Manager</span></a></li>
						<li><a class="ajax-link" href="employees"><i class="icon-user"></i><span class="hidden-tablet"> Employees</span></a></li>
						<li><a class="ajax-link" href="etts"><i class="icon-inbox"></i><span class="hidden-tablet"> ETTS</span></a></li>
						<li><a class="ajax-link" href="store"><i class="icon-tags"></i><span class="hidden-tablet"> Store</span></a></li>
						
					</ul>
					
				</div><!--/.well -->
			</div><!--/span-->
			<!-- left menu ends -->
			
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			
			<div id="content" class="span10">
			<!-- content starts -->
			<?php }

/* End of file leftbar.php */
/* Location: ./application/views/template/leftbar.php */