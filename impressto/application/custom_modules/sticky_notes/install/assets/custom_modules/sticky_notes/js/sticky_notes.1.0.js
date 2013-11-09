function draginit() {
	$.each($(".my_ticket"),function(){
		if($(this).position().left > ($(this).parent().width() - $(this).outerWidth())) {
			$(this).css("left",($(this).parent().width() - $(this).outerWidth())+"px");
		}
		if($(this).position().top > ($(this).parent().height() - $(this).outerHeight())) {
			$(this).css("top",($(this).parent().height() - $(this).outerHeight())+"px");
		}
		if($(this).position().left < 0) {
			$(this).css("left", "0px");
		}
		if($(this).position().top < 0) {
			$(this).css("top", "0px");
		}
		$(this).mousedown(function(e){
			document.dragging = $(this);
			var x = e.pageX - $(this).position().left;
			var y = e.pageY - $(this).position().top;
			document.draggingx = x;
			document.draggingy = y;
			if($(this).attr("save")) {
				$("#span"+$(this).attr("id").replace("ticket","")).html("Saving...");
			}
			$(this).toggleClass("drag",true);
		}).mouseup(function(){
			document.draggingx = 0;
			document.draggingy = 0;
			document.dragging = "";
			$(this).toggleClass("drag",false);
			id = $(this).attr("id").replace("ticket","");
			$.post("save.php", {
				'id': id,
				'x': Math.abs($(this).position().left),
				'y': Math.abs($(this).position().top)
			}, function(data) {
				$("#span"+id).empty().append($(data));
			});
		});
	});
}
$(document).mousemove(function(e){
	var x = parseInt(e.pageX);
	var y = parseInt(e.pageY);
	var obj;
	if(document.dragging) {
		$.each($(".my_ticket"),function(){
			$(this).css("z-index","4");
		});
		if(document.dragging != "") {
			xfix = document.draggingx;
			yfix = document.draggingy;
			obj = document.dragging;
			x -= xfix;
			y -= yfix;
			var parent = obj.parent();
			if(parent.tagName == "body") {
				parent = $(document);
			}
			var position = parent.offset();
			var fromx = 0;
			var tox = parent.width() - document.dragging.outerWidth();
			var fromy = 0;
			var toy = parent.height() - document.dragging.outerHeight();
			if(x < fromx) {
				x = fromx;
			} else if(x > tox) {
				x = tox;
			}
			if(y < fromy) {
				y = fromy;
			} else if(y > toy) {
				y = toy;
			}
			obj.css("left",Math.abs(x) + "px");
			obj.css("top",Math.abs(y) + "px");
			obj.css("z-index","5");
		}
	}
});
function newticket() {
	var ifs = "";
	if(document.pvtvar) {
		ifs = "?author=" + escape($("#author").val());
	}
	$.post("new_ticket.php"+ifs, $("#my_popupform").serialize(), function(data) {
		$("body").append($(data));
	});
}
function popup() {
	$("#my_popup").css("display","block");
}
$(document).ready(function(){
	draginit();
	$.each($("input[type=text], input[type=email], textarea"), function(){
		$(this).val($(this).attr("placeholder"));
		$(this).toggleClass("placeholder",true);
		$(this).focus(function(){
			if($(this).attr("class").indexOf("placeholder") !== -1 && $(this).val() == $(this).attr("placeholder")) {
				$(this).val("");
				$(this).toggleClass("placeholder",false);
			}
		}).blur(function(){
			if($(this).attr("class")) {
				if($(this).attr("class").indexOf("placeholder") === -1 && $(this).val() == "") {
					$(this).val($(this).attr("placeholder"));
					$(this).toggleClass("placeholder",true);
				}
			} else if($(this).val() == "") {
				$(this).val($(this).attr("placeholder"));
				$(this).toggleClass("placeholder",true);
			}
		});
	});
	$("img#alignleft, img#aligncenter, img#alignright").click(function(){
		var era = $(this).attr("class");
		$("img#alignleft").attr("class","align");
		$("img#aligncenter").attr("class","align");
		$("img#alignright").attr("class","align");
		if(era != "selected") {
			$("#alignvalue").val($(this).attr("id").replace("align",""));
			$(this).attr("class","selected");
		} else {
			$("#alignvalue").val("left");
		}
	});
	$("#color").click(function(){
		if($("#colorselect")) {
			$("#colorselect").css("display","block");
		}
	});
	$("#bgcolor").click(function(){
		if($("#bgcolorselect")) {
			$("#bgcolorselect").css("display","block");
		}
	});
	$("#color").mouseover(function(){
		$("#coloropen").attr("src","images/list_hover.png");
	}).mouseout(function(){
		$("#coloropen").attr("src","images/list.png");
	});
	$("#bgcolor").mouseover(function(){
		$("#bgcoloropen").attr("src","images/list_hover.png");
	}).mouseout(function(){
		$("#bgcoloropen").attr("src","images/list.png");
	});
	var img = $("#colorselect img");
	$.each(img, function(){
		$(this).click(function(){
			if($(this).attr('data')) {
				$("#colorpix").css("background","#"+$(this).attr('data'));
				$("#colorvalue").val($(this).attr('data'));
			}
		});
	});
	img = $("#bgcolorselect img");
	$.each(img, function(){
		$(this).click(function(){
			if($(this).attr('data')) {
				$("#bgcolorpix").css("background","#"+$(this).attr('data'));
				$("#bgcolorvalue").val($(this).attr('data'));
			}
		});
	});
	$("#my_popup .obfuscator").click(function(){
		$("#my_popup").css("display","none");
	});
});
$(document).click(function(e){
	var elem = $(e.target).attr('id');
	if(elem !== 'color' && elem !== 'bgcolor' && elem !== 'colorpix' && elem !== 'bgcolorpix' && elem !== 'coloropen' && elem !== 'bgcoloropen' && $(e.target).attr('class') != "footer") {
		if(elem !== 'colorselect'){
			$('#colorselect').css("display","none");
		}
		if(elem !== 'bgcolorselect'){
			$('#bgcolorselect').css("display","none");
		}
	}
});