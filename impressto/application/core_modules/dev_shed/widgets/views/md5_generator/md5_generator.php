<?PHP /*
@Name: text tools
@Description: text manipulation and cleanup
@Type: PHP
@Author: Nimmitha Vidyathilaka
@Projectnum: 1001
@Version: 1.0
@Status: development
@Date: 2012/10/18
*/ ?>

							
		
<fieldset>
				
	<h3>MD5 Generator</h3>
				
	<p>Useful for resetting password in Wordpress and other CMS.<br /></p>
				
	<div style="float:left;">
		<label for="">Original</label>
		<input type="text" style="width:120px" id="unencrypted_md5">
	</div>
				
	<div style="float:left; margin-left:10px;">
		<label for="">MD5 Encrypted</label>
		<input type="text" style="width:260px" 	readonly="readonly" id="encrypted_md5">
	</div>
				
				
	<div style="float:left; margin-left:10px; margin-top:24px;">
		<button onclick="md5generator.get_md5()" class="btn">Generate MD5</button>
	</div>
				
	</fieldset>
