$(document).ready(function()
{
    initPriceSlider();
	loadProducts("load-all", -1);


    function initPriceSlider()
    {
		if($("#slider-range").length)
		{
			$("#slider-range").slider(
			{
				range: true,
				min: 0,
				max: 20000000,
				step: 500000,
				values: [ 0, 20000000 ],
				slide: function( event, ui )
				{
					$( "#amount" ).val( "Rp " + ui.values[ 0 ] + " - Rp " + ui.values[ 1 ] );
				},
				stop: function(){
					loadShop("");
				}
			});
				
			$( "#amount" ).val( "Rp " + $( "#slider-range" ).slider( "values", 0 ) + " - Rp " + $( "#slider-range" ).slider( "values", 1 ) );
		}	
    }

	function search_product()
	{
		let name_of_product = $("#search_input").val();
		$("#search_input").val("");

		loadShop(name_of_product);
		$("#hidden_name_product").val(name_of_product);
		$("#checkbox").prop('checked', false);
		$("#the_name").html(name_of_product);

		if($('.nameFilter_wrapper').hasClass("d-none")){
			$('.nameFilter_wrapper').removeClass("d-none");
		}
	}

	$("#btn_search").on('click', search_product);

	$("#search_input").on('keydown', function(e) {
		if (e.keyCode === 13) {
			e.preventDefault();
			e.stopImmediatePropagation();
			search_product();
		}
	});

	$(".btn_the_name").on('click', function(){
		if(!$('.nameFilter_wrapper').hasClass("d-none")){
			$('.nameFilter_wrapper').addClass("d-none");
		}

		loadShop("");
	});

	$(".loadMore_wraper").on('click', function(){
		let last_index_element = $('#content_shop').children().last();
		let last_index = last_index_element.find(".id_product_hidden").val();

		loadProducts("load-more", last_index);
	});

	function loadProducts(action, last_index){
		let search_name = $("#hidden_name_product").val();
		let search_category = $("#hidden_category_product").val();
		let search_brand = $("#hidden_brand_product").val();

		if(search_name != "" || search_category != "" || search_brand != ""){
			loadShop(search_name);
		} else {
			$.ajax({
				type: "POST",
				url: "../controller/loadProducts.php",
				data: {
						'action' : action,
						'start_from' : last_index
					},
				beforeSend: function() {
					$("#overlay").fadeIn(300);
				},
				success: function (data) {
					if(data.trim() != ""){
						if(action == "load-all"){
							$('#content_shop').html(data);
						} else {
							$('#content_shop').append(data);
						}
					} else {
						if(!$('.loadMore_wraper').hasClass("d-none")){
							$('.loadMore_wraper').addClass("d-none");
						}
					}
	
					$("#product_found").html($("#content_shop").children().length);

					setTimeout(function(){
                        $("#overlay").fadeOut(300);
                    },500);
				}
			});
		}
	}

	$(".selectpicker").change(function(){
		loadShop("");
	});

	function loadShop(name_product){
		if(!$('.loadMore_wraper').hasClass("d-none")){
			$('.loadMore_wraper').addClass("d-none");
		}

		let where = [];

		if(name_product !== ""){
			where.push(" name LIKE \'%" + name_product + "%\' ");
		} else {
			if(!$('.nameFilter_wrapper').hasClass("d-none")){
				name_product = $("#the_name").html();
				where.push(" name LIKE \'%" + name_product + "%\' ");
			}
		}

		let category = $('#category').val();
		if(category !== "all") {
			where.push(" id IN (SELECT id_products FROM products_categories WHERE id_categories=\'" + category + "\') ");
		}

		let color = $('#color').val();
		if(color !== "all"){
			where.push(" id IN (SELECT id_products FROM products_colors WHERE id_colors=\'" + color + "\') ");
		}

		let brand = $('#brand').val();
		if(brand !== "all"){
			where.push(" id_brands =\'" + brand + "\' ");
		}

		let priceRange = $('#amount').val();
		let priceMin = parseFloat(priceRange.split('-')[0].replace('Rp ', ''));
		let priceMax = parseFloat(priceRange.split('-')[1].replace('Rp ', ''));
		where.push(" harga BETWEEN " + priceMin + " AND " + priceMax + " ");

		var jsonString = JSON.stringify(where);

		$.ajax({
			type: "POST",
			url: "../controller/loadFilter.php",
			data: {
					'data' : jsonString
				},
			beforeSend: function() {
				$("#overlay").fadeIn(300);
			},
			success: function (data) {
				$('#content_shop').html(data);
				$("#product_found").html($("#content_shop").children().length);

				setTimeout(function(){
					$("#overlay").fadeOut(300);
				},500);
			}
		});
	}

	$('#content_shop').on('click', '.product_fav', function (e) {
		e.preventDefault();
		let element = $(this);
		let id_product = element.parent().find(".id_product_hidden").val();
		let id_user = $("#id_user_now").val();

		if(id_user != "-1"){
			$( this ).toggleClass("active");
			$.ajax({
				type: "POST",
				url: "../controller/products.php",
				data: {
					'action' : "wishlist",
					'id_user' : id_user,
					'id_product' : id_product
				},
				success: function (data) {
					let tmpData = data.trim();
					if(tmpData != ""){
						let result = tmpData.split("~");
						let tmpTitle;

						if(result[0] == "success") tmpTitle = "Yeay!!";
						else tmpTitle = "Oops!";

						// AMBIL FUNCTION DARI SCRIPT NAVBAR
						loadCountWishlist(id_user);

						swal({
							title: tmpTitle,
							text: result[1],
							type: result[0]
						});
					}
				}
			});
		} else {
			window.location = "../login/login.php";
		}
	});
});