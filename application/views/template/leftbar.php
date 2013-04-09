<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<? $session_id = $this->session->userdata('session_id');?>
	<div class="container-fluid">
		<div class="row-fluid">
		<?php if(!isset($no_visible_elements) || !$no_visible_elements) { ?>
		
			<!-- left menu starts -->
			<? $nav = nav_generate($this->session->userdata('position'),$session_id);?>
			<div class="span2 main-menu-span">
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<?foreach ($nav as $page): ?>
							<?if(!is_array($page)): ?>
								<span><li class="nav-header hidden-tablet"><?=$page?></li></span>
							<?else:?>
								<li><a class="ajax-link" href="<?=$page['uri']?>" <?if($page['title'] == 'File Manager'){echo 'target = _blank';}?>><i class="<?=$page['icon']?>"></i><span class="hidden-tablet"> <?=$page['title']?></span></a></li>
							<?endif?>
						<?endforeach?>
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
		if($this->session->flashdata('message')){
			foreach ($this->session->flashdata('message') as $messages):
			foreach ($messages as $type => $message): ?>
				<div class="alert <?=$type?>">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<?=$message?>
				</div>
			<?endforeach;
			endforeach;
		}


/* End of file leftbar.php */
/* Location: ./application/views/template/leftbar.php */