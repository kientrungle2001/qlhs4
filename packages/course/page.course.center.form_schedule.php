<!-- Xếp lịch học -->
<div layout="form/schedule">
<layout.toolbarItem action="$dg.actOnSelected({
	'url': '{url /dtable/addschedule}', 
	'gridField': 'classId', 
	'fields': {
		'startDate': 'input[name=startDate]',
		'endDate' : 'input[name=endDate]',
		'weekday' : '#weekday',
		'studyTime' : '#studyTime'
	}
}); $dg2.reload();" icon="ok" />