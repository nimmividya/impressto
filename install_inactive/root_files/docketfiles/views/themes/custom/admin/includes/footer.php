
        </div>
    	<div class="clearfix"></div>
  	</div>
  	<div id="footer">
	

	
	
	Generated in <?php 

$this->benchmark->mark('code_end');
		
echo $this->benchmark->elapsed_time('code_start', 'code_end'); ?> seconds

	</div>
</div>

<?php //if(isset($developer_toolbox)) echo $developer_toolbox; ?>
			
			
<div id="ajaxLoadAni">
	<img src="/assets/<?php echo PROJECTNAME; ?>/default/core/images/ajax-loader.gif" alt="Ajax Loading Animation" />
	<span>Processing...</span>
</div><!-- [END] #ajaxLoadAni -->


