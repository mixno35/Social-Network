function popupWindow(id) {
	event.stopPropagation();
	if (document.getElementById(id).style.display == "none") {
		document.getElementById(id).style.display = "block";
	} else {
		document.getElementById(id).style.display = "none";
	}
}
function showMenu(id) {
    try {
        event.stopPropagation();
        if (document.getElementById(id).style.display == "none") {
            document.getElementById(id).style.display = "flex";
        } else {
            document.getElementById(id).style.display = "none";
        }
    } catch (exx) {}
}

function showUserPopup(argument, argument2) {
    event.stopPropagation();
    closePopups();
    $.ajax({
        type: "GET", 
        url: "/assets/alert/view-user.php", 
        data: {id: argument}, 
        success: function(result){
            $("body").append(result);
        }
    });
}
function showUserPopupOld(argument, argument2) {
    event.stopPropagation();
    closePopups();
    $.ajax({
        type: "GET", 
        url: "/assets/alert/view-user-old.php", 
        data: {id: argument}, 
        success: function(result){
            $("#"+argument2).append(result);
        }
    });
}

function updParam(param, paramVal){
	var url = window.location.href;
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var additionalURL = tempArray[1];
    var temp = "";
    if (additionalURL) {
        tempArray = additionalURL.split("&");
        for (var i=0; i<tempArray.length; i++){
            if(tempArray[i].split('=')[0] != param){
                newAdditionalURL += temp + tempArray[i];
                temp = "&";
            }
        }
    }

    var rows_txt = temp + "" + param + "=" + paramVal;
    // return baseURL + "?" + newAdditionalURL + rows_txt;
    window.history.replaceState('', '', baseURL + "?" + newAdditionalURL + rows_txt);
}

function removeParam(param) {
	var url = window.location.href.split('?')[0]+'?';
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
 
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] != param) {
            url = url + sParameterName[0] + '=' + sParameterName[1] + '&'
        }
    }
    // return url.substring(0,url.length-1);
    window.history.replaceState('', '', url.substring(0,url.length-1));
    // window.location = removeParams(parameter);
}