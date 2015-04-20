(function($){

var Cic = {

	server_url: 'https://app.customericare.com',

	init: function()
	{
		var cic_api_email = $('input[name="cic-api-email"]').val();
		if(typeof cic_api_email != 'undefined' && cic_api_email.length > 0)
		{
			this.show_plugin_fields();
		}
	},

	alert: function(obj)
	{
		obj.text		= typeof(obj.text) == 'undefined'		? 'error'		: obj.text;
		obj.delay_time	= typeof(obj.delay_time) == 'undefined' ? 4000			: obj.delay_time;

		var box = $('.cic-section .updated');
		box.find('p').text(obj.text);
		box.show();

		var st = setTimeout(function(){
			box.hide();
		},obj.delay_time);
	},

	clear_licence_fields: function()
	{
		$('.cic-content').find('input[name="cic-email"]').val('');
		$('.cic-content').find('input[name="cic-pass"]').val('');
	},

	add_licence_fields: function(email, apikey)
	{
		$('.cic-content').find('input[name="cic-api-email"]').val(email);
		$('.cic-content').find('input[name="cic-apikey"]').val(apikey);
	},

	show_licence_fileds: function()
	{
		$('#cic-create-licence-form').show();
		$('#new-licence-title').addClass('expand_form');
	},

	hide_licence_fields: function()
	{
		$('#cic-create-licence-form').hide();
		$('#new-licence-title').removeClass('expand_form');
	},

	show_plugin_fields: function()
	{
		$('#cic-add-plugin-form').show();
		$('#new-plugin-title').addClass('expand_form');
	},

	hide_plugin_fields: function()
	{
		$('#cic-add-plugin-form').hide();
		$('#new-plugin-title').removeClass('expand_form');
	},
	
	build_query: function(email, token)
	{
	
		var data = {};
		var p = '';
	
		if(typeof token != 'undefined' && token != null)
		{
			data.email = email;
			data.token = token;
			data.paylane = 'one';
			p = '/login/token/?';
		}
		
		var q = decodeURIComponent( $.param( data ) );

		return this.server_url+p+q;
	}
};



$(document).ready(function() {

	//apikey save
	$('#cic-add-plugin-form').submit(function(e){

		e.preventDefault();

		var cic_apikey		= $('input[name="cic-apikey"]').val();
		var cic_api_email	= $('input[name="cic-api-email"]').val();

		/*
		if(cic_apikey.length < 1)
		{
			Cic.alert({text: 'Apikey it\'s empty'});
			return false;
		}
		*/
		
		$.ajax({
			url: Cic.server_url+'/ajax/get-apikey-from-admin-email',
			type: "POST",
			dataType: 'JSONP',
			data: {email: cic_api_email},
			success: function (data, status, error) {

				if(data.res == 0)
				{
					Cic.alert({text: data.msg});
					e.preventDefault();
					return false;
				}

				if(data.res == 1)
				{
					if(typeof data.user.token == 'undefined')
						data.user.token = null;
			
					var _data = data;
					$.post( "admin.php?page=cic-admin-settings", { 'cic-apikey': data.user.apikey, 'cic-api-email': data.user.email, 'cic-token' : data.user.token } )
						.done(function( data ) {
							Cic.alert({text: 'Success! Check your website to see the chat box!', delay_time: 5000});
							
							var url = Cic.build_query(_data.user.email, _data.user.token);
							$('#sign-in').attr( 'href', url.replace('&paylane=one', '') );

							$('#sign-in-one-payment').attr( 'href', url);
							$('#sign-in-one-payment-wrap').css({'display': 'inline-block'});
							$('#info-sale').hide();
					});
				}
			}
		});
	});

	//new account create
	$('#cic-create-licence-form').submit(function(e){
		e.preventDefault();
		var that	= $(this);

		$('#create-new-licence').attr('disabled', 'disabled');
		
		var licence = {
			email:		$(this).find('input[name="cic-email"]').val(),
			password:	$(this).find('input[name="cic-pass"]').val(),
			company:	$(this).find('input[name="cic-email"]').val(),
			url:		'',
			lng:		'en',
			link:		window.location.href,
			add_type:	'plugin_wp'
		};

		$.ajax({
			dataType: "jsonp",
			url: Cic.server_url+"/ajax?callback=?",
			type: "POST",
			data: licence,
			success: function(data) {
				if(data.res == '1')
				{

					$.post( "admin.php?page=cic-admin-settings", { 'cic-apikey': data.apikey, 'cic-api-email': licence.email, 'cic-token' : data.token  } )
						.done(function( data2 ) {
							Cic.alert({text: 'Success! Check your website to see the chat box!', delay_time: 5000});
							Cic.add_licence_fields(licence.email, data.apikey);
							Cic.clear_licence_fields();
							Cic.hide_licence_fields();
							Cic.show_plugin_fields();
							
							var url = Cic.build_query(licence.email, data.token);
							$('#sign-in').attr( 'href', url.replace('&paylane=one', '') );
							window.open(url.replace('&paylane=one', ''));
							
							$('#sign-in-one-payment').attr( 'href', url);
							$('#sign-in-one-payment-wrap').css({'display': 'inline-block'});
							$('#info-sale').hide();
							return false;
					});
				}
				else
				{
					Cic.alert({text: data.msg, delay_time: 7000});
				}
				
				$('#create-new-licence').attr('disabled', false);
			}
		});
	});

	$('.cic-content h3').click(function() {
		var that = $(this);

		that.next('form').toggle(function(){
			if($(this).is(":visible"))
			{
				that.addClass('expand_form');
			}
			else
			{
				that.removeClass('expand_form');
			}
		});
	});

	Cic.init();
});

})(jQuery);