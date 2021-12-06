<div id="placeholder-webpage-qak">
	<!-- <img src="/assets/images/qak-logo.png" id="placeholder-webpage-qak-img"> -->
	<text>QAK</text>
</div>
<script type="text/javascript" id="placeholder-webpage-qak-script">
	window.onload = function() {
		document.getElementById('placeholder-webpage-qak').remove();
		document.getElementById('placeholder-webpage-qak-script').remove();
	}
</script>

<script type="text/javascript">
	document.documentElement.onclick = function(event) {
		closePopups();
	}
</script>
<script type="text/javascript">
	function closePopups() {
		var olsMenu = document.getElementsByTagName("ol");
		for (var i = 0; i < olsMenu.length; i++) {
		   if (olsMenu[i].style.display != 'none') {
		   		olsMenu[i].style.display = 'none';
		   		if (document.getElementById('bar-top-alert') != null) {
					document.getElementById('bar-top-alert').remove();
				} if (document.getElementById('view-user') != null) {
					document.getElementById('view-user').remove();
				}
		   }
		}
	}
</script>