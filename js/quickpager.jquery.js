(function($) {
	    
	$.fn.quickPager = function(options) {
	
		var defaults = {
			pageSize: 10,
			currentPage: 1,		
			pagerLocation: "after",
			childSelector: null
		};
		
		var options = $.extend(defaults, options);
		
		
		return this.each(function() {
	
			var selector = $(this);	
			var pageCounter = 1;
			
			selector.wrap("<div class='simplePagerContainer'></div>");

			selector.children(options.childSelector).each(function(i){ 
				if(i >= pageCounter*options.pageSize || i < (pageCounter-1)*options.pageSize) 
					pageCounter ++;
				$(this).addClass("simplePagerPage"+pageCounter);
			});
			
			// nothing to paginate
			if(pageCounter <= 1) {
				return;
			}
			
			// show/hide the appropriate regions 
			selector.children(options.childSelector).hide();
			selector.children(".simplePagerPage"+options.currentPage).show();
			
			//Build pager navigation
			
			var pageNav = "<ul class='simplePagerNav'>";	
			pageNav += "<li class='simplePageNavBack'><a rel='back' href='#'>&laquo; Back</a></li>";
			for (i=1;i<=pageCounter;i++){
				if (i==options.currentPage) {
					pageNav += "<li class='currentPage simplePageNav"+i+"'><a rel='"+i+"' href='#'>"+i+"</a></li>";	
				}
				else {
					pageNav += "<li class='simplePageNav"+i+"'><a rel='"+i+"' href='#'>"+i+"</a></li>";
				}
			}
			pageNav += "<li class='simplePageNavNext'><a rel='next' href='#'>Next Page &raquo;</a></li>";
			pageNav += "</ul>";
			
			selector.after(pageNav);

			if (options.currentPage == 1 )
				$('.simplePageNavBack').hide();
			if (options.currentPage == pageCounter )
				$('.simplePageNavNext').hide();
			
			//pager navigation behaviour
			selector.parent().find(".simplePagerNav a").click(function() {
					
				//grab the REL attribute 
				var clickedLink = $(this).attr("rel");
				var Parent = $(this).parent("li").parent("ul").parent(".simplePagerContainer");
				
				if (clickedLink == 'next') {
					clickedLink = Parent.find("li.currentPage a").attr("rel");
					clickedLink++;
					if (Parent.find("a[rel='"+clickedLink+"']").length == 0)
						return false; // should not happen
				} else if (clickedLink == 'back') {
					clickedLink = Parent.find("li.currentPage a").attr("rel");
					clickedLink--;
					if (Parent.find("a[rel='"+clickedLink+"']").length == 0)
						return false; // should not happen
				}
				
				options.currentPage = clickedLink;
				
				//remove current current (!) page
				Parent.find("li.currentPage").removeClass("currentPage");
				//Add current page highlighting
				Parent.find("a[rel='"+clickedLink+"']").parent("li").addClass("currentPage");

				//hide and show relevant links
				selector.children().hide();			
				selector.find(".simplePagerPage"+clickedLink).show();
				
				if (options.currentPage == 1 )
					$('.simplePageNavBack').hide();
				else $('.simplePageNavBack').show();
				if (options.currentPage == pageCounter )
					$('.simplePageNavNext').hide();
				else $('.simplePageNavNext').show();
				
				$(window).scrollTop(0);
				
				return false;
			});
		});
	}
	

})(jQuery);

