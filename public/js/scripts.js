
/**
 * Created by user on 2/5/2018.
 */

var hrEmpDetailsURL = '';
var ajaxEditURL = '';
var idPrefix = '';
var ajaxEditFormId = '';
var profile_record_id = 1;
var role_record_id = 1;
var department_record_id = 1;
var unitCode = 1;
var category_record_id = 1;
var reg_office_record_id = 1;
var organization_record_id = 1;
var decimalPlaces = 2;
var debugScript = false;
var stepperInstace;
var defaultActiveStep = 0;

$.fn.allchange = function (callback) {
    var me = this;
    var last = "";
    var infunc = function () {
        var text = $(me).val();
        if (text != last) {
            last = text;
            callback();
        }
        setTimeout(infunc, 100);
    };
    setTimeout(infunc, 100);
};

function prefillSectionDBasedOnSectionE() {


    $('.input-keyduty').each(function(i, obj) {
       // alert($(this).val());
        var oldValue = $(this).val();
        $(this).val(oldValue).trigger('change');
    });


}


function setupModalsThatWillPickDataFromTheServer() {

    //for each button attach a click listener such that when click it, 1. Pick the URL attached to it in the data-source
    //attribute. 2. assign a call back to the details modal that will pick the view details from the server using the URL in 1

    $('.hr-emp-details-button').click(function () {

        //get clear modal container
        $(".modal-content").html('<div class="col s12 center spacer-bottom spacer-top"><h5 class="red-text center">Loading Data ...</h5></div>');

        //get URL attached to this button
        hrEmpDetailsURL = $(this).attr('data-source');

        //dynamically attach callback to pick the details from the server
        $('.modal-trigger-with-server-side-data').modal({

                dismissible: true, // Modal can be dismissed by clicking outside of the modal
                ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.

                    // use other ajax submission type for post, put ...
                    $.get( hrEmpDetailsURL, function(data ) {
                        // use this method you need to handle the response from the view
                        // with rails Server-Generated JavaScript Responses this is portion will be in a .js.erb file
                        $( ".modal-content" ).html(data);

                        //we also dynamically attach the form handler events
                        var formId  = '#form_employee_contract';
                        var map = {};
                        handleForm(formId,'', map, true);

                        handleForm('#form_employee_contract_edit','edit', map, true);

                    });

                }
            }
        );

    });


}


function populateFormWithAjaxData(ajaxEditFormId, data) {

    switch(ajaxEditFormId){

        case "#form_modal_user_academic_bg_edit":{

            $("#institution_edit").val(data.institution);
            $("#year_of_study_edit").val(data.yearOfStudy);
            $("#award_edit").val(data.award);
            $("#username_edit").val(data.username);
            $("#record_id_edit").val(data.id);
            Materialize.updateTextFields();

            break;

        }

    }

}

function setupModalsThatWillPickDataFromTheServerDynamic() {

    //for each button attach a click listener such that when click it, 1. Pick the URL attached to it in the data-source
    //attribute. 2. assign a call back to the details modal that will pick the view details from the server using the URL in 1

    $('.ajax-edit-button').click(function () {

        //get URL attached to this button
        ajaxEditURL = $(this).attr('data-source');
        ajaxEditFormId = $(this).attr('data-modal-form-id');

        handleForm(ajaxEditFormId,'edit',{},false);

        //dynamically attach callback to pick the details from the server
        $('.modal-for-ajax-data').modal({

                dismissible: true, // Modal can be dismissed by clicking outside of the modal
                ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.

                    // use other ajax submission type for post, put ...
                    $.get( ajaxEditURL, function(data ) {

                        // use this method you need to handle the response from the controller, in this case I am returning a json response
                        var resp = jQuery.parseJSON(data);

                        if(resp.statusCode == 0){

                            populateFormWithAjaxData(ajaxEditFormId, resp.data);

                        }else{

                            $( ".modal-content" ).html(resp.statusDescription);

                        }

                    });

                },
                complete: function() { // Callback for Modal close

                    //get clear modal container
                    location.reload(false); // $(ajaxEditFormId)[0].reset();

                }
            }
        );

    });

}


function attachListenersToDeleteButtons() {

    /* Handle click event for the user edit button in the user list */
    $('.timo-btn-delete').click(function () {

        //get the necessary details to fill in the modal
        var dtDeleteUrl = $(this).attr('data-delete-url');
        var dtItemGroup = $(this).attr('data-item-gp');
        var dtItemName = $(this).attr('data-item-name');

        //call method to show the delete dialog
        showDynamicDeleteConfirmDialog(dtItemGroup, dtItemName, dtDeleteUrl);

    });

}


function attachListenersToMaterializeSteps() {



    $('.step-title').click(function () {

        //what I am attempting to do is close a step if it's open and open it if it's closed
        var currentSteps = stepperInstace.getSteps() ;


        //i need to be sure that I have the current steps object
        var activeStepIndex = currentSteps != null ? currentSteps.active.index : -1;



        //get the step index of the guy clicked
        var clickedStepIndex = $(this).attr('data-step-index');

        //to close the step I just remove the active, the opening will be handled automatically
        if(activeStepIndex == clickedStepIndex){

            ($(this).parent()).removeClass('active');
        }

        // code below was for changing the icon on the stepper indication  to be dynamic
        /*var contentIndicator = $(this).attr('data-before');
        contentIndicator = contentIndicator == 'add' ? 'remove' : 'add';
        $(this).attr('data-before',contentIndicator);*/

    });

}

function handleAutoFillForUsernameField() {

    try{

        $("#username_login_page").allchange(function () {

            $('#username_login_page_label').addClass('active');
            $('#password_login_page_label').addClass('active');

        });

    }catch (exception){

    }

}

function openModalById(modalId) {
    $('#'+modalId).modal('open');
}

function showCustomizableModal(title,message) {

    $('#modal-customizable-title').text(title);
    $('#modal-customizable-message').text(message);
    $('#modal-customizable').modal('open');

}

//Stylize our selects
function selectize() {

    //$('.timo').chosen({allow_single_deselect:true});
    //chosen select
    $('.chosen-select, .selectize:not(tr.hide .selectize)').chosen({allow_single_deselect: true});

}

function moreEventListeners() {

    selectize();

    $('body').on('click','.dismiss', function () {
        $(this).closest('.modal').modal('close');
    });

    $('body').on('click','.open-modal-base, .open-modal-level-1', function () {
        event.preventDefault();

        //we have different size of modals so we find the
        var modalId = '';
        if($(this).hasClass('open-modal-base')){
            modalId = 'modal-base';
        }else if($(this).hasClass('open-modal-level-1')){
            modalId = 'modal-level-1';
        }

        //we failed to find the modal ID
        if(modalId === ''){  return;  }

        var modal = $('#' + modalId);
        var title = $(this).attr('data-title');
        var url = $(this).attr('data-url');

        modal.find('.modal-title').html(title);
        var modalBody = modal.find('.modal-body').html(title);

        //show progress dialog
        show_custom_preloader(true, null);

        $.ajaxSetup({ headers: {'X-Requested-With': 'XMLHttpRequest'} });
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                modalBody.html(''); //clear modal

                if ($.isEmptyObject(data.error)) {
                    var resp = JSON.parse(data);
                    if(resp.statusCode !== "0"){
                        showCustomizableModal('Error occurred', resp.statusDescription);
                        return;
                    }

                    // we got a success response
                    modalBody.html(resp.result);
                    loadListing();
                    show_custom_preloader(false, null);

                    openModalById(modalId);
                    selectize();

                } else {
                   showCustomizableModal('Error occurred', data.error);
                }
            },
            error: function (xhr, status, error) {
                modalBody.html('');
                modal.modal('close');
               showCustomizableModal('Error occurred', error);

            }
        });

    });

    $('body').on('click','.btnSubmitAjax', function () {

        event.preventDefault();
        var btnSubmit = $(this);

        var formToSubmit = btnSubmit.closest('form');
        var formData = formToSubmit.serialize();

        // var validator = formToSubmit.validate();
        // var valid = validator.form();
        // if(!valid) { return } //validation failed

        btnSubmit.addClass('disabled'); //hide btn
        show_custom_preloader(true, null);

        $.ajaxSetup({ headers: {'X-Requested-With': 'XMLHttpRequest'} });
        $.ajax({
            type: 'POST',
            url: formToSubmit.attr('action'),
            data: formData,
            success: function (data) {

                show_custom_preloader(false, null);
                btnSubmit.removeClass('disabled'); //show btn again
                //progressDialog.addClass('hide'); //hide dialog

                if ($.isEmptyObject(data.error)) {
                    var resp = JSON.parse(data);
                    if(resp.statusCode !== "0"){
                        showCustomizableModal('Error occurred', resp.statusDescription);
                        return;
                    }

                    // we got a success response
                    //show message and reload
                    loadListing();
                    btnSubmit.closest('.modal').modal('close');
                    showCustomizableModal('Operation successful', resp.statusDescription);
                    //location.reload();

                } else {
                    showCustomizableModal('Error occurred', data.error);
                }
            },
            error: function (xhr, status, error) {

                show_custom_preloader(false, null);
                btnSubmit.removeClass('disabled'); //show btn again
                showCustomizableModal('Error occurred', error);

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
                        showCustomizableModal('Error occurred', resp.statusDescription);
                        return;
                    }

                    // we got a success response
                    loadListing();
                    showCustomizableModal('Operation successful', resp.statusDescription);

                } else {
                    showCustomizableModal('Error occurred', data.error);
                }
            },
            error: function (xhr, status, error) {

                show_custom_preloader(false, null);
                btnDelete.removeClass('disabled'); //show btn again
                showCustomizableModal('Error occurred', error);

            }
        });


    });

}

$(document).ready(function(){


    var dateToday = moment().format('YYYY-MM-DD');


    $('.modal').modal({  dismissible: true  });
    $('tabs').tabs();
    $('.dropdown-trigger').dropdown();
    $('.dropdown-button').dropdown();


    $('body').on('click','.btnSetLmsRoles',function(event) {

        idPrefix = $(this).attr('data-id-prefix');

        //set the rbtn values
        $enableReception = $('#'+idPrefix+'reception_flag').val();
        $enableRegistry = $('#'+idPrefix+'registry_flag').val();
        $enableEd = $('#'+idPrefix+'ed_office_flag').val();
        $enableOutLetters = $('#'+idPrefix+'outgoing_letter_flag').val();
        $enableMasterData = $('#'+idPrefix+'master_data_flag').val();
        $enableReports = $('#'+idPrefix+'reports_flag').val();
        $enableFinance = $('#'+idPrefix+'finance_flag').val();

        $("input[name=gp_reception_flag][value=" + $enableReception + "]").prop('checked', true);
        $("input[name=gp_registry_flag][value=" + $enableRegistry + "]").prop('checked', true);
        $("input[name=gp_ed_office_flag][value=" + $enableEd + "]").prop('checked', true);
        $("input[name=gp_outgoing_letter_flag][value=" + $enableOutLetters + "]").prop('checked', true);
        $("input[name=gp_master_data_flag][value=" + $enableMasterData + "]").prop('checked', true);
        $("input[name=gp_reports_flag][value=" + $enableReports + "]").prop('checked', true);
        $("input[name=gp_finance_flag][value=" + $enableFinance + "]").prop('checked', true);

        $('#modal_lms_roles').modal('open');

    });

    $('body').on('click','.btnFillLmsRoles',function(event) {

        //get the flag values
         $selReception = $("input[name=gp_reception_flag]:checked").next().text();
         $selRegistry = $("input[name=gp_registry_flag]:checked").next().text();
         $selEd = $("input[name=gp_ed_office_flag]:checked").next().text();
         $selOutgoing = $("input[name=gp_outgoing_letter_flag]:checked").next().text();
         $selMasterData = $("input[name=gp_master_data_flag]:checked").next().text();
         $selReports = $("input[name=gp_reports_flag]:checked").next().text();
         $selFinance = $("input[name=gp_finance_flag]:checked").next().text();

        //set the flag fields
         $('#'+idPrefix+'reception_flag').val($selReception == 'Yes' ? 1 : 0);
         $('#'+idPrefix+'registry_flag').val($selRegistry == 'Yes' ? 1 : 0);
         $('#'+idPrefix+'ed_office_flag').val($selEd == 'Yes' ? 1 : 0);
         $('#'+idPrefix+'outgoing_letter_flag').val($selOutgoing == 'Yes' ? 1 : 0);
         $('#'+idPrefix+'master_data_flag').val($selMasterData == 'Yes' ? 1 : 0);
         $('#'+idPrefix+'reports_flag').val($selReports == 'Yes' ? 1 : 0);
         $('#'+idPrefix+'finance_flag').val($selFinance == 'Yes' ? 1 : 0);

         var modalId = $(this).attr('data-modal-id');
        $('#'+modalId).modal('close');

    });


    $('body').on('click','#btnSearchIncompleteAppraisalsByStatus',function(event) {

        event.preventDefault();

        var ddStatusCode = $("#ddAppraisalStatus");
        var url = $(this).attr('href');
        url = url.replace('PARAM_STATUS_CODE',ddStatusCode.val());
        window.location.href = url;

    });

    moreEventListeners();

    setupModalsThatWillPickDataFromTheServer();

    setupModalsThatWillPickDataFromTheServerDynamic();

    attachListenersToEditButtons();

    attachListenersToDeleteButtons();

    handleAutoFillForUsernameField();

    $('#modal_deletion').modal('open');
    $('#modal_message').modal('open');


    $('select').material_select();


    $(".button-collapse").sideNav();



    $('.parallax').parallax();

    // $('.stepper').activateStepper();

    var stepper = document.querySelector('.stepper');
    defaultActiveStep = $('#default_active_step').val();
    stepperInstace = new MStepper(stepper, {
        // options
        firstActive: defaultActiveStep // this is the default
    });


    attachListenersToMaterializeSteps();


    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 100, // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd',
        defaultDate:dateToday,
        setDefaultDate:true
    });


    $('#modal_org_created').modal('open');
    $('#modal_account_created').modal('open');
    $('#modal_change_password').modal('open');
    $('#modal_successful_operation').modal('open');
    $('#modal_form_message').modal('open');


    $('#user_profiles_table').pageMe({
        pagerSelector:'#myPager',
        activeColor: 'green',
        prevText:'Previous',
        nextText:'Next',
        showPrevNext:true,
        hidePageNumbers:false,
        perPage:7,
        totalLabel:"#total_users"
    });

    $('#document_types_table').pageMe({
        pagerSelector:'#myPagerDocumentTypes',
        activeColor: 'green',
        prevText:'Previous',
        nextText:'Next',
        showPrevNext:true,
        hidePageNumbers:false,
        perPage:7,
        totalLabel:"#total_reg"
    });


    prefillSectionDBasedOnSectionE();


});

function attachListenersToEditButtons() {

    /* Handle click event for contract edit by HR */
    $('#modal_hr_contract_history').on('click','.edit-button-contract', function (evt) {

        $('#form_employee_contract').addClass('hidden');
        $('#form_employee_contract_edit').removeClass('hidden');

        var dtRef = $(this).attr('data-ref');
        var dtStartDate = $(this).attr('data-start-date');
        var dtExpiryDate = $(this).attr('data-expiry-date');
        var dtRecordId = $(this).attr('data-record-id');

        $('#contract_reference_edit').val(dtRef);
        $('#contract_start_date_edit').val(dtStartDate);
        $('#contract_expiry_date_edit').val(dtExpiryDate);
        $('#record_id_edit').val(dtRecordId);

        Materialize.updateTextFields();

    });

    $('#modal_hr_contract_history').on('click','.cancel-edit-button', function (evt) {

        $('#form_employee_contract_edit').addClass('hidden');
        $('#form_employee_contract').removeClass('hidden');

    });


    /* Handle click event for the user edit button in the user list */
    $('.edit-btn-competence-cat').click(function () {

        var dtRecordId = $(this).attr('data-record-id');
        var dtOrgCode = $(this).attr('data-org-code');
        var dtEmpCatCode = $(this).attr('data-emp-cat-code');
        var dtCategory = $(this).attr('data-cat');
        var dtMaxRating = $(this).attr('data-max-rating');

        $('#org_code_edit').find('option[value="'+dtOrgCode+'"]').prop('selected', true);
        $('#employee_category_code_edit').find('option[value="'+dtEmpCatCode+'"]').prop('selected', true);

        $('#competence_category_edit').val(dtCategory);
        $('#max_rating_edit').val(dtMaxRating);
        $('#record_id_edit').val(dtRecordId);

        handleForm('#form_modal_competence_cat_edit','edit',{},true);

        Materialize.updateTextFields();

    });


    /* Handle click event for the user edit button in the user list */
    $('.edit-btn-behavioral-competence-cat').click(function () {

        var dtRecordId = $(this).attr('data-record-id');
        var dtCategory = $(this).attr('data-cat');
        var dtMaxRating = $(this).attr('data-max-rating');


        $('#competence_category_edit').val(dtCategory);
        $('#max_rating_edit').val(dtMaxRating);
        $('#record_id_edit').val(dtRecordId);

        handleForm('#form_modal_competence_cat_edit','edit',{},true);

        Materialize.updateTextFields();

    });


    /* Handle click event for the user edit button in the user list */
    $('.edit-btn-objective').click(function () {

        var dtFormId = $(this).attr('data-form-id');
        var dtRecordId = $(this).attr('data-record-id');
        var dtOrgCode = $(this).attr('data-org-code');
        var dtObjective = $(this).attr('data-obj');

        $('#organization_edit').find('option[value="'+dtOrgCode+'"]').prop('selected', true);

       // $('#record_id').val(dtRecordId);
        $('input:hidden[name="record_id"]').val(dtRecordId);
        $('#objective_edit').val(dtObjective);

        handleForm('#'+dtFormId,'edit',{},true);

        Materialize.updateTextFields();

    });


    /* Handle click event for the user edit button in the user list */
    $('.edit-btn-competence').click(function () {

        var dtFormId = $(this).attr('data-form-id');
        var dtRecordId = $(this).attr('data-record-id');
        var dtCompetence = $(this).attr('data-competence');
        var dtRank = $(this).attr('data-rank');
        var dtRating = $(this).attr('data-rating');
        var dtCatId = $(this).attr('data-cat-id');

        $('input:hidden[name="record_id"]').val(dtRecordId);
        $('#competence_edit').val(dtCompetence);
        $('#rank_edit').val(dtRank);
        $('#rating_edit').val(dtRating);
        $('#competence_category_id_edit').val(dtCatId);

        handleForm('#'+dtFormId,'edit',{},true);

        Materialize.updateTextFields();

    });


    /* Handle click event for the user edit button in the user list */
    $('.edit-btn-behavioral-competence').click(function () {

        var dtFormId = $(this).attr('data-form-id');
        var dtRecordId = $(this).attr('data-record-id');
        var dtCompetence = $(this).attr('data-competence');
        var dtRating = $(this).attr('data-rating');
        var dtCatId = $(this).attr('data-cat-id');

        $('input:hidden[name="record_id"]').val(dtRecordId);
        $('#competence_edit').val(dtCompetence);
        $('#rating_edit').val(dtRating);
        $('#competence_category_id_edit').val(dtCatId);

        handleForm('#'+dtFormId,'edit',{},true);

        Materialize.updateTextFields();

    });


    /* Handle click event for the user edit button in the user list */
    $('.edit-btn-appraisal-approvers').click(function () {

        var dtAppraisalRef = $(this).attr('data-appraisal-ref');
        var dtHod = $(this).attr('data-hod');
        var dtSupervisor = $(this).attr('data-supervisor');
        var dtEd = $(this).attr('data-ed');

        $('#head_of_department').find('option[value="'+dtHod+'"]').prop('selected', true);
        $('#supervisor').find('option[value="'+dtSupervisor+'"]').prop('selected', true);
        $('#executive_director').find('option[value="'+dtEd+'"]').prop('selected', true);

       $('input:hidden[name="appraisal_ref"]').val(dtAppraisalRef);

        handleForm('#form_modal_appraisal_approvers','',{},true);

        Materialize.updateTextFields();

    });

    $('#page-length-option').on('click', '.edit-btn-appraisal-approvers', function(){

        var dtAppraisalRef = $(this).attr('data-appraisal-ref');
        var dtHod = $(this).attr('data-hod');
        var dtSupervisor = $(this).attr('data-supervisor');
        var dtEd = $(this).attr('data-ed');

        $('#head_of_department').find('option[value="'+dtHod+'"]').prop('selected', true);
        $('#supervisor').find('option[value="'+dtSupervisor+'"]').prop('selected', true);
        $('#executive_director').find('option[value="'+dtEd+'"]').prop('selected', true);

        $('input:hidden[name="appraisal_ref"]').val(dtAppraisalRef);

        handleForm('#form_modal_appraisal_approvers','',{},true);

        Materialize.updateTextFields();

    });


    $('#page-length-option').on('click', '.edit-button', function(){

        profile_record_id = $(this).attr('data-user_id');
        var formId  = '#edit_profile_form';

        /* Define extra data to pass to form */
        var orgCode = '#org_code_'+profile_record_id;
        var regionalOfficeCode = '#regional_office_code_'+profile_record_id;
        var deptCode = '#department_code_'+profile_record_id;
        var categoryCode = '#category_code_'+profile_record_id;
        var roleCode = '#role_code_'+profile_record_id;
        var deptUnit = '#department_unit_'+profile_record_id;

        var map = {
            "org_code" : orgCode,
            "regional_office_code" : regionalOfficeCode,
            "department_code" : deptCode,
            "category_code" : categoryCode,
            "department_unit" : deptUnit,
            "role_code" : roleCode
        };

        handleForm(formId,profile_record_id, map, true);

    });

/*

    $('.edit-button').click(function () {

        profile_record_id = $(this).attr('data-user_id');
        var formId  = '#edit_profile_form';

        /!* Define extra data to pass to form *!/
        var orgCode = '#org_code_'+profile_record_id;
        var regionalOfficeCode = '#regional_office_code_'+profile_record_id;
        var deptCode = '#department_code_'+profile_record_id;
        var categoryCode = '#category_code_'+profile_record_id;
        var roleCode = '#role_code_'+profile_record_id;

        var map = {
            "org_code" : orgCode,
            "regional_office_code" : regionalOfficeCode,
            "department_code" : deptCode,
            "category_code" : categoryCode,
            "role_code" : roleCode
        };

        handleForm(formId,profile_record_id, map, true);

    });
*/



    /* Handle the click event for the academic background save button */
    $('#btn_save_academic_bg').click(function () {
        var formId  = '#form_modal_user_academic_bg';
        var map = {};
        handleForm(formId,'', map, true);
    });

    $('#btn_save_competence_cat').click(function () {
        var formId  = '#form_modal_competence_cat';
        var map = {};
        handleForm(formId,'', map, true);
    });

    $('#btn_save_competence').click(function () {
        var formId  = '#form_modal_competence';
        var map = {};
        handleForm(formId,'', map, true);
    });

    $('#btn_save_objective').click(function () {
        var formId  = $(this).attr('data-form-id');
        handleForm('#'+formId,'', {}, true);
    });

    $('.timo-btn-add').click(function () {
        var formId  = $(this).attr('data-form-id');
        handleForm('#'+formId,'', {}, true);
    });


    /* Handle the click event for the department edit button in the departments list */
    $('.edit-button-department').click(function () {

        department_record_id = $(this).attr('data-record-id');
        var formId  = '#edit_department_form';

        /* Define extra data to pass to form */
        var orgCode = '#org_code_'+department_record_id;

        var map = {
            "org_code" : orgCode
        };

        handleForm(formId,department_record_id, map, true);

    });


    /* Handle the click event for the employee category edit button in the employee category list */
    $('.edit-button-categories').click(function () {

        category_record_id = $(this).attr('data-record-id');
        var formId  = '#edit_category_form';

        /* Define fields for extra data to pass to form */

        var orgCode = '#org_code_'+category_record_id;

        var map = {
            "org_code" : orgCode
        };

        handleForm(formId,category_record_id, map, true);

    });


    /* Handle the click event for the regional offices edit button in the regional offices list */
    $('.edit-button-regional-office').click(function () {

        reg_office_record_id = $(this).attr('data-record-id');
        var formId  = '#edit_regional_office_form';

        /* Define fields for extra data to pass to form */

        var orgCode = '#org_code_'+reg_office_record_id;

        var map = {
            "org_code" : orgCode
        };

        handleForm(formId,reg_office_record_id, map, true);

    });


    /* Handle the click event for the organization edit button in the organizations list */
    $('.edit-button-organization').click(function () {

        organization_record_id = $(this).attr('data-record-id');
        var formId  = '#edit_organization_form';

        handleForm(formId,organization_record_id, {},true);

    });

    /* Handle the click event for the role code edit button in the role code list */
    $('.edit-button-role-code').click(function () {

        role_record_id = $(this).attr('data-record-id');
        var formId  = '#edit_role_code_form';

        /* Define extra data to pass to form */
        var orgCode = '#org_code_'+role_record_id;

        var map = {
            "org_code" : orgCode
        };

        handleForm(formId,role_record_id, map, true);

    });

    /* Handle the click event for the department edit button in the departments list */
    $('.edit-button-unit').click(function () {

        unitCode = $(this).attr('data-record-id');
        var formId  = '#edit_unit_form';

        /* Define extra data to pass to form */
        var deptCode = '#department_code'+unitCode;

        var map = {
            "department_code" : deptCode
        };

        handleForm(formId,unitCode, map, true);

    });

    $('.edit-button-designation').click(function () {

        var designationId = $(this).attr('data-record-id');
        var formId  = '#edit_designation_form';

        /* Define extra data to pass to form */
        var id = '#designation_id'+designationId;

        var map = {
            "designation_id" : id
        };

        handleForm(formId,designationId, map, true);

    });


}

function setDatePickerValue( dateSent) {

    alert('sasasa');

   /*  var $input = $('.datepicker').pickadate();
    var picker = $input.pickadate('picker');

    picker.set('select', dateSent, { format: 'yyyy/mm/dd' } */

}

function printErrorMsg(errors, recordId) {

    var error_msg_box = "#print-error-msg"+recordId;

    $(error_msg_box).find("ul").html('');
    $(error_msg_box).css('display','block');

    $.each( errors, function( key, value ) {
        $(error_msg_box).find("ul").append('<li>'+value+'</li>');
    });

}


function printErrorMsgDocumentTypes(errors) {

    var error_msg_box = "#print-error-msg-doc-type"+document_type_record_id;

    $(error_msg_box).find("ul").html('');
    $(error_msg_box).css('display','block');

    $.each( errors, function( key, value ) {
        $(error_msg_box).find("ul").append('<li>'+value+'</li>');
    });

}


function clearErrorMsg(recordId) {

    var error_msg_box = "#print-error-msg"+recordId;
    $(error_msg_box).find("ul").html('');
    $(error_msg_box).css('display','none');

}


function printSuccessMessage(formMessages, message) {
    var data = message == null ? '' : message.success;
    $(formMessages).text(data);
}


function handleForm($formId, $recordId, extraDataFieldsObj, refreshPage) {


    /*
    * Not for some cases, I have the edit form and the new form on the same page, so to differentiate the messages fields,
    * I append "edit" to the message field ID (i.e Edit[form-messagesedit] and New[form-messages]) but this should not affect the form ID and thus the logic below
    * */
    var form = $($formId + ($recordId == 'edit' ? '' : $recordId));
    var formMessages = $('#form-messages'+$recordId);


    $(form).submit(function (event) {

        event.preventDefault();

        var formData = $(form).serializeArray();

        /*
        * Attach extra data to the form
        * */
        for (var property in extraDataFieldsObj) {

            if (!extraDataFieldsObj.hasOwnProperty(property)) continue;

            /*
            * Get the field value
            * */
            var fieldValue = $(extraDataFieldsObj[property]).val();

            /*
             * Attach the field to the data
             * */
            formData.push({name: property, value: fieldValue});

        }

        // Submit the form using AJAX.
        $.ajaxSetup({
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        });

        $.ajax({

            type: 'POST',
            url: $(form).attr('action'),
            data: formData,
            success: function (data) {

                if($.isEmptyObject(data.error)){

                    if(refreshPage){
                        window.location.reload(true);
                    }else{
                        printSuccessMessage(formMessages, data);
                        clearErrorMsg($recordId);
                    }

                }else{
                    printSuccessMessage(formMessages,null);
                    printErrorMsg(data.error,$recordId);

                }

            },
            error: function (data) {
                alert(data);
            }

        });

        // Stop the browser from submitting the form.
       // event.preventDefault();
        return false;

    });


}

function handleUserProfileForm() {


    var form = document.getElementById('edit_profile_form'+profile_record_id);
    //alert(elem);

//    var form = $('#edit_profile_form' + profile_record_id);



    var formMessages = document.getElementById('form-messages'+profile_record_id);
   // var formMessages = $('#form-messages'+profile_record_id);


    alert(formMessages);


    $(form).submit(function (event) {

        /*
        * Serialize the form to get the data,
        * Note that for materialize css material_select the select values are not serialized so we added them manually
        * */
        var formData = $(form).serializeArray();


        /*
        * Get the values for the materialize css select fields
        * */
        $orgCode =  $('#org_code_'+profile_record_id).val();
        $regionalOfficeCode = $('#regional_office_code_'+profile_record_id).val();
        $deptCode = $('#department_code_'+profile_record_id).val();
        $categoryCode = $('#category_code_'+profile_record_id).val();
        $roleCode = $('#role_code_'+profile_record_id).val();



        /*
        * Push the select values to the form data manually
        * */
        formData.push({name: 'org_code', value: $orgCode});
        formData.push({name: 'regional_office_code', value: $regionalOfficeCode});
        formData.push({name: 'department_code', value: $deptCode});
        formData.push({name: 'category_code', value: $categoryCode});
        formData.push({name: 'role_code', value: $roleCode});

        /*
        * Now we have all the form data maybe if there is some other weird stuff I don't know of
        * But man if you are wise find away of avoiding the above stuff, it's not scalable
        * */


        // Submit the form using AJAX.
        $.ajaxSetup({
            headers: {'X-Requested-With': 'XMLHttpRequest','Accepts': 'application/json'}
        });

        $.ajax({

            type: 'POST',
            url: $(form).attr('action'),
            data: formData,
            success: function (data) {

                if($.isEmptyObject(data.error)){

                    printSuccessMessage(formMessages, data);
                    clearErrorMsg(profile_record_id);

                }else{

                    printSuccessMessage(formMessages,null);
                    printErrorMsg(data.error,profile_record_id);

                }

            },
            error: function (data) {
                alert(data);
            }

        });

        // Stop the browser from submitting the form.
        event.preventDefault();

    });
}


function showDeleteConfirmationModal(triggerButton, modal){

    $('#' + modal).modal('open');
    $('#' + modal + '_YesBtn').click(function(){
        $('#' + modal).modal('close');
        document.location = triggerButton.href;
    });

}

function showDynamicDeleteConfirmDialog(itemGroup, itemName, deleteURL) {

    //set the item group value in the delete modal
    $('#item_group').text(itemGroup);

    //set the item name value in the delete modal
    $('#item_name').text(itemName);

    //open the delete modal
    $('#modal_delete').modal('open');

    //attach lister to the confirm button of the delete dialog
    $('#modal_delete_YesBtn').click(function(){
        $('#modal_delete').modal('close');
        document.location = deleteURL;
    });

}

function closeModalAndRedirect(modalId,href) {

    $(modalId).modal('close');
    document.location = href;
    return false;

}


/**
 * Format to give number of decimal places
 * @param value
 * @param precision
 * @returns {string}
 */
function toFixed(value, precision) {

    var power = Math.pow(10, precision || 0);
    return String(Math.round(value * power) / power);

}

/**
 * Method used to sum up the contents in agiven row and fill the sum into the totals field
 * @param fieldIdPrefix ID Prefix for the fields being looped through
 * @param noOfRows used to loop through the fields
 * @param totalFieldId
 * @param maxValueOfTotal Sum must not go beyond this value
 */
function sumRow(fieldIdPrefix, noOfRows, totalFieldId, maxValueOfTotal) {

    var rowTotal = 0.0;
    for(var count = 1; count <= noOfRows ; count++){

        var fieldId = '#'+fieldIdPrefix+count;
        var rating = parseFloat($(fieldId).val());

        if(!isNaN(rating)){
            rowTotal += rating;
        }

    }

    if(rowTotal > maxValueOfTotal){
        alert("Total is beyond "+maxValueOfTotal+", please check input");
        $('#'+totalFieldId).val('');
    }else{
        $('#'+totalFieldId).val(rowTotal);
    }

    calculateSectionDAndSectionDAdditionalAsAPercentage()

}

/**
 * Section D and Section D Additional Should sum upto 120 now we are converting the person's score
 * as a percentage ie ((personScore * 100)/120) where personScore = scoreInSectionD + scoreInSectionDAdditional
 */
function calculateSectionDAndSectionDAdditionalAsAPercentage() {

    var sectionDAgreedRating = parseFloat($('#sec_d_total_agreed_rating').val());
    var sectionDAdditionalAgreedRating = parseFloat($('#sec_d_add_total_agreed_rating').val());

    if(!isNaN(sectionDAgreedRating) && !isNaN(sectionDAdditionalAgreedRating)){
        var percentageScore = ((sectionDAgreedRating + sectionDAdditionalAgreedRating)*100)/120;
        $('#sec_d_final_percentage_score').val(toFixed(percentageScore,decimalPlaces));
    }else{
        $('#sec_d_final_percentage_score').val('');
    }

    apply80PercentWeightOnSectionD();

}

/**
 * Applies 80% weighting on the score obtained from Section D
 */
function apply80PercentWeightOnSectionD(){

    var weighedValue = 0.0;
    var secDPercentageScore = window.document.getElementById("sec_d_final_percentage_score");
    var secDWeighedBy80 = window.document.getElementById("sec_d_weighed");

    if(!isNaN(secDPercentageScore.value)){
        weighedValue = ((parseFloat(secDPercentageScore.value)/100)*80);
        secDWeighedBy80.value = isNaN(weighedValue) ? '' : toFixed(weighedValue,decimalPlaces);
    }else{
        secDWeighedBy80.value = '';
    }

    window.document.getElementById("FinalScoreSecD").value =  secDWeighedBy80.value;
    sumSections();

}


function finishTable(tableId, columnIndex, totalCellId) {

    var columnToSum = columnIndex;
    var tableElemTableId = tableId;
    var tableElemTotal = totalCellId;
    var totalScore = 0.0;

    //Variables for the footer values
    var totalScoreElem = window.document.getElementById(tableElemTotal);

    try {

        totalScore = computeTableColumnTotal(tableElemTableId, columnToSum);
        totalScoreElem.value = totalScore.toLocaleString();

        if(tableId == "table_sec_e"){
            calculateSecEpercent();
        }
    }
    catch (ex) {
        window.alert("Exception in function finishTable()\n" + ex);
    }
    finally {
        event.target.style.background = "";
        return;
    }

}


function computeTableColumnTotal(tableId, colNumber) {

    // find the table with id attribute tableId
    // return the total of the numerical elements in column colNumber
    // skip the top row (headers) and bottom row (where the total will go)
    var result = 0.0;
    if (debugScript) {
        window.alert("Processing table " + tableId + " Column " + colNumber);
    }
    try {

        var tableElem = window.document.getElementById(tableId);

        var tableBody = tableElem.getElementsByTagName("tbody").item(0);
       // var tableBody = tableElem.getElementsByTagName("tbody");

        var howManyRows = tableBody.rows.length;

        // window.alert("Body has " + howManyRows + " rows.");
        for (var i = 1; i < howManyRows ; i++) // We expect headers and footers in their own sections
        {
            var thisTrElem = tableBody.rows[i];
            var thisTdElem = thisTrElem.cells[colNumber];

            if(thisTdElem.children[0] == null) continue;
            var thisTextNode = thisTdElem.children[0];
            var thisNumber = parseFloat(thisTextNode.value.replace(/,/g, ''));
            if (debugScript) {
                window.alert("Row " + i + " Column " + colNumber + " value is " + thisNumber);
            } // end if
            // try to convert text to numeric
            // if you didn't get back the value NaN (i.e. not a number), add into result
            if (!isNaN(thisNumber))
                result += thisNumber;
            //alert(result);


        }


        // end for
    } // end try
    catch (ex) {
        window.alert("Exception in function computeTableColumnTotal()\n" + ex);
        result = 0.0;
    }
    finally {
        if (debugScript) window.alert("Total is: " + result);


        return result;
    }
}

function calculateSecEpercent(){

    var maxTotalElem = window.document.getElementById("secEmaxTotal");
    var agreedTotalElem = window.document.getElementById("secEagreedTotal");
    var maxTotal = parseFloat(maxTotalElem.value);
    var agreedTotal = parseFloat(agreedTotalElem.value);
    var secEpercent = window.document.getElementById("sec_e_final_percentage_score");
    //additional

    if (!isNaN(maxTotal)){
        if (!isNaN(maxTotal)){

            var percent = (((agreedTotal)/(maxTotal))*100);

           secEpercent.value = toFixed(percent,3);
           calculateSecEpercentActual();

        }
    }


}



function calculateSecEpercentActual(){
    var percent1 = 0.0;
    var ElemSecEOutOf100 = window.document.getElementById("sec_e_final_percentage_score");
    var ElemWeighedOutOf20 = window.document.getElementById("sec_e_weighed");

    if(!isNaN(ElemSecEOutOf100.value)){
        percent1 = ((parseFloat(ElemSecEOutOf100.value)/100)*20);

        ElemWeighedOutOf20.value = toFixed(percent1,3);
        window.document.getElementById("FinalScoreSecE").value =  toFixed(percent1,3);

    }

    sumSections();

}

function sumSections(){

    var ElemSecD = window.document.getElementById("FinalScoreSecD");
    var ElemSecE = window.document.getElementById("FinalScoreSecE");
    var SumElem = window.document.getElementById("OverallTotal");

    if(!isNaN(ElemSecD.value)){
        if(!isNaN(ElemSecE.value)){
            var FinalMark = parseFloat(ElemSecD.value) + parseFloat(ElemSecE.value);
            SumElem.value = toFixed(FinalMark,3);

            /*Fill up the summary table values after calculating all totals*/
            var ElemsumScored04 = window.document.getElementById("sumScored04");
            var ElemsumScored05 = window.document.getElementById("sumScored05");
            var ElemsumScoredTotal = window.document.getElementById("sumScoredTotal");

        }
    }
}


function generateChildRowHtml(newId, parentId) {

    var childHtml = "";

    if(parentId == 'parent_dynamic_education_bg'){

        childHtml =
            '<div class="col m1 s12 ">' + newId + '</div> ' +
            '<div class="col m4 s12 "><input id="' + 'school_' + newId + '" name="' + 'school_' + newId + '" type="text" class="validate"></div>' +
            '<div class="col m2 s12 "><input id="' + 'year_of_study_' + newId + '" name="' + 'year_of_study_' + newId + '" type="text" class="validate"></div>' +
            '<div class="col m5 s12 "><input id="' + 'award_' + newId + '" name="' + 'award_' + newId + '" type="text" class="validate"></div>';

    }
    else if(parentId == 'parent_dynamic_key_duties'){

        var fnAssignment = "assignment_"+newId;
        var fnExpectedOutput = "expected_output_"+newId;
        var fnExpectedOutputSecD = "expected_output_sec_d_"+newId;
        var fnMaxRating = "max_rating_"+newId;
        var fnTimeFrame = "time_frame_"+newId;
        var fnFormFieldCount = "form_field_count"+newId;

        //get the options for the drop down of the objectives, here I assume the first drop down will have the values
        var firstObjectiveDropDown = document.getElementsByName('objective_1').item(0);
        var objectiveOptions = firstObjectiveDropDown.innerHTML;

        childHtml =
            '<div class="row">'+

                '<div class="col m1 s12 ">'+ newId + '</div>'+
                '<div class="col m11 s12">'+
                    '<select name="objective_'+newId+'" required class="browser-default validate s12" style="width: 100%">'+
                    //'<option value="" disabled selected>Select related strategic objective</option>'+
                    objectiveOptions +
                    '</select>'+
                '</div>'+

            '</div>'+

            '<div class="row ">'+

                '<div class="col m1 s12 ">' + '</div>'+
                '<div class="col m4 s12 ">'+
                    '<textarea  id="'+fnAssignment+'" onchange="copyBetweenTextField(0,1)"'+
                     ' name="'+fnAssignment+'" type="text" class="validate"></textarea>'+
                '</div>'+
                '<div class="col m4 s12 ">'+
                '<textarea id="'+fnExpectedOutput+'" name="'+fnExpectedOutput+'" type="text" class="validate"></textarea>'+
                '</div>'+
                '<div class="col m1 s12 ">'+
                '<input  id="'+fnMaxRating+'" name="'+fnMaxRating+'" type="number"  class="validate browser-default tab-input ">'+
                '</div>'+
                '<div class="col m2 s12 ">'+
                '<input  id="'+fnTimeFrame+'" name="'+fnTimeFrame+'" type="text" class="validate  browser-default tab-input">'+
                '</div>'+

                '<input type="hidden" name="'+fnFormFieldCount+'" value="'+newId+'"/>'+

            '</div>';

        return childHtml;

    }
    else if(parentId == 'parent_dynamic_assignments'){

        var fnObjective = "objective_"+newId;
        var fnExpectedOutputSecD = 'expected_output_sec_d_'+newId;
        var fnActualPerformance = 'actual_performance_'+newId;
        var fnMaxRatingSecD= 'max_rating_sec_d'+newId;
        var fnAppraiseeRatingSecD = 'appraisee_rating_sec_d'+newId;
        var fnAppraiserRatingSecD = 'appraiser_rating_sec_d'+newId;
        var fnAgreedRatingSecD = 'agreed_rating_sec_d'+newId;

        //get the options for the drop down of the objectives, here I assume the first drop down will have the values
        var firstObjectiveDropDown = document.getElementsByName('objective_1').item(0);
        var objectiveOptions = firstObjectiveDropDown.innerHTML;

        childHtml =
            '<div class="row">'+
                '<div class="col m1 s12 ">'+ newId + '</div>'+
                '<div class="col m11 s12" style="padding-left: 1.5%">'+
                    '<select  name="'+fnObjective+'" required class="browser-default validate s12" style="width: 100%">'+
                    objectiveOptions+
                    '</select>'+
                '</div>'+
            '</div>'+

            '<div class="row">'+

                '<div class="col s7">'+

                    '<div class="col s2 ">'+
                    '</div>'+
                    '<div class="col s5 ">'+
                    '<textarea id="'+fnExpectedOutputSecD+'" name="'+fnExpectedOutputSecD+'" type="text" class="validate"></textarea>'+
                    '</div>'+
                    '<div class="col s5 ">'+
                    '<textarea id="'+fnActualPerformance+'" name="'+fnActualPerformance+'" type="text" class="validate"></textarea>'+
                    '</div>'+

                '</div>'+

                '<div class="col s5">'+

                    '<div class="col s3 ">'+
                    '<input id="'+fnMaxRatingSecD+'" min="0" name="'+fnMaxRatingSecD+'" type="number" onblur="sumRow(\'max_rating_sec_d\',14,\'sec_d_total_max_rating\',100)" class="validate browser-default tab-input">'+
                    '</div>'+
                    '<div class="col s3 ">'+
                    '<input id="'+fnAppraiseeRatingSecD+'" min="0" name="'+fnAppraiseeRatingSecD+'" onblur="sumRow(\'appraisee_rating_sec_d\',14,\'sec_d_total_appraisee_rating\',100)" type="number" class="validate browser-default tab-input">'+
                    '</div>'+
                    '<div class="col s3 ">'+
                    '<input id="'+fnAppraiserRatingSecD+'" min="0" name="'+fnAppraiserRatingSecD+'" onblur="sumRow(\'appraiser_rating_sec_d\',14,\'sec_d_total_appraiser_rating\',100)" type="number" class="validate browser-default tab-input">'+
                    '</div>'+
                    '<div class="col s3 ">'+
                    '<input id="'+fnAgreedRatingSecD+'" min="0" name="'+fnAgreedRatingSecD+'" onblur="sumRow(\'agreed_rating_sec_d\',14,\'sec_d_total_agreed_rating\',100)" type="number" class="validate browser-default tab-input">'+
                    '</div>'+
                '</div>'+

            '</div>';

        return childHtml;

    }
    else if(parentId == 'parent_dynamic_additional_assignments'){

        var fnObjective = "objective_"+newId;
        var fnExpectedOutputSecD = 'expected_output_sec_d_add'+newId;
        var fnActualPerformance = 'actual_performance_sec_d_add'+newId;
        var fnMaxRatingSecD= 'max_rating_sec_d_add'+newId;
        var fnAppraiseeRatingSecD = 'appraisee_rating_sec_d_add'+newId;
        var fnAppraiserRatingSecD = 'appraiser_rating_sec_d_add'+newId;
        var fnAgreedRatingSecD = 'agreed_rating_sec_d_add'+newId;

        //get the options for the drop down of the objectives, here I assume the first drop down will have the values
        var firstObjectiveDropDown = document.getElementsByName('objective_1').item(0);
        var objectiveOptions = firstObjectiveDropDown.innerHTML;

        childHtml =
            '<div class="row">'+
            '<div class="col m1 s12 ">'+ newId + '</div>'+
            '<div class="col m11 s12" style="padding-left: 1.5%">'+
            '<select  name="'+fnObjective+'" required class="browser-default validate s12" style="width: 100%">'+
            objectiveOptions+
            '</select>'+
            '</div>'+
            '</div>'+

            '<div class="row">'+

            '<div class="col s7">'+

            '<div class="col s2 ">'+
            '</div>'+
            '<div class="col s5 ">'+
            '<textarea id="'+fnExpectedOutputSecD+'" name="'+fnExpectedOutputSecD+'" type="text" class="validate"></textarea>'+
            '</div>'+
            '<div class="col s5 ">'+
            '<textarea id="'+fnActualPerformance+'" name="'+fnActualPerformance+'" type="text" class="validate"></textarea>'+
            '</div>'+

            '</div>'+

            '<div class="col s5">'+

            '<div class="col s3 ">'+
            '<input id="'+fnMaxRatingSecD+'" min="0" name="'+fnMaxRatingSecD+'" type="number" onblur="sumRow(\'max_rating_sec_d_add\',5,\'sec_d_add_total_max_rating\',20)" class="validate browser-default tab-input">'+
            '</div>'+
            '<div class="col s3 ">'+
            '<input id="'+fnAppraiseeRatingSecD+'" min="0" name="'+fnAppraiseeRatingSecD+'" onblur="sumRow(\'appraisee_rating_sec_d_add\',5,\'sec_d_add_total_appraisee_rating\',20)" type="number" class="validate browser-default tab-input">'+
            '</div>'+
            '<div class="col s3 ">'+
            '<input id="'+fnAppraiserRatingSecD+'" min="0" name="'+fnAppraiserRatingSecD+'" onblur="sumRow(\'appraiser_rating_sec_d_add\',5,\'sec_d_add_total_appraiser_rating\',20)" type="number" class="validate browser-default tab-input">'+
            '</div>'+
            '<div class="col s3 ">'+
            '<input id="'+fnAgreedRatingSecD+'" min="0" name="'+fnAgreedRatingSecD+'" onblur="sumRow(\'agreed_rating_sec_d_add\',5,\'sec_d_add_total_agreed_rating\',20)" type="number" class="validate browser-default tab-input">'+
            '</div>'+
            '</div>'+

            '</div>';

        return childHtml;

    }
    else if(parentId == 'parent_dynamic_challenges'){

        var fnChallenge = "challenge_"+newId;
        var fnChallengeCause = 'challenge_cause_'+newId;
        var fnChallengeRecommendation = 'challenge_recommendation_'+newId;
        var fnChallengeWhen = 'challenge_when_'+newId;

        childHtml =
            '<div class="col s12">'+
                '<div class="col s1 ">' + newId+
                '</div>'+
                '<div class="col s3 ">'+
                    '<textarea id="'+fnChallenge+'" name="'+fnChallenge+'" type="text" class="validate"></textarea>'+
                '</div>'+
                '<div class="col s3 ">'+
                    '<textarea id="'+fnChallengeCause+'" name="'+fnChallengeCause+'" type="text" class="validate"></textarea>'+
                '</div>'+
                '<div class="col s3 ">'+
                    '<textarea id="'+fnChallengeRecommendation+'" name="'+fnChallengeRecommendation+'" type="text" class="validate"></textarea>'+
                '</div>'+
                '<div class="col s2 ">'+
                    '<input id="'+fnChallengeWhen+'" name="'+fnChallengeWhen+'" type="text" class="validate browser-default tab-input">'+
                '</div>'+
            '</div>';
        return childHtml;

    }
    else if(parentId == 'parent_dynamic_performance_gaps'){

        var fnGap = "gap_"+newId;
        var fnGapCause = 'cause_'+newId;
        var fnGapRecommendation = 'recommendation_'+newId;
        var fnGapWhen = 'when_'+newId;

        childHtml =
            '<div class="col s12">'+
                '<div class="col s1 ">' + newId+
                '</div>'+
                '<div class="col s3 ">'+
                '<textarea id="'+fnGap+'" name="'+fnGap+'" type="text" class="validate"></textarea>'+
                '</div>'+
                '<div class="col s3 ">'+
                '<textarea id="'+fnGapCause+'" name="'+fnGapCause+'" type="text" class="validate"></textarea>'+
                '</div>'+
                '<div class="col s3 ">'+
                '<textarea id="'+fnGapRecommendation+'" name="'+fnGapRecommendation+'" type="text" class="validate"></textarea>'+
                '</div>'+
                '<div class="col s2 ">'+
                '<input id="'+fnGapWhen+'" name="'+fnGapWhen+'" type="text" class="validate browser-default tab-input">'+
                '</div>'+
            '</div>';
        return childHtml;

    }
    else if(parentId == 'parent_dynamic_workplan'){

        var fnWpAssignment = "assignment_"+newId;
        var fnWpExpectedOutput = 'expected_output_'+newId;
        var fnWpMaxRating = 'max_rating'+newId;
        var fnWpTimeFrame = 'time_frame_'+newId;
        var fnWpRecordIdCount = 'record_id_count'+newId;

        childHtml =
            '<div class="row ">'+
                '<div class="col m1 s12 ">'+ newId+ '</div>'+
                '<div class="col m4 s12 ">'+
                '<textarea id="'+fnWpAssignment+'" name="'+fnWpAssignment+'" type="text" class="validate"></textarea>'+
                '</div>'+
                '<div class="col m4 s12 ">'+
                '<textarea id="'+fnWpExpectedOutput+'" name="'+fnWpExpectedOutput+'" type="text" class="validate"></textarea>'+
                '</div>'+
                '<div class="col m1 s12 ">'+
                '<input id="'+fnWpMaxRating+'" name="'+fnWpMaxRating+'" type="number" class="validate browser-default tab-input">'+
                '</div>'+
                '<div class="col m2 s12 ">'+
                '<input id="'+fnWpTimeFrame+'" name="'+fnWpTimeFrame+'" type="text" class="validate browser-default tab-input">'+
                '</div>'+
                '<input type="hidden" name="'+fnWpRecordIdCount+'" value="'+newId+'">'+
            '</div>';
        return childHtml;

    }
    else{
        return "Invalid Row Parent ID Supplied";
    }

    return childHtml;

}

function addElement(parentId, elementTag, elementCounterRows) {

    // Adds an element to the document
    var parentElem = document.getElementById(parentId);
    var rowCounterElem = document.getElementById(elementCounterRows);

    //get the number of children in the parent
    //var countChildren = parentElem.childElementCount == null ? 0 : parentElem.childElementCount;
    var countChildren = rowCounterElem == null || rowCounterElem.value == null ? 0 : rowCounterElem.value;

    //increment that number to get the new id
    var newId = (parseInt(countChildren)) + 1;

    //create the holder element
    var newElement = document.createElement(elementTag);

    // newElement.setAttribute('id', elementId);
    newElement.setAttribute('class', 'row');

    //this is the content
    var childHtml = generateChildRowHtml(newId, parentId);

    newElement.innerHTML = childHtml;

    parentElem.appendChild(newElement);

    //now we set the counter of the number of rows
    rowCounterElem.value = parentElem.childElementCount;//newId;

}

function deleteLastElement(parentId, elementCounterRows) {

    // Adds an element to the document
    var parentElem = document.getElementById(parentId);

    //the person is trying to remove everything
    if(parentElem.childElementCount <= 1){
        alert('You cannot remove all fields');
        return;
    }

    //get the last element
    var lastElem = parentElem.lastElementChild;

    //remove the last element
    parentElem.removeChild(lastElem);

    //now we set the counter of the number of rows
    var rowCounterElem = document.getElementById(elementCounterRows);
    rowCounterElem.value = parentElem.childElementCount;

}
