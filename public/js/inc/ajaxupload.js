
function uploadImage (action,element,idEle){

	$('#target_input').html('');

	//var $ele = $('#'+element), $clone = $ele.clone();
	var $ele = element, $clone = $ele.clone();
		$ele.after($clone).appendTo('#target_input');

		var random_id = Math.random()
		idEle.attr('id',random_id)
	
	//return ajaxUpload(document.frmPhoto,action,'<div class="info">Uploading file please wait.....</div>',idEle);
	return ajaxUpload(document.frmPhoto,action,'<div class="info">Uploading file please wait.....</div>',idEle);

}
//  -->
function disableForm(theform) {
    if (document.all || document.getElementById) {
        for (i = 0; i < theform.length; i++) {
        var tempobj = theform.elements[i];
        if (tempobj.type.toLowerCase() == "submit")
            tempobj.disabled = true;
        }

     return true;
    }
}
function $m(theVar){
	return document.getElementById(theVar)
}
function remove(theVar){
	var theParent = theVar.parentNode;
	theParent.removeChild(theVar);
}
function addEvent(obj, evType, fn){
	if(obj.addEventListener)
	    obj.addEventListener(evType, fn, true)
	if(obj.attachEvent)
	    obj.attachEvent("on"+evType, fn)
}
function removeEvent(obj, type, fn){
	if(obj.detachEvent){
		obj.detachEvent('on'+type, fn);
	}else{
		obj.removeEventListener(type, fn, false);
	}
}
function isWebKit(){
	return RegExp(" AppleWebKit/").test(navigator.userAgent);
}
function ajaxUpload(form,url_action,msg,idEle){

var container_id = idEle.attr('id')
//alert(container_id)
var id_element=idEle[0];

var html_show_loading= msg+'<div class="loading"></div>';
var html_error_http='<i class="fa fa-ban red"></i> Error in Upload, check settings and path info in source code.';

	var detectWebKit = isWebKit();
	form = typeof(form)=="string"?$m(form):form;
	var erro="";
	if(form==null || typeof(form)=="undefined"){
		erro += "The form of 1st parameter does not exist.\n";
	}else if(form.nodeName.toLowerCase()!="form"){
		erro += "The form of 1st parameter its not a form.\n";
	}
	//if($m(id_element)==null){
	if(id_element==null){
		erro += "The element of 3rd parameter does not exist.\n";
	}
	if(erro.length>0){
		alert("Error in call ajaxUpload:\n" + erro);
		return;
	}
	var iframe = document.createElement("iframe");
	iframe.setAttribute("id","ajax-temp");
	iframe.setAttribute("name","ajax-temp");
	iframe.setAttribute("width","0");
	iframe.setAttribute("height","0");
	iframe.setAttribute("border","0");
	iframe.setAttribute("style","width: 0; height: 0; border: none;");
	form.parentNode.appendChild(iframe);
	window.frames['ajax-temp'].name="ajax-temp";
	var doUpload = function(){
		removeEvent($m('ajax-temp'),"load", doUpload);
		var cross = "javascript: ";
		cross += "window.parent.$m('"+container_id+"').innerHTML = document.body.innerHTML; void(0);";
		//cross += id_element+".innerHTML = document.body.innerHTML; void(0);";
		id_element.innerHTML = html_error_http;
		$m('ajax-temp').src = cross;
		if(detectWebKit){
        	remove($m('ajax-temp'));
        }else{
        	setTimeout(function(){ remove($m('ajax-temp'))}, 250);
        }

		//add the name of the file into the name box
		//alert( $('#'+container_id).attr('class') )
		//alert(idEle.attr('id'))
		var this_tr = idEle.parents('tr')
		//alert(this_tr.find('.ace-file-name').length)
		setTimeout(function(){
			this_tr.find('.file_name').val( this_tr.find('.ace-file-name').attr('data-title') )
		},300)
		

    }
	addEvent($m('ajax-temp'),"load", doUpload);
	form.setAttribute("target","ajax-temp");
	form.setAttribute("action",url_action);
	form.setAttribute("method","post");
	form.setAttribute("enctype","multipart/form-data");
	form.setAttribute("encoding","multipart/form-data");
	if(html_show_loading.length > 0){
		id_element.innerHTML = html_show_loading;
	}
	form.submit();
}