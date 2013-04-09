<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
		<?php if(!isset($no_visible_elements) || !$no_visible_elements)	{ ?>
			<!-- content ends -->
			</div><!--/#content.span10-->
		<?php } ?>
		</div><!--/fluid-row-->
		<?php if(!isset($no_visible_elements) || !$no_visible_elements)	{ ?>
		
		<hr>

		<footer>
			<p class="pull-left">&copy; <a href="http://usman.it" target="_blank">Muhammad Usman</a> <?php echo date('Y') ?></p>
			<p class="pull-right">Powered by: <a href="http://usman.it/free-responsive-admin-template">Charisma</a></p>
		</footer>
		<?php } ?>

	</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<!-- jQuery-->
	<script src="<?=base_url(); ?>js/jquery-1.7.2.min.js"></script>
	<!-- jQuery UI -->
	<script src="<?=base_url(); ?>js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- custom dropdown library -->
	<script src="<?=base_url(); ?>js/bootstrap-dropdown.js"></script>
	
	
	<?
/* End of file footer.php */
/* Location: ./application/views/template/footer.php */