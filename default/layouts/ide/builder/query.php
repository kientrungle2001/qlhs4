<?php
$query = $data->query;
$querySet = $query->getSet();
$fields = array();
$fields[] = $query->getImplodedFields();
$tables = $query->getTables();
foreach($tables as $table) {
	$fields[] = $table->getImplodedFields();
}
$querySql = 'select ' . implode(', ',$fields) . ' from ' . $querySet->get('code') . ' as ' . $query->get('code');

if($tables) {
	foreach($tables as $table) {
		$tableSet = $table->getSet();
		$querySql .= "\n".' inner join ' . $tableSet->get('code') . ' as ' . $table->get('code', $tableSet->get('code')) . ' on ' . 
			$query->get('code', $querySet->get('code')) . '.' .  $table->get('rightField') . '=' . $table->get('code', $tableSet->get('code')) 
				. '.' . $table->get('leftField', 'id');
		if($table->get('additionConditions')) {
			$querySql .= ' and ' . $table->get('additionConditions');
		}
	}
}

if($query->get('conditions')) {
	$querySql .= ' where ' . $query->get('conditions');
}
if($query->get('groupBy')) {
	$querySql .= ' group by ' . $query->get('groupBy');
}
if($query->get('havingConditions')) {
	$querySql .= ' having ' . $query->get('havingConditions');
}
if($query->get('orderBy')) {
	$querySql .= ' order by ' . $query->get('orderBy');
}
echo $querySql;

?>