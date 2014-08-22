
function convertDateTimeToDate(d, t) {
	
	// assumes date in local timezone (but actually it is GMT)
	var m = moment(d+" "+t);
	m.zone(m.zone()+m.zone());
	m.lang(navigator.language);
	return m.format("L");

}

function convertDateTimeToTime(d, t) {
	
	// assumes date in local timezone (but actually it is GMT)
	var m = moment(d+" "+t);
	m.zone(m.zone()+m.zone());
	m.lang(navigator.language);
	return m.format("HH:mm");

}

function convertDateTimeToISODate(d, t) {
	
	// assumes date in local timezone (but actually it is GMT)
	var m = moment(d+" "+t);
	m.zone(m.zone()+m.zone());
	m.lang(navigator.language);
	return m.format("YYYY-MM-DD");

}

