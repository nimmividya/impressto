var sUrl = 'classes/cropimg.php';
var asset_url = '';

runDroppable = function() {
  // there's the gallery and the selected
  var $gallery = $("#files"),
    $selectedImages = $("#selectedImages");
  // let the gallery items be draggable
  $(".imageBlock1", $gallery).draggable({
    helper: function() {
      if ($(this).hasClass("imageBlockAct")) {
        selected = $(this);
      }
      var container = $('<div/>').attr('id', 'draggingContainer');
      container.append(selected.clone());
      return container;
    },
    revert: "invalid",
    helper: "clone",
    cursor: "move",
    scroll: false
  });

  /********************  selected image droppable  ********************/

  $selectedImages.droppable({
    accept: "#files > .imageBlock1",
    activeClass: "ui-state-highlight",
    drop: function(event, ui) {
      movingId = ui.draggable.find('img').attr('src');
      var elements = $(ui.draggable).siblings(".imageBlockAct").andSelf();
      var error = 0;
      $('#selectedImages').children('div').each(function() {
        if (movingId  == $(this).find('img').attr('src')) {
          $(this).fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);
          error = 1;
        }
      });
      if (error == 0) {
        var itemclone = ui.draggable.clone().attr('id', movingId + '_clone').draggable({
          connectToSortable: "#selectedImages",
          cursor: "move"
        });
        moveImage(itemclone);
      }
    }
  });

  /********************  trash area for selected image  ********************/

  $('#trash').droppable({
    accept: "#selectedImages .selectedImgBlockMain",
    activeClass: "custom-state-active",
    drop: function(event, ui) {
      ui.draggable.hide('explode', {
        pieces: 4
      }, 500, function() {
        ui.draggable.remove();
      });
    }
  });

  $("#imgProp_modal a.btn-primary").click(function(e) {
    $('#' + $('#modalSelImgId').val()).find('.imageName').html($('#SelImgTitle').val());
    $('#imgProp_modal').modal('hide');
  });

  /********************  Move image to "Selected"  ********************/

  function moveImage($item) {
    var imagePath = $item.find("img").attr("src"),
      imageName = $item.attr("fname"),
      filename = $item.attr("filename"),
      ext = $item.attr("ext"),
      path = $item.attr("path"),
      date = $item.attr("date"),
      linkto = $item.attr("linkto");
    $('#selectedImages').prepend('<div class="ui-draggable selectedImgBlockMain" id="' + linkto + '_clone" filename="' + filename + '" fname="' + imageName + '" ext="' + ext + '" path="' + path + '" linkto="' + linkto + '" date="' + date + '"><div class="imageName selectedImgBlock">' + imageName + '</div><div class="imageImage" style="height: 36px; width: 36px; left: 0px; "><img src="' + imagePath + '" alt="01" style="width: 77px !important;"></div></div>');
    $("#selectedImages").sortable({ items: '.selectedImgBlockMain',scroll: false, tolerance: 'pointer'});
  }
} // end of 'runDroppable'

var images_onload = function() {
  
  
      executeConfirmation = function(){
	eval($('#tempFunctionHolder').val());
      	$('#questionModal').hide();
    }
    
    
    
// 	UPLOAD
    
    $('#loader').show();
    // Address line
    $.ajax({
      type: "POST",
      url: "classes/managerCore/",
      data: "action=showpath&type=images&path=&default=1",
      success: function(data) {
        $('#addr').html(data);

      }
    });
    
//	 Folders list

    $.ajax({
      type: "POST",
      url: "classes/managerCore/",
      data: "action=showtree&default=1",
      success: function(data) {
        $('#tree').html(data);
      }
    });
    
// 	Files list
    
    $.ajax({
      type: "POST",
      url: "classes/managerCore/",
      data: "action=showdir&pathtype=images&path=&default=1",
      success: function(data) {

        $('#loader').hide();
        $('#files').html(data);
        showFootInfo();
        runDroppable();

      }
    });
    
//	Address line
    
    $('.addrItem div,.addrItem img').live('mouseover', function() {
      $(this).parent().animate({
        backgroundColor: '#222222'
      }, 300, 'swing', function() {});
    });
    $('.addrItem div,.addrItem img').live('mouseout', function() {
      $(this).parent().animate({
        backgroundColor: '#ffffff'
      }, 300, 'linear', function() {
        $(this).css({
          'background-color': 'transparent'
        });
      });
    });
    $('.addrItem div,.addrItem img').live('mousedown', function() {
      $(this).parent().css({
        'background-color': '#777777'
      });
    });
    $('.addrItem div,.addrItem img').live('mouseup', function() {
      $(this).parent().css({
        'background-color': '#ffffff'
      });
      
//       show folders tree
      
      $.ajax({
        type: "POST",
        url: "classes/managerCore/",
        data: "action=showtree&path=" + $(this).parent().attr('path') + "&type=" + $(this).parent().attr('pathtype'),
        success: function(data) {
          $('#tree').html(data);
        }
      });
      
//       show path
      
      $.ajax({
        type: "POST",
        url: "classes/managerCore/",
        data: "action=showpath&type=" + $(this).parent().attr('pathtype') + "&path=" + $(this).parent().attr('path'),
        success: function(data) {
          $('#addr').html(data);
        }
      });
      
//       show directory
      
      $.ajax({
        type: "POST",
        url: "classes/managerCore/",
        data: "action=showdir&pathtype=" + $(this).parent().attr('pathtype') + "&path=" + $(this).parent().attr('path'),
        success: function(data) {
          $('#loader').hide();
          $('#files').html(data);
          showFootInfo();
        }
      });
    });
    
// 	"Home" button
    $('#toBeginBtn').mouseover(function() {
      $(this).children(0).attr('src', 'img/backActive.gif');
    });
    $('#toBeginBtn').mouseout(function() {
      $(this).children(0).attr('src', 'img/backEnabled.gif');
    });

// 	Path glowing effect when mouseover and out

$('.folderClosed,.folderOpened,.folderS,.folderImages,.folderFiles').live('mouseover', function() {
      if (!$(this).hasClass('folderAct')) {
        $(this).addClass('folderHover');
      } else {
        $(this).addClass('folderActHover');
      }
    });
    $('.folderClosed,.folderOpened,.folderS,.folderImages,.folderFiles').live('mouseout', function() {
      if (!$(this).hasClass('folderAct')) {
        $(this).removeClass('folderHover');
      } else {
        $(this).removeClass('folderActHover');
      }
    });
    
// 	Uploading flag
    
    var folderLoadFlag = false;
    
// 	Open selected folder
    
    openFolder = function(type, path, callback) {
      $.ajax({
        type: "POST",
        url: "classes/managerCore/",
        data: "action=showpath&type=" + type + "&path=" + path,
        success: function(data) {
          $('#addr').html(data);
        }
      });
      $.ajax({
        type: "POST",
        url: "classes/managerCore/",
        data: "action=showdir&pathtype=" + type + "&path=" + path,
        success: function(data) {
          $('#loader').hide();
          $('#files').html(data);
          showFootInfo();
          callback();
          runDroppable();
$(".imageBlock1").css({"width":$( "#imagePreviewSize" ).slider( "value" ), "height":$( "#imagePreviewSize" ).slider( "value" )/0.93});
$(".imageBlock1 .imageImage").css({"width":$( "#imagePreviewSize" ).slider( "value" )-12, "height":$( "#imagePreviewSize" ).slider( "value" )-12});
        }
      });
    }

    $('.folderClosed,.folderOpened,.folderS,.folderImages,.folderFiles').live('click', function() {

// 	Switching interdiction

      if (folderLoadFlag) return false;
      folderLoadFlag = true;
      $('#loader').show();
      $('.folderAct').removeClass('folderAct');
      $(this).removeClass('folderHover');
      $(this).addClass('folderAct');
      openFolder($(this).attr('pathtype'), $(this).attr('path'), function() {
        folderLoadFlag = false;
      });
    });

    $('.folderImages,.folderFiles').live('dblclick', function() {
      $(this).next().slideToggle('normal');
      return false;
    });

    $('.folderOpened,.folderS').live('dblclick', function() {
      if (!$(this).next().hasClass('folderOpenSection')) return false;
      if ($(this).hasClass('folderS')) {
        $(this).removeClass('folderS').addClass('folderOpened');
      } else {
        $(this).removeClass('folderOpened').addClass('folderS');
      }
      $(this).next().slideToggle('normal');
      return false;
    });
    
    showUploaderEmptyMessage = function() {
      var thisobject = $('#fileUploaderList').find('.uploaderEmptyMessage');
      if ($('#fileUploaderList').find('.files').html() == '') {
        if (thisobject.length > 0) thisobject.remove();
        $('#fileUploaderList').append("<div class='uploaderEmptyMessage'>Drag and drop files here or click 'Add files'</div>");
      } else {
        thisobject.remove();
      }
    }
    
// 	MENU ACTIONS

//	Open file uploader
     
    $('#menuUploadFiles').click(function() {
      showUploaderEmptyMessage();
      var path = getCurrentPath();
      var str = '';
      if (path.type == 'images') {
        str = '<span>Images:</span>';
      } else if (path.type == 'files') {
        str = '<span>Files:</span>';
      }
      str += path.path;
      $('#uploadTarget').html(str);
      $('#currentPathImages').val(path.path);
      $('#normalPathVal').val(path.path);
      $('#normalPathtypeVal').val(path.type);
      $('#upload').show();
    });
    
//	Create new folder

    var canCancelFolder = true;

    $('#menuCreateFolder').click(function() {
      $(this).hide();
      $('#menuCancelFolder,#menuSaveFolder').show();
      $('.folderAct').after('<div id="newFolderBlock"><input type="text" name="newfolder" id="newFolder" /></div>');
      $('#newFolderBlock').slideDown('fast', function() {
        $('#newFolderBlock input').focus().blur(cancelNewFolder).keypress(function(e) {
          if (e.which == 13) {
            saveNewFolder();
          } else if (e.which == 27) {
            cancelNewFolder();
          } else if ((e.which >= 97 && e.which <= 122) || (e.which >= 65 && e.which <= 90) || (e.which >= 48 && e.which <= 57) || e.which == 8 || e.which == 95 || e.which == 45 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 16) {} else {
            return false;
          }
        });
      });
    });

//	Cancel new folder creation

    function cancelNewFolder() {
      if (!canCancelFolder) {
        canCancelFolder = true;
        return false;
      }
      $('#menuCancelFolder,#menuSaveFolder').hide();
      $('#menuCreateFolder').show();
      $('#newFolderBlock').slideUp('fast', function() {
        $(this).remove();
      });
    }
    $('#menuCancelFolder').click(cancelNewFolder);

//	New folder creation

    function saveNewFolder() {
      canCancelFolder = false;
      if ($('#newFolderBlock input').val() == '') {
	$('#AlertModal .modal-body').html("Enter a name for the new folder");
	$('#AlertModal').show();
        $('#newFolderBlock input').focus();
        return false;
      }
      $('#loader').show();
      $('#menuCancelFolder,#menuSaveFolder').hide();
      $('#menuCreateFolder').show();
      // Folder creating request and server must reply with the new catalog structure
      var pathtype = $('.folderAct').attr('pathtype');
      var path = $('.folderAct').attr('path');
      var path_new = $('#newFolderBlock input').val();
      var path_will = path + '/' + path_new;
      $.ajax({
        type: "POST",
        url: "classes/managerCore/",
        data: "action=newfolder&type=" + pathtype + "&path=" + path + "&name=" + path_new,
        success: function(data) {
          $('#loader').hide();
          var blocks = eval('(' + data + ')');
          if (blocks.error != '') {
	    $('#AlertModal .modal-body').html(blocks.error);
	    $('#AlertModal').show();
            $('#newFolderBlock input').focus();
          } else {
            $('#tree').html(blocks.tree);
            $('#addr').html(blocks.addr);
            canCancelFolder = true;
            // Opening created folder
            $.ajax({
              type: "POST",
              url: "classes/managerCore/",
              data: "action=showdir&pathtype=" + pathtype + "&path=" + $('.folderAct').attr('path'),
              success: function(data) {
                $('#loader').hide();
                $('#files').html(data);
              }
            });
          }
        }
      });
    }
    $('#menuSaveFolder').click(saveNewFolder).hover(function() {
      canCancelFolder = false;
    }, function() {
      canCancelFolder = true;
    });
    
//	 Delete folder

    $('#menuDelFolder').click(function() {
        var path = getCurrentPath();
  	$('#questionModal .modal-body').html("Delete folder <b>" + path.path + "</b> ?");
	$('#tempFunctionHolder').val("deletefolder()");
	$('#questionModal').show();

    });


    deletefolder = function(){
        var path = getCurrentPath();
            $('#loader').show();
            $.ajax({
                type: "POST",
                url: "classes/managerCore/",
                data: "action=delfolder&pathtype=" + path.type + "&path=" + path.path,
                success: function(data) {
                    var result = eval('(' + data + ')');
                    if (typeof(result.error) != 'undefined') {
                        $('#loader').hide();

			  $('#AlertModal .modal-body').html(result.error);
			  $('#AlertModal').show();
  
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "classes/managerCore/",
                            data: "action=showtree&path=&type=" + path.type,
                            success: function(data) {
                                //$('#loader').hide();
                                $('#tree').html(data);
                                runDroppable();
                            }
                        });
                        openFolder(path.type, '', function() {
                            $('#loader').hide();
                        });
                    }
                }
            });
    }

//	 Delete files

  $('#menuDelFiles').click(function() {
    var files = $('.imageBlockAct');
    if (files.length == 0) {
      $('#AlertModal .modal-body').html("Select files to delete");
      $('#AlertModal').show();
    } else {
      if (files.length == 1) $('#questionModal .modal-body').html("Delete file " + files.attr('fname') + "." + files.attr('ext') + " ?");
      else $('#questionModal .modal-body').html("You are about to delete " + files.length + " files. <br> Continue?");
      $('#tempFunctionHolder').val("menuDelFiles()");
      $('#questionModal').show();
    }
  });
      
      
    function menuDelFiles() {
        var files = $('.imageBlockAct');
 if (files.length == 1) {
                $('#loader').show();
                var path = getCurrentPath();
                $.ajax({
                    type: "POST",
                    url: "classes/managerCore/",
                    data: "action=delfile&pathtype=" + path.type + "&path=" + path.path + "&md5=" + files.attr('md5') + "&filename=" + files.attr('filename'),
                    success: function(data) {
                        $('#loader').hide();
                        if (data != 'error') {
                            $('#files').html(data);
                            showFootInfo();
                            runDroppable();
                            $('#selectedImages').children('div').each(function() {
                                if (this.id == '/storage/images' + path.path + files.attr('filename') + '_clone') $(this).remove();
                            });
                        } else {
			  $('#AlertModal .modal-body').html(data);
			  $('#AlertModal').show();
			  
                        }
                    }
                });
        } else {
                $('#loader').show();
                var path = getCurrentPath();
                // Gathering the request string
                var actionStr = 'action=delfile&pathtype=' + path.type + '&path=' + path.path,
                    selectedList = $('#selectedImages').children('div');
                $.each(files, function(i, item) {
                    actionStr += "&md5[" + i + "]=" + $(this).attr('md5') + "&filename[" + i + "]=" + $(this).attr('filename');
                    var thisfilename = $(this).attr('filename');
                    for (i1 = 0; i1 < selectedList.length; i1++) {
                        if (selectedList[i1].id == '/storage/images' + path.path + '/' + thisfilename) {
                            $(selectedList[i1]).remove();
                        }
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "classes/managerCore/",
                    data: actionStr,
                    success: function(data) {
                        $('#loader').hide();
                        if (data != 'error') {
                            $('#files').html(data);
                            showFootInfo();
                            runDroppable();
                            $('#selectedImages > #/storage/images' + path.path + '/' + files.attr('filename')).remove();
                        } else {
			     $('#AlertModal .modal-body').html(data);
			     $('#AlertModal').show();
                        }
                    }
                });
        }
    }
// 	Files actions
    var ctrlState = false;
    $('.imageBlock1').live('mouseover', function() {
        if (!$(this).hasClass('imageBlockAct')) {
            $(this).addClass('imageBlockHover');
        } else {
            $(this).addClass('imageBlockActHover');
        }
    });
    $('.imageBlock1').live('mouseout', function() {
        if (!$(this).hasClass('imageBlockAct')) {
            $(this).removeClass('imageBlockHover');
        } else {
            $(this).removeClass('imageBlockActHover');
        }
    });
    
//     Click 'Done' on image selector main window

    $('#insertImage').click(function() {
      
      pasteSelectedImages();

        $("#dialogImageSelector").dialog("close");
    });
    $('.imageBlock1').live('dblclick', function() {
      var e = $(this);
      if (e.attr('type') == 'files') {
        var filesize = e.attr('fsizetext');
        var text = '<a href="' + e.attr('linkto') + '" ' + addAttr + ' title="' + e.attr('fname') + '">';
        text += e.attr('fname');
        text += '</a> ' + ' (' + filesize + ') ';
      } else {
        if (e.attr('fmiddle')) {
          var addAttr = (e.attr('fclass') != '' ? 'class="' + e.attr('fclass') + '"' : '') + ' ' + (e.attr('frel') != '' ? 'rel="' + e.attr('frel') + '"' : '');
          var text = '<a href="' + e.attr('linkto') + '" ' + addAttr + ' title="' + e.attr('fname') + '">';
          text += '<img src="' + e.attr('fmiddle') + '" width="' + e.attr('fmiddlewidth') + '" height="' + e.attr('fmiddleheight') + '" alt="' + e.attr('fname') + '" />';
          text += '</a> ';
        } else {
          var text = '<img src="' + e.attr('linkto') + '" width="' + e.attr('fwidth') + '" height="' + e.attr('fheight') + '" alt="' + e.attr('fname') + '" /> ';
        }
      }
      var linkthis = '<a href="' + e.attr('linkto') + '" ' + addAttr + ' title="' + e.attr('fname') + '"></a>';
      var $item = $(this),
        $target = $(event.target);
      if ($('.imageBlockAct').length == 1) {}
      return false;
    });
    
    $('.imageBlock1').live('click', function() {
      if (ctrlState) {
        if ($(this).hasClass('imageBlockActHover') || $(this).hasClass('imageBlockAct')) {
          $(this).removeClass('imageBlockAct');
          $(this).removeClass('imageBlockActHover');
        } else {
          $(this).removeClass('imageBlockHover');
          $(this).addClass('imageBlockAct');
        }
      } else {
        $('.imageBlockAct').removeClass('imageBlockAct');
        $(this).removeClass('imageBlockHover');
        $(this).addClass('imageBlockAct');
      }
      showFootInfo();
    });

    function selectAllFiles() {
        $('.imageBlock1').addClass('imageBlockAct');
        showFootInfo();

    }

//	Select all by Ctrl+A

    $(document).bind('keydown', function(e) {
              if (event.keyCode == 17) ctrlState = true;
      if(e.ctrlKey && (e.which == 65)) {
	e.preventDefault();
	selectAllFiles();
	return false;
      }
    });

//     Select multiple by holding Ctrl key

    $(this).keyup(function(event) {
        if (event.keyCode == 17) ctrlState = false;
    });
    $(this).blur(function(event) {
        ctrlState = false;
    });
    
// BOTTOM PANEL
// 	Show current information

   function showFootInfo() {
     $('#fileNameEdit').show();
     $('#fileNameSave').hide();
     var file = $('.imageBlockAct');
     if (file.length > 1) {
       $('.footInfo').css('visibility', 'hidden');
       $('#footExt').text("Files selected" + ': ' + file.length);
       var tmpSizeCount = 0;
       $.each(file, function(i, item) {
         tmpSizeCount += parseInt($(this).attr('fsize'));
       });
       $('#footSize').text(intToMb(tmpSizeCount));
     } else if (file.length == 0) {
       var allFiles = $('.imageBlock1'),
         tmpSizeCount = 0;
       $('.footInfo').css('visibility', 'hidden');
       $('#footExt').text("Files total" + ': ' + allFiles.length);
       $('#noFilesHereMessage').hide();
       if(allFiles.length==0) $('#noFilesHereMessage').show(); else $('#noFilesHereMessage').hide();
       $.each(allFiles, function(i, item) {
         tmpSizeCount += parseInt($(this).attr('fsize'));
       });
       $('#footSize').text(intToMb(tmpSizeCount));
     } else {
       $('#fileName').text(file.attr('fname'));
       $('#footExt').text(file.attr('ext'));
       $('#footDate').text(file.attr('date'));

       $("#tempImageGetDim").attr("src", file.attr('linkto'));

        var img = new Image();
        img.src = file.attr('linkto');

        img.onload = function() {

	   $('#footDim').text(img.width + 'x' + img.height);
        }

  var request;
  request = $.ajax({
    type: "HEAD",
    url: img.src,
    success: function () {
             $('#footSize').text(intToMb(request.getResponseHeader("Content-Length")));
    }
  });
       $('#footLink a').text(file.attr('fname').substr(0, 16)).attr('href', file.attr('linkto'));
       $('.footInfo').css('visibility', 'visible');
     }
   }
   
// 	Bytes in Mb and Kb

   function intToMb(i) {
     if (i < 1024) {
       return i + ' bytes';
     } else if (i < 1048576) {
       var v = i / 1024;
       v = parseInt(v * 10) / 10;
       return v + ' kbytes';
     } else {
       var v = i / 1048576;
       v = parseInt(v * 10) / 10;
       return v + ' mbytes';
     }
   }
   
// 	Edit filename
   
   $('#fileNameEdit').click(function() {
     $('#fileName').html('<input type="text" name="fileName" id="fileNameValue" value="' + $('#fileName').html() + '" />');
     $('#fileNameValue').focus();
     $('#fileNameEdit').hide();
     $('#fileNameSave').show();
   });
   
// 	Save filename
   
   $('#fileNameSave').click(function() {
     $('#loader').show();
     var path = getCurrentPath();
     var newname = $('#fileNameValue').val();
     $.ajax({
       type: "POST",
       url: "classes/managerCore/",
       data: 'action=renamefile&path=' + path.path + '&pathtype=' + path.type + '&filename=' + $('.imageBlockAct').attr('filename') + '&newname=' + newname,
       success: function(data) {
         $('#loader').hide();
         if (data != 'error') {
           $('#fileName').html(newname);
           $('.imageBlockAct').attr('fname', newname);
           $('.imageBlockAct .imageName').text(newname);
         } else {
	   $('#AlertModal .modal-body').html(data);
	    $('#AlertModal').show();
         }
       }
     });
     $('#fileNameSave').hide();
     $('#fileNameEdit').show();
   });
   
// 	Close upload window

    $('#uploadClose').click(function() {
      $('#loader').show();
      var path = getCurrentPath();
      $.ajax({
        type: "POST",
        url: "classes/managerCore/",
        data: "action=showtree&path=" + path.path + "&type=" + path.type,
        success: function(data) {
          $('#tree').html(data);
        }
      });
      openFolder(path.type, path.path, function() {
        $('#loader').hide();
      });
      $('#fileUploaderList tbody').html('');
      $('#upload').hide();
    });
    
//	 Get current directory
    
    getCurrentPath = function() {
      var type = $('.addrItem:first').attr('pathtype');
      var path = $('.addrItemEnd').attr('path');
      if (!path) path = '/';
      return {
        'type': type,
        'path': path
      };
    }
}; // end of images_onload function


    if (window.attachEvent) window.attachEvent('onload', images_onload); // IE
    else if (window.addEventListener) // modern
    window.addEventListener('load', function() {
      images_onload.call(document);
    }, false);

// 	document ready
    $(function() {

      $( "#imagePreviewSize" ).slider({
	value: 112,
	min: 112,
	max: 200,
	slide: function(event, ui) {
	    $(".imageBlock1").css({"width":ui.value, "height":ui.value/0.93});
	    $(".imageBlock1 .imageImage").css({"width":ui.value-12, "height":ui.value-12});
	}
      });
      
      var jcrop_api, boundx, boundy;
      $('.imageBlock1').live('dblclick', function() {
        $('#previewDiv1').show();
        thisImgSrc = this.id.replace('*', '');
        if (thisImgSrc.indexOf('?') == -1) {
          thisImgSrc += '?__rnd=' + Math.random();
        } else {
          thisImgSrc = thisImgSrc.split('?');
          thisImgSrc = thisImgSrc[0] + '?__rnd=' + Math.random();;
        }

        $('#imgEditImage').attr('src', thisImgSrc);
        $('#imgEditImage').css('height', 'auto');
        $('#preview').attr('src', thisImgSrc);
        onImgLoad();
        $('#cropModal').modal({
          backdrop: 'static'
        }, 'show').css('z-index', '9999999');
        initJcrop();
	$("#w").val('0');
	$("#h").val('0');
	$("#wDiv").html('0');
	$("#hDiv").html('0');
        return false;
      });
      
// 	Click 'Done' button on image selector

      $('#DoneEditImage').live('click', function() {
        jcrop_api.destroy();
        $('#previewDiv').hide();
        $('#cropModal').modal('hide');
        $('#loader').show();
        var path = getCurrentPath();
        $.ajax({
          type: "POST",
          url: "classes/managerCore/",
          data: "action=showtree&path=" + path.path + "&type=" + path.type,
          success: function(data) {
            $('#tree').html(data);
          }
        });
        openFolder(path.type, path.path, function() {
          $('#loader').hide();
        });
      });

//       Click edit image button - flip H, flip V, rotate
      
      $('#flipHButton, #flipVButton, #rotateImg').live('click', function() {
        switch (this.id) {
        case 'flipVButton':
          var mode = 'flipV';
          break;
        case 'flipHButton':
          var mode = 'flipH';
          break;
        case 'rotateImg':
          var mode = 'rotateImg';
          $('#w').val('');
          $('#h').val('');
	  $("#wDiv").html('');
	  $("#hDiv").html('');
          newH = $('#wR').val();
          newW = $('#hR').val();
          $('#wR').val(newW);
          $('#hR').val(newH);
	$("#wRDiv").html(newW);
	$("#hRDiv").html(newH);
          break;
        }
        var dataString = {
          imgSrcProcess: $('#imgEditImage').attr('src').replace('http://' + window.location.hostname, ''),
          h: $('#hR').val(),
          w: $('#wR').val(),
          mode: mode
        };
        $.ajax({
          url: sUrl,
          async: false,
          type: "POST",
          data: dataString,
          success: function(data) {
//             console.log('edit image response: ' + data);
            imgReload(0);
          }
        });
      });
      onImgLoad = function() {
        var img = new Image();
        img.src = $('#imgEditImage').attr('src');

        img.onload = function() {

          $('#wR').val(img.width);
          $('#hR').val(img.height);
	$("#wRDiv").html(img.width);
	$("#hRDiv").html(img.height);
        }
      }

//	Initializing crop function

initJcrop = function() {
  $('#imgEditImage').Jcrop({
    onChange: updatePreview,
    aspectRatio: 0
  }, function() {
    // Use the API to get the real image size
    var bounds = this.getBounds();
    boundx = bounds[0];
    boundy = bounds[1];
    // Store the API in the jcrop_api variable
    jcrop_api = this;
  });
}

// 	Updating image after image edit

function updatePreview(coords) {
  multix = $('#wR').val() / $('#imgEditImage').width();
  multiy = $('#hR').val() / $('#imgEditImage').height();
  $('#x').val(Math.round(coords.x * multix));
  $('#y').val(Math.round(coords.y * multiy));
  $('#w').val(Math.round(coords.w * multix));
  $('#h').val(Math.round(coords.h * multiy));
  
  	$("#wDiv").html($('#w').val());
	$("#hDiv").html($('#h').val());
	
  if (parseInt(coords.w) <= 0 || parseInt(coords.h) <= 0) return;
  var cropRatio = coords.w / coords.h,
    previewMaxHeight = 200,
    previewMaxWidth = 200;
  var innerWidth = cropRatio >= 1 ? previewMaxWidth : previewMaxHeight * cropRatio;
  var innerHeight = cropRatio < 1 ? previewMaxHeight : previewMaxWidth / cropRatio;
  $('#previewDiv').css({
    width: Math.ceil(innerWidth) + 'px',
    height: Math.ceil(innerHeight) + 'px',
    marginTop: (previewMaxHeight - innerHeight) / 2 + 'px',
    marginLeft: (previewMaxWidth - innerWidth) / 2 + 'px',
    overflow: 'hidden',
    display: 'block'
  });
  var scalex = innerWidth / coords.w,
    scaley = innerHeight / coords.h;
  $('#preview').css({
    width: Math.round(scalex * $('#imgEditImage').width()) + 'px',
    height: Math.round(scaley * $('#imgEditImage').height()) + 'px',
    marginLeft: '-' + Math.round(scalex * coords.x) + 'px',
    marginTop: '-' + Math.round(scaley * coords.y) + 'px'
  });
}

// Resize button click

$('#resizeButton').live('click', function() {
      $('#resizeImageWidth').val($('#wR').val());
      $('#resizeImageHeight').val($('#hR').val());
      
            $('#ResizeModal').show();
	    
});

// Confirm resize click

resizeImage = function() {
      $('#loadingWait').css('display', 'block');
    var dataString = {
      imgSrcProcess: $('#imgEditImage').attr('src').replace('http://' + window.location.hostname, ''),
      x: $('#resizeImageWidth').val(),
      y: $('#resizeImageHeight').val(),
      w: $('#wR').val(),
      h: $('#hR').val(),
      mode: 'resize'
    };
    $.ajax({
      url: sUrl,
      async: false,
      type: "POST",
      data: dataString,
      success: function(data) {
        imgReload(1);
        $('#loadingWait').css('display', 'none');
	$('#wR').val($('#resizeImageWidth').val()),
	$('#hR').val($('#resizeImageHeight').val())
	
	$("#wRDiv").html($('#wR').val());
	$("#hRDiv").html($('#hR').val());
	
      }
    });
    $('#ResizeModal').hide();
}
    
// 	Crop button click

$('#cropButton').live('click', function() {
  if (checkCoords() == true) {
    $('#loadingWait').css('display', 'block');
    var dataString = {
      imgSrcProcess: $('#imgEditImage').attr('src').replace('http://' + window.location.hostname, ''),
      x: $('#x').val(),
      y: $('#y').val(),
      w: $('#w').val(),
      h: $('#h').val(),
      mode: 'crop'
    };
    $.ajax({
      url: sUrl,
      async: false,
      type: "POST",
      data: dataString,
      success: function(data) {
        imgReload(1);
        $('#loadingWait').css('display', 'none');
      }
    });
  }
});

//	Reload image

function imgReload(reloadWH) {
  jcrop_api.destroy();
  if (reloadWH == 1) {
    
	
	
    if ($('#w').val()) {$('#wR').val($('#w').val()); $("#wRDiv").html($('#w').val());}
    if ($('#h').val()) {$('#hR').val($('#h').val());$("#hRDiv").html($('#h').val());}
  }
  dev_reload_image($('#imgEditImage'), $('#imgEditImage').attr('src'), 'imgReload');
  dev_reload_image($('#preview'), $('#imgEditImage').attr('src'), 'imgReload1');
  
  newWidth = 674;
  
  $('#imgEditImage').width(newWidth);
  $('#preview').width(newWidth);

  thisHeight = newWidth/($('#wR').val()/$('#hR').val());
  
  $('#imgEditImage').height(thisHeight);
  $('#preview').height(thisHeight);
  

  $('#previewDiv').css('display', 'none');
  initJcrop();
}

// 	global reload image function,

dev_reload_image = function(img_id, new_src) {
  new_src = new_src || '';
  old_src = img_id.attr('src');

  // No change in source - we'll have to add random data to the url to refresh the image
  
  if (new_src == '' || old_src == new_src) {
    if (old_src.indexOf('?') == -1) {
      old_src += '?__rnd=' + Math.random();
    } else {
      old_src = old_src.split('?');
      old_src = old_src[0] + '?__rnd=' + Math.random();;
    }
    img_id.attr('src', old_src);
  } else {
    img_id.attr('src', new_src);
  }
}

//  Check if crop selection exists when clicking 'Crop' button

function checkCoords() {
  if ($('.jcrop-holder div').width()) return true;

  $('#AlertModal .modal-body').html('Please select a crop region then press submit.');
  $('#AlertModal').show();

  return false;
};
      
      
});