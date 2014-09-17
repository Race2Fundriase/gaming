
function convertDateTimeToDate(d, t) {
	
	// assumes date in local timezone (but actually it is GMT)
	var m = moment(d+" "+t+" +0000", "YYYY-MM-DD HH:mm Z");
	m.lang(navigator.language);
	return m.format("L");

}

function convertDateTimeToTime(d, t) {
	
	// assumes date in local timezone (but actually it is GMT)
	var m = moment(d+" "+t+" +0000", "YYYY-MM-DD HH:mm Z");
	m.lang(navigator.language);
	return m.format("HH:mm");

}

function convertDateTimeToISODate(d, t) {
	
	// assumes date in local timezone (but actually it is GMT)
	var m = moment(d+" "+t+" +0000", "YYYY-MM-DD HH:mm Z");
	m.lang(navigator.language);
	return m.format("YYYY-MM-DD");

}

function pad(a,b){
	
	if (a>=0)
		return "+"+(1e15+a+"").slice(-b)
	else
		return "-"+(1e15+(-a)+"").slice(-b)
	
}

function convertDateTimeToTimeZoneDateTime(d, t, z) {
	m = moment();
	m.zone(-z*60);
	m.lang(navigator.language);
	return m.format("L HH:mm");
}

function convertDateTimeToTimeZoneDate(d, t, z) {
	m = moment();
	m.zone(-z*60);
	m.lang(navigator.language);
	return m.format("L");
}

function convertDateTimeToTimeZoneTime(d, t, z) {
	m = moment();
	m.zone(-z*60);
	m.lang(navigator.language);
	return m.format("HH:mm");
}