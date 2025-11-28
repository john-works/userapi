var next_action = false;
var new_provider_from_form = false;
var generalErrorPrefix = '<strong>Oops</strong>, Looks like something is a mess!!<br>';
function requires_confirmation(formId) {

    var formToSubmit = $('#'+formId);
    if(formToSubmit.hasClass('require-confirmation') && formToSubmit.attr('data-confirmed') !== '1'){

        if(formToSubmit.hasClass('launch-letter-movement')){

            var recipientDepts = ''; //hold a list of the departments with radio btns turned to yes i.e value = 1
            var tagBtns = formToSubmit.find('.rbtns-letter-launch');
            for(var index=0;index<tagBtns.length;index++){

                var tagBtn = $(tagBtns[index]);
                var isChecked = tagBtn.is(":checked");
                if(tagBtn.val() === "1" && isChecked){
                    recipientDepts += recipientDepts === '' ? (tagBtn.attr('data-dept')) : (', ' + (tagBtn.attr('data-dept')));
                }

            }

            bootbox.confirm('<br>Are you sure you want to send this Letter to ' + recipientDepts + ' ?<br>&nbsp;<br>', function (result) {
                if (result) {

                    formToSubmit.attr('data-confirmed', '1');
                    formToSubmit.find('.btnSubmit').trigger('click')
                }
            });

            return true;

        }else{
            return false;
        }

    }
    return false;
}

$('body').on('click','#randomActionModal .btnSubmit,.btnSubmit',function(event){

	event.preventDefault();
	var formId = $(this).parents('form').attr('id');
	//if validation fails return false else save_frm()
	if(!validate_form(formId)){
		return false
	}

	if(requires_confirmation(formId)){
	    return false;
    }
    var whatNext = $(this).attr('data-next')
	if(whatNext) next_action = whatNext
	else next_action = false
	var origin = $(this).attr('data-origin');
	new_provider_from_form = /from_form/i.test(origin); // signifies that we have opened a new modal form to save the provider, so if origin has the string 'from_form' we set to true

	save_frm(formId);

});

$('body').on('click','.btnGenerateReport,.btnGenerateReport',function(event){
    event.preventDefault()
    var formId = $(this).parents('form').attr('id');

    //if validation fails return false else save_frm()
    if(!validate_form(formId)){
        return false
    }
    generate_report(formId);
});

function generate_report(frm){

    var loading_ = $('.request_loader_');
    var values = $('#'+frm).serialize();
    var frmAction = $('#'+frm).attr('action');
    $('#report_data').html('');
    $.ajax(
        {
            type: "POST",
            url: frmAction,
            data: "myData=" + values,
            cache: false,
            beforeSend: function(){
                loading_.removeClass('hide');
            },
            success: function(message)
            {
                loading_.addClass('hide');
                $('#report_data').html(message);

            },
            error:function(jqXHR, textStatus, errorThrown) {
                loading_.addClass('hide');

                show_custom_message_modal('error',generalErrorPrefix + jqXHR.status+" "+errorThrown,null,null);
            }
        });

}

$('body').on('click','.btnEmailDispatchReport',function(event){
    event.preventDefault()
    var formId = 'form-dispatch-report';
    var url = $(this).attr('data-url');

    //if validation fails return false else save_frm()
    if(!validate_form(formId)){
        return false
    }
    email_dispatch_report(formId,url);
});

function email_dispatch_report(frm,url){

    var values = $('#'+frm).serialize();
    var frmAction = url; // $('#'+frm).attr('action');
    $('#report_data').html('');
    $.ajax(
        {
            type: "POST",
            url: frmAction,
            data: "myData=" + values,
            cache: false,
            beforeSend: function(){
                show_custom_preloader(true,null);
            },
            success: function(message)
            {
                show_custom_preloader(false,null);
                show_custom_message_modal('success','Report successfully emailed',null,null);

            },
            error:function(jqXHR, textStatus, errorThrown) {
                alert('error');
                show_custom_preloader(false,null);
                show_custom_message_modal('error',generalErrorPrefix + jqXHR.status+" "+errorThrown,null,null);
            }
        });

}


$('body').on('change','.btn-condition', function () {

	if($('.btn-condition:checked').val() == 'Bad'){
		$('.bad-condition').toggle(true)
	}else{
		$('.bad-condition').toggle(false)
	}
});

$('body').on('change','.btn-sticker', function () {

	if($('.btn-sticker:checked').val() == 'Damaged'){
		$('.bad-sticker').toggle(true)
	}else{
		$('.bad-sticker').toggle(false)
	}

});

//function to save by ajax
function save_frm(frm){
    show_custom_preloader(true,null);
    var formToSubmit = $('#'+frm);
	var values = $('#'+frm).serialize();
	var frmAction = $('#'+frm).attr('action');

	if($('#'+frm).find($('.import')).length > 0){

		var formData = new FormData($('#'+frm)[0]);
		$.ajax({
			url: frmAction,  //Server script to process data
			type: 'POST',
			xhr: function() {  // Custom XMLHttpRequest
				var myXhr = $.xhr();
				if(myXhr.upload){ // Check if upload property exists
					myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
				}
				return myXhr;
			},

			//Ajax events
			/*beforeSend: beforeSendHandler,*/
			success: function (message){
				completeHandler(frm,message)
			},
			/*error: errorHandler,*/
			// Form data
			data: formData,
			//Options to tell jQuery not to process data or worry about content-type.
			cache: false,
			contentType: false,
			processData: false
		});
	}else{
	    var myData = new FormData( formToSubmit[0] );

        $.ajaxSetup({ headers: {'X-Requested-With': 'XMLHttpRequest'} });
        $.ajax({
            type: 'POST',
            url: formToSubmit.attr('action'),
            data: myData,
            processData: false,
            contentType: false,
            success: function (message) {
                completeHandler(frm,message);
            },
            error: function (xhr, status, error) {
                if(error === "Unprocessable Entity"){
                    backendValidation(xhr);
                    show_custom_message_modal('error',error,null,null);
                    return
                }
                var bodyText = '<strong>Oops</strong>, Looks like something is a mess!!<br>' + error ;
                show_custom_message_modal('error',bodyText,null,null);

            }
        });

		// $.ajax(
		// {
		// 	type: "POST",
		// 	url: frmAction,
		// 	data: new FormData( formToSubmit[0]),// "myData=" + values,
		// 	cache: false,
		// 	success: function(message)
		// 	{
		// 		completeHandler(frm,message);
		// 	},
		// 	error: function(message)
		// 	{
        //         var bodyText = '<strong>Oops</strong>, Looks like something is a mess!!<br>' + message;
        //         show_custom_message_modal('error',bodyText,null,null);
		// 	}
		// });
	}

	setTimeout(function(){$('.submit_msg').fadeOut('slow').html('')},10000);
}

function handleCustomObjectResponse(message, frm) {
    message = JSON.parse(message);
    var statusCode = message.statusCode;
    var statusDesc = message.statusDescription;

    if (statusCode == "0") {

        if($('#' + frm).hasClass('set_trust_device')){
            $('#trusted_device_status').closest(".modal").modal('hide');
        }

        show_custom_message_modal('success',statusDesc, null,null);
        loadListing();
        resetFrm(frm);
        $('#' + frm).closest(".modal").modal('hide');
        if ($('#' + frm).hasClass('reload_page')) {
            location.reload()
        }

    } else {

        show_custom_message_modal('error',statusDesc, null,null);

    }

    return message;

}

function handleResponseMessageWithIdReturned(frm, message) {

    //unset this such dt on next save we don't have the same logic
    $('#return_id').attr('name','');

    var messageParts = message.split("ID_RETURNED");
    var recordId = messageParts[0].trim();
    var messageToShow = messageParts[1] + ' Please fill in the other necessary details and proceed to Forward for Action.';

    if($('#'+frm).hasClass('letter_movement_detail')){

        var hrefOriginal = $('#'+frm).attr('data-href-edit-after-create');
        hrefOriginal= hrefOriginal.replace('PARAM_ID',recordId);
        var url = hrefOriginal;

        $.get(url, function (result) {

            $('#accordion_letter_movement_detail').append(result);

            initiateDateRangePicker()
            initializeTimePicker()
            selectize()
            loadListing()
            initiateWYSIWYG()
            initializeFilePicker()
            form_element_show_hide()

            show_custom_message_modal('success',messageToShow,null,null);

        });

    }else{

        show_custom_message_modal('success',messageToShow,null,null);
        loadListing();
        resetFrm(frm);
        $('#'+frm).closest(".modal").modal('hide');
        if($('#'+frm).hasClass('reload_page')){
            location.reload()
        }

    }

}

function completeHandler(frm,message){
    //in this case we get a object with a status code and status description
    if($('#'+frm).hasClass('refresh_status_table')){
        reloadStatusTable();
    }

    if($('#'+frm).hasClass('custom_response')){

        message = handleCustomObjectResponse(message, frm);
        return;
    }

    var expectsIdInResponse = $('#'+frm).hasClass('response_with_id');

    var returnedId = '';
    if(expectsIdInResponse){
        var original = message;
        message = original.message;
        returnedId = original.id;
    }
	//if message contains the String 'successfully'
	if (/successfully/i.test(message)){
        if(next_action){
			// var entry_id = message.id
			var route_edit = next_action
				route_edit = route_edit.replace("%5BID%5D",returnedId)
            if($('#'+frm).closest('.modal.container').attr('id') == 'saveAndStickModal'){
                $('.modal-body.ajaxLoad').attr('data-route',route_edit);
            }else{
                var ele = $('#'+frm).closest('.modal-body')
                loadPart(ele, route_edit,false)
            }
			next_action = false
		}else if(new_provider_from_form){

			//get value of new added provider
			var select_option_text = ''; // $('#'+frm+' #service_center_name').val();
            var select_option_value = returnedId;

            if($('#'+frm).hasClass('form-vehicle-type')){
                select_option_text =  $('#'+frm+' #vehicle_type_name').val();
            }else if($('#'+frm).hasClass('form-insurance-company')){
                select_option_text =  $('#'+frm+' #company_name').val();
            }else{
                select_option_text =  $('#'+frm+' #service_center_name').val();
            }

			//new select option
			var newOption;

			//identifier for selects where the new data came from e.g 'from_form:::provider_select' and we go ahead to split this guy
			var origin = $('#'+frm+' .btnSubmit').attr('data-origin');

			$.each(origin.split(':::'),function(index,selector_ele){


				if(index != 0){

					//if its the second option then it's the current select, so we set the new option to be selected
					if(index == 1){
						newOption = $('<option value="'+select_option_value+'" selected="selected">'+select_option_text+'</option>');
					}
					// if its not the second then we just add the new option to list
					else{
						newOption = $('<option value="'+select_option_value+'" >'+select_option_text+'</option>');
					}

					//add the new option and then trigger that we have selected something new
					$('#'+selector_ele).append(newOption);
					$('#'+selector_ele).trigger("chosen:updated");

				}

			});

			new_provider_from_form = false;
			$('#'+frm).closest(".modal").modal('hide');

		}
        show_custom_message_modal('success',message,null,null);
		loadListing();
        if($('#'+frm).hasClass('particular_form')){
            sumUpParticularAmounts(frm);
        }

		resetFrm(frm);
        // For forms without details
        if(!expectsIdInResponse && !next_action){
            $('#'+frm).closest(".modal").modal('hide');
        }
		if($('#'+frm).hasClass('reload_page') || $('#' + frm).hasClass('just_reload')){
			location.reload()
		}

	}else{

	    //error
        show_custom_message_modal('error',message,null,null);

	}

}

function resetFrm(frm){
	$('#'+frm+' input,#'+frm+' select,#'+frm+' checkbox').removeAttr('disabled');
	$('#'+frm).trigger("reset");
}

function pushNotification(title,body_text,type){

	var add_class = 'gritter-info'
	if(type == 'success'){
		add_class = 'gritter-success'
	}
	else if(type == 'danger'){
		add_class = 'gritter-danger'
	}
	$.gritter.add({
		// (string | mandatory) the heading of the notification
		title: '<h4>'+title+'</h4>',
		// (string | mandatory) the text inside the notification
		text: body_text,
		//sticky: true,
		 time: '',
		//time: 5000,
		class_name: 'gritter-center- gritter-'+type
	});

}

function backendValidation(response){
    Object.keys(response.responseJSON.errors).forEach(item => {
        const itemDom = document.getElementById(item);
        const errorMessage = response.responseJSON.errors[item];
        const errorMessages = document.querySelectorAll(".text-danger");
        errorMessages.forEach(Element => (Element.textContent = ""));
        const formControls = document.querySelectorAll(".form-control");
        formControls.forEach(Element =>
        Element.classList.remove("is-invalid")
    );
    itemDom.classList.add("is-invalid");
    itemDom.insertAdjacentHTML(
        "afterend",
        `<div class="error">${errorMessage}</div>`
    );
    });

    return false;
};