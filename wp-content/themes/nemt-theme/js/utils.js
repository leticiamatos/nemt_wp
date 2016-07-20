jQuery.noConflict();

jQuery(function($) {

	// Fancybox Galery modal
	$(".fancybox").fancybox({
		openEffect  : 'none',
		closeEffect	: 'none'
	});

	// Home Highlight Slide
	$('.slide_wpr').bxSlider({
		infiniteLoop: true,
		pager: false
	});	

	// Home Pós-venda Carousel
	$('.slide_posvenda_wpr, .slide_revista_wpr').bxSlider({
		infiniteLoop: false,
		pager: false,
		minSlides: 1,
		maxSlides: 4,
		slideWidth: 220,
		slideMargin: 10
	});	

	// Select Menu
	$( ".selected-ui" ).selectmenu();

	// Toggle class Highlight post home
	$('.btn.open, .btn.close').click(function(){
		$('.highlight.post').toggleClass('active');
	})

    $( "#tabs-ajax" ).tabs({
		active: false,
		collapsible: true,
	  	
		beforeActivate: function( event, ui ) {
          	// $('.submenu_loading').addClass('active');
		},
		beforeLoad: function( event, ui ) {
          	$('.submenu_loading').addClass('active');
	        ui.jqXHR.fail(function() {
	          ui.panel.html(
	            "Ops! Um erro!" );
	        });
      	},
	  	load: function( event, ui ) {
          	$('.submenu_loading').removeClass('active');
	  	}
    });

    $( "#tabs-ajax-modal, #tabs-ajax-onibus, #tabs-ajax-logistica" ).tabs({
		show: { effect: "fade", duration: 800 },
		hide: { effect: "fade", duration: 800 },
		beforeLoad: function( event, ui ) {
			ui.jqXHR.fail(function() {
		  	ui.panel.html(
		    "Ops! Um erro!" );
        });
      }
    });

	$( ".post , .page" ).each(function() {
  		$(this).addClass('post-item');
	});

	// Home News Ticker 
	$('.ticker_rss ul').addClass('ticker');
	$('.ticker a').each(function( ) {
		$(this).attr("target","_blank");
	});
	var newsTicker = $('.ticker').newsTicker({
	    row_height: 33,
	    max_rows: 1,
	    duration: 4000
	});

	// Set Target Blank for social menu 
	$('#menu-social a, #menu-social-1 a').each(function( ) {
		$(this).attr("target","_blank");
		title = $(this).html();
		$(this).attr("title", title);
	});

	if ($('body').hasClass('post-blog') || $('body').hasClass('category-blog')){
		$('.menu .menu-blog').addClass('current');
	}

	function scrollMenuPanel(){
	  	var topPage = $(this).scrollTop();

		if($('body').hasClass('home')){
		 	//var video_height = $('.home_panel').height();
		 	var scrollPosition = $('.fixed').offset().top;
		 	var top_number = scrollPosition;

			if (topPage >= 0 && topPage < scrollPosition){
				$('body').addClass('header_extended');
				$('body').removeClass('header_normal');
			}else if (scrollPosition < 0 || topPage < 0){
				$('body').addClass('header_extended');
				$('body').removeClass('header_normal');
			}else {
		  		$('body').addClass('header_normal');
		  		$('body').removeClass('header_extended');
			}
		} else{
			//var video_height = $('.home_panel').height();
		 	var scrollPosition = $('.fixed').offset().top;

			if (topPage > 0){
				$('body').addClass('header_normal');
				$('body').removeClass('header_extended');
			}else{
				$('body').addClass('header_extended');
				$('body').removeClass('header_normal');
			}

			if ($('body').hasClass('post-blog') || $('body').hasClass('category-blog')){
				var top_number = 600;
			}else{
				var top_number = 200;
			}
		}
	  	
	      
		if (topPage < top_number) {
		  $('body').addClass('top');
		  $('body').removeClass('not-top');
		}
		else{
		  $('body').addClass('not-top');
		  $('body').removeClass('top');
		}
	}
	scrollMenuPanel();

	// Panel
	$(window).scroll(function () {
		scrollMenuPanel();
 	});

 	// Fancybox
	if ( $(".gallery")) {
		$(".gallery img").each(function( ) {
			//console.log(output);
	  		$(this).parent().addClass('fancybox');
	  		$(this).parent().attr( "data-fancybox-group", "gallery" );
		});
	}

	// Fancybox Galery modal
	$(".fancybox").fancybox({
		openEffect  : 'none',
		closeEffect	: 'none'
	});
	$('.gallery-item a img').each(function(){
		img_description = $(this).attr('alt');
		$(this).parent().attr( 'title', img_description );
	});

	// Menu Dropdown 
	$( ".menu_link" ).click(function() {
		$( ".menu.responsive.cntt" ).toggleClass("active");
	});
	$( ".menu.responsive.cntt" ).click(function() {
		$( ".menu.responsive.cntt" ).removeClass("active");
	});

	// Menu Filtros SUbcategorias Tabs no Responsivo
	$('.responsive_menu_subcat_link').click(function() {
		$(this).parent().toggleClass('active');
	})

	// Menu Grupo TT Dropdown 
	$( ".menu_grupo_link" ).click(function() {
		$( ".menu_grupo.menu_cntt" ).toggleClass("active");
	});
	$( ".menu_grupo.menu_cntt" ).click(function() {
		$( ".menu_grupo.menu_cntt" ).removeClass("active");
	});


	// Hover effect search form
	$('.hover_effect').click(
		function(){
			$(this).addClass('active');
		}, function(){
			$(this).removeClass('active');
	});

})

// Responsive debugger script
jQuery(document).ready(function ($) {
	var MEASUREMENTS_ID = 'measurements'; // abstracted-out for convenience in renaming
	$("body").append('<div id="'+MEASUREMENTS_ID+'"></div>');
	$("#"+MEASUREMENTS_ID).css({
	    'position': 'fixed',
	    'bottom': '0',
	    'right': '0',
	    'background-color': 'black',
	    'color': 'white',
	    'padding': '5px',
	    'font-size': '10px',
	    'opacity': '0.4',
	    'font-family': 'Arial, Sans',
	    'z-index': '100'
	});
	getDimensions = function(){
	    return $(window).width() + ' (' + $(document).width() + ') x ' + $(window).height() + ' (' + $(document).height() + ')';
	}
	getOrientation = function(){
		if ($(window).width() >= $(window).height()){
			return 'horizontal';
		}else{
			return 'vertical';
		}
	}
	setOrientation = function(){
	    if (getOrientation() == 'vertical' && !$('body').hasClass('vertical')){
	    	$('body').addClass('vertical');
	    } else if (getOrientation() == 'horizontal' && $('body').hasClass('vertical')){
	    	$('body').removeClass('vertical');
	    }
	}
	setOrientation();

	$("#"+MEASUREMENTS_ID).text(getDimensions());
	$(window).on("resize", function(){
	    $("#"+MEASUREMENTS_ID).text(getDimensions());
	    setOrientation();
	});
 });
