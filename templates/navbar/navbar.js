$(document).ready(function()
{
    var menuActive = false;

    setHeader();
    initCustomDropdown();
	initPageMenu();

	$(window).on('resize', function()
	{
		setHeader();
	});

    function setHeader()
	{
		if(window.innerWidth > 991 && menuActive)
		{
			closeMenu();
		}
	}

    function initCustomDropdown()
	{
		if($('.custom_dropdown_placeholder').length && $('.custom_list').length)
		{
			var placeholder = $('.custom_dropdown_placeholder');
			var list = $('.custom_list');
		}

		placeholder.on('click', function (ev)
		{
			if(list.hasClass('active'))
			{
				list.removeClass('active');
			}
			else
			{
				list.addClass('active');
			}

			$(document).one('click', function closeForm(e)
			{
				if($(e.target).hasClass('clc'))
				{
					$(document).one('click', closeForm);
				}
				else
				{
					list.removeClass('active');
				}
			});

		});

		$('.custom_list a').on('click', function (ev)
		{
			ev.preventDefault();

			placeholder.text( $(this).text() ).css('opacity', '1');
			$("#input_hidden_category").val($(this).text());

			if(list.hasClass('active'))
			{
				list.removeClass('active');
			}
			else
			{
				list.addClass('active');
			}
		});


		$('select').on('change', function (e)
		{
			if(!$(this).hasClass('product_color') && !$(this).hasClass('selectpicker')){
				placeholder.text(this.value);

				$(this).animate({width: placeholder.width() + 'px' });
			}
		});
	}

    function initPageMenu()
	{
		if($('.page_menu').length && $('.page_menu_content').length)
		{
			var menu = $('.page_menu');
			var menuContent = $('.page_menu_content');
			var menuTrigger = $('.menu_trigger');

			//Open / close page menu
			menuTrigger.on('click', function()
			{
				if(!menuActive)
				{
					openMenu();
				}
				else
				{
					closeMenu();
				}
			});

			//Handle page menu
			if($('.page_menu_item').length)
			{
				var items = $('.page_menu_item');
				items.each(function()
				{
					var item = $(this);
					if(item.hasClass("has-children"))
					{
						item.on('click', function(evt)
						{
							// evt.preventDefault();
							evt.stopPropagation();
							var subItem = item.find('> ul');
								if(subItem.hasClass('active'))
								{
									subItem.toggleClass('active');
									TweenMax.to(subItem, 0.3, {height:0});
								}
								else
								{
									evt.preventDefault();
									subItem.toggleClass('active');
									TweenMax.set(subItem, {height:"auto"});
									TweenMax.from(subItem, 0.3, {height:0});
								}
						});
					}
				});
			}
		}
	}

    function openMenu()
	{
		var menuContent = $('.page_menu_content');
		TweenMax.set(menuContent, {height:"auto"});
		TweenMax.from(menuContent, 0.3, {height:0});
		menuActive = true;
	}

	function closeMenu()
	{
		var menu = $('.page_menu');
		var menuContent = $('.page_menu_content');
		TweenMax.to(menuContent, 0.3, {height:0});
		menuActive = false;
	}
});