/* [ ---- Gebo Admin Panel - common ---- ] */

	//* detect touch devices 
    function is_touch_device() {
	  return !!('ontouchstart' in window);
	}

	$(function() {
		//* search typeahead

		//* make active on accordion change
		$('#side_accordion').on('hidden.bs.collapse shown.bs.collapse', function () {
			gebo_sidebar.make_active();
            
		});
		//* resize elements on window resize
		var lastWindowHeight = $(window).height();
		var lastWindowWidth = $(window).width();
		$(window).on("debouncedresize",function() {
			if($(window).height()!=lastWindowHeight || $(window).width()!=lastWindowWidth){
				lastWindowHeight = $(window).height();
				lastWindowWidth = $(window).width();
				//gebo_sidebar.update_scroll();
				if(!is_touch_device()){
                    $('.sidebar_switch').qtip('hide');
                }
			}
		});

		
        if(!is_touch_device()){
		    //* popovers
            gebo_popOver.init();
        }
		//* sidebar
        gebo_sidebar.init();
		gebo_sidebar.make_active();
		//* breadcrumbs
        gebo_crumbs.init();
		//* pre block prettify

		//* external links
		gebo_external_links.init();
		//* accordion icons
		gebo_acc_icons.init();
		//* colorbox single
		if($('.cbox_single').length) {
			gebo_colorbox_single.init();
		}
		//* main menu mouseover
		gebo_nav_mouseover.init();
		//* top submenu
		gebo_submenu.init();
		
		
		
		
		$('body').on('touchstart.dropdown', '.dropdown-menu', function (e) { e.stopPropagation(); });
	
		
	});
    
    gebo_sidebar = {
        init: function() {
			// sidebar onload state
			if($(window).width() > 979){
                if(!$('body').hasClass('sidebar_hidden')) {
                    if( $.cookie('gebo_sidebar') == "hidden") {
                        $('body').addClass('sidebar_hidden');
                        $('.sidebar_switch').toggleClass('on_switch off_switch').attr('title','Show Sidebar');
                    }
                } else {
                    $('.sidebar_switch').toggleClass('on_switch off_switch').attr('title','Show Sidebar');
                }
            } else {
                $('body').addClass('sidebar_hidden');
                $('.sidebar_switch').removeClass('on_switch').addClass('off_switch');
            }
            
            gebo_sidebar.info_box();
            
			//* sidebar visibility switch
            $('.sidebar_switch').click(function(){
                $('.sidebar_switch').removeClass('on_switch off_switch');
                if( $('body').hasClass('sidebar_hidden') ) {
                    $.cookie('gebo_sidebar', null);
                    $('body').removeClass('sidebar_hidden');
                    $('.sidebar_switch').addClass('on_switch').show();
                    $('.sidebar_switch').attr( 'title', "Hide Sidebar" );
                } else {
                    $.cookie('gebo_sidebar', 'hidden');
                    $('body').addClass('sidebar_hidden');
                    $('.sidebar_switch').addClass('off_switch');
                    $('.sidebar_switch').attr( 'title', "Show Sidebar" );
                };
				gebo_sidebar.info_box();
				//gebo_sidebar.update_scroll();
				$(window).resize();
            });
            //* prevent accordion link click
            $('.sidebar .accordion-toggle').click(function(e){e.preventDefault()});
			
			$(window).on("debouncedresize", function( event ) {
				gebo_sidebar.scrollbar();
			});
			
        },
        info_box: function(){
			var s_box = $('.sidebar_info');
			var s_box_height = s_box.actual('height');
			s_box.css({
				'height'        : s_box_height
			});
			$('.push').height(s_box_height);
			$('.sidebar_inner').css({
				'margin-bottom' : '-'+s_box_height+'px',
				'min-height'    : '100%'
			});
        },
		make_active: function() {
			var thisAccordion = $('#side_accordion');
			thisAccordion.find('.panel-heading').removeClass('sdb_h_active');
			var thisHeading = thisAccordion.find('.panel-body.in').prev('.panel-heading');
			if(thisHeading.length) {
				thisHeading.addClass('sdb_h_active');
			}
		}

    };

    
    //* popovers
    gebo_popOver = {
        init: function() {
            $(".pop_over").popover();
        }
    };
    
    //* breadcrumbs
    gebo_crumbs = {
        init: function() {
            $('#jCrumbs').jBreadCrumb({
                endElementsToLeaveOpen: 0,
                beginingElementsToLeaveOpen: 0,
                timeExpansionAnimation: 500,
                timeCompressionAnimation: 500,
                timeInitialCollapse: 500,
                previewWidth: 30
            });
        }
    };
	
	//* external links
	gebo_external_links = {
		init: function() {
			$("a[href^='http']").not('.thumbnail>a,.ext_disabled,.btn').each(function() {
				$(this).attr('target','_blank').addClass('external_link');
			})
		}
	};
	
	//* accordion icons
	gebo_acc_icons = {
		init: function() {
			var accordions = $('#accordion1,#accordion2');
			
			accordions.find('.accordion-group').each(function(){
				var acc_active = $(this).find('.accordion-body').filter('.in');
				acc_active.prev('.accordion-heading').find('.accordion-toggle').addClass('acc-in');
			});
			accordions.on('show', function(option) {
				$(this).find('.accordion-toggle').removeClass('acc-in');
				$(option.target).prev('.accordion-heading').find('.accordion-toggle').addClass('acc-in');
			});
			accordions.on('hide', function(option) {
				$(option.target).prev('.accordion-heading').find('.accordion-toggle').removeClass('acc-in');
			});		
		}
	};
	
	//* main menu mouseover
	gebo_nav_mouseover = {
		init: function() {
			$('header li.dropdown').mouseenter(function() {
				if($('body').hasClass('menu_hover')) {
					$(this).addClass('navHover')
				}
			}).mouseleave(function() {
				if($('body').hasClass('menu_hover')) {
					$(this).removeClass('navHover open')
				}
			});
            $('header li.dropdown > a').click(function(){
                if($('body').hasClass('menu_hover')) {
                    window.location = $(this).attr('href');
                }
            });
		}
	};
	
	//* single image colorbox
	gebo_colorbox_single = {
		init: function() {
			$('.cbox_single').colorbox({
				maxWidth	: '80%',
				maxHeight	: '80%',
				opacity		: '0.2', 
				fixed		: true
			});
		}
	};
	
	//* submenu
	gebo_submenu = {
		init: function() {
			$('.dropdown-menu li').each(function(){
				var $this = $(this);
				if($this.children('ul').length) {
					$this.addClass('sub-dropdown');
					$this.children('ul').addClass('sub-menu');
				}
			});
			
			$('.sub-dropdown').on('mouseenter',function(){
				$(this).addClass('active').children('ul').addClass('sub-open');
			}).on('mouseleave', function() {
				$(this).removeClass('active').children('ul').removeClass('sub-open');
			})
			
		}
	};
	
