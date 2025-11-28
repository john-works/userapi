$('body').on('blur change','input,select',function(){
    return validate_control($(this))
})

/**
 * This is called when you press the submit/save button on the form.
 * This does the general sweeping...
 * to check whether we are submitting the form but with errors
 * it checks the entire form frm
 * @param frm
 */
function validate_form(frm){
    var valid = true
    var errors = 0

    $('#'+frm).find('input,select, textarea').not( ":submit, :reset, :image, [disabled], [readonly]" ).each(function(){
        errors += ((validate_control($(this))? 0: 1) )
    })

    return valid = ((errors == 0)?true:false)
}

/**
 * This is the end function that is called on an individual control
 * (input, select, textarea, checkbox, radio)
 * @param el jquery-element
 */
function validate_control(el){
    //reset form validation information
    el.parent('div').removeClass('empty-input invalid-input').addClass('valid-input').find('.error').remove()
    //end reset

    /**
     * Define your validation rules here
     * You can use selector classes to impose certain validation rules
     * Remember we are dealing with the input element directly
     */

    //check if required and empty
    if(el.attr('required') && isEmpty(el.val()) ){
        el.parent('div').removeClass('valid-input').addClass('empty-input').append('<span class="error">This is required!!</span>')
        return false
    }
    //check phone number
    if( /phone_number/i.test(el.attr('class')) && !validPhone(el.val()) && !isEmpty(el.val()) ){
        el.parent('div').removeClass('valid-input').addClass('invalid-input').append('<span class="error">This is not a valid phone number! Enter in the format <em>+000 000 000000</em></span>')
        return false
    }
    //check email
    if( /email/i.test(el.attr('class')) && !validEmail(el.val()) && !isEmpty(el.val()) ){
        el.parent('div').removeClass('valid-input').addClass('invalid-input').append('<span class="error">This is not a valid email address!</span>')
        return false
    }

    return true
}


/**
 * These are validation functions
 * Just call them in the script lines above as you may wish
 */
function validEmail(email){
    return /^[a-zA-Z0-9\-_]+(\.[a-zA-Z0-9\-_]+)*@[a-z0-9]+(\-[a-z0-9]+)*(\.[a-z0-9]+(\-[a-z0-9]+)*)*\.[a-z]{2,100}$/.test(email)
}
function isValidPassword(input)
{
     var reg = /^[^%\s]{6,}$/;
     var reg2 = /[a-zA-Z]/;
     var reg3 = /[0-9]/;
     return reg.test(input) && reg2.test(input) && reg3.test(input);
}
function isEmpty(str){
    return (str == '')
}
function validName(name){
    return /^[a-zA-Z]+(\s{0,3}[a-zA-Z-])*$/.test(name)
}
function validPhone(phone){
    return /^\+[0-9]{3}\s[0-9]{3}\s[0-9]{6}$/.test(phone)
}

function isValidPostcode(p) {
    var postcodeRegEx = /[A-Z]{1,2}[0-9]{1,2} ?[0-9][A-Z]{2}/i;
    return postcodeRegEx.test(p);
}
