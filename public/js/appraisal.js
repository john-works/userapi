
$(document).ready(function(){

    var editCls = document.getElementsByClassName('edit-off');
    if(editCls.length > 0){
        disableForm();
    }

});

function copyTextToOtherTextField(input_to_populate){

    var input_to_fill = document.getElementById(input_to_populate);
    var cell_data = event.target.value;

    alert('cell data'+cell_data);

    input_to_fill.value = cell_data.toLocaleString();
    input_to_fill.readOnly = true;

}

function copyBetweenTextField(input_with_content,input_to_populate){

    var input_to_fill = document.getElementById(input_to_populate);
    var data_input = document.getElementById(input_with_content);
    var cell_data = data_input.value;
    input_to_fill.value = cell_data.toLocaleString();
    input_to_fill.readOnly = true;

}


function disappear(){

    var secA= document.getElementById('sec_a');
    var secB = document.getElementById('sec_b');
    var secC = document.getElementById('sec_c');
    var secD = document.getElementById('sec_d');
    var secDAdd = document.getElementById('sec_d_add');
    var secE = document.getElementById('sec_e');
    var secF = document.getElementById('sec_f');
    var secG = document.getElementById('sec_g');
    var secH = document.getElementById('sec_h');
    var secI = document.getElementById('sec_i');
    var secJ = document.getElementById('sec_j');
    var secK = document.getElementById('sec_k');
    var secL = document.getElementById('sec_l');
    var secM = document.getElementById('sec_m');
    var secN = document.getElementById('sec_n');

    var sectionsArr = [secA,secB,secC,secD,secDAdd,secE,secF,secG,secH,secI,secJ,secK,secL,secM,secN];

    var e = document.getElementById("dropDownSectionsVisible");
    var selectedSections = e.options[e.selectedIndex].value;


    if(selectedSections == 1){

       // var visibleSections = [secA,secB];
        for (var index =0;index<sectionsArr.length;index++){

            if(sectionsArr[index].id == secA.id || sectionsArr[index].id == secB.id){
                sectionsArr[index].classList.remove("hide");
            }else{
               sectionsArr[index].classList.add("hide");
            }

        }

    }else if(selectedSections == 2) {

      //  var visibleSections = [secC,secD,secDAdd,secE];
        for (var index2 =0;index2<sectionsArr.length;index2++){

            if(sectionsArr[index2].id == secC.id || sectionsArr[index2].id == secD.id ||
                sectionsArr[index2].id == secDAdd.id || sectionsArr[index2].id == secE.id){
                sectionsArr[index2].classList.remove("hide");
            }else{
                sectionsArr[index2].classList.add("hide");
            }

        }

    } else if(selectedSections == 3){

      //  var visibleSections = [secF,secG,secH,secI];
        for (var index3 =0;index3<sectionsArr.length;index3++){

            if(sectionsArr[index3].id == secF.id || sectionsArr[index3].id == secG.id ||
                sectionsArr[index3].id == secH.id || sectionsArr[index3].id == secI.id){
                sectionsArr[index3].classList.remove("hide");
            }else{
                sectionsArr[index3].classList.add("hide");
            }

        }

    }  else if(selectedSections == 4){

        //  var visibleSections = [secJ,secK,secL,secM, secN];
        for (var index4 =0;index4<sectionsArr.length;index4++){

            if(sectionsArr[index4].id == secJ.id || sectionsArr[index4].id == secK.id ||
                sectionsArr[index4].id == secL.id || sectionsArr[index4].id == secM.id ||
                sectionsArr[index4].id == secN.id){
                sectionsArr[index4].classList.remove("hide");
            }else{
                sectionsArr[index4].classList.add("hide");
            }

        }


    }else{

        //Show every thing
        for (var indexOther =0;indexOther<sectionsArr.length;indexOther++){
            sectionsArr[indexOther].classList.remove("hide");
        }

    }

}


function disableForm() {

    var inputs = document.getElementsByTagName("input");
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].disabled = true;
    }
    var selects = document.getElementsByTagName("select");
    for (var i = 0; i < selects.length; i++) {
        selects[i].disabled = true;
    }
    var textareas = document.getElementsByTagName("textarea");
    for (var i = 0; i < textareas.length; i++) {
        textareas[i].disabled = true;
    }
    var buttons = document.getElementsByTagName("button");
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].disabled = true;
    }

    var submitBtn = document.getElementById("btnMoveForm");
    submitBtn.disabled = true;
    submitBtn.href = '';
    submitBtn.classList.add("isDisabled");
    submitBtn.removeAttribute("href");

}