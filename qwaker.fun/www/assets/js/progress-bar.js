function showProgressBar() {
	hideProgressBar();
	pb = document.getElementsByTagName("body")[0].appendChild(document.createElement("pb"));
    pb.id = "progress-bar";
    pb.className = "over";

    cont = document.getElementsByTagName("pb")[0].appendChild(document.createElement("cont"));
    // cont.textContent = "QAK";
}

function hideProgressBar() {
	try {
		document.getElementById('progress-bar').remove();
	} catch (exx) {}
}