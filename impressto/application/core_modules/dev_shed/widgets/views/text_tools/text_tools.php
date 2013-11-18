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

		
				
				
		
			<button style="float:left;"  class="btn" onclick="texttools.random_text_selector()">Random Text</button>
			<div style="display:none; float:left; margin-left:5px" id="random_text_selector">
			<select onchange="texttools.getrandomtext(this)">
					<option value="">Please random text type</option>
					<option value="lorem_ipsum">Lorem ipsum</option>
					<option value="en">English</option>
					<option value="fr">French</option>				
					<option value="cn">Chinese (Han)</option>
					<option value="es">Spanish</option>					
					<option value="it">Italian</option>
				</select>
			</div>
			
			<button style="float:left; margin-left:5px"  class="btn" onclick="texttools.character_convert()">Convert Characters</button>
			<button style="float:left; margin-left:5px"  class="btn" onclick="texttools.inline_stripper()">Remove Inline Styles</button>
			<button style="float:left; margin-left:5px" class="btn" onclick="texttools.preview_html()">Preview</button>	
		

			
			<div style="clear:both; height:10px;"></div>
				
						
				
			<textarea style="width:98%; height:400px" id="text_tools_text"></textarea>