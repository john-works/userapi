<!-- The Random Action Modal -->
<div class="modal container fade" id="randomActionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modal Heading</h4>
                <button type="button" class="close" data-dismiss="modal" style="margin-top: -35px;">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                Modal body..
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End the Random Action modal -->

<!-- The Mega Modal -->
<div class="modal container fade" id="megaModal" tabindex="-1" xmlns="" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modal Heading</h4>
                <button type="button" class="close" data-dismiss="modal" style="margin-top: -35px;">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Modal body..
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End the Mega Modal modal -->

<!-- The Calendar Modal -->
<div class="modal container fade" id="calendarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="calendar_heading">Calendar</h4>
                <button type="button" class="close" data-dismiss="modal" style="margin-top: -35px;">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2" id="calendar_types">
                        Calendar Type
                    </div>
                    <div class="col-md-6">
                        <form class="form-inline">
                            <div class="form-group">
                              <div class="input-group">
                                <input id="customCalendarSelector" class="form-control" type="text" data-id readonly>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-2">
                        Switch Calendar
                    </div>
                    <div class="col-md-4">
                        <div class="container mt-5">
                            <form class="form-inline" id="calendar_switcher">
                                <div class="form-group mx-2">
                                    <input type="radio" class="form-check-input" id="month" name="viewType" value="month" checked>
                                    <label class="form-check-label" for="monthly">Monthly</label>
                                </div>
                                <div class="form-group mx-2">
                                    <input type="radio" class="form-check-input" id="week" name="viewType" value="week">
                                    <label class="form-check-label" for="weekly">Weekly</label>
                                </div>
                                <div class="form-group mx-2">
                                    <input type="radio" class="form-check-input" id="day" name="viewType" value="day">
                                    <label class="form-check-label" for="daily">Daily</label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Navigation
                    </div>
                    <div class="col-md-4">
                        <div class="btn-group">
                            <div  class="btn btn-primary btn-sm" onclick="reloadEvents()">Reload</div>
                            <div class="btn btn-primary btn-sm" onclick="switchView('today')">Today</div>
                            <div  class="btn btn-primary btn-sm" onclick="switchView('previous')">Previous</div>
                            <div class="btn btn-primary btn-sm" onclick="switchView('next')">Next</div>
                        </div>
                    </div>
                </div>
                <div id="custom_calendar" style="height:80vh"></div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End the Calendar modal -->
<!--  Custom Event Modal -->
<div class="modal container fade" id="customEventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">Create Event</h4>
                <button type="button" class="close" data-dismiss="modal" style="margin-top: -35px;" id="closeCustomEventModal">
                    &times;
                </button>
            </div>
            <!-- Modal body -->
            <form id="custom_event_form">
            <div class="modal-body">
               <div class="row">
                    <input type="hidden" name="id" id="id">
                    <div class="col-md-12 hidden" id="pm_event_field">
                        <label for="pm_event_type">PM Event Type</label>
                        <select type="text" name="pm_event_type" id="pm_event_type" class="form-control">
                            <option value="" selected disabled>Select PM Event Type</option>
                            <option value="Audit">Audit</option>
                            <option value="Capacity Building">Capacity Building</option>
                            <option value="Local Content">Local Content</option>
                        </select>
                    </div>
                    <div class="col-md-12 hidden" id="audit_type_field">
                        <label for="audit_type">Audit Type</label>
                        <select type="text" name="audit_type" id="audit_type" class="form-control">
                            <option value="" selected disabled>Select Audit Type</option>
                        </select>
                    </div>
                    <div class="col-md-12 hidden" id="audit_activity_field">
                        <label for="audit_activity">Audit Activity</label>
                        <select type="text" name="audit_activity" id="audit_activity" class="form-control">
                            <option value="" selected disabled>Select Audit Activity</option>
                        </select>
                    </div>
                    <div class="col-md-12 hidden" id="pm_entity_field">
                        <label for="entity_name">Entity Name</label>
                        <select type="text" name="entity_name" id="entity_name" class="form-control selectize">
                            <option value="" selected disabled>Select Entity</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Event Title" required>
                    </div>
                    <div class="col-md-12">
                        <label for="location">Location</label>
                        <input type="text" name="location" id="location" class="form-control" placeholder="Event Location" required>
                    </div>
                    <div class="col-md-6">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Start Date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" placeholder="End Date" required>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <input type="submit" id="delete_event" value="Delete" class="btn btn-danger hidden">
                <input type="submit" id="event_submit_btn" value="Save" class="btn btn-primary">
            </div>
        </form>
        </div>
    </div>
</div>
<!-- End the Custom Event modal -->
<!-- Second model -->
<div class="modal fade bs-fill-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button" style="margin-top: -35px;">
                    &times;
                </button>
            </div>
            <div class="modal-body">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End the Second model -->

<!-- Tertiary model -->
<div class="modal fade" id="TertiaryModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button" style="margin-top: -35px;">
                    &times;
                </button>
            </div>
            <div class="modal-body">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End the Tertiary modal -->


{{-- Confirmation Modal --}}
<!-- Modal -->
<div class="modal fade" id="modalConfirmEmisAttachment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Confirm EMIS Attachment Details</h4>
            </div>
            <div class="modal-body" id="modalConfirmEmisAttachmentBody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-url="" data-title="" data-clarify=""
                        id="confirmEmisAttachment">Confirm
                </button>
            </div>
        </div>
    </div>
</div>
{{-- End Confirmation Modal --}}

{{-- Start Confirm Device Revoke --}}
<div class="modal fade" id="modal_confirm_utd_revoke" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Confirm Revoke of Trusted Device</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="col-md-12"><label class="font-bold">Comment:</label></div>
                        <div class="col-md-12">
                            <textarea rows="3" id="utd_revoke_code" class="form-control"></textarea>
                            <span class="error" style="display: block" id="utd_revoke_code_error"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-url="" data-title="" data-clarify="" id="confirmUtdRevoke">Revoke</button>
            </div>
        </div>
    </div>
</div>
{{-- End  Confirm Device Revoke --}}


<!-- Custom Message Modal -->
<div class="modal fade center-modal" id="custom_message_modal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="custom_modal_title"></h4>
            </div>
            <div class="modal-body" id="custom_modal_message">
            </div>
            <div class="modal-footer">
                <span class="pull-left" id="custom_modal_action_btns"></span>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{-- End Message Modal --}}


{{-- PDF Viewer Modal --}}
<div id="pdf-dialog" class="modal container fade PdfViewerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">PDF Document Viewer</h4>
            </div>
            <div class="modal-body">
                <iframe id="iframe-pdf-viewer" style="width: 100%;height: 600px" src=""></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{-- End PDF Viewer Modal --}}

<!-- Photo Preview model -->
<div class="modal fade" id="photo_preview_old">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button" style="margin-top: -15px;">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                {{-- <img src="#" alt="Preview Uploaded Image" id="image_holder"> --}}
            </div> 
        </div>
    </div>
</div>
{{-- Used for showing message modal and progress bar --}}
<div id="tds_notifier_modal_container"></div>
<div id="tds_notifier_progress_container"></div>

<div class="footer" style="padding-top: 0px">
    <div class="footer-inner">
        <!-- #section:basics/footer -->
        <div class="footer-content um-primary-bg">
            <span class="bigger-120 text-white">
				<span style="font-size:0.8em;">&copy; {{ date("Y") }} PPDA All Rights Reserved</span>
			</span>
        </div>
        <!-- /section:basics/footer -->
    </div>
</div>

<!-- Hidden form for image uploads -->
<div style="display:none;">
    <form name="frmPhoto" enctype="multipart/form-data" method="post" id="target">
        @csrf
        <div id="target_input"></div>
    </form>
</div>
<!-- End hidden form -->

<!-- Hidden form for holding temp html -->
<div style="display:none;" id="dummy_div"></div>
<!-- End hidden form -->


<!-- basic scripts -->

<!--[if !IE]> -->
<script type="text/javascript">
    window.jQuery || document.write("<script type='text/javascript' src='{{ asset('js/jquery.js') }}'>" + "<" + "/script>");
    window.jQuery || document.write("<script type='text/javascript' src='{{ asset('js/jquery-ui.js') }}'>" + "<" + "/script>");
    window.jQuery || document.write("<script type='text/javascript' src='{{ asset('js/jquery-ui.custom.js') }}'>" + "<" + "/script>");
</script>
<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script type='text/javascript' src='{{ asset('js/jquery1x.js') }}'>" + "<" + "/script>");
</script>
<![endif]-->


<script type="text/javascript" src="{{ asset('js/app-scripts.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/app-custom-scripts.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/chosen.jquery.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/jquery.gritter.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/date-time/bootstrap-timepicker.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/form_validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/tds_notifier.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/forms_custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bowser_browser_detection.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/tinymce/jquery.tinymce.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/inc/ajaxupload.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-ui.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/tui-time-picker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/tui-date-picker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/toastui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/yearpicker.js') }}"></script>
<!-- inline scripts related to this page -->
<script type="text/javascript">

    function handleLetterCategorySelectionLogic() {

        var selected = $('#select_letter_category').children("option:selected").val();
        if (selected === 'Incoming Letter') {

            //show incoming letter specific fields
            $('.ctn-org-type').css('display', 'block');
            $('.ctn-letter-specific-fields').css('display', 'block');
            $('.ctn-memo-specific-fields').css('display', 'none');

            //enable required fields
            $("#org_type_selector").prop('required', true);
            $("#dropdown_letter_types").prop('required', true);
            $("#from_user").prop('required', false);

        } else if (selected === 'Memo - To ED' || selected === 'Memo - From ED') {

            //show memo specific fields
            $('.ctn-memo-specific-fields').css('display', 'block');
            $('.ctn-letter-specific-fields').css('display', 'none');

            //enable required fields
            $("#org_type_selector").prop('required', false);
            $("#dropdown_letter_types").prop('required', false);
            $("#from_user").prop('required', true);

            var folderField = $("#edms_document_path_folder");
            folderField.val("DEFAULT_MEMO");

        } else {
            $('.ctn-org-type').css('display', 'none');
            $('.ctn-letter-specific-fields').css('display', 'block');
            $('.ctn-memo-specific-fields').css('display', 'none');

            //enable required fields
            $("#org_type_selector").prop('required', true);
            $("#dropdown_letter_types").prop('required', true);
            $("#from_user").prop('required', false);
        }

    }

    function allowEmisAttachment(elem) {

        if (!(elem.hasClass('btnEmisAttachment'))) {
            return true;
        } else {

            var dept = elem.attr('data-dept');
            var caseType = elem.attr('data-case-type');
            var emisAttachmentId = elem.attr('data-attachment-type-id');
            var letterId = elem.attr('data-letter-id');
            var letterType = elem.attr('data-letter-type');

            if (letterId == null || letterId == "") {
                show_custom_message_modal('error', 'Letter ID not Found', null, null);
                return false;
            }
            if (dept == null || dept == "") {
                show_custom_message_modal('error', 'Unknown Department', null, null);
                return false;
            }
            if (caseType == null || caseType == "") {
                show_custom_message_modal('error', 'Please Select Section', null, null);
                return false;
            }
            if (emisAttachmentId == null || emisAttachmentId == "") {
                show_custom_message_modal('error', 'Please Select Letter Type', null, null);
                return false;
            }
            if (letterType == null || letterType == "") {
                show_custom_message_modal('error', 'Unknown Letter Type', null, null);
                return false;
            }

            var dataHref = elem.attr('data-href');
            dataHref = dataHref + '/' + letterId + ':::' + dept + ':::' + caseType + ':::' + emisAttachmentId + ':::' + letterType;

            //set the right href
            elem.attr('href', dataHref);

            return true;

        }

    }

    function allowDocumentAttachment(elem) {

        if (!(elem.hasClass('btn_attach_document'))) {
            return true;
        } else {

            var entityEdmsFolderSet = elem.attr('data-entity-edms-folder-set');
            if (entityEdmsFolderSet == 1) {
                return true;
            }

            var body = '<ol><li>Please FIRST CONTACT <u>REGISTRY</u> TO Setup the Entity Folders in both EDMS and EMIS.</li><li>Wait and TRY AGAIN after Registry is done.</li></ol>';
            show_custom_message_modal("warning", body, "Warning - Entity EDMS Folder Not Found", null);
            return false;

        }

    }

    function showEmailLinkAttachment() {

        var deleteTempDocumentURL = $("#pdf-dialog-1").attr('data-remove-temp-url');
        var dialog1 = $("#pdf-dialog-1").dialog({
            width: 1300,
            height: 600,
            top: ['center', 20],
            close: function (event) {

                $.get(deleteTempDocumentURL, function (data) {
                    var resp = jQuery.parseJSON(data);
                });
            }
        });

        $("#pdf-dialog-1").show();

    }

    jQuery(function ($) {
        showEmailLinkAttachment();
        $('body').on('click', '.clarify,.clarify_secondary,.clarify_tertiary,.clarify_form', function (event) {
            event.preventDefault();

            //additional verifications
            var sourceElement = $(this);
            if (!allowEmisAttachment(sourceElement) || !allowDocumentAttachment(sourceElement)) {
                return;
            }

            var modal_selector = (/clarify_secondary/i.test($(this).attr('class')) ? '.bs-fill-modal' : '#randomActionModal')

            modal_selector = ''
            if (/clarify_secondary/i.test($(this).attr('class'))) {
                modal_selector = '.bs-fill-modal'
            } else if (/clarify_form/i.test($(this).attr('class'))) {
                modal_selector = '#saveAndStickModal'
            } else if (/clarify_tertiary/i.test($(this).attr('class'))) {
                modal_selector = '#TertiaryModal'
            } else {
                modal_selector = '#randomActionModal'
            }

            var $msg_load_preview_wait = "" +
                "<div class='float-alert'>" +
                "<div class='float-alert-container'>" +
                "<div class='col-sm-9-'>" +
                "<h3 class='header smaller lighter green text-center'><i class='fa fa-globe'></i>&nbsp;Request Submitted </h3>" +
                "<p class='text-center'>" +
                "<i class='ace-icon fa fa-spinner fa-spin orange bigger-225'></i> " +
                "Loading details! Please wait..." +
                "</p>" +
                "</div>" +
                "</div>" +
                "</div>";

            $(modal_selector + ' .modal-body').html($msg_load_preview_wait)
            $(modal_selector + ' .modal-title').html('Please wait...')
            $(modal_selector).modal('show');

            var url = $(this).attr('href')
            var title = $(this).attr('title')

            $.get(url, function (result) {
                $(modal_selector + ' .modal-body').html(result);
                $(modal_selector + ' .modal-title').html(title);
                //activateForm()
                initiateDateRangePicker()
                initializeTimePicker()
                selectize()
                loadListing()
                initiateWYSIWYG()
                initializeFilePicker()
                form_element_show_hide()
            })
        });

        $('body').on('click','.clarify_post',function(){
            event.preventDefault();
            var btn = $(this)
            var modal = btn.data('modal')

            var modal_selector = ''
            if (/clarify_secondary/i.test(modal)) {
                modal_selector = '.bs-fill-modal'
            } else if (/clarify_form/i.test(modal)) {
                modal_selector = '#saveAndStickModal'
            } else if (/clarify_tertiary/i.test(modal)) {
                modal_selector = '#TertiaryModal'
            } else if (/clarify_mega/i.test(modal)) {
                modal_selector = '#megaModal'
            } else {
                modal_selector = '#randomActionModal'
            }

            var $msg_load_preview_wait = "" +
                "<div class='float-alert'>" +
                "<div class='float-alert-container'>" +
                "<div class='col-sm-9-'>" +
                "<h3 class='header smaller lighter green text-center'><i class='fa fa-globe'></i>&nbsp;Request Submitted </h3>" +
                "<p class='text-center'>" +
                "<i class='ace-icon fa fa-spinner fa-spin orange bigger-225'></i> " +
                "Loading details! Please wait..." +
                "</p>" +
                "</div>" +
                "</div>" +
                "</div>";

            $(modal_selector + ' .modal-body').html($msg_load_preview_wait)
            $(modal_selector + ' .modal-title').html('Please wait...')
            $(modal_selector).modal('show');

            var extra = btn.data('extra')     
            if(!(typeof extra === 'object' && extra !== null)){
                var strJson = JSON.stringify(extra)
                extra = JSON.parse(strJson)
            }   
            url = btn.data('route')
            next = btn.data('after_action')
            
            $.post(
                url,
                extra
            ).done(function(result){
                var title = btn.attr('title')
                $(modal_selector + ' .modal-title').html(title);
                $(modal_selector + ' .modal-body').html(result);

                loadListing()
            }).error(function(message){
                pushNotification('Error',message.responseJSON.message,'error')
            }).fail(function(result){
                if(/Unauthenticated/i.test(result.responseJSON.message)){
                    $msg = '"Hmmm!! Looks like Your session has expired!! Provide your credentials so we can log you in again...<br>';
                    pushNotification('Unauthenticated',$msg,'warning')
                    location.reload();
                }else{
                    if(result.responseJSON.message != undefined){
                        $msg = result.responseJSON.message
                    }else if(result.responseJSON.error != undefined){
                        $msg = result.responseJSON.error
                    }else{
                        $msg = 'Please Check error message'
                    }
                    pushNotification('Error',$msg,'error')
                    $(modal_selector + ' .modal-body').html(result.responseJSON.message);
                }
            })
        })


        $('body').on('click', '#confirmEmisAttachment', function (event) {
            event.preventDefault();

            $('#modalConfirmEmisAttachment').modal('hide');

            var dataClarify = $(this).attr('data-clarify');
            var dataUrl = $(this).attr('data-url');
            var dataTitle = $(this).attr('data-title');

            var modal_selector = (/clarify/i.test(dataClarify) ? '.bs-fill-modal' : '#randomActionModal')

            modal_selector = ''
            if (/clarify_secondary/i.test(dataClarify)) {
                modal_selector = '.bs-fill-modal'
            } else if (/clarify_form/i.test(dataClarify)) {
                modal_selector = '#saveAndStickModal'
            } else if (/clarify_tertiary/i.test(dataClarify)) {
                modal_selector = '#TertiaryModal'
            } else {
                modal_selector = '#randomActionModal'
            }

            var $msg_load_preview_wait = "" +
                "<div class='float-alert'>" +
                "<div class='float-alert-container'>" +
                "<div class='col-sm-9-'>" +
                "<h3 class='header smaller lighter green text-center'><i class='fa fa-globe'></i>&nbsp;Request Submitted </h3>" +
                "<p class='text-center'>" +
                "<i class='ace-icon fa fa-spinner fa-spin orange bigger-225'></i> " +
                "Loading details! Please wait..." +
                "</p>" +
                "</div>" +
                "</div>" +
                "</div>";

            $(modal_selector + ' .modal-body').html($msg_load_preview_wait)
            $(modal_selector + ' .modal-title').html('Please wait...')
            $(modal_selector).modal('show');

            var url = dataUrl;
            var title = dataTitle;

            $.get(url, function (result) {
                $(modal_selector + ' .modal-body').html(result);
                $(modal_selector + ' .modal-title').html(title);
                //activateForm()
                initiateDateRangePicker()
                initializeTimePicker()
                selectize()
                loadListing()
                initiateWYSIWYG()
                initializeFilePicker()
                form_element_show_hide()
            })
        });

        $('body').on('click', '.btnEmisAttachment', function (event) {
            event.preventDefault();

            //additional verifications
            var sourceElement = $(this);
            if (!allowEmisAttachment(sourceElement)) {
                return;
            }

            var dataClarify = $(this).attr('data-clarify');
            var dataUrl = $(this).attr('href');
            var dataTitle = $(this).attr('title');
            var department = $(this).attr('data-dept');
            var section = $(this).attr('data-case-type');
            var letterType = $(this).attr('data-attachment-type');

            var modalBody =
                '<div><div style="width: 100px;display:inline-block;">DEPARTMENT:</div><span >' + department.toUpperCase() + '</span></div>\n' +
                '<div><span style="width: 100px;display:inline-block;">SECTION:</span><span >' + section + '</span></div>\n' +
                '<div><span style="width: 100px;display:inline-block;">LETTER TYPE:</span><span>' + letterType + '</span></div>';

            $('#confirmEmisAttachment').attr('data-url', dataUrl).attr('data-title', dataTitle).attr('data-clarify', dataClarify);
            $('#modalConfirmEmisAttachmentBody').html(modalBody);

            $('#modalConfirmEmisAttachment').modal('show');

        });


        $(window).on('resize.ace.top_menu', function () {
            //$(document).triggerHandler('settings.ace.top_menu', ['sidebar_fixed' , $sidebar.hasClass('sidebar-fixed')]);
        });


        //timothy custom script

        $(document).on('change', '#dropdown_letter_types', function () {

            var selectedLetterType = $(this).val();
            var showExtraFields = $(this).attr('data-show-extra-fields');

            //no selection clear the extra fields
            if (selectedLetterType == '0' || showExtraFields != 'true') {
                $('#extra_fields').html('');
                return;
            }

            var dataURL = $(this).attr('data-url') + '/' + selectedLetterType;

            $.get(dataURL, function (data) {
                // use this method you need to handle the response from the view
                $('#extra_fields').html(data);
            });

        });

        $(document).on('change', '#dropdown_letter_types_outgoing', function () {

            var selectedLetterType = $(this).val();

            //no selection clear the extra fields
            if (selectedLetterType == '0') {
                $('#extra_fields').html('');
                return;
            }

            var dataURL = $(this).attr('data-url') + '/' + selectedLetterType;

            $.get(dataURL, function (data) {
                // use this method you need to handle the response from the view
                $('#extra_fields').html(data);
            });

        });

        /*
        * For Access Modules
        * */
        $('body').on('change','.cbx_access_module_selector',function(){

            var containerSubModuleRights = $(this).attr('data-sub-mod-container-id');
            var accessGranted = $(this).val() === "Grant Access";
            if(this.checked && accessGranted) {
                $('.'+containerSubModuleRights).css('display','block');
            }else{
                //set check boxes to no
                var subClass = '.sub_no_'+containerSubModuleRights;
                $(subClass).prop('checked', true);
                $('.'+containerSubModuleRights).css('display','none');
            }

        });

        /*
        * Handles PDF viewing using the Jquery-ui library
        * */
        $(document).on('click', '.pdf-link', function () {

            $('#pdf-dialog').modal('show');

            //go to EDMS API and get the HREF
            var downloadLinksURL = $(this).attr('data-download-url');
            var deleteTempDocumentURL = $(this).attr('data-remove-temp-url');
            var enableToolBar = $(this).attr('data-enable-toolbar');
            var tempPath = '';

            $('#pdf-dialog').on('hidden.bs.modal', function (event) {

                var removeURL = deleteTempDocumentURL + tempPath;
                $.get(removeURL, function (data) {
                    var resp = jQuery.parseJSON(data);
                });
            });

            //show progress dialog
            show_custom_preloader(true, 'Please wait as we load the requested PDF!');

            // use other ajax submission type for post, put ...
            $.get(downloadLinksURL, function (data) {

                show_custom_preloader(false, null);

                // use this method you need to handle the response from the controller, in this case I am returning a json response
                var resp = jQuery.parseJSON(data);
                if (resp.statusCode == 0) {

                    $(".ui-dialog").show();
                    var pdfURL = resp.result;
                    tempPath = resp.tempPath;

                    //disable the download and print link on the PDF Viewer
                    pdfURL = enableToolBar === "yes" ? pdfURL : pdfURL + "?page=hsn#toolbar=0"; //https://stackoverflow.com/questions/41586093/disable-hide-download-button-in-iframe-on-default-pdf-viewer //https://stackoverflow.com/questions/20328820/how-to-disable-pdf-toolbar-download-button-in-iframe
                    $('#iframe-pdf-viewer').attr('src', pdfURL);

                } else {

                    $('#pdf-dialog').modal('hide');
                    show_custom_message_modal('error', resp.statusDescription, null, null);

                }

            });

        });


        /*
        * Refresh entity list
        * */
        $(document).on('click', '.btnRefreshEntities', function () {

        });

        /*
        * For setting EDMS Folder path for the Government entities
        * */
        $('body').on('change', '.government_entity_select', function () {

            var folderField = $("#edms_document_path_folder");
            var entityType = $('.org_type_selector').children("option:selected").val();
            if (entityType == 'Government Entity') {

                var selected = $(this).children("option:selected");
                var dataEntityId = selected.attr('data-entity-id');
                var dataEdmsDocRootPath = selected.attr('data-edms-doc-path');
                dataEdmsDocRootPath = dataEdmsDocRootPath == null || $.trim(dataEdmsDocRootPath) === "" ? "DEFAULT" : dataEdmsDocRootPath;
                folderField.val(dataEdmsDocRootPath);

            }

        });

        /*
        * For setting EDMS Folder path for the Non government to DEFAULT
        * */
        $('body').on('change', '.org_type_selector', function () {

            // var selected = $(this).children("option:selected").val();
            // if(selected === 'Non - Government Entity'){
            //
            //     var folderField = $("#edms_document_path_folder");
            //     folderField.val("DEFAULT");
            //
            // }

        });

        /*
        * For setting EDMS Folder path for Non Government entities
        * */
        $('body').on('change', '.non_government_entity_select', function () {

            var folderField = $("#edms_document_path_folder");
            var entityType = $('.org_type_selector').children("option:selected").val();
            if (entityType == 'Non - Government Entity') {

                var selected = $(this).children("option:selected");
                var dataEntityId = selected.attr('data-entity-id');
                var dataEdmsDocRootPath = selected.attr('data-edms-doc-path');
                dataEdmsDocRootPath = dataEdmsDocRootPath == null || $.trim(dataEdmsDocRootPath) === "" ? "DEFAULT" : dataEdmsDocRootPath;
                folderField.val(dataEdmsDocRootPath);

            }

        });

        /*
        * For handling TAG selection
        * */
        $('body').on('change', '.tag-rbtns', function () {

            if (this.checked) {

                // we need to first send request to backend to update the department flag
                var deptTag = $(this).closest('tr').attr('data-tag');
                var letterId = $(this).closest('tr').attr('data-letter-id');
                var letterType = $(this).closest('tr').attr('data-letter-type');
                var flagValue = $(this).val();

                // format of the route is, so we need to replace the place holders /tag-to-dept/{letterCategory}/{letterId}/{deptTag}/{flagValue}
                var urlTagging = $(this).closest('table').attr('data-tag-url');
                var url = urlTagging.replace('Param1',letterType).replace('Param2',letterId).replace('Param3',deptTag).replace('Param4',flagValue);

                var cbxRowId = $(this).attr('data-cbx-container-id');
                var radioBtn = $(this);

                //======================= SEND REQUEST TO SERVER========================
                $.ajax({
                    url: url,
                    method: "get",
                    beforeSend: function (data) {
                        show_custom_preloader(true, null);
                    },
                    success: function (response) {
                        show_custom_preloader(false,null);
                        var result = JSON.parse(response);
                        var statusCode = result.statusCode;
                        var statusDesc = result.statusDescription;

                        if (statusCode == "0") {
                            loadListing();
                        } else {
                            show_custom_message_modal('error', statusDesc, null, null);
                        }

                    },
                    error:function(jqXHR, textStatus, errorThrown) {
                        show_custom_preloader(false,null);
                        show_custom_message_modal('error',"Seems like something went wrong</br>" + jqXHR.status+" "+errorThrown,null,null);
                    }
                });
                //======================= #END SEND REQUEST TO SERVER===================

            }

        });

        /*
        * For handling TAG selection
        * */
        $('body').on('change', '.rbtns-letter-launch', function () {

            var cbxRowId = $(this).attr('data-cbx-container-id');
            var selectClassId = $(this).attr('data-dropdown-class');

            if (this.checked) {

                var selected = $(this).val() === "1";
                if (selected) {

                    $('#' + cbxRowId).css('display', 'block'); //show the check boxes
                    $('.' + cbxRowId).css('display', 'block'); //show the check boxes

                } else {

                    $('#' + cbxRowId).css('display', 'none'); //Hide the check boxes
                    $('.' + cbxRowId).css('display', 'none'); //Hide the check boxes

                }

            }

        });

        /*
        * Private File
        * */
        $('body').on('change', '.cbx_private_file', function () {

            var fileIsPrivate = $(this).val() === "1";
            if (this.checked && fileIsPrivate) {
                $('#container_emis_tags').css('display', 'none')
            } else {
                $('#container_emis_tags').css('display', 'block')
            }

        });

        /*
        * For setting name value of the selected user
        * */
        $('body').on('change', '.select-fill-hidden-input', function () {

            try {

                //autofill the fullName
                var textValue = $(this).children("option:selected").text();
                var idOfInputToFill = $(this).attr('data-hidden-input-id');
                $('#' + idOfInputToFill).val(textValue);

                //autofill the department
                var selectedOption = $(this).children("option:selected");
                var dataDept = selectedOption.attr('data-dept');
                var idOfInputDept = $(this).attr('data-hidden-input-dept');
                $('#' + idOfInputDept).val(dataDept);

            } catch (e) {
                show_custom_message_modal('error', e.message, null, null);
            }

        });

        $('body').on('click', '.btn-association-letters', function () {

            var elemShow = $(this).attr('data-table-to-show');
            var elemHide = $(this).attr('data-table-to-hide');

            $('#' + elemHide).css('display', 'none');
            $('#' + elemShow).css('display', 'block');

            loadListing();

        });

        // Call delete URL with confirmation
        $('body').on('click', '.delete-timo', function () {

            var deleteURL = $(this).attr('data-url');
            var modelToDel = $(this).attr('data-model');

            bootbox.confirm('Are you sure you want to delete ' + modelToDel + '!', function (result) {
                if (result) {
                    actionAuthorized = true;
                    document.location = deleteURL;
                }
            });

            return false;
        });

        /*
        * For setting EDMS Folder path for the Non government to DEFAULT
        * */
        $('body').on('change', '.org_type_selector', function () {

            var selected = $(this).children("option:selected").val();
            if (selected === 'Non - Government Entity') {

                var folderField = $("#edms_document_path_folder");
                folderField.val("DEFAULT");

            }

        });

        /*
        * For handling letter category selection
        * */
        $('body').on('change', '.select_letter_category', function () {
            handleLetterCategorySelectionLogic();
        });

        $("body").on('change', ".select_out_letters_signatory_title", function () {
            try {

                form_element_show_hide();
            } catch ($ex) {
            }
        });

        /*
        * When the modal is loaded, with server data, handle show
        * */
        $("body").on('DOMSubtreeModified', ".modal-body", function () {
            try {
                handleLetterCategorySelectionLogic();
            } catch ($ex) {
            }
        });


        /*
        * For setting EDMS Folder path for the Government entities
        * */
        $('body').on('change', '#select_departments', function () {

            var selectedDepartment = $('#select_departments').children("option:selected").val();

            $('option[data-dept="' + selectedDepartment + '"]').hide();

            // $('#origin_department_unit').children().hide();
            // $('#origin_department_unit').children('option[data-dept="'+selectedDepartment+'"]').hide();
            //
            // $("#origin_department_unit").trigger('contentChanged');

        });


        $('body').on('change', '.select_section', function () {

            var dept = $(this).attr('data-dept');
            var typeField = $(this).attr('data-type-field');
            var typeWrapper = $(this).attr('data-type-field-wrapper');

            var attachBtnId = $(this).attr('data-attach-btn');
            var attachBtn = $('#' + attachBtnId);
            attachBtn.attr('data-attachment-type-id', ""); //clear the letter type
            attachBtn.attr('data-attachment-type', ""); //clear the letter type

            var selected = $(this).children("option:selected");
            var selectedValue = selected.val();

            if (selectedValue == "") {
                attachBtn.attr('title', 'Attach Letter to EMIS');

                $('#' + typeField).html("");
                $('#' + typeWrapper).css('display', 'none');
            } else {
                var dataCaseType = selected.val();
                attachBtn.attr('title', 'Attach Letter to EMIS ' + dataCaseType);
                attachBtn.attr('data-case-type', dataCaseType);

                selectedValue = selectedValue.replace(/\s/g, '');
                var htmlOptions = $('#' + dept + selectedValue).html();

                $('#' + typeField).html(htmlOptions);
                $('#' + typeWrapper).css('display', 'block');
            }

        });

        $('body').on('change', '.select_letter_type', function () {

            var attachBtnId = $(this).attr('data-attach-btn');
            var attachBtn = $('#' + attachBtnId);

            var selected = $(this).children("option:selected");
            var selectedValue = selected.val();
            var selectedText = selected.text();

            if (selectedValue == "") {
                attachBtn.attr('data-attachment-type-id', '');
                attachBtn.attr('data-attachment-type', '');
            } else {
                attachBtn.attr('data-attachment-type-id', selectedValue);
                attachBtn.attr('data-attachment-type', selectedText);
            }

        });


        $('body').on('click', '.export_to_excel', function () {
            $table_id = $(this).data('table');
            export_to($table_id)
        });

        $('body').on('change', '#cbx_entity_not_in_list_flag', function () {

            var que = $('#current_que').val();
            if (($(this).is(":checked")) && que === 'reception') {
                //show warning
                var body = '<ol><li>Please FIRST CONTACT <u>REGISTRY</u> TO Setup the Entity Folders in both EDMS and EMIS.</li><li>Wait and TRY AGAIN after Registry is done.</li></ol>';
                show_custom_message_modal("warning", body, "Warning - Entity DOES NOT EXIST", null);
            }

        });


        $('body').on('change', '#select_letter_movement_type', function () {

            var selectedLetterMovementType = $('#select_letter_movement_type').children("option:selected").val();

            var btnAddLmdFinalAction = $('#btnAddLmdFinalAction');
            var currerentHref = btnAddLmdFinalAction.attr('href');
            var hrefParts = currerentHref.split('letter_movement_type_');
            var newHref = hrefParts[0] + 'letter_movement_type_' + selectedLetterMovementType;

            //set the new href
            btnAddLmdFinalAction.attr('href',newHref);

        });

        $('body').on('click','.btnAjaxGet', function () {

            event.preventDefault();
            var btnAction = $(this);

            var url = btnAction.attr('data-url');

            //show confirmation message

            btnAction.addClass('disabled');
            show_custom_preloader(true, null);

            $.ajaxSetup({ headers: {'X-Requested-With': 'XMLHttpRequest'} });
            $.ajax({
                type: 'GET',
                url: url,
                // data: formData,
                success: function (data) {

                    show_custom_preloader(false, null);
                    btnAction.removeClass('disabled'); //show btn again
                    //progressDialog.addClass('hide'); //hide dialog

                    if ($.isEmptyObject(data.error)) {
                        var resp = JSON.parse(data);
                        if(resp.statusCode !== "0"){
                            show_custom_message_modal('error', resp.statusDescription,null,null);
                            return;
                        }

                        if(btnAction.hasClass('link-trust-device-revoke')){
                            $('.link-trust-device-revoke').addClass('hide');
                            $('.link-trust-device-set').removeClass('hide');
                        }

                        // we got a success response
                        loadListing();
                        show_custom_message_modal('success', resp.statusDescription,null,null);

                    } else {
                        show_custom_message_modal('error', data.error,null,null);
                    }
                },
                error: function (xhr, status, error) {

                    show_custom_preloader(false, null);
                    btnAction.removeClass('disabled'); //show btn again
                    show_custom_message_modal('error', error,null,null);

                }
            });

        });

        $('body').on('click','.btnDeleteAjax', function () {

            event.preventDefault();
            var btnDelete = $(this);

            var url = btnDelete.attr('data-url');

            //show confirmation message

            btnDelete.addClass('disabled');
            show_custom_preloader(true, null);

            $.ajaxSetup({ headers: {'X-Requested-With': 'XMLHttpRequest'} });
            $.ajax({
                type: 'GET',
                url: url,
                // data: formData,
                success: function (data) {

                    show_custom_preloader(false, null);
                    btnDelete.removeClass('disabled'); //show btn again
                    //progressDialog.addClass('hide'); //hide dialog

                    if ($.isEmptyObject(data.error)) {
                        var resp = JSON.parse(data);
                        if(resp.statusCode !== "0"){
                            show_custom_message_modal('error', resp.statusDescription,null,null);
                            return;
                        }

                        // we got a success response
                        loadListing();
                        show_custom_message_modal('success', resp.statusDescription,null,null);

                    } else {
                        show_custom_message_modal('error', data.error,null,null);
                    }
                },
                error: function (xhr, status, error) {

                    show_custom_preloader(false, null);
                    btnDelete.removeClass('disabled'); //show btn again
                    show_custom_message_modal('error', error,null,null);

                }
            });

        });

        $('body').on('mouseover', '.link-trust-device-set', function () {

            var result = bowser.getParser(window.navigator.userAgent);
            var browser = result.parsedResult.browser.name +
                " v" + result.parsedResult.browser.version +
                " on " + result.parsedResult.os.name;
            browser = result.parsedResult.browser.name;
            browser = browser.trim();

            var href = $(this).attr('href');
            href = href.replace('PARAM_BROWSER_NAME',browser.toUpperCase());
            $(this).attr('href',href);

        });

        $('body').on('click','.btnTrustedDeviceVerificationCode', function () {

            event.preventDefault();
            var btnAction = $(this);

            if(!validate_form(btnAction.closest('form').attr('id'))){
                return false
            }

            var browser = $('#utd_browser').val();
            var deviceIp = $('#utd_device_ip').val();
            var deviceName = $('#utd_device_name').val();
            var deviceDetails = browser+":::"+deviceName+":::"+deviceIp;
            deviceDetails = encodeURIComponent(deviceDetails);

            var url = btnAction.attr('data-url');
            url = url.replace('PARAM_DETAILS',deviceDetails)

            //show confirmation message

            btnAction.addClass('disabled');
            show_custom_preloader(true, null);

            $.ajaxSetup({ headers: {'X-Requested-With': 'XMLHttpRequest'} });
            $.ajax({
                type: 'GET',
                url: url,
                // data: formData,
                success: function (data) {

                    show_custom_preloader(false, null);
                    btnAction.removeClass('disabled'); //show btn again

                    if ($.isEmptyObject(data.error)) {
                        var resp = JSON.parse(data);
                        if(resp.statusCode !== "0"){
                            show_custom_message_modal('error', resp.statusDescription,null,null);
                            return;
                        }

                       var confirmationCode = resp.result;
                        $('#confirmation_code').val(confirmationCode);
                        $('.show-on-code-sent').removeClass('hide');
                        $('.hide-on-code-sent').addClass('hide');
                        $("#confirmation_code_input").attr("required", "required");
                        // we got a success response
                        // loadListing();
                        // showCustomizableModal('Operation successful', resp.statusDescription);

                    } else {
                        show_custom_message_modal('error', data.error,null,null);
                    }
                },
                error: function (xhr, status, error) {

                    show_custom_preloader(false, null);
                    btnAction.removeClass('disabled'); //show btn again
                    show_custom_message_modal('error', error,null,null);

                }
            });

        });

        $('body').on('click','.btnRevokeTrustedDevice', function () {

            event.preventDefault();
            var btnAction = $(this);

            //clear the error and the value in the text area
            $('#utd_revoke_code_error').html('');
            $('#utd_revoke_code').val("");

            var url = btnAction.attr('data-url');
            $('#confirmUtdRevoke').attr('data-url',url);
            $('#modal_confirm_utd_revoke').modal('show');

        });

        $('body').on('focus','#utd_revoke_code', function () {
            $('#utd_revoke_code_error').html('');
        });

        $('body').on('click','#confirmUtdRevoke', function () {

            event.preventDefault();
            var btnAction = $(this);

            //clear the error
            $('#utd_revoke_code_error').html('');

            var comment = $('#utd_revoke_code').val();
            if(comment == null || comment === ""){
                $('#utd_revoke_code_error').html('Comment is required on revoke');
                return;
            }

            var url = btnAction.attr('data-url');
            url = url.replace('PARAM_COMMENT', encodeURIComponent(comment));

            btnAction.addClass('disabled');
            show_custom_preloader(true, null);

            $.ajaxSetup({ headers: {'X-Requested-With': 'XMLHttpRequest'} });
            $.ajax({
                type: 'GET',
                url: url,
                // data: formData,
                success: function (data) {

                    show_custom_preloader(false, null);
                    btnAction.removeClass('disabled'); //show btn again

                    if ($.isEmptyObject(data.error)) {
                        var resp = JSON.parse(data);
                        if(resp.statusCode !== "0"){
                            showCustomizableModal('Error occurred', resp.statusDescription);
                            return;
                        }

                        // we got a success response
                        showHideModalWithId("modal_confirm_utd_revoke", false);
                        loadListing();
                        show_custom_message_modal('success', resp.statusDescription,null,null);

                    } else {
                        show_custom_message_modal('error', data.error,null,null);
                    }
                },
                error: function (xhr, status, error) {

                    show_custom_preloader(false, null);
                    btnAction.removeClass('disabled'); //show btn again
                    show_custom_message_modal('error', error,null,null);

                }
            });

        });

        //end timothy custom scripts

    });

    function export_to(tableId) {
        var tab_text = "<table border='2px'><tr bgcolor='#87AFC6'>";
        var textRange;
        var j = 0;
        tab = document.getElementById(tableId); // id of table

        for (j = 0; j < tab.rows.length; j++) {
            tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
            //tab_text=tab_text+"</tr>";
        }

        tab_text = tab_text + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
        tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
            txtArea1.document.open("txt/html", "replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa = txtArea1.document.execCommand("SaveAs", true, "save report.xls");
        } else   //other browser not tested on IE 11
        {

            /*=========================================
             * HANDLE DOWNLOAD FILE NAME
             *==========================================*/

            var fileName = $('#'+tableId).attr('data-filename')
            if(null != fileName){

                var uri = 'data:application/vnd.ms-excel,' +  encodeURIComponent(tab_text);
                var downloadLink = document.createElement("a");
                downloadLink.href = uri;
                downloadLink.download = fileName;

                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);

            }else{
                sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
                return (sa);
            }

        }

    }

    function print_report(container) {
        var display_setting = "toolbar=yes,location=no,directories=yes,menubar=no,resizable=no,alwaysRaised=yes,";
        display_setting += "scrollbars=yes, left=100, top=25";

        var content = $('#' + container).html();
        var report_document = window.open("", "Report", display_setting);
        report_document.document.open();
        report_document.document.write('<html><head><title>Report </title><link href="{{ asset('css/print.css') }}" rel="stylesheet" type="text/css"> </head>');
        report_document.document.write('<body onLoad="self.print();self.close();" style="background:url(images/logo.png) no-repeat center;" >');
        var headerRpt = $('#' + container + ' .headerReport').html();
        //report_document.document.write(headerRpt);
        report_document.document.write(content);
        report_document.document.write('</body></html>');
        //report_document.print();
        report_document.document.close();
        return false;
    }

</script>

<script type="text/javascript">

    $('.dropdown-toggle').dropdown()

    var actionAuthorized = false
    $(document).on('click', 'button[value=Delete],button[value=Deactivate],button[value="Auto Deactivate"]', function (e) {
        var action = $(this).val()
        var btn = $(this)
        if (actionAuthorized) {
            actionAuthorized = false
            return
        }
        e.preventDefault()
        if (action == 'Deactivate') {
            bootbox.prompt("Give reasons for Deactivation?", function (result) {
                alert(result)
                if (result === null) {
                    alert('Please specify reason for deactivation')
                } else {
                    $('.reason_text').val(result)
                    actionAuthorized = true
                    btn.trigger('click')
                    //alert()
                }
            });
        } else {
            bootbox.confirm('Are you sure you want to ' + action + '!', function (result) {
                if (result) {
                    actionAuthorized = true
                    btn.trigger('click')
                }
            });
        }

    })

    actionAuthorized = false
    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        var action = "Delete";
        var deleteURL = $(this).attr('href');

        var errorHtml = '<div>Operation has been cancelled because of the following:</br></br><ul>';
        var closeErrorHtml = '</ul></div>';

        //check whether record is deletable based on the deletable attribute
        var deletable = $(this).attr('data-deletable');
        if(deletable === "no"){
            errorHtml += '<li>There are other records linked to this record</li>';
            errorHtml += closeErrorHtml;
            show_custom_message_modal('error',errorHtml,null,null);
            return;
        }


        var btn = $(this)
        if (actionAuthorized) {
            actionAuthorized = false
            return
        }

        if (action == 'Delete') {
            bootbox.confirm('Are you sure you want to ' + action + '!', function (result) {
                if (result) {
                    actionAuthorized = true
                    document.location = deleteURL
                }
            });
        }

    })

    $(document).on('change', '.chk-other', function () {
        if ($(this).prop('checked')) {
            $(this).parents('label').find('.specify-other').show()
        } else {
            $(this).parents('label').find('.specify-other').val('').hide()

        }
    });

    $(window).on('resize.ace.top_menu', function () {
        // $(document).triggerHandler('settings.ace.top_menu', ['sidebar_fixed', $sidebar.hasClass('sidebar-fixed')]);
    });

    // datepicker
    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "d M yyyy"
    })
    //show datepicker when clicking on the icon
        .next().on(ace.click_event, function () {
        $(this).prev().focus();
    });
    //////////////////////////////////////////////
    /* $(document).on('focus','.date-picker',function(){
        $(this).datepicker()
    })
    $(document).on('focus','.date-range-picker',function(){
        $(this).daterangepicker()
    }) */

    // initialize date pickers
    function initiateDateRangePicker() {
        $('.calendar').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: "d M yyyy"
        })
        //show datepicker when clicking on the icon
            .next().on(ace.click_event, function () {
            $(this).prev().focus();
        });

        $('.date-range-picker').daterangepicker({
            'applyClass': 'btn-sm btn-success',
            'cancelClass': 'btn-sm btn-default',
            format: "D MMM YYYY",
            locale: {
                applyLabel: 'Apply',
                cancelLabel: 'Cancel',
            }
        })
            .prev().on(ace.click_event, function () {
            $(this).next().focus();
        });
    }

    ////////////////////////////////////////

    // initialize time pickers
    function initializeTimePicker() {
        $('.clock').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        }).next().on(ace.click_event, function () {
            $(this).prev().focus();
        });
    }

    //Stylize our selects
    function selectize() {

        //$('.timo').chosen({allow_single_deselect:true});
        //chosen select
        $('.chosen-select, .selectize:not(tr.hide .selectize)').chosen({allow_single_deselect: true});

    }


    function changeInput(str) {
        alert(str)
    }

    function addRow(tableID) {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        var cellContent = ''
        if (rowCount < 100) {							// limit the user from creating fields more than your limits
            var row = table.insertRow(rowCount);
            row.id = (rowCount - 1) + '_rowdata';
            var colCount = table.rows[0].cells.length;
            for (var i = 0; i < colCount; i++) {
                cellContent = ''
                var newcell = row.insertCell(i);
                if (tableID == "dataTable3") {
                    cellContent = table.rows[1].cells[i].innerHTML;
                } else if (tableID == "activity_dates_table" && i == 1) {
                    cellContent = table.rows[1].cells[i].innerHTML;
                    cellContent = cellContent.replace("[DAY]", "Day " + (rowCount - 1));
                } else {
                    cellContent = table.rows[1].cells[i].innerHTML;
                }


                //$(cellContent).find('.chosen-container').remove()
                //$(cellContent).find('select').css('display','block')
                //cellContent = cellContent

                newcell.innerHTML = cellContent;


            }
            if (tableID == "activity_dates_table") {
                initiateDateRangePicker(); //add calendar for dates
                initializeTimePicker();
            }
        } else {
            alert("Maximum is 100.");
        }

        //style_select()
        selectize()
    }

    function deleteRow(tableID) {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        for (var i = 1; i < rowCount; i++) { //0
            var row = table.rows[i];
            var chkbox = row.cells[0].childNodes[0];
            if (null != chkbox && true == chkbox.checked) {
                if (rowCount <= 2) { 						// limit the user from removing all the fields
                    alert("Cannot Remove all.");
                    break;
                }
                table.deleteRow(i);
                rowCount--;
                i--;
            }
        }
    }

    $('[data-rel=tooltip]').tooltip();


</script>

<!-- query analyzer code -->
<script type="text/javascript">
    var $validation = true;

    $('#validation-form').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5
            },
            password2: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            name: {
                required: true
            },
            phone: {
                required: true,
                phone: 'required'
            },
            url: {
                required: true,
                url: true
            },
            comment: {
                required: true
            },
            state: {
                required: true
            },
            service: {
                required: true
            },
            description: {
                required: true
            },
            age: {
                required: true,
            },
            agree: {
                required: true,
            }
        },

        messages: {
            email: {
                required: "Please provide a valid email.",
                email: "Please provide a valid email."
            },
            password: {
                required: "Please specify a password.",
                minlength: "Please specify a secure password."
            },
            state: "Please choose state",
            subscription: "Please choose at least one option",
            gender: "Please choose gender",
            agree: "Please accept our policy"
        },


        highlight: function (e) {
            $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
        },

        success: function (e) {
            $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
            $(e).remove();
        },

        errorPlacement: function (error, element) {
            if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                var controls = element.closest('div[class*="col-"]');
                if (controls.find(':checkbox,:radio').length > 1) controls.append(error);
                else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            } else if (element.is('.select2')) {
                error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
            } else if (element.is('.chosen-select')) {
                error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            } else error.insertAfter(element.parent());
        },

        submitHandler: function (form) {
            $('.results_container').html('<div class="center"><i class="fa fa-spinner fa-spin bigger-230"></i></div>')
            $('#accordion').find('.accordion-toggle').addClass('collapsed');
            $('#accordion').find('.panel-collapse').removeClass('in');
            $('#accordion').find('.ace-icon').addClass('fa-angle-right').removeClass('fa-angle-down');
            var values = $(form).serialize();
            $.ajax(
                {
                    type: "POST",
                    url: 'qry_results.php',
                    data: "myData=" + values,
                    cache: false,
                    success: function (message) {
                        $('.results_container').html(message)
                        $('html').animate({scrollTop: $('.results_container').offset().top}, 600, 'swing')
                    },
                    error: function (message) {
                        alert('Query failure!! Please make sure all the required fields are filled before Submitting.');
                    }
                });
        },
        invalidHandler: function (form) {
        }
    });


    $(document).on('change', '#qry_dataset', function () {
        //alert('am in')
        var fields_html = '';
        var txt_dataset = $(this).val()
        if ($(this).val() != '') {
            $.post('qry_fields.php', {dataset: txt_dataset}, function (result) {
                fields_html = result;
                $('.fields_container').html(fields_html);
                $('#accordion').toggle(true)
                $('#accordion').find('.accordion-toggle').removeClass('collapsed');
                $('#accordion').find('.panel-collapse').addClass('in');
                $('#accordion').find('.ace-icon').removeClass('fa-angle-right').addClass('fa-angle-down');

                //initiateDateRangePicker()
            })
        } else {
            $('.fields_container').html(fields_html);
            $('#accordion').toggle(false)
        }

    });
    $(document).on('change', '.query_operator', function () {
        try {
            //$(this).parents('tr').find('.calendar').datepicker('destroy')
            $(this).parents('tr').find('.calendar').data('datepicker').remove()
        } catch (error) {
            console.log(error);
        }
        try {
            $(this).parents('tr').find('.calendar').data('daterangepicker').remove()
        } catch (error) {
            console.log(error);
        }

        if ($(this).val() == 'BETWEEN') {
            //$(this).parents('tr').find('.date-picker').removeClass('date-picker').addClass('date-range-picker').off()
            $(this).parents('tr').find('.calendar').daterangepicker({
                'applyClass': 'btn-sm btn-success',
                'cancelClass': 'btn-sm btn-default',
                format: "D MMM YYYY",
                locale: {
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel',
                }
            })
        } else {
            //$(this).parents('tr').find('.date-range-picker').removeClass('date-range-picker').removeClass('hasDatepicker').addClass('date-picker').off()
            $(this).parents('tr').find('.calendar').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: "d M yyyy"
            })
        }
        //initiateDateRangePicker()
    })


    $(document).on("change", ".chk_select_all", function () {
        if ($(this).prop('checked')) {
            $('.chk_fields').prop('checked', true)
        } else {
            $('.chk_fields').prop('checked', false)
        }
    });

    $(document).on("keypress", "#pass1,#pass2", function (e) {
        if (e.which == 118) {
            e.preventDefault()
            alert("You can not paste URA Payment NO. Please type.")
            return false
        }

    })

    $(document).on("contextmenu", "#pass1,#pass2", function (e) {
        return false
    })


    function export_to(tableId) {
        var tab_text = "<table border='2px'><tr bgcolor='#87AFC6'>";
        var textRange;
        var j = 0;
        tab = document.getElementById(tableId); // id of table

        for (j = 0; j < tab.rows.length; j++) {
            tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
            //tab_text=tab_text+"</tr>";
        }

        tab_text = tab_text + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
        tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
            txtArea1.document.open("txt/html", "replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa = txtArea1.document.execCommand("SaveAs", true, "save report.xls");
        } else                 //other browser not tested on IE 11
            sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

        return (sa);
    }
</script>

<script>

    function showCustomAjaxHtmlError(htmlError) {

        $('#dummy_div').html(htmlError);

        //show error message
        var modalAjaxCustomMessage = $('.modalAjaxCustomMessage');
        var actionBtnsContainerElem = $('.modalAjaxCustomMessage .actionButtons');
        var actionButtonsHtml = actionBtnsContainerElem.html();

        if (actionButtonsHtml === "undefined" || actionButtonsHtml == null) {
            actionButtonsHtml = null;
            actionBtnsContainerElem.html('');
        } else {
            actionBtnsContainerElem.html(actionButtonsHtml.replace(actionButtonsHtml, ''));
        }

        var messageType = modalAjaxCustomMessage.attr('data-message-type');
        show_custom_message_modal(messageType, (modalAjaxCustomMessage.html()), null, actionButtonsHtml);
    }

    $(document).ready(function () {
        let trustedUser ='';
        let entities;
        var active_users;
        $.ajax({
            type: "GET",
            url: "{{ endpoint('GET_CURRENT_PPDA_USERS') }}",
            success: function(active_users){
                var localActiveUsers = localStorage.getItem('active_users');
                if(localActiveUsers === null){
                    localStorage.setItem('active_users', JSON.stringify(active_users));
                }
            }
        });
        $.ajax({
            url: '{{ route("trusted-devices.ajax") }}',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log(data);
               try{
                    if(typeof data == 'object'){
                        if(data.msg =='Valid Cookie Approved'){

                            if(data.management_rights == true){
                                $('.btn_management_dashboard').show()
                            }else{
                                $('.btn_management_dashboard').hide()
                            }

                            if(data.app_usage_rights == true){
                                $('.btn_app_usage').show()
                            }else{
                                $('.btn_app_usage').hide()
                            }

                            if(data.is_admin == true){
                                $('.btn_trusted_calendar').show()
                            }else{
                                $('.btn_trusted_calendar').hide()
                            }

                            if(data.is_admin == true){
                                $('.btn_fuel_capture').show()
                            }else{
                                $('.btn_fuel_capture').hide()
                            }

                            if(data.is_employee_360_viewer == true){
                                $('.btn_employee_360_viewer').show()
                            }else{
                                $('.btn_employee_360_viewer').hide()
                            }
                         
                            //btn_my_pending_actions
                            // if(data.is_admin == true){
                            //     $('#tab_may_pending_actions').show()
                            // }else{
                            //     $('#tab_may_pending_actions').hide()
                            // }
                        }
                    }

                    // $('#employee_360_viewer').attr('href', $('#employee_360_viewer').attr('href').replace('USERNAME', data.trustedDevice.username));
                    $('#trusted_user').attr('href', $('#trusted_user').attr('href').replace('USERNAME', data.trustedDevice.username));
                    $('#driver_requests_btn').attr('href', $('#driver_requests_btn').attr('href').replace('USERNAME', data.trustedDevice.username));
                    $('#fuel_issues').attr('href', $('#fuel_issues').attr('href').replace('USERNAME', data.trustedDevice.username));
                    $('#it_tickets').attr('href', $('#it_tickets').attr('href').replace('USERNAME', data.trustedDevice.username));
                    $('#management_dashboard').attr('href', $('#management_dashboard').attr('href').replace('ISADMIN', data.is_admin));
                    $('#ajax_test_device').css('display', 'block');
                   //set the trusted user value
                    trustedUser = data.trustedDevice.username;
                    //save trusted user in a global variable
                    localStorage.setItem('trustedUser', trustedUser);
               }
               catch (e) {
               }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });


        //data tables
        loadListing()

        //chosen select
        selectize()

        $('body').on('click', '#fuel_issue_mobile', function () {
            var url = $('#fuel_issues').attr('href');
            var modal_size = 'clarify';
            var modal_title = $('#fuel_issues').attr('title');
            openModal(modal_size,url, modal_title);
        });

        // Delete row in a table
        $('body').on('click', '.delete-row', function () {

            var details = $(this).attr('class').split(' ')
            var route = details[1]
            var table = details[2]
            var pK = details[3]
            var id = details[4]

            bootbox.confirm('Are you sure you want to delete ' + table + '!', function (result) {
                if (result) {
                    //var url = '/'+route+'/'+id
                    var url = '/delete/' + table + '/' + id

                    $.get(url, function (message) {
                        completeHandler(table, message)
                    })

                    $(this).closest('tr').fadeOut(function () {
                        $(this).remove();
                    });
                }
            });
            return false;
        });

        $('body').on('click', '.btn-reveal-form', function () {
            $('.form-container').toggle();
        });

        $('body').on('click', '.btnProceedToToDefaultFolder', function () {

            $("#enable_save_to_default_folder").val(1);

            $.gritter.removeAll();
            setTimeout(function () {
                $(".btnUploadSubmit").trigger('click');
            }, 500);

        });

        $('body').on('click', '.btnCancelProceedToToDefaultFolder', function () {
            $.gritter.removeAll();
        });

        $('body').on('click', '.btnRenameAttachedDocument', function () {

            //get the current name, suggested name
            var currentName = $(this).attr('data-filename-original');
            var suggestedName = $(this).attr('data-filename-suggested');

            $('#modalRenameFile #attached_doc_current_file_name').val(currentName);
            $('#modalRenameFile #attached_doc_new_upload_file_name').val(suggestedName);
            $('#modalRenameFile #attached_doc_current_file_name_length').html(currentName.length);

            hide_custom_message_modal();
            showHideModalWithId('modalRenameFile', true);

        });

        $('body').on('click', '#btnConfirmNewName', function () {

            //get the current name, suggested name
            var newNameInput = $('#attached_doc_new_upload_file_name').val();
            if (newNameInput === "") {
                show_custom_message_modal('error', "Please a new file name", null, null);
                return;
            }

            //close the rename modal
            showHideModalWithId('modalRenameFile', false);

            //set the new name
            $('#new_upload_file_name').val(newNameInput);

            //attempt a second upload
            $(".btnUploadSubmit").trigger('click');

        });

        $('body').on('click', '.btnUploadSubmit', function (event) {

            event.preventDefault();

            var formId = $(this).parents('form').attr('id');
            var url = $(this).parents('form').attr('action');
            var formData = new FormData($('#' + formId)[0]);

            $.ajax({
                url: url,
                method: "POST",
                data: formData,
                // dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function (data) {
                    show_custom_preloader(true, null);
                },
                success: function (response) {

                    if($("#"+formId).hasClass('custom_response')){
                        handleCustomObjectResponse(response, formId);
                        return;
                    }

                    if (response.success) {

                        completeHandler('frm', response.message);
                        setTimeout(function () {
                            location.reload();
                        }, 1000);

                    } else {

                        if (response.message === 'File name exceeds allowed maximum length of [100] characters') {

                            showCustomAjaxHtmlError(response.htmlError);

                        } else if (response.message === "666") {

                            showCustomAjaxHtmlError(response.htmlError);

                        } else {

                            //check if it's a target folder error, then show the form for reloading the path
                            if (/MISSING TARGET FOLDER/i.test(response.message)) {
                                $('#container-refresh-path').css('display', 'block');
                            }
                            show_custom_message_modal('error', response.message, null, null);

                        }

                    }

                },
                error:function(jqXHR, textStatus, errorThrown) {
                    backendValidation(jqXHR);
                    show_custom_message_modal('error',"Seems like something went wrong</br>" + jqXHR.status+" "+errorThrown,null,null);
                }
            })
        });

        $('body').on('click', '.btnRefreshEdmsPath', function (event) {

            event.preventDefault();
            var formId = $(this).parents('form').attr('id');
            var url = $(this).parents('form').attr('action');
            var formData = new FormData($('#' + formId)[0]);
            console.log("formData " + formData);

            $.ajax({
                url: url,
                method: "POST",
                data: formData,
                // dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function (data) {
                    show_custom_preloader(true, null);
                },
                success: function (response) {
                    if (response.success) {
                        $('#container-refresh-path').css('display', 'none');
                        completeHandler('frm', response.message);
                    } else {
                        show_custom_message_modal('error', response.message, null, null);
                    }
                },
                error:function(jqXHR, textStatus, errorThrown) {
                    show_custom_message_modal('error','Seems like something went wrong</br>' + jqXHR.status+" "+errorThrown,null,null);
                }
            })
        });

        $('body').on('change', '#GetEntityDetails', function () {
            console.log("show_entity_details");
            var entity_id = $(this).val();
            var section = 'details';
            GetEntityDetails(entity_id, section);
        });

        $('body').on('change', '#drop_off_date', function (e) {
            e.preventDefault();
            var drop_off_date = $(this).val();
            //set the value of drop off date to the pick up date
            $('#pick_up_date').val(drop_off_date);
        });


        $('body').on('click', '#create_driver_request', function (e) {
            // e.preventDefault();
            
        });






        function GetEntityDetails(entity_id, section) {
            $.ajax({
                type: "GET",
                url: '/get_entity_details/' + entity_id + "/" + section,
                cache: false,
                success: function (data) {
                    if (section == 'details') {
                        $('#show_entity_details').html(data);
                        GetEntityDetails(entity_id, "last_audited")
                    } else {
                        $('#last_audited_details').html(data);
                    }
                },
                error: function (error) {
                    alert('Please select an Entity.');
                }
            });
        }

        $('body').on('change', '#select_entity_compliance', function () {
            var loading_ = $('.request_loader_');
            var get_entity_compliance = $("#get_entity_compliance");
            var show_entity_compliance = $("#show_entity_compliance");
            var entity_id = $(this).val();
            $.ajax({
                type: "GET",
                url: '/get_entity_compliance/' + entity_id,
                cache: false,
                beforeSend: function () {
                    loading_.removeClass('hide');
                },
                success: function (data) {
                    loading_.addClass('hide');
                    show_entity_compliance.html(data);
                },
                error: function (error) {
                    loading_.addClass('hide');
                    alert('Please select an Entity.');
                }
            });
        });

        $('body').on('change', '#get_selection_criteria', function (event) {
            event.preventDefault()
            console.log("selection_criteria");
            var audit_type = $(this).val();
            var loading_ = $('.request_loader_');
            loading_.removeClass('hide');
            $("#showSelectedCriteria").html('');
            $("#showCriteriaEntities").html('');
            $("#showOagOpinions").addClass('hide');
            $("#showYearLastAudited").addClass('hide');
            $("#showPreviousPpdaPerformance").addClass('hide');

            var url = "{ route('get_selection_criteria','[ID]') }"
            url = url.replace("%5BID%5D", audit_type)

            $.ajax(
                {
                    type: "GET",
                    url: url,
                    cache: false,
                    success: function (data) {
                        $("#showSelectedCriteria").html(data);
                        loading_.addClass('hide');
                    },
                    error: function (error) {
                        loading_.addClass('hide');
                        alert('Seems like something went wrong');
                    }
                });
        });

        $('body').on('change', '#selection_criteria', function (event) {
            event.preventDefault()
            var selection_criteria = $(this).val()
            $("#showOagOpinions").addClass('hide');
            $("#showYearLastAudited").addClass('hide');
            $("#showPreviousPpdaPerformance").addClass('hide');
            if (selection_criteria == 'previous_oag_opinion') {
                $("#showOagOpinions").removeClass('hide');
            } else if (selection_criteria == 'last_year_audited') {
                $("#showYearLastAudited").removeClass('hide');
            } else if (selection_criteria == 'previous_ppda_performance') {
                $("#showPreviousPpdaPerformance").removeClass('hide');
            }
        });


        $('body').on('change', '#selectPreviousPpdaPerformance', function (event) {
            event.preventDefault()
            var performance_sub_criteria = $(this).val();
            // $("#PreviousPerformanceComparisonSign").addClass('hide');
            var PM_CategorySection = $("#PM_CategorySection");
            var PM_ComparisonSignValueSection = $("#PM_ComparisonSignValueSection");
            var PM_ComparisonSignSection = $("#PM_ComparisonSignSection");
            var PM_CategorySection = $("#PM_CategorySection");
            PM_CategorySection.addClass('hide');
            PM_ComparisonSignSection.find("select").val('');
            PM_ComparisonSignValueSection.addClass('hide');
            if (performance_sub_criteria == 'last_performance_category') {
                PM_CategorySection.removeClass('hide');
                PM_ComparisonSignValueSection.addClass('hide');
                PM_ComparisonSignSection.find("select").val('=');
                PM_ComparisonSignSection.find("*").prop("disabled", true);
            } else {
                PM_ComparisonSignValueSection.removeClass('hide');
                PM_ComparisonSignSection.find("*").prop("disabled", false);
                PM_ComparisonSignValueSection.find("*").prop("disabled", false);
            }
        });

        $('body').on('change', '#pm_interval_selector', function (event) {
            event.preventDefault();
            var pm_interval_selector = $(this);
            var pm_interval_selector_vaule = $(this).val();
            pm_interval_selector_vaule = (pm_interval_selector_vaule == "") ? "interval above" : pm_interval_selector_vaule;
            $('.pm_interval').val('').addClass('hide');
            $('#pm_interval_' + pm_interval_selector_vaule).val(pm_interval_selector_vaule).removeClass('hide');
            $('label#pm_interval_label').html("Select " + pm_interval_selector_vaule);
        });

        $('body').on('change', '#cb_select_entity', function () {
            var entity_type = $(this).children("option:selected").attr('entity_type');
            var input = $(this).parents('tr').find('.display_entity_type').val(entity_type);
        })

        $('body').on('change', '.fuel_cost_select', function () {
            $(this).parents('tr').find('.cost_per_litre').val($(this).children("option:selected").val())
        })

        $('body').on('change', '.mgt-letter-section-select', function () {
            $('.section-exceptions-select').val('')
            form_element_show_hide()
        })

        $('body').on('change', '.attachment-module-select', function () {
            $('.module-sections-select').val('')
            form_element_show_hide()
        })


        $('body').on('change', '#provider_select', function () {
            //alert($(this).children("option:selected").text());
            $('.provider_name').val($(this).children("option:selected").text())
        })

        $('body').on('change', '.contract_value_selector', function () {
            //alert($(this).children("option:selected").text());
            var selected = $(this).children("option:selected").text()
            $('.known_values,.unknown_values').attr('disabled', 'disabled').hide()
            if (selected == 'Known') {
                $('.known_values').removeAttr('disabled').show()
                $('.unknown_values').attr('disabled', 'disabled').hide()
            } else if (selected == 'Unknown') {
                $('.unknown_values').removeAttr('disabled').show()
                $('.known_values').attr('disabled', 'disabled').hide()
            }
        })

        $('body').on('change', '.attendee_type_select', function () {
            //alert($(this).children("option:selected").text());
            var selected = $(this).children("option:selected").val()
            $('.ppda_staff_select,.entity_person_select').removeAttr('name').attr('disabled', 'disabled').parents('.form-group.row').hide()
            if (selected == 'App\\User') {
                $('.ppda_staff_select').removeAttr('disabled').attr('name', 'r_fld[commentable_id]').parents('.form-group.row').show()
            } else if (selected == 'App\\Person') {
                $('.entity_person_select').removeAttr('disabled').attr('name', 'r_fld[commentable_id]').parents('.form-group.row').show()
            }
            $('.chosen-container').css('width', '100%')
        })

        $('body').on('change', '.org_type_selector', function () {

            form_element_show_hide()

        })

        $('body').on('click', '.btn-people-form', function () {
            $(this).toggleClass('active').toggleClass('btn-danger')
            $(this).parents('.input-group').find('.chosen-container').toggleClass('chosen-disabled')
            $(this).parents('.input-group').find('.form-heading').toggleClass('active')
            $('.people-form').toggle()
            $('.people_form_active').prop('checked', (i, v) => !v);
        })
        $('body').on('click', '.btn-user-form', function () {
            $('.user-form').toggle()
        })

        $('body').on('keyup change', '.budget_items_table .quantity, .budget_items_table .unit_price, .budget_items_table .budget_item_selector', function () {
            var $tblrows = $(".budget_items_table tbody tr");
            $tblrows.each(function (index) {
                var $tblrow = $(this);
                var quantity = $tblrow.find(".quantity").val();
                var unit_price = $tblrow.find(".unit_price").val();
                var subTotal = parseInt(quantity, 10) * parseFloat(unit_price);

                if (!isNaN(subTotal)) {
                    $tblrow.find('.sub_total').val(subTotal.toFixed(2));
                    get_budget_items_table_grand_total();
                }
            });
        });

        $('body').on('change', '.budget_item_selector', function () {
            var unit_price = $(this).children("option:selected").attr('unit_price');
            unit_price = parseInt(unit_price);
            $(this).parents('tr').find('.unit_price').val(unit_price);
        })

        $('body').on('change', '.allowances_budget_item', function () {
            var rate = $(this).children("option:selected").attr('rate');
            $(this).parents('tr').find('.rate').val(rate);
            computeAllowanceBudgets();
        })


        $('body').on('keyup', '.entity_allowances_budgets .staff, .entity_allowances_budgets .days', function () {
            computeAllowanceBudgets();
        })

        function computeAllowanceBudgets() {
            var $tblrows = $(".entity_allowances_budgets tbody tr");
            $tblrows.each(function (index) {
                var $tblrow = $(this);
                // $tblrow.find('.quantity').on('change', function () {
                var rate = $tblrow.find(".rate").val();
                var days = $tblrow.find(".days").val();
                var staff = $tblrow.find(".staff").val();
                var subTotal = parseInt(rate) * parseFloat(days) * parseFloat(staff);

                if (!isNaN(subTotal)) {
                    $tblrow.find('.allowance_sub_total').html(subTotal);
                    var allowance_grandTotal = 0;

                    $(".allowance_sub_total").each(function () {
                        var stval = parseFloat($(this).html());
                        allowance_grandTotal += isNaN(stval) ? 0 : stval;
                    });
                    $('.allowances_budget_total').html(allowance_grandTotal);
                    $tblrow.find('.allowance_sub_total').html(subTotal);
                    var allowance_grandTotal = 0;

                    $(".allowance_sub_total").each(function () {
                        var stval = parseFloat($(this).html());
                        allowance_grandTotal += isNaN(stval) ? 0 : stval;
                    });
                    $('.allowances_budget_total').html(number_format(allowance_grandTotal));
                }
                var fuel_grandTotal = parseInt($('.fuel_budget_total').html());
                var grandTotal = allowance_grandTotal + (isNaN(fuel_grandTotal) ? 0 : fuel_grandTotal);
                $('.grandTotal').html(number_format(grandTotal));

                // });
            });
        }

        $('body').on('keyup', '.entity_fuel_budgets .litres', function () {
            calculate_fuel_budgets()
        })
        $('body').on('change', '.entity_fuel_budgets .fuel_cost_select', function () {
            calculate_fuel_budgets()
        })
        $('body').on('change', '.grounds_table input[type=checkbox]', function () {
            var data_sample = $(this).parents('table').attr('data-sample')
            var parent_tr_id = $(this).parents('tr').attr('id')
            var this_checked = $(this).prop('checked')
            $('.grounds_table[data-sample=' + data_sample + '] tr#' + parent_tr_id + ' input[type=checkbox]').each(function () {
                $(this).prop('checked', this_checked)
            })
        })
        $('body').on('change keyup', '.grounds_table input[type=text]', function () {
            var data_sample = $(this).parents('table').attr('data-sample')
            var parent_tr_id = $(this).parents('tr').attr('id')
            var this_value = $(this).val()
            var this_class = $(this).attr('class')
            $('.grounds_table[data-sample=' + data_sample + '] tr#' + parent_tr_id + ' input[class="' + this_class + '"]').each(function () {
                $(this).val(this_value)
            })
        })

        $('body').on('click', '.close_tab', function () {
            $('.administration_tab,.master_data_tab').toggleClass('hide')
        })

        function calculate_fuel_budgets() {
            var $tblrows = $(".entity_fuel_budgets tbody tr");
            $tblrows.each(function (index) {
                var $tblrow = $(this);
                // $tblrow.find('.quantity').on('change', function () {
                var litres = $tblrow.find(".litres").val();
                var cost_per_litre = $tblrow.find(".cost_per_litre").val();
                var subTotal = parseFloat(litres) * parseFloat(cost_per_litre);

                if (!isNaN(subTotal)) {
                    $tblrow.find('.fuel_sub_total').html(subTotal);
                    var fuel_grandTotal = 0;

                    $(".fuel_sub_total").each(function () {
                        var stval = parseFloat($(this).html());
                        fuel_grandTotal += isNaN(stval) ? 0 : stval;
                    });
                    $('.fuel_budget_total').html(number_format(fuel_grandTotal));
                }

                var allowance_grandTotal = parseFloat($('.allowances_budget_total').html());
                var grandTotal = fuel_grandTotal + (isNaN(allowance_grandTotal) ? 0 : allowance_grandTotal);
                $('.grandTotal').html(number_format(grandTotal));

                // });
            });
        }


        $('body').on('keyup', '.entity_budget_plan_table .amount, .entity_budget_plan_table .rate', function () {
            var $tblrows = $(".entity_budget_plan_table tbody tr");
            $tblrows.each(function (index) {
                var $tblrow = $(this);
                var amount = $tblrow.find(".amount").val();
                var rate = $tblrow.find(".rate").val();
                var subTotal = parseInt(amount) * parseFloat(rate);

                if (!isNaN(subTotal)) {
                    $tblrow.find('.sub_total').val(subTotal.toFixed(2));
                }
            });
        })


        $('body').on('click', '.audit_counts_continue', function () {
            var counts = parseInt($(this).parents('.form-group').find('.audit_plan_counts').val());
            if (isNaN(counts)) {
                alert("Please provide count");
                return;
            }

            $(this).parents('.form-group').addClass('hide');
            $('.entity_counts_table').removeClass('hide');
            $('.display-planned-count').html(counts);
        })

        $('body').on('keyup', '.entity_audit_count_size', function () {
            var $tblrows = $(".entity_audit_count_size_table tbody tr");
            $tblrows.each(function (index) {
                var totalCount = 0;
                $(".entity_audit_count_size").each(function () {
                    var stval = parseFloat($(this).val());
                    totalCount += isNaN(stval) ? 0 : stval;
                });

                $(this).parents('table').find('.display_audit_total_count').html(totalCount);
                // console.log("total count ", totalCount);
            });
        })

        $('body').on('change', '.entity_type_selector', function () {
            var entity_id = $(this).val();
            $('.entity_type_selected_row').removeClass('hide');
            var entity_type_category = $('.entity_type_category');
            entity_type_category.addClass('hide').removeAttr('required');
            $('#entity_type_selected_' + entity_id).removeClass('hide');
        })

        $('body').on('change', '#select_cb_activity_facilitator', function () {
            var type = $(this).children("option:selected").attr('type');
            var new_class = type + '_facilitators';
            $(this).parents('tr').find('.facilitator').addClass('hide').attr('disabled');
            $(this).parents('tr').find('#' + new_class).removeClass('hide').removeAttr('disabled');
        })

        $('body').on('change', '.row-findings-select', function () {

            loadListing()
        })

        // control for image upload
        $('body').on('change', '.uploadimg', function () {

            var selectedFileName = $(this).val();

            if (selectedFileName != null && selectedFileName != "") {

                var filename = $(this).val().split('\\').pop();

                if ($('#letter_file_name').length) {
                    $('#letter_file_name').val(filename);  // it exists
                }

                $('#fancy_file_name').attr('data-title', filename);

            } else {
                $('#fancy_file_name').attr('data-title', "No File ...");
            }

        });


        $('body').on('change', '.upload_attached_docs', function () {

            if($(this).hasClass('manual_trigger')){

                var filename = $(this).val().split('\\').pop();

                var fileContainer = $(this).closest('.file-input-container');

                //update the details of the fancy input field
                fileContainer.find('.ace-file-name').attr('data-title',filename);
                fileContainer.find('.ace-file-container').attr('data-title',"Change");

                //set the file name in the doc name field
                $('.manual-doc-upload-name').val(filename);

                return;
            }

        });



        $('body').on('keyup', '.search_entity_selector_filter', function () {
            var value = $(this).val().toLowerCase();
            $("#entity_selector_table tbody tr ").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });


        $('body').on('change', '.validate_selected', function () {
            var $this = $(this)
            var details = $(this).attr('class').split(' ')
            var selector_class = details[2]
            var selection_value = $this.val();
            $("." + selector_class + " option[value=" + selection_value + "]").addClass('hide');
        })

        $('body').on('click', '.delete-custom-url-action', function (event) {

            event.preventDefault();
            show_custom_preloader(true,null);

            var dataHref = $(this).attr('href');
            var clickedElem = $(this);
            $.get(dataHref, function (data) {

                    var result = JSON.parse(data);
                    var statusCode = result.statusCode;
                    var statusDesc = result.statusDescription;

                    if (statusCode == "0") {
                        show_custom_message_modal('success', statusDesc, null, null);
                        clickedElem.closest(".modal").modal('hide');
                        loadListing();
                    } else {
                        show_custom_message_modal('error', statusDesc, null, null);
                    }

                }
            )
        });

        $('body').on('blur', '.comma_separate_on_blur', function () {
            var currentVal = $(this).val();
            var currentValNoCommas = parseInt(currentVal.replace(/,/g, ''));
            $(this).val(number_format(currentValNoCommas));
        });

        $('body').on('click','.btn-run-job',function(event){

            event.preventDefault();
            show_custom_preloader(true, null);

            var dataHref = $(this).attr('href');
            var clickedElem = $(this);
            $.get(dataHref,function(data){

                    show_custom_preloader(false, null);

                    var result = JSON.parse(data);
                    var statusCode = result.statusCode;
                    var statusDesc = result.statusDescription;

                    if (statusCode == "0"){
                        show_custom_message_modal('success', statusDesc,null,null);
                        clickedElem.closest(".modal").modal('hide');
                        loadListing();
                    }else{
                        show_custom_message_modal('error', statusDesc,null,null);
                    }

                }
            )
        });

        $('body').on('click', '.getYearHolidays', function (e) {
            e.preventDefault();
            //validate year
            var year = $('#selected_year').val();
            var el = $('#selected_year');
            if (year == '') {
                el.parent('div').removeClass('valid-input').addClass('empty-input').append('<span class="error">This is required!!</span>')
                return false
            }
            //get form url from the parent form to this button
            var url = $(this).parents('form').attr('action');
            var data = {
                year: year
            }
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (res) {
                    var response = JSON.parse(res);
                    var dataArray = JSON.parse(response.result);
                    if(dataArray.length == 0){
                        $('#year_holidays_body').html('<tr><td colspan="2">There are no public holidays found for the year provided</td></tr>');
                        $('#year_results').removeClass('hidden');
                        return;
                    }
                    dataArray.forEach(function (result) {
                        var date = result.date;
                        var name = result.name;
                        var table_row = '<tr><td>' + name + '</td><td>'+ date +'</td></tr>';
                        $('#year_holidays_body').append(table_row);
                    });
                    //remove the hidden class on year_results
                    $('#year_results').removeClass('hidden');
                    
                },
                error: function (xhr, status, error) {
                    console.error(xhr);
                }
            });
        })

        $('body').on('click', '.getRangeHolidays', function (e) {
            e.preventDefault();
            var range_start = $('#range_start').val();
            var range_end = $('#range_end').val();
            var range_start_el = $('#range_start');
            var range_end_el = $('#range_end');
            if (range_start == '') {
                range_start_el.parent('div').removeClass('valid-input').addClass('empty-input').append('<span class="error">This is required!!</span>')
                return false
            }
            if (range_end == '') {
                range_end_el.parent('div').removeClass('valid-input').addClass('empty-input').append('<span class="error">This is required!!</span>')
                return false
            }
            //make ajax call
            var url = $(this).parents('form').attr('action');
            var data = {
                range_start: range_start,
                range_end: range_end
            }
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (res) {
                    
                    var response = JSON.parse(res);
                    var dataArray = JSON.parse(response.result);
                    // console.log(response.result.length);
                    if(dataArray.length == 0){
                        $('#range_holidays_body').html('<tr><td colspan="2">There are no public holidays found for the range provided</td></tr>');
                        $('#range_results').removeClass('hidden');
                        return;
                    }
                    dataArray.forEach(function (result) {
                        var date = result.date;
                        var name = result.name;
                        var table_row = '<tr><td>' + name + '</td><td>'+ date +'</td></tr>';
                        $('#range_holidays_body').append(table_row);
                    });
                    //remove the hidden class on year_results
                    $('#range_results').removeClass('hidden');
                },
                error: function (xhr, status, error) {
                    console.error(xhr);
                }
            });
        })
    });



    function formatDateTime(dateString) {
        var date = new Date(dateString);
        var year = date.getFullYear();
        var month = ('0' + (date.getMonth() + 1)).slice(-2); // Months are zero-based, so we add 1
        var day = ('0' + date.getDate()).slice(-2);
        var hours = ('0' + date.getHours()).slice(-2);
        var minutes = ('0' + date.getMinutes()).slice(-2);
        var seconds = ('0' + date.getSeconds()).slice(-2);

        return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
    }

    function convertTo12Hour(timeString) {
        const [hours, minutes, seconds] = timeString.split(':');
        let hour = parseInt(hours);
        const period = hour >= 12 ? 'PM' : 'AM';
        hour = hour % 12 || 12;
        return `${hour}:${minutes} ${period}`;
    }

    function openModal(modal_size,url,modal_title){
        modal_selector = ''
        if(modal_size == 'clarify_secondary'){
            modal_selector = '.bs-fill-modal'
        }else if(modal_size == 'clarify_form'){
            modal_selector = '#saveAndStickModal'
        }else if(modal_size == 'clarify_tertiary'){
            modal_selector = '#TertiaryModal'
        }else{
            modal_selector = '#randomActionModal'
        }
        $.ajax({
            type: 'GET',
            url: url,
        })
        .done(function(result) {
            $(modal_selector +' .modal-title').html(modal_title);
            $(modal_selector +' .modal-body').html(result);
            $(modal_selector).modal('show');
        })
        .fail(function() {
            $(modal_selector +' .modal-title').html('Isses');
            $(modal_selector +' .modal-body').html('Could not load the page');
            $(modal_selector).modal('show');
            console.log("error");
        })
    }
    // end document ready function
    function previewImage(event, previewId) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById(previewId);
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
    // function to load datatable lists on pages
    function loadListing() {
        if ($('.data-table').length > 0) {
            $('.data-table,.inner-table').each(function () {

                var table = $(this).attr('class').split(' ')[1]
                var id = $(this).attr('class').split(' ')[2]
                var extraParam = $(this).attr('class').split(' ')[3]
                initiateDataTable('.'+table, table, id, extraParam)
            })
        }
        if ($('.data-table-new').length > 0) {
            $('.data-table-new').each(function () {
                var table = $(this).data('table')
                var id = $(this).data('id')
                var extraParam = $(this).data('extra')
                var selector = $(this).attr('id')

                $(this).css('width', '100%')
                //alert(table)

                //initiateDataTable('data-table',table,id)
                initiateDataTable('#'+selector, table, id, extraParam)
            })
        }
        if ($('.ajaxLoad').length > 0) {
            $('.ajaxLoad').each(function () {
                var route = $(this).attr('class').split(' ')[1]

                loadPart($(this), route)
            })
        }


    }

    function get_budget_items_table_grand_total() {
        var grandTotal = 0;
        $('.budget_items_table').find(".sub_total").each(function () {
            var stval = parseFloat($(this).val());
            grandTotal += isNaN(stval) ? 0 : stval;
        });
        console.log("grandTotal ", grandTotal);
        $('.grand_total').html(number_format(grandTotal));
    }

    function loadPart(ele, url) {
        $.get(url, function (response) {
            ele.html(response)
        })
    }


    function initiateDataTable(selector, table, id, extraParam) {
            @include('layouts.webparts.listings')

        var url = listing[table]['url'].replace("%5BID%5D", id);
        url = url.replace("%5BEXTRA%5D", extraParam);
        var cols = listing[table]['cols'];

        var orderIndexAndDirection = listing[table]['order_idx_direction'];
        var resultArr = orderIndexAndDirection.split(':');
        var orderIndex = resultArr[0];
        var orderDirection = resultArr[1];

        if ($.fn.DataTable.isDataTable(selector)) {
            $(selector).DataTable().ajax.reload();
            return
        }


        $(selector).DataTable({
            "bDestroy": true,
            responsive: false,
            "bProcessing": true,
            serverSide: true,
            ajax: url,
            columns: cols,
            order: [ [orderIndex, orderDirection] ],
            "buttons": [
                {extend: 'copyHtml5', 'footer': true, exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]}},
                {extend: 'excelHtml5', 'footer': true, exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]}},
                {extend: 'csvHtml5', 'footer': true, exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]}},
                {
                    extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4', 'footer': true,
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]}
                },
                {extend: 'colvis', text: 'Columns'},
            ],
        }, function (data) {
            console.log("Data :::", data);
        });
    }

    //function to initiate rich text
    function initiateWYSIWYG() {
        $('textarea.wysiwyg').tinymce({
            width: '100%',
            height: 300,
            toolbar: "responsivefilemanager  undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image table fullscreen | forecolor backcolor | code | mybutton",
            menubar: false,

            setup: function (editor) {
                editor.addButton('mybutton', {
                    type: 'menubutton',
                    text: 'Place holders',
                    icon: false,
                    menu: [
                    ]
                });
            }
        });

    }

    function number_format(num) {
        return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }

    function initializeFilePicker() {
        $('.input-file').ace_file_input({
            no_file: 'No File ...',
            btn_choose: 'Choose',
            btn_change: 'Change',
            droppable: false,
            onchange: null,
            thumbnail: false //| true | large
            //whitelist:'gif|png|jpg|jpeg'
            //blacklist:'exe|php'
            //onchange:''
            //
        });
    }

    function form_element_show_hide() {
        //.mgt-letter-section-select
        $('.section-exceptions-select').children("option").hide()
        var section = $('.mgt-letter-section-select').val();
        $('.section-exceptions-select').children("option[data-section=" + section + "]").show()
        $('.section-exceptions-container').show()

        //file upload sections
        $('.module-sections-select').children("option").hide()
        var module = $('.attachment-module-select').val();
        $('.module-sections-select').children("option[data-module='" + module + "']").show()
        $('.module-sections-container').show()

        //entity_type
        var selected = $('.org_type_selector').children("option:selected").val()
        $('.government_entity_select,.non_government_entity_select').removeAttr('name').attr('disabled', 'disabled').parents('.form-group.row').hide()
        if (selected == 'Government Entity') {
            $('.government_entity_select').removeAttr('disabled').attr('name', 'r_fld[entity_name]').parents('.form-group.row').show()
        } else if (selected == 'Non - Government Entity') {
            $('.non_government_entity_select').removeAttr('disabled').attr('name', 'r_fld[entity_name]').parents('.form-group.row').show()
        }

        //signatory title
        var selectedTitle = $('.select_out_letters_signatory_title').children("option:selected").val();
        $('.ctn_out_letter_signatory_ed,.ctn_out_letter_signatory_others,.ctn_out_letter_signatory_username_ed').removeAttr('name').attr('disabled', 'disabled').parents('.form-group.row').hide();
        if (selectedTitle === 'Executive Director') {

            $('.ctn_out_letter_signatory_username_ed').removeAttr('disabled').attr('name', 'r_fld[signatory_username]').parents('.form-group.row').show();
            $('.ctn_out_letter_signatory_ed').removeAttr('disabled').attr('name', 'r_fld[signatory]');
            //update the ED user name
            var edUsername = $('.select_out_letters_signatory_title').attr('data-ed-username');
            var edName = $('.select_out_letters_signatory_title').attr('data-ed-name');

            $('#signatory_username_ed').val(edUsername);
            $('#signatory_ed').val(edName);

        } else if (!(selectedTitle === '')) {
            $('.ctn_out_letter_signatory_others').removeAttr('disabled').attr('name', 'r_fld[signatory_username]').parents('.form-group.row').show();
            $('.ctn_out_letter_signatory_name').removeAttr('disabled').attr('name', 'r_fld[signatory]').parents('.form-group.row').show();
            $(".ctn_out_letter_signatory_username_ed").attr('disabled', 'disabled');
        }

        $('.chosen-container').css('width', '100%')
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
    function taskReopening(){
        let task_reopen = document.getElementById('task_reopen');
        let formData = new FormData(task_reopen);
        let url = task_reopen.getAttribute('action');
        let method = task_reopen.getAttribute('method');
        $.ajax({
            url: url,
            method: method,
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function (data) {
                show_custom_preloader(true, null);
            },
            success: function (response) {
                show_custom_preloader(false, null);
                if (response.success) {
                    show_custom_message_modal('success', response.message, null, null);
                    loadListing();
                } else {
                    show_custom_message_modal('error', response.message, null, null);
                }
            },
            error: function (error) {
                show_custom_preloader(false, null);
                show_custom_message_modal('error', 'Seems like something went wrong', null, null);
            }
        });
     };

    const markerAttach = elementID => {
        const ELEMENT = document.getElementById(elementID);
        if (ELEMENT !== null) ELEMENT.classList.add("is-invalid");
    };

    const markerDetach = elementID => {
        const ELEMENT = document.getElementById(elementID);
        if (ELEMENT !== null) ELEMENT.classList.remove("is-invalid");
    };

    //add csrf token to ajax header
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    //Calendar begin

    let calendar_buttons = document.querySelectorAll(".calendar_btn");
    calendar_buttons.forEach(Element => Element.addEventListener("click", (e) => {
        e.preventDefault();
        let param = e.target.dataset.ref;
        let calendar_title = e.target.title;
        $('#calendar_heading').text(calendar_title);
        $('#calendar_switcher').trigger('reset');
            $.ajax({
                url: '{{ route('events') }}' + '/' + param,
                method: "GET",
                success: function (response) {
                    renderEvents(response);
                },
                error:function(jqXHR, textStatus, errorThrown) {
                    show_custom_message_modal('error','Seems like something went wrong</br>' + jqXHR.status+" "+errorThrown,null,null);
                }
            })
        }));
        
        function fetchEvents(param){

        }
        function showCalendarModal(){
            
        }

    //add csrf token to ajax header
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let currentViewType = 'week';
    let calendars = [];
    let calendar = new tui.Calendar('#custom_calendar', {
        defaultView: currentViewType,
        milestoneView: false,
        useFormPopup: false,
        useDetailPopup: false,
        useCreationPopup: false,
        usageStatistics: false,
        isReadonly:false,
        template: {
            monthGridHeader: function(model) {
                var date = new Date(model.date);
                var template = '<span class="tui-full-calendar-weekday-grid-date">' + date.getDate() + '</span>';
                return template;
            },
            time(event){
                const { start, end, title } = event;
                return `<span style="color: black;">${event.title}</span>`;
            },
                allday(event) {
                return `<span style="color: white;">${event.title}</span>`;
            },
        },

    });

    bindInstanceEvents();

    calendar.setOptions({
        template: {
            weekDayName(model) {
                return `<span>${model.date}</span>&nbsp;&nbsp;<span>${model.dayName}</span>`;
            },
        },
        week: {
            taskView: false,
        },
    });
    
    calendar.setTheme({
		common: {
			backgroundColor: 'white',
		},
		month: {
			dayName: {
				borderLeft: 'none',
				backgroundColor: 'rgba(44, 130, 201)',
			},
			weekend: {
				backgroundColor: 'rgba(81, 92, 230, 0.05)',
			},
		},
        week: {
			dayName: {
				borderLeft: 'none',
				backgroundColor: 'rgba(44, 130, 201)',
			},
        },
	});

    function bindInstanceEvents(){
        calendar.on({
            selectDateTime: function (dateTimeInfo) {
                let calendarId = document.getElementById('customCalendarSelector').dataset.id;
                if(calendarId == 'DEPT_24'|| calendarId == 'DEPT_26'){
                    $('#pm_event_field').removeClass('hidden');
                }else{
                    $('#pm_event_field').addClass('hidden');
                }
                $('#custom_event_form')[0].reset();
                $('#custom_event_form').attr('action', '/events/store');
                $('#custom_event_form').attr('method', 'POST');
                let start = new Date(dateTimeInfo.start);
                let end = new Date(dateTimeInfo.end);
                let startFormatted = start.toISOString().split('T')[0];
                let startDateObject = new Date(startFormatted);
                startDateObject.setDate(startDateObject.getDate() + 1);
                let startDayFormatted = startDateObject.toISOString().split('T')[0];

                let endFormatted = end.toISOString().split('T')[0];
                let endDateObject = new Date(endFormatted);
                endDateObject.setDate(endDateObject.getDate() + 1);
                let endDayFormatted = endDateObject.toISOString().split('T')[0];
                $('#start_date').attr('type', 'date').val(startDayFormatted);
                $('#end_date').attr('type', 'date').val(endDayFormatted);
                $('#custom_event_form').attr('action', '/events/store');
                $('#custom_event_form').attr('method', 'POST');
                $('#modal_title').text('Create Event');
                $('#event_submit_btn').val('Create');
                $('#delete_event').addClass("hidden");
                $('#customEventModal').modal('show');
            },
            clickEvent: function (eventInfo) {
                let event = eventInfo.event;
                let calendarId = document.getElementById('customCalendarSelector').dataset.id;

                if(calendarId == 'DEPT_24'|| calendarId == 'DEPT_26'){
                    $.ajax({
                        url: '{{ route('getevent') }}' + '/' + event.id,
                        method: "GET",
                        success: function (response) {
                            let pm_event_type = response.pm_event_type;
                            if(pm_event_type=='Audit'){
                                let audit_activity_id = response.pm_audit_activity.id;
                                let audit_activity = response.pm_audit_activity.name;
                                let audit_type_id = response.pm_audit_type.id;
                                let audit_type = response.pm_audit_type.name;
                                let entity_name = response.pm_entity_name;
                                let entity_id = response.pm_entity_id;
                                $('#pm_event_type').val(response.pm_event_type);
                                $('#audit_type').append(`<option value="${audit_type_id}" selected>${audit_type}</option>`);
                                $('#audit_activity').append(`<option value="${audit_activity_id}" selected>${audit_activity}</option>`);
                                $('#audit_type_field').removeClass('hidden');
                                $('#audit_activity_field').removeClass('hidden');
                                $('#entity_name').empty();
                                entities.forEach(function(entity){
                                    if(entity.id == entity_id){
                                        $('#entity_name').append(`<option value="${entity.id}" data-name="${entity.entity_name}" selected>${entity.entity_name}</option>`);
                                    }
                                    else{
                                        $('#entity_name').append(`<option value="${entity.id}" data-name="${entity.entity_name}">${entity.entity_name}</option>`);
                                    }
                                })
                                $('#entity_name').trigger("chosen:updated");
                                $('#pm_entity_field').removeClass('hidden');
                            }
                            else{
                                $('#pm_event_type').val(response.pm_event_type);
                                $('#audit_type_field').addClass('hidden');
                                $('#audit_activity_field').addClass('hidden');
                            }
                        },
                    });
                    $('#pm_event_field').removeClass('hidden');
                }

                let start = new Date(event.start);
                let end = new Date(event.end);
                let startFormatted = start.toISOString().split('T')[0];
                let startDateObject = new Date(startFormatted);
                startDateObject.setDate(startDateObject.getDate() + 1);
                let startDayFormatted = startDateObject.toISOString().split('T')[0];

                let endFormatted = end.toISOString().split('T')[0];
                let endDateObject = new Date(endFormatted);
                endDateObject.setDate(endDateObject.getDate() + 1);
                let endDayFormatted = endDateObject.toISOString().split('T')[0];
                $('#custom_event_form')[0].reset();
                $('#custom_event_form').attr('action', '/events/update/' + event.id);
                $('#custom_event_form').attr('method', 'PUT');
                $('#id').val(event.id);
                $('#delete_event').removeClass("hidden");
                $('#event_submit_btn').val('Update');
                $('#modal_title').text('Update Event');
                $('#title').val(event.title);
                $('#location').val(event.location);
                $('#start_date').attr('type', 'date').val(startDayFormatted);
                $('#end_date').attr('type', 'date').val(endDayFormatted);
                $('#calendarId').val(event.calendarId);
                $('#category').val(event.category);
                $('#isPrivate').prop('checked', event.isPrivate);
                $('#state').val(event.state);
                $('#customEventModal').modal('show');
            }
        });
    }

    $('body').on('change', '#start_date,#end_date', function () {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();

        if(startDate !== "" && endDate !== ""){

            startDate = parseDate(startDate);
            endDate = parseDate(endDate);
            var difference = datediff(startDate, endDate);

            if(difference < 0){

                $('#days').val('');
                $('#end_date').val('')
                var error = 'End Date should be after Start Date';
                show_custom_message_modal('error',error,null,null);
                return;

            }

        }else{

        }

    });
    
    function parseDate(str) {
        var mdy = str.split('-');
        return new Date(mdy[0], mdy[1]-1, mdy[2]);
    }

    function datediff(first, second) {
        return Math.round((second-first)/(1000*60*60*24));
    }
    function renderEvents(response){
        let events = response.events;
        let calendar_types = response.calendar_types;
        let styling = response.styling;
        calendar_types.forEach(function(calendar_type){
            document.getElementById('customCalendarSelector').value = calendar_type.department_name
            document.getElementById('customCalendarSelector').dataset.id = calendar_type.department_code
        })
        calendar.clear();
        if(styling == undefined){
            events.forEach(function (event) {
                calendar.createEvents([{
                    id: event.id,
                    calendarId: event.calendar_type_id,
                    title: event.title,
                    body: event.body,
                    start: new Date(event.start),
                    end: new Date(event.end),
                    location: event.location,
                    category: event.category,
                    state: event.state,
                    color:'#000',
                    backgroundColor:'transparent',
                    borderColor:'transparent',
                    dragBackgroundColor:'transparent',
                    customStyle: {
                        dragBackgroundColor:styling.dragBackgroundColor,
                        backgroundColor: calendarData.styling.backgroundColor,
                        borderColor: calendarData.styling.borderColor,
                        color: calendarData.styling.color,
                    },
                }]);
            });
        } else {
            events.forEach(function (event) {
                calendar.createEvents([{
                    id: event.id,
                    calendarId: event.calendar_type_id,
                    title: event.title,
                    body: event.body,
                    start: new Date(event.start),
                    end: new Date(event.end),
                    location: event.location,
                    category: event.category,
                    state: event.state,
                    color:'#000',
                    backgroundColor:'transparent',
                    borderColor:'transparent',
                    dragBackgroundColor:'transparent',
                    customStyle: {
                        dragBackgroundColor:styling.dragBackgroundColor,
                        backgroundColor: styling.backgroundColor,
                        borderColor: styling.borderColor,
                        color: styling.color,
                    },
                }]);
            });
        }
        reloadEvents();
        calendar.render();
        $('#calendarModal').modal('show');

        setTimeout(() => {
            calendar.changeView('month');
        }, 200);
    }

    function switchView(action) {
		if (action === 'today') {
			calendar.today();
		} else if (action === 'previous') {
			if (currentViewType === 'day') {
				calendar.prev();
			} else if (currentViewType === 'week') {
				calendar.prev();
			} else if (currentViewType === 'month') {
				calendar.prev();
			}
		} else if (action === 'next') {
			if (currentViewType === 'day') {
				calendar.next();
			} else if (currentViewType === 'week') {
				calendar.next();
			} else if (currentViewType === 'month') {
				calendar.next();
			}
		}
	};

    function loadEvents(calendarId) {
        let url = calendarId ? '{{ route('events') }}' + '/' + calendarId : '{{ route('events') }}';
        $.ajax({
            url: url,
            method: "GET",
            success: function (response) {
                if (calendarId && calendarId != 0) {
                    calendar.setCalendars(response.calendar_types);
                } else {
                    calendar.setCalendars(response.calendar_types);
                }
                calendar.render()
            },
            error: function (response) {
                console.log(response);
            }
        });
    }
    function getDefaultCalendarId() {
        return calendars.length > 0 ? calendars[0].id : null;
    }

    function reloadEvents() {
        let calendarId = document.getElementById('customCalendarSelector').dataset.id;
        loadEvents(calendarId);
    }

    // calendar views
    const radioButtons = document.getElementsByName('viewType');
    radioButtons.forEach(function(radioButton) {
        radioButton.addEventListener('change', function() {
          currentViewType = this.value;
            calendar.changeView(currentViewType);
        });
    });

	function switchCalendar(calendar) {
		var calendarId = document.getElementById('customCalendarSelector').dataset.id;
		if(calendarId == 0){
			showAllCalendars(totalCalendars);
			reloadEvents();
		}else{
			hideAllCalendars(totalCalendars);
			showSelectedCalendar(calendarId);
			reloadEvents();
			getCalendarUsers(calendarId);
		}
	}

	function hideAllCalendars(totalCalendars){
		if(totalCalendars == 0){
		for (var i = 1; i <= totalCalendars; i++) {
				calendar.setCalendarVisibility(i,false);
			}
		}
	}
	function showAllCalendars(totalCalendars){
		if(totalCalendars == 0){
			for (var i = 1; i <= totalCalendars; i++) {
				calendar.setCalendarVisibility(i,true);
			}
		}
	}

	function showSelectedCalendar(calendarId){
		calendar.setCalendarVisibility(calendarId,true);
	}
	
	function getCalendarUsers(calendarId){
		$.ajax({
			type: "GET",
			url: `/calendar_users/${calendarId}`,
			cache: false,
			success: function (response) {
				$('#calendar_users').html(response);
			},
		});

	}

    function getSessionEntities() {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: "GET",
                url: "/session_entities",
                cache: false,
                success: function (response) {
                    resolve(response);
                },
                error: function (error) {
                    reject(error);
                },
            });
        });
    }
    getSessionEntities().then(function (response) {
        entities = response;
    }).catch(function (error) {
        console.error(error);
    });


	function getEventTemplate(event, isAllday) {
        var html = [];
        var start = moment(event.start.toDate().toUTCString());
        if (!isAllday) {
        html.push('<strong>' + start.format('HH:mm') + '</strong> ');
        }

        if (event.isPrivate) {
        html.push('<span class="calendar-font-icon ic-lock-b"></span>');
        html.push(' Private');
        } else {
        if (event.recurrenceRule) {
            html.push('<span class="calendar-font-icon ic-repeat-b"></span>');
        } else if (event.attendees.length > 0) {
            html.push('<span class="calendar-font-icon ic-user-b"></span>');
        } else if (event.location) {
            html.push('<span class="calendar-font-icon ic-location-b"></span>');
        }
        html.push(' ' + event.title);
        }

        return html.join('');
    }

    $('#all_day').on('change', function () {
        let start = new Date($('#start_date').val());
        let end = new Date($('#end_date').val());
        let startFormatted, endFormatted;

        if ($(this).is(':checked')) {
            startFormatted = formatDate(start);
            endFormatted = formatDate(end);
            setDateTimeInput('#start_date', 'date', startFormatted);
            setDateTimeInput('#end_date', 'date', endFormatted);
        } else {
            startFormatted = start.toISOString().slice(0, 16);
            endFormatted = end.toISOString().slice(0, 16);
            setDateTimeInput('#start_date', 'date', startFormatted);
            setDateTimeInput('#end_date', 'date', endFormatted);
        }
    });

    function setDateTimeInput(selector, type, value) {
        $(selector).attr('type', type).val(value);
    }

    function formatDate(date) {
        let year = date.getFullYear();
        let month = String(date.getMonth() + 1).padStart(2, '0');
        let day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    $('#pm_event_type').on('change', function () {
        let type = $(this).val();
        if (type == 'Audit') {
            getSessionEntities();
            $.ajax({
                type: 'GET',
                url: '/audit_activities',
                cache: false,
                success: function (response){
                    $('#audit_activity').find('option').remove();
                    $('#audit_activity').append(`<option value="" selected disabled>-Select Audit Activity-</option>`);
                    response.activities.forEach(function (activity) {
                        $('#audit_activity').append(`<option value="${activity.id}">${activity.name}</option>`);
                    });
                    // Load audit types
                    $('#audit_type').find('option').remove();
                    $('#audit_type').append(`<option value="" selected disabled>-Select Audit Type-</option>`);
                    response.types.forEach(function (audit_type) {
                        $('#audit_type').append(`<option value="${audit_type.id}">${audit_type.name}</option>`);
                    });
                    $('#entity_name').empty();
                    entities.forEach(function(entity){
                        $('#entity_name').append(`<option value="${entity.id}" data-name="${entity.entity_name}">${entity.entity_name}</option>`);
                    })
                    $('#entity_name').trigger("chosen:updated");
                    $('#pm_entity_field').removeClass('hidden');

                    $('#audit_activity_field').removeClass('hidden');
                    $('#audit_type_field').removeClass('hidden');
                },
            });
        } else {
            //reset audit activity and type fields
            $('#audit_activity').find('option').remove();
            $('#audit_type').find('option').remove();
            $('#entity_name').find('option').remove();
            $('#entity_name').empty();
            $('#audit_type').empty();
            $('#audit_activity').empty();
            $('#audit_activity_field').addClass('hidden');
            $('#audit_type_field').addClass('hidden');
            $('#pm_entity_field').addClass('hidden');
        }
    });

    $('#custom_event_form').on('submit', function(e){
        e.preventDefault();
        let calendarId = document.getElementById('customCalendarSelector').dataset.id;
        
        let pmEventType = (calendarId == 'DEPT_24' ||calendarId == 'DEPT_26') ? $('#pm_event_type').val() : null;
        let auditActivity = pmEventType == 'Audit' ? $('#audit_activity').val() : null;
        let auditType = pmEventType == 'Audit' ? $('#audit_type').val() : null;
        let entityId = pmEventType == 'Audit' ? $('#entity_name').val() : null;
        let entityName = pmEventType == 'Audit' ? $('#entity_name').data('name') : null;
        let title = $('#title').val();
        let location = $('#location').val();
        let start = $('#start_date').val();
        let end = $('#end_date').val();
        let isAllDay = 0;
        let category = 'allday';
        let isPrivate = 0;
        let state = 'Busy';
        let url = $(this).attr('action');
        let method = $(this).attr('method');
        let id = parseInt($('#id').val());
        $.ajax({
            type: method,
            url: url,
            data: {
                id: id,
                pm_event_type: pmEventType,
                audit_activity: auditActivity,
                audit_type: auditType,
                entity_id: entityId,
                entity_name: entityName,
                title: title,
                location: location,
                start: start,
                end: end,
                isAllDay: isAllDay,
                calendarId: calendarId,
                category: category,
                isPrivate: isPrivate,
                state: state
            },
            cache: false,
            success: function(response) {
                if (id) {
                    calendar.updateEvent(id, calendarId,{
                        title: title,
                        location: location,
                        start: new Date(start),
                        end: new Date(end),
                        isAllDay: isAllDay,
                        calendarId: calendarId,
                        category: category,
                        isPrivate: isPrivate,
                        state: state
                    })
                } else {
                    let event = response.event;
                    let styles = response.styles[0];
                    calendar.createEvents([{
                        id: event.id,
                        calendarId: event.calendar_id,
                        title: event.title,
                        body: event.body,
                        start: new Date(event.start),
                        end: new Date(event.end),
                        location: event.location,
                        category: event.category,
                        state: event.state,
                        color: '#000',
                        backgroundColor: 'transparent',
                        borderColor: 'transparent',
                        dragBackgroundColor: 'transparent',
                        customStyle: {
                            dragBackgroundColor: styles.dragBackgroundColor,
                            backgroundColor: styles.backgroundColor,
                            borderColor: styles.borderColor,
                            color: styles.color
                        }
                    }]);
                }
                calendar.clearGridSelections();
                reloadEvents();
                calendar.render();
                $('#custom_event_form')[0].reset();
                $('#customEventModal').modal('hide');
            },
            error: function (jqXHR, textStatus, errorThrown){
                backendValidation(jqXHR);
            }
        });
    });

    $('#delete_event').on('click', function(e){
        e.preventDefault();
        let id = parseInt($('#id').val());
        let calendarId = document.getElementById('customCalendarSelector').dataset.id;
        $.ajax({
            type: 'DELETE',
            url: `/events/delete/${id}`,
            cache: false,
            success: function (response) {
                calendar.deleteEvent(id, calendarId);
                calendar.clearGridSelections();
                $('#custom_event_form')[0].reset();
                $('#customEventModal').modal('hide');
                reloadEvents();
            },
            error: function (response) {
                console.log(response);
            }
        });
    });
    $('#closeCustomEventModal').on('click', function(e){
        e.preventDefault();
        $('#audit_activity_field').addClass('hidden');
        $('#audit_type_field').addClass('hidden');
        $('#pm_entity_field').addClass('hidden');
        $('#custom_event_form')[0].reset();
        $('#customEventModal').modal('hide');
        calendar.clearGridSelections();
    });
    // Calendar end

    //Refresh masterdata department info
    let calendar_types_url = "{{ route('refresh','calendar_types') }}";
    let calendar_types_table = '.calendar_types';

    let actionlog_types_url = "{{ route('refresh','action_log_types') }}";
    let actionlog_types_table = '.action_log_types';

        function loadCalendarTypes(url, table) {
            $.get(url, function (response) {
                $(table).DataTable().ajax.reload();
            })
        }
    $('#reloadCalendars').on('click', function (e) {
        e.preventDefault();
        loadCalendarTypes(calendar_types_url, calendar_types_table);
    });
    $('#reloadAtionlogTypes').on('click', function (e) {
        e.preventDefault();
        loadCalendarTypes(actionlog_types_url, actionlog_types_table);
    });

    $('body').on('click', '#closeActionLog', function (e) {
        e.preventDefault();
        let creator = this.dataset.creator;
        let curre_user = this.dataset.current;
        if(creator !=curre_user){
            let error = `This action log can only be closed by ${creator}`;
            show_custom_message_modal('error', error,null,null);
            return false
        }else{
            return
        }
    });

    $('body').on('click', '#checkActionLogCreator', async function (e) {
        e.preventDefault();
        let creator = this.dataset.creator;
        let current_user = this.dataset.current;
        
        if (creator !== current_user) {
            let error = `This action log can only be edited by ${creator}`;
            show_custom_message_modal('error', error, null, null);
            return false;
        } else {
            return
        }
    });

</script>


@if(session('successMessage') != null)
    <div class="modal container fade" id="modalSuccess" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Operation Successful</h4>
                </div>
                <div class="modal-body">
                    {{session('successMessage')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#modalSuccess').modal('show');
    </script>
@elseif(session('errorMessage'))
    <div class="modal container fade" id="modalFailed" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Operation Failed</h4>
                </div>
                <div class="modal-body">
                    {{session('errorMessage')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#modalFailed').modal('show');
    </script>
@endif

@if(session('errorMsg') != null)
    <?php $isError = true; $msg = session('errorMsg')?>
    @include('shared.modal-message')
@elseif(session('successMsg') != null)
    <?php $isError = false; $msg = session('successMsg')?>
    @include('shared.modal-message')
@endif
