/*
* ----------------------------------
* Note you need to define 2 empty elements with IDS below,
* 1. tds_notifier_modal_container [for the message modal]
* 2. tds_notifier_progress_container [for the progress bar]
* ----------------------------------
* */


/*
Sample div definitions, copy and use these
<div id="tds_notifier_modal_container"></div>
<div id="tds_notifier_progress_container"></div>
*/

var notifierModalBodySet = 0;
var notifierProgressBodySet = 0;

var tdsNotifierModalBody = '<div class="modal fade center-modal-" id="custom_message_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\n' +
    '    <div class="modal-dialog">\n' +
    '        <div class="modal-content" style="margin-top: 25% !important;">\n' +
    '            <div class="modal-header">\n' +
    '                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n' +
    '                <h4 class="modal-title" id="custom_modal_title"></h4>\n' +
    '            </div>\n' +
    '            <div class="modal-body" id="custom_modal_message">\n' +
    '            </div>\n' +
    '            <div class="modal-footer">\n' +
    '                <span class="pull-left" id="custom_modal_action_btns"></span>\n' +
    '                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>\n' +
    '            </div>\n' +
    '        </div>\n' +
    '    </div>\n' +
    '</div>';

var tdsNotifierProgressBody = '<div class="modal container fade" id="modal_custom_preloader" tabindex="-1" data-backdrop="static" data-keyboard="false" >\n' +
    '    <div class="modal-dialog" style="width: 28%;margin-top: 15%">\n' +
    '        <div class="modal-content" style="display: flex;align-items: center;min-height: 100px;border-radius: 5px;background-color: whitesmoke">\n' +
    '            <div class="modal-body" style="width: 100%">\n' +
    '               <div class="row" style=" display: flex;align-items: center;">\n' +
    '                   <div class="col-md-3 center" style="margin-right: 0 !important;">\n' +
    '                       <img id="modal_custom_preloader_loading_image" src="/images/tymo_preloader.gif" alt="Loading..." />\n' +
    '                   </div>\n' +
    '                   <div class="col-md-9 left" style="padding-left: 0 !important;">\n' +
    '                       <span style="color: #02A4C5;" id="modal_custom_preloader_msg"></span>\n' +
    '                   </div>\n' +
    '               </div>\n' +
    '            </div>\n' +
    '        </div>\n' +
    '    </div>\n' +
    '</div>';


function show_custom_message_modal(messageType, message, title, actionButtons) {

    //create the modal if it does not exist
    if (notifierModalBodySet === 0) {
        $('#tds_notifier_modal_container').html(tdsNotifierModalBody);
        notifierModalBodySet = 1;
    }

    //remove all loading dialogs if any exist
    show_custom_preloader(false, null);

    $('#custom_modal_title').removeClass('error').removeClass('success').removeClass('warning');

    //title content and styling
    var color_class = '';
    if (messageType === 'success') {
        color_class = 'success';
        title = (title === null) ? "Operation Successful" : title;

    } else if (messageType === 'warning') {
        color_class = 'warning';
        title = (title === null) ? "Warning Message" : title;
    } else if (messageType === 'error') {
        color_class = 'error';
        title = (title === null) ? "Error Message" : title;
    }
    if (!(color_class === '')) $('#custom_modal_title').html(title).addClass(color_class);

    //body  content
    $('#custom_modal_message').html(message);

    //action buttons
    if (actionButtons == null) {
        $('#custom_modal_action_btns').html('');
    } else {
        $('#custom_modal_action_btns').html(actionButtons);
    }

    //show the modal
    showHideModalWithId('custom_message_modal',true);

}

function hide_custom_message_modal() {
    showHideModalWithId('custom_message_modal', false);
}

function showHideModalWithId(modalId, open) {
    if (open === true) {
        $('#' + modalId).modal('show');
    } else {
        $('#' + modalId).modal('hide');
    }
}

function show_custom_preloader(open, message) {

    //create the progress dialog if it does not exist
    if (notifierProgressBodySet === 0) {
        $('#tds_notifier_progress_container').html(tdsNotifierProgressBody);
        notifierProgressBodySet = 1;
    }

    let msg = 'Please wait as we process your request...';
    msg = (message == null || message === "") ? msg : message;

    let msgElement = $("#modal_custom_preloader #modal_custom_preloader_msg");

    if (open === true) {
        msgElement.html(msg);
        showHideModalWithId('modal_custom_preloader',true);
    } else {
        msgElement.html('');
        showHideModalWithId('modal_custom_preloader',false);
    }

}
