jQuery(document).ready(function($) {

	//utilities from http://dl.dropboxusercontent.com/u/35146/js/tests/isNumber.html
	function isNumber(n) {
		return !isNaN(parseFloat(n)) && isFinite(n);
	}

	//check for a valid role
	$("#targetForm").submit(function(e){
		var target = $("#moderateTarget").val();
		if(target != "moderate-NO-TARGET")
			return true;
		alert("You must " + $("#targetValue").html());
		return false;
	});

	$('#moderateTarget').change(function(){
		var target = $(this).val();
		//userValues are numeric, a prefix is needed
		var targetCurrentSettings = isNumber(target)?window["moderate_uid_" + target]:window[target];
		if(targetCurrentSettings != undefined){
			var dropDown = $('input[name=rule\\[\\]]');
			for (var i = 0; i < dropDown.length; i++) {
				if($.inArray(dropDown[i].value,targetCurrentSettings) != -1)
					dropDown[i].checked = true;
				else
					dropDown[i].checked = false;
				
			};
		}
	});

});