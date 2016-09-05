function station_search(text, tip) {
	if (text.length > 1) {
		jQuery.getJSON("index.php?option=com_rasp&view=station_search&station="+encodeURIComponent(text), function(data) {
			if (data.length > 0) {
				display_stations(data, tip);
			}
		});
	} else {
		jQuery("#ul_"+tip+" > li").remove();
		jQuery("#div_"+tip).hide();
	}
}

function display_stations(result, tip) {
	jQuery("#div_"+tip).hide();
	jQuery("#ul_"+tip+" > li").remove();
	var name = '';
	for (var i=0; i< result.length; i++) {
		name = result[i].popularName == null ? result[i].name : result[i].popularName;
		jQuery("#ul_"+tip).append('<li class="li_station" onclick="select_station(\''+result[i].id+'\', \''+name+'\', \''+tip+'\')">'+name+' ('+result[i].road+' ЖД)</li>');
	}
	
	jQuery("#div_"+tip).show();
}

function select_station(id, name, tip) {
	jQuery("#"+tip+"_id").val(id);
	jQuery("#rasp_"+tip).val(name);
	jQuery("#div_"+tip).hide();
}
jQuery(document).ready(function (e) {
	jQuery(".obratno").bind('click', function (ee) {
		var fromID = jQuery("#from_id").val();
		var toID = jQuery("#to_id").val();
		var from = jQuery("#rasp_from").val();
		var to = jQuery("#rasp_to").val();
		jQuery("#from_id").val(toID);
		jQuery("#to_id").val(fromID);
		jQuery("#rasp_from").val(to);
		jQuery("#rasp_to").val(from);
	})
	
});