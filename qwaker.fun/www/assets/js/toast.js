let timerShowToast;

if(document.getElementById) {
    window.toast = function(txt) {
        if(document.getElementById("toastContainer")) {
            removeToast();
        }

        createToast(txt);
    }
}

function createToast(txt) {
    d = document;

    if(d.getElementById("toastContainer")) return;

    toastObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
    toastObj.id = "toastContainer";
    toastObj.onclick = function() { removeToast();return false; }

    msg = toastObj.appendChild(d.createElement("p"));
    msg.innerHTML = txt;

    toastObj.style.display = "block";

    timerShowToast = setTimeout(function() {removeToast()}, 10000);
}

function removeToast() {
    try {
        clearTimeout(timerShowToast);
    } catch (exx) {}
    document.getElementsByTagName("body")[0].removeChild(document.getElementById("toastContainer"));
}