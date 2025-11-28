$(document).ready(function(){
	
	var scaleMode = "maximize";
	
	var marginTop = parseFloat( $("#mWrapper").css("marginTop") );
	var marginRight = parseFloat( $("#mWrapper").css("marginRight") );
	var marginBottom = parseFloat( $("#mWrapper").css("marginBottom") );
	var marginLeft = parseFloat( $("#mWrapper").css("marginLeft") );

	
	$(".hoverButton img.hover").css({ "opacity" : 0  });
	$(".hoverButton").hover(
		function () {
			$("img.hover", this).stop().show().animate({opacity: 1}, {duration: 200, easing: 'easeInOutCubic', complete: function() { } });
		}, 
		function () {
			$("img.hover", this).stop().show().animate({opacity: 0}, {duration: 450, easing: 'easeInOutCubic', complete: function() {  } });
		}
	);

	
	$(window).resize(function(e){ 
		resize();
	});
	resize();
	
	function resize(){
		var contW = $(window).width() - marginRight - marginLeft;
		var contH = $(window).height() - marginTop - marginBottom;
		
		$("a.h2").css({ left: ( $(window).width() - $("a.h2").outerWidth() ) * .5 });
		$("a.p").css({ left: ( $(window).width() - $("a.p").outerWidth() ) * .5 });

		$("#mWrapper").css({ height: contH });
		
		$("#logo").css({ left: ( $(window).width() - $("#logo").width() ) / 2  });
		
		var defaultWidth = $("img.fullScreen").width();
		var defaultHeight = $("img.fullScreen").height();
		
		var windowWidth = contW;
		var windowHeight = contH;
		
		var tempXscale = (windowWidth ) / defaultWidth;
		var tempYscale = (windowHeight) / defaultHeight;
		
		var imgW;
		var imgH;
	
		if(scaleMode === "maximize"){
			// MAXIMIZE
			if (tempXscale > tempYscale) {
				// QUERFORMAT 
				imgW = (tempXscale * defaultWidth);	
				imgH = (tempXscale * defaultHeight);	
			} else {
				// HOCHFORMAT 
				imgW = (tempYscale * defaultWidth);	
				imgH = (tempYscale * defaultHeight);	
			}
			
		}else{
			// MINIMIZE
			if (tempXscale < tempYscale) {
				// QUERFORMAT 
				imgW = (tempXscale * defaultWidth);	
				imgH = (tempXscale * defaultHeight);	
			} else {
				// HOCHFORMAT 
				imgW = (tempYscale * defaultWidth);	
				imgH = (tempYscale * defaultHeight);	
			}
		}
		
	
		$("img.fullScreen").css({ 
			width : imgW,
			height : imgH,
			left : (windowWidth - imgW) * .5,
			top : (windowHeight - imgH) * .5
		});
	}
		

});