$(document).ready(function()
{
    initTabLines();
    initFeaturedSlider();
	featuredSliderZIndex();
	initReviewsSlider();

    function initTabLines()
    {
        if($('.tabs').length)
        {
            var tabs = $('.tabs');

            tabs.each(function()
            {
                var tabsItem = $(this);
                var tabsLine = tabsItem.find('.tabs_line span');
                var tabGroup = tabsItem.find('ul li');

                var posX = $(tabGroup[0]).position().left;
                tabsLine.css({'left': posX, 'width': $(tabGroup[0]).width()});
                tabGroup.each(function()
                {
                    var tab = $(this);
                    tab.on('click', function()
                    {
                        if(!tab.hasClass('active'))
                        {
                            tabGroup.removeClass('active');
                            tab.toggleClass('active');
                            var tabXPos = tab.position().left;
                            var tabWidth = tab.width();
                            tabsLine.css({'left': tabXPos, 'width': tabWidth});
                        }
                    });
                });
            });
        }
    }

    function initFeaturedSlider()
	{
		if($('.featured_slider').length)
		{
			var featuredSliders = $('.featured_slider');
			featuredSliders.each(function()
			{
				var featuredSlider = $(this);
				initFSlider(featuredSlider);
			});
				
		}
	}

    function initFSlider(fs)
	{
		var featuredSlider = fs;
		featuredSlider.on('init', function()
		{
			var activeItems = featuredSlider.find('.slick-slide.slick-active');
			for(var x = 0; x < activeItems.length - 1; x++)
			{
				var item = $(activeItems[x]);
				item.find('.border_active').removeClass('active');
				if(item.hasClass('slick-active'))
				{
					item.find('.border_active').addClass('active');
				}
			}
		}).on(
		{
			afterChange: function(event, slick, current_slide_index, next_slide_index)
			{
				var activeItems = featuredSlider.find('.slick-slide.slick-active');
				activeItems.find('.border_active').removeClass('active');
				for(var x = 0; x < activeItems.length - 1; x++)
				{
					var item = $(activeItems[x]);
					item.find('.border_active').removeClass('active');
					if(item.hasClass('slick-active'))
					{
						item.find('.border_active').addClass('active');
					}
				}
			}
		}).slick(
			{
				rows:2,
				slidesToShow:4,
				slidesToScroll:4,
				infinite:false,
				arrows:false,
				dots:true,
				responsive:
				[
					{
						breakpoint:768, settings:
						{
							rows:2,
							slidesToShow:3,
							slidesToScroll:3,
							dots:true
						}
					},
					{
						breakpoint:575, settings:
						{
							rows:2,
							slidesToShow:2,
							slidesToScroll:2,
							dots:false
						}
					},
					{
						breakpoint:480, settings:
						{
							rows:1,
							slidesToShow:1,
							slidesToScroll:1,
							dots:false
						}
					}
				]
			});
	}

    function featuredSliderZIndex()
	{
		// Hide slider dots on item hover
		var items = document.getElementsByClassName('featured_slider_item');
		
		for(var x = 0; x < items.length; x++)
		{
			var item = items[x];
			item.addEventListener('mouseenter', function()
			{
				$('.featured_slider .slick-dots').css('display', "none");
			});

			item.addEventListener('mouseleave', function()
			{
				$('.featured_slider .slick-dots').css('display', "block");
			});
		}
	}

	function initReviewsSlider()
	{
		if($('.reviews_slider').length)
		{
			var reviewsSlider = $('.reviews_slider');

			reviewsSlider.owlCarousel(
			{
				items:3,
				loop:true,
				margin:30,
				autoplay:false,
				nav:false,
				dots:true,
				dotsContainer: '.reviews_dots',
				responsive:
				{
					0:{items:1},
					768:{items:2},
					991:{items:3}
				}
			});
		}
	}
});