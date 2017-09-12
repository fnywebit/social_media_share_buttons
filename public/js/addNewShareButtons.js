jQuery(document).ready(function($) {
	console.log(jQuery('input[name=float]:checked').val());
	fny_share_buttons_list_active =["facebook","twitter","google","linkedin","vk"];
	fny_share_buttons_list_not_active = ["digg","pinterest","reddit","telegram","tumblr","wordpress"];
	fny_buttons_size = {small:24,medium:32,large:40};
	fny_buttons_theme_active = ["theme1","theme2","theme3"];
//selecting the size and the theme of sharing buttons

	fny_init_edit_page(FNY_SOCIALBUTTONS_PARAMS);

	fny_selected_social_buttons = FNY_SELECTED_SOCIALBUTTONS;
//title section of share buttons
	jQuery('#fny_save').on('click', function() {
		var fny_title_value = jQuery('#fny_title').val();
		fny_title_value=fny_title_value.replace(/\s/g, "");

		if (fny_title_value=='') {alert('   Please write Title');}
		else {

		var id = '';
		if (typeof jQuery("#fny-sharebuttons-id").val() != 'undefined') {
			id = jQuery("#fny-sharebuttons-id").val();
		}

		var csrf_token = jQuery("#fny-create-ajax-nonce").val();
		var data = {
			id: id,
			_ajax_nonce: csrf_token,
			action: 'save_share_button_options',
			float: jQuery('input[name=float]:checked').val(),
			size: jQuery('input[name=size]:checked').val(),
			socailButtons: fny_selected_social_buttons,
			title: jQuery('#fny_title').val(),
			theme: jQuery('input[name=theme]:checked').val(),
			customSize: ''
		}

		jQuery.post(ajaxurl, data, function(response) {
			var href = window.location.href.split("?");
			window.location.href = href[0] + "?page=fny_share_buttons_admin";
		});

	}
	});
//the view of share buttons, active and not active parts
	jQuery(".icon").click(function(){
		jQuery("#fny-submit").css("display","block");
		jQuery("#fny-remove").css("display","block");

		var clickedElement = jQuery(this).attr('id');
		var clickedElementID = '#'+clickedElement;
		fny_selected_social_buttons.push(clickedElement);

		jQuery(clickedElementID).addClass("not-active");
		jQuery("#fny-firstbox").append("<span id="+clickedElement+" draggable='true' ondragstart='startDragging(event)'  ><a class='btn btn-social-icon btn-"+clickedElement+"'  ><i class='fa fa-"+clickedElement+"'></i></a> </span>");
	});

	jQuery("#fny-submit").click(function(){
		fny_show();
		fny_hide();
		fny_addbuttonstolive(fny_selected_social_buttons, []);
	});

	jQuery('input[type=radio][name=theme]').change(function(){
		var that = this;
		jQuery.each(jQuery("p>a>img"), function(i, val) {
			var socialButton = jQuery(val).parent().attr('title');
			var src = sharebuttons_obj.images_ulr + 'logo/theme'+ that.value +'/' + socialButton + '.svg';
			jQuery(val).attr('src', src);
		});
	});

	jQuery('input[type=radio][name=float_type]').change(function(){
		if (jQuery('input[name=float_type]:checked').val()=='vertical') {
			jQuery("#fny-upofpic").css("float","left");
			jQuery(':radio[value=left]').attr('checked',true);
			jQuery('#fny_float').show();
			jQuery('#fny-upofpic').addClass('fny_float_live_demo');
		} else {
			jQuery("#fny-upofpic").css("float","left");
			jQuery('#fny_float').hide();
			jQuery(':radio[value=rigth]').attr('checked',false);
			jQuery(':radio[value=left]').attr('checked',false);
			jQuery('#fny-upofpic').removeClass('fny_float_live_demo');
		}
	});

	jQuery('input[type=radio][name=float]').change(function(){
		console.log(jQuery(this).val());
		// jQuery("#fny-upofpic").removeProp("float");
		jQuery("#fny-upofpic").css("float",jQuery(this).val());
		
	});
	
	jQuery("#fny_cancel").click(function(){
		location.reload(true);
	});

	jQuery('input[type=radio][name=size]').change(function() {
		if (jQuery('#fny_custom').is(':checked')) {jQuery('#fny_size_custom').css({'display':'inline-block'}); jQuery('#fny_size_custom').removeAttr('disabled');} else {jQuery('#fny_size_custom').attr('disabled',true);};
		jQuery("p>a>img").width(this.value);
		jQuery("p>a>img").height(this.value);
	});

});
	
	jQuery(document).on('keyup mouseup', '#fny_size_custom', function() {

		if (jQuery('#fny_custom').is(':checked') && jQuery('#fny_size_custom').val() != '') {
			
			jQuery('input[type=radio][name=size]:checked').val(this.value);
		    jQuery("p>a>img").width(this.value);
			jQuery("p>a>img").height(this.value);

		}
		
	    
	});


	jQuery(document).on('keyup mouseup', '#fny_space_between_buttons', function() {                                                                                                                     
		                                                                                                              
		jQuery(".fny-share-social-media-buttons-live").css({'margin-right':this.value+'px'});

		
	});

function fny_init_edit_page(params) {

	if (jQuery("#fny-sharebuttons-id").val() != '') {
		fny_show();
		fny_hide();
		fny_addbuttonstolive(FNY_SELECTED_SOCIALBUTTONS, params);
		fny_add_size(fny_buttons_size, params.size);
		fny_theme_active(fny_buttons_theme_active, params.theme);
	}
	else {
		fny_add_size(fny_buttons_size);
		fny_theme_active(fny_buttons_theme_active);
	}

	
	fny_add_active_buttons(fny_share_buttons_list_active);
	fny_add_not_active_buttons(fny_share_buttons_list_not_active);
}

function allowDrop(event) {
	event.preventDefault();
}

function startDragging(event) {
	event.dataTransfer.setData("text", event.target.id);
}

function drop(event) {
	var data = event.dataTransfer.getData("text");
	jQuery('#fny-firstbox #'+data).remove();

	var index = fny_selected_social_buttons.indexOf(data);
	var clickedElementID = '#'+fny_selected_social_buttons[index];
	jQuery(clickedElementID).removeClass("not-active");


	console.log(fny_selected_social_buttons);
	console.log(data);

	fny_selected_social_buttons = jQuery.grep(fny_selected_social_buttons, function(value) {
		return value != data;
	});

	console.log(fny_selected_social_buttons);
}
//moving section of icons , facebook, twitter, vk, linkedin and google
function fny_show() {
	jQuery("#fny_cancel").css("display","block");
	jQuery("#fny_save").css("display","block");
	jQuery(".fny-half").css("display","block");
}

function fny_hide() {
	jQuery("#fny-submit").css("display","none");
	jQuery("#fny-firstbox").css("display","none");
	jQuery("#fny-remove").css("display","none");
	jQuery("#button_list").addClass("not-active");
}

function fny_addbuttonstolive(buttons, params) {

	fny_selected_social_buttons = buttons;

	var size = 24;
	var theme = 1;

	if (params.size && params.theme) {
		size = params.size;
		theme = params.theme;
	}
	
	for (i=0; i<fny_selected_social_buttons.length; i++){
		if(typeof fny_selected_social_buttons[i] != 'undefined'){
			var fyregexp = fny_selected_social_buttons[i].replace(/[0-9]/,'');
			var img = jQuery('<img style="width:'+ size +'px; height:'+ size +'">');

			img.attr('src', sharebuttons_obj.images_ulr + 'logo/theme'+ theme +'/' + fyregexp + '.svg' );
			jQuery("#fny-upofpic").append("<a class='fny-share-social-media-buttons-live' id='shareto"+fyregexp+"' target='_blank' title='"+fyregexp+"'>");

			jQuery("#shareto"+fyregexp).append(img);
			//jQuery("#fny-upofpic").css("float","left");

		}
	}
    //share button links
	jQuery("#sharetofacebook").attr("href","https://www.facebook.com/sharer.php?u=" + encodeURIComponent(location.href));
	jQuery("#sharetotwitter").attr("href","https://twitter.com/intent/tweet?url=" + encodeURIComponent(location.href));
	jQuery("#sharetogoogle").attr("href","https://plus.google.com/share?url=" + encodeURIComponent(location.href));
	jQuery("#sharetolinkedin").attr("href","https://www.linkedin.com/shareArticle?mini=true&amp&url=" + encodeURIComponent(location.href));
	jQuery("#sharetovk").attr("href","http://vk.com/share.php?url=" + encodeURIComponent(location.href));
}

function fny_add_active_buttons (fny_active_list){
	fny_share_buttons_list_active=fny_active_list;
	for (i=0;i<fny_share_buttons_list_active.length;i++){
		jQuery('#button_list').append('<div class="icon col-xs-12 col-sm-12 col-md-12 col-lg-12" id="'+fny_share_buttons_list_active[i]+'">\
			<a class="btn btn-block btn-social btn-'+fny_share_buttons_list_active[i]+'">\
			<span class="fa fa-'+fny_share_buttons_list_active[i]+'"></span> '+fny_share_buttons_list_active[i]+'</a></div>');
	}
	jQuery('#fny_get_now').append('<a href="http://fny-webit.com/social-media-share-buttons/"><button type=button id="fny_pro_version" class="btn btn-danger">GET PRO!</button></a>');

}

function fny_add_not_active_buttons(fny_not_active_list){
	fny_share_buttons_list_not_active=fny_not_active_list;
	for (i=0;i<fny_share_buttons_list_not_active.length;i++){
		jQuery('#button_list_not_active').append('<div class="icon col-xs-12 col-sm-12 col-md-12 col-lg-12 not-select">\
			<a class="btn btn-block btn-social btn-'+fny_share_buttons_list_not_active[i]+'">\
			<span class="fa fa-'+fny_share_buttons_list_not_active[i]+'"></span> '+fny_share_buttons_list_not_active[i]+'</a></div>');
	}
}

function fny_add_size(fny_size_val, activeSize = 24){
	var fny_x;

	for (fny_x in fny_size_val) {

		var checked = '';

		if (activeSize == fny_size_val[fny_x]) {
			checked = 'checked';
		}

		if (fny_x != 'custom') {
		jQuery('#fny_size').append('<div class="fny-share-social-media-buttons-size-buttons"><input id="fny_'+fny_x+'" class="fny-share-social-media-buttons-size-buttons-radio" type="radio" name="size" value="'+fny_size_val[fny_x]+'" '+checked+'>'+'<label for="'+fny_size_val[fny_x]+'"><b>'+fny_x.toUpperCase()+'</b></label>'+'</div> ');
		} else {
			jQuery('#fny_size').append('<div class="fny-share-social-media-buttons-size-buttons"><br><input id="fny_'+fny_x+'" class="fny-share-social-media-buttons-size-buttons-radio" type="radio" name="size" value="'+fny_size_val[fny_x]+'" '+checked+'>'+'<label for="'+fny_size_val[fny_x]+'"><b>'+fny_x.toUpperCase()+'</b></label>'+'</div> ');
			
		}
	}
    jQuery('#fny_size').append('<a href="http://fny-webit.com/social-media-share-buttons/"><button type=button id="fny_pro_version" class="btn btn-danger">GET PRO!</button></a>');
	jQuery('#fny_size').append('<br><img src="'+sharebuttons_obj.images_ulr+'pro_size.PNG" ></img>');
}

function fny_theme_active(fny_theme_active_list, activeTheme = 1){
	for (i=0;i<fny_theme_active_list.length;i++) {
		var checked = '';
		if (activeTheme == i+1) {
			checked = 'checked';
		}

		jQuery('#theme').append('<div class="fny-social-share-buttons-theme"> \
			<input class="form-control" type="radio" name="theme" id="fny-'+fny_theme_active_list[i]+'" value="'+parseInt(i+1)+'" '+checked+'> \
			<img style="height:32px; width:32px" src="'+ sharebuttons_obj.images_ulr+'logo/'+fny_theme_active_list[i]+'/facebook.svg" alt="facebook"> \
			<img style="height:32px; width:32px" src="'+ sharebuttons_obj.images_ulr+'logo/'+fny_theme_active_list[i]+'/twitter.svg" alt="twitter"> \
			<img style="height:32px; width:32px" src="'+ sharebuttons_obj.images_ulr+'logo/'+fny_theme_active_list[i]+'/google.svg" alt="google_plus" > \
			<img style="height:32px; width:32px" src="'+ sharebuttons_obj.images_ulr+'logo/'+fny_theme_active_list[i]+'/linkedin.svg" alt="linkedin"> \
			<img style="height:32px; width:32px" src="'+ sharebuttons_obj.images_ulr+'logo/'+fny_theme_active_list[i]+'/vk.svg" alt="vk"> \
		</div>');
	}
    jQuery('#fny_theme_not_active').append('<a href="http://fny-webit.com/social-media-share-buttons/"><button type=button id="fny_pro_version" class="btn btn-danger">GET PRO!</button></a>');
	jQuery('#fny_theme_not_active').append('<br><img src="'+sharebuttons_obj.images_ulr+'pro.PNG" style="width:210px;heigth:160px"></img>');
}

