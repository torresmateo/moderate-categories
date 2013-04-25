jQuery(document).ready(function($) {

	//check for a valid role
	$("#targetForm").submit(function(e){
		var target = $("#moderateTarget").val();
		if(target != "moderate-NO-TARGET")
			return true;
		alert("You must " + $("#targetValue").html());
		return false;
	});

	//TODO load rule on target selection

});