<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Image Manager
@Type: PHP
@Filename: image_manager.php
@Description: management interface for images
@Author: Nimmitha Vidyathilaka
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-05-15
*/
?>

<script>

asset_url = '<?php echo DIR_IMAGES; ?>';

</script>



<div class="admin-box">
<h3>Image Manager</h3>
<?=$infobar?>


<!-- The template to display uploaded files -->

<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span><br><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>




<!-- Modal Question -->

<div class="modal hide" id="questionModal">
  <div class="modal-header">
    <b>Question</b>
  </div>
<input type="hidden" id="tempFunctionHolder">
  <div class="modal-body questionModalBody">
  </div>
  <div class="modal-footer">
    <a class="btn" onClick="$('#questionModal').hide()">Cancel</a>
    <a class="btn btn-primary" onclick="executeConfirmation()">Yes</a>
  </div>
</div>

<!-- Modal Alert -->

<div class="modal hide" id="AlertModal">
  <div class="modal-header">
    <b>Error</b>
  </div>
  <div class="modal-body alertModalBody">
  </div>
  <div class="modal-footer">
    <a class="btn btn btn-primary" onClick="$('#AlertModal').hide()">OK</a>
  </div>
</div>

<!-- Resize image dialog -->

<div class="modal hide" id="ResizeModal">
  <div class="modal-header">
    <b>Resize image</b>
  </div>
  <div class="modal-body alertModalBody">

<div style="float:left">
Width: <input type="text" style="width:100px" id="resizeImageWidth"><br />
Height: <input type="text" style="width:100px" id="resizeImageHeight"><br />
</div>

<div style="float:left; margin-left:30px;">


<label class="checkbox">
	<input type="checkbox" checked="checked" value="1" name="maintain_aspect" id="maintain_aspect" onclick="psimgmgr.toggle_maintain_aspect(this);" />
	Maintain Aspect Ratio
</label>


<br />
  
<div style="width:200px" id="resize_slider"></div>
<span id="percentage_resize_indicator"></span>


</div>

<div class="clearfix"></div>


  

  </div>
  


					
  
  
  <div class="modal-footer">
    <a class="btn" onClick="$('#ResizeModal').hide()">Cancel</a>
    <a class="btn btn-primary" onclick="resizeImage()">OK</a>

  </div>
</div>



<!-- upload popup -->

<div id="upload">
  <div id="shadowBack"></div>
    <div id="uploadWindow">
      <div id="uploadWindow1">
	<div id="uploadClose"></div>
	  <div id="uploadAreaMulti">



  <div class="container">

    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="/image_manager/uploadhandler" method="POST" enctype="multipart/form-data">
<input type="hidden" name="path" id="normalPathVal" value="" />
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="span7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancel upload</span>
                </button>

            </div>
            <!-- The global progress information -->
            <div class="span5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="bar" style="width:0%;"></div>
                </div>
                <!-- The extended global progress information -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The loading indicator is shown during file processing -->
        <div class="fileupload-loading"></div>
        <br>
        <!-- The table listing the files available for upload/download -->
        <table id="fileUploaderList" role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
    </form>
 
	</div>
      </div>
    </div>
  </div>
</div>




<!-- crop popup -->

<div class="modal hide" id="cropModal">
  <div class="modal-header">

		<a class="button icon crop" id='resizeButton'>
		    Resize Image
		</a>

		<a class="button icon crop" id='cropButton'>
		    Crop Image
		</a>

		<a class="button icon fliph" id='flipHButton'>
		    Flip H
		</a>

		<a class="button icon flipv" id='flipVButton'>
		    Flip V
		</a>

		<a class="button icon rotate" id='rotateImg'>
		    Rotate
		</a>
    <a class="btn btn-primary" id='DoneEditImage'>Close</a>
  </div>
  <div class="modal-body" style='height:433px;'>

		  <div id="outer">
		  <div class="jcExample">
		  <div class="article">

	      <table>
		<tr>
		  <td class='parentEditImage'>

	  <img src="" id='imgEditImage' style="width:670px;">



		  </td>
		  <td>

	  <div id="previewDiv1">
	      <div style="width:200px;height:200px;overflow:hidden;position:absolute;display:none;" id="previewDiv">
		<img src="" id="preview" alt="Preview" class="jcrop-preview" style="width:200px;" />
	  </div>
	  </div>

	<div id="previewValues">
	  <div class="previewValuesHolder">
Selected area size:<br>
	      W: <div id="wDiv"></div><input disabled id="w" name="w" type="text"><br>
	      H: <div id="hDiv"></div><input disabled id="h" name="h" type="text"><br>
<br>Source image size:<br>
	      W: <div id="wRDiv"></div><input disabled id="wR" name="wR" type="text"><br>
	      H: <div id="hRDiv"></div><input disabled id="hR" name="hR" type="text">
	  </div>
	</div>

		  </td>
		</tr>
	      </table>

	  <input type="hidden" id="x" name="x" />
	  <input type="hidden" id="y" name="y" />

	</div>
      </div>
    </div>

</div>


</div>

<!-- organizer -->

<div class="modalx hidex" id="SelectImageModal" style="">
<input type='hidden' id='clickedElementId'>


  <div class="" style='height:590px !important;padding:0 !important;overflow: hidden !important;'>

<div id="addrBar"><div class="addrBar2" id="addr"></div></div>

<div style="clear:both;"></div>


<div id="toolBar">
        <a class="button icon add" id="menuCreateFolder">
            Create folder
        </a>

          <a class="button icon trash" id="menuDelFolder">
            Delete folder
        </a>

        <a class="button icon arrowup" id="menuUploadFiles">
           Upload files...
        </a>

        <a class="button icon trash" id="menuDelFiles">
         Delete files
        </a>
<font class="IMWhiteFont">Zoom: </font>
  <div id="imagePreviewSize" class="IMsliderZoom"></div>



	<div id="loader">
		<img src="/assets/<?php echo PROJECTNAME; ?>/default/core_modules/image_manager/img/loading.gif" alt="loading" />
	</div>
	
</div>




<table id="mainField" cellpadding="0" cellspacing="0"><tr>
 <td valign="top" id="mainTree">
  <div id="tree"></div>
 </td>
 <td valign="top" id="mainFiles"><div id="noFilesHereMessage" class="uploaderEmptyMessage viewerEmptyMessage">Select another folder or upload files here</div>
  <div id="files" class="gallery ui-helper-reset ui-helper-clearfix ui-droppable" data-toggle="modal-gallery" data-target="#modal-gallery"></div>
 </td>

      </tr></table>


<div id="foot">

<div  id="footTableName" class="footInfo">
  <div  id="fileName"></div>


<a class="button icon edit" id="fileNameEdit">Edit file name</a>
<a class="button icon approve" id="fileNameSave">Save file name</a>

</div>
<table cellpadding="0" cellspacing="0" id="footTable">
  <tr>
    <td width="35%"></td>

    <td class="footLabel footInfo" id="footDateLabel" width="20%">Upload date:</td>

    <td class="footInfo" id="footDate" width="20%"></td>

    <td class="footLabel footInfo" id="footDimLabel">Image size:</td>

    <td class="footInfo" id="footDim"></td>
  </tr>

  <tr>
    <td id="footExt">Files:</td>

    <td class="footLabel footInfo" id="footLinkLabel">Link to file:</td>

    <td class="footInfo" id="footLink"><img alt="Link" height="16" src="/assets/<?php echo PROJECTNAME; ?>/default/core_modules/image_manager/img/chain.png" style="vertical-align:sub" width="16">&nbsp;<a href="#"
    target="_blank"></a></td>

    <td class="footLabel">Size:</td>

    <td id="footSize">0</td>
  </tr>
</table>
</div>
  </div>

</div>

<img id="tempImageGetDim" style="display:none;" src="">


</div>


