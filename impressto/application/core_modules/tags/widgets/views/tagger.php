<!--
@Name: Admin Tagger
@Type: PHP
@Filename: simple
@Projectnum: 4660
@Author: peterdrinnan
@Status: complete
@Date: 2012-02
-->

<div class="tagger_wrapper">

<img alt="tags" src="<?php echo ASSETURL . PROJECTNAME; ?>/default/themes/liquid/samples/img/gCons/tag.png" />
<span>Enter new tags below.</span>

<div style="clear:both"></div>
<input id="tagfield_<?=$lang?>" type="<?=$field_name?>" name="<?=$field_name?>" placeholder="Add Tag" class="tagManager"/>

</div>

			
<script>
				
$(function() {

	// SEE: http://welldonethings.com/tags/manager

     $("#tagfield_<?=$lang?>").tagsManager({
	 	prefilled: [<?=$tags?>],
		preventSubmitOnEnter: true,
		taggerfieldname : 'hiddenTagList_<?=$lang?>',
		typeahead: true,
		typeaheadAjaxSource: null,
		typeaheadSource: [<?=$all_tags?>],
		backspace: [8],
		CapitalizeFirstLetter: true,
		backspace: [8]
	});
	
		
});

</script>


