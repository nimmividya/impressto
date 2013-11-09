<?php $this->load->view('inc/header'); ?>
<script language="javascript" type="text/javascript">
	

function ValidateSubmitForm()
{
	document.getElementById("errors").innerHTML ="";
	var errors = new Array()
	var title 		= document.getElementById("title").value;
	var category 	= document.getElementById("category").value;
	var designDesc 	= document.getElementById("description").value;
	var styleTag 	= document.getElementById("styletag").value;
	var fabric 		= document.getElementById("fabric").value;
	if(title == "")
	{
		document.getElementById("errors").innerHTML = "Title field Required <br/>";
		
	}
	if(category == "")
	{
		document.getElementById("errors").innerHTML += "Category field Required <br/>";
		
	}
	if(designDesc == "")
	{
		document.getElementById("errors").innerHTML += "Design Description field Required <br/>";
		
	}	
	if(styleTag == "")
	{
		document.getElementById("errors").innerHTML += "How It Works field Required <br/>";
		
	}	
	if(fabric == "")
	{
		document.getElementById("errors").innerHTML += "Materials Used field Required <br/>";
		
	}
	if(title == "" || category == ""|| designDesc == "" ||styleTag == "" || fabric == "")
	{
		return false;
	}else
	{
		document.submitdDesign.submit();
	}		

	
	
}
	
</script>
<div class="container">


WOOHOOOO

	<div class="green_header">
    
    	<div class="green_header_left_submit_design"><p class="purpleBar" style="min-width:300px">Your design</p></div>
        
        <div class="green_header_rite_white_bg">
            <ul class="white_menu">
            	<li style="background:none;">Your design</li>
                <?php if($this->session->userdata('user_auth') == '' || $this->session->userdata('id') == ''):?><li>Your fashion label</li><?php endif;?>
                <li>Preview &amp; publish</li>
                <li>Promote</li>
            </ul>
            
        </div>
        
        <div class="clear"><img src="<?php echo $this->config->item('main_site_skin').'images/blank.gif'?>" alt="Blank Image" /></div>
	
    </div><!-- GRENN HEADER END -->
    
    <span class="show_error"><?php echo validation_errors();?></span>
    <div id="errors" class="show_error"></div>       
    <form action="" method="post" name="submitdDesign" id="submitdDesign">
    <div class="name_your_design">
    	<p>Name for your design: <span class="red">*</span></p>
        <input type="text" name="design[title]" id="title"value="<?php echo set_value('design[title]');?>" class="inside_submit_design_field" />
    </div>
    
	<div class="category">
		
    	<p>Category: <span class="red">*</span></p>
		
       <select name="design[category]" id="category" class="inside_submit_design_drop_down" >
	    	<option value="" <?php echo set_select('design[category]', '', TRUE ); ?>>Select a category</option>
	    	
	    	
	    	<option value="Architecture" <?php echo set_select('design[category]', 'Architecture'); ?>>Architecture</option>
          	  	<option value="Bags and footwear" <?php echo set_select('design[category]', 'Bags and footwear'); ?>>Bags and footwear</option>
          	  	<option value="Childrens toys and games" <?php echo set_select('design[category]', 'Childrens toys and games'); ?>>Children’s toys and games</option>
			<option value="Clothing" <?php echo set_select('design[category]', 'Clothing'); ?>>Clothing</option>
          	  	<option value="Clothing accessories" <?php echo set_select('design[category]', 'Clothing accessories'); ?>>Clothing accessories</option>
	    		<option value="Construction material" <?php echo set_select('design[category]', 'Construction material'); ?>>Construction material</option>
          	  	<option value="Electronics" <?php echo set_select('design[category]', 'Electronics'); ?>>Electronics</option>
			<option value="Furniture" <?php echo set_select('design[category]', 'Furniture'); ?>>Furniture</option>
          	  	<option value="Hand tools" <?php echo set_select('design[category]', 'Hand tools'); ?>>Hand tools</option>
	    	
          	  	<option value="Household appliances" <?php echo set_select('design[category]', 'Household appliances'); ?>>Household appliances</option>
          	  	<option value="Hospital equipment" <?php echo set_select('design[category]', 'Hospital equipment'); ?>>Hospital equipment</option>
			<option value="Interior design" <?php echo set_select('design[category]', 'Interior design'); ?>>Interior design</option>
          	  	<option value="Jewelry" <?php echo set_select('design[category]', 'Jewelry'); ?>>Jewelry</option>
	    		<option value="Lighting" <?php echo set_select('design[category]', 'Lighting'); ?>>Lighting</option>
          	  	<option value="Machinery" <?php echo set_select('design[category]', 'Machinery'); ?>>Machinery</option>
			<option value="Office supplies" <?php echo set_select('design[category]', 'Office supplies'); ?>>Office supplies</option>
          	  	<option value="Vehicles and other transportation parts" <?php echo set_select('design[category]', 'Vehicles and other transportation parts'); ?>>Vehicles and other transportation parts </option>
          	  	<option value="v_Other" <?php echo set_select('design[category]', 'Other'); ?>>Other</option>
       
        </select>
        <p><label for="other_specify">if other, please specify:</label><br />
        <input type="text" name="design[other_specify]" id="other_specify" value="<?php echo set_value('design[other_specify]'); ?>" class="inside_submit_design_big_field" /></p>
	</div>
  
	<div class="clear"><img src="<?php echo $this->config->item('main_site_skin').'images/blank.gif'?>" alt="Blank Image" /></div>
  	
    
      <!-------------------------------------------------------->
        
        <div class="cover_uploaded_images">
        </div>
        <!-------------------------------------------------------->
  
	<div class="upload_images">
    	<p><span>Upload images</span> (max. 5MB each) <span class="red">*</span></p>
        <p>To have an optimal presentation, please upload images in ratio 3/4 (for example: 450x600 pixels)</p>
        <!--<input name="upload-images" type="file" />-->
        <p id='status'></p>
        <div id="uploader-modal" class="upload_image_btn"><a href="#" id="add-image">Upload image</a></div>
	</div>
    	<div class="clear"><img src="<?php echo $this->config->item('main_site_skin').'images/blank.gif'?>" alt="Blank Image" /></div>
        
      
        
        
    
    <div class="submit_sep"></div>
    
    <h2>Design description</h2>
    <br />
    
    <p>Design description: [hint: sell your product]  <span class="red">*</span></p>
    <input type="text" name="design[description]" id="description" value="<?php echo set_value('design[description]'); ?>" class="inside_submit_design_big_field" />
    <br /><br />
    <p>Explain your design in 500 words: [explain how it works]  <span class="red">*</span></p>
    <textarea type="text" name="design[style]" id="styletag" value="<?php echo set_value('design[style]'); ?>" class="inside_submit_design_textarea" rows="5"></textarea>

    
    
    <div class="submit_sep"></div>
    <div class="fabric_color">
    	<p>Materials used: <span class="red">*</span></p>
        <input type="text" name="design[fabric]" id="fabric" value="<?php echo set_value('design[fabric]');?>" class="inside_submit_design_field" />
	</div>
	
    <div class="fabric_color">
    	<p>Target market: <span class="red">*</span></p>
        <input type="text" name="design[market]" id="market" value="<?php echo set_value('design[market]');?>" class="inside_submit_design_field" />
	</div>
	
    <div class="fabric_color">
    	<p>Name of designer: <span class="red">*</span></p>
        <input type="text" name="design[namedesigner]" id="namedesigner" value="<?php echo set_value('design[namedesigner]');?>" class="inside_submit_design_field" />
	</div>
	
    <div class="fabric_color">
    	<p>Logo or brand:</p>
        <input type="text" name="design[logobrand]" id="logobrand" value="<?php echo set_value('design[logobrand]');?>" class="inside_submit_design_field" />
	</div>
    
    <div class="green_ribbon_left"></div>
    <div class="green_ribbon_mid"><input type="button" onclick="javascript:ValidateSubmitForm();" name="proceed" class="inside_submit_design_process" value="Proceed to Next Step" /></div>
    <div class="green_ribbon_rite"></div>
    </form>
    <div class="clear"><img src="<?php echo $this->config->item('main_site_skin').'images/blank.gif'?>" alt="Blank Image" /></div>
</div><!-- CONTAINER END -->

<?php $this->load->view('inc/footer'); ?>