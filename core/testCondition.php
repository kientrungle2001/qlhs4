<?php
$condition = array('column', 'code');
echo json_encode($condition) . '<br />';
$result = buildCondition($condition);
assertEquals($result, '`code`');

$condition = array('string', '123456');
echo json_encode($condition) . '<br />';
$result = buildCondition($condition);
assertEquals($result, '\'123456\'');

$condition = array('string', '12\'3456');
echo json_encode($condition) . '<br />';
$result = buildCondition($condition);
assertEquals($result, '\'12\\\'3456\'');


$condition = array('equal', array('column', 'code'), array('string', '123456'));
echo json_encode($condition) . '<br />';
$result = buildCondition($condition);
assertEquals($result, "`code`='123456'");

$condition = array('equal', 'code', array('string', '123456'));
echo json_encode($condition) . '<br />';
$result = buildCondition($condition);
assertEquals($result, "`code`='123456'");

$condition = array("and", 
	array('equal', array('column', 'code'), array('string', '123456') ),
	array('equal', array('column', 'password'), array('string', '123456') )
);
echo json_encode($condition) . '<br />';
$result = buildCondition($condition);
assertEquals($result, "`code`='123456' and `password`='123456'");

$condition = array("or", 
	array('equal', array('column', 'code'), array('string', '123456') ),
	array('equal', array('column', 'password'), array('string', '123456') )
);
echo json_encode($condition) . '<br />';
$result = buildCondition($condition);
assertEquals($result, "`code`='123456' or `password`='123456'");

$condition = array("or", 
	array('equal', 'code', '123456'),
	array('equal', 'password', '123456')
);
echo json_encode($condition) . '<br />';
$result = buildCondition($condition);
assertEquals($result, "`code`='123456' or `password`='123456'");
$condition = array("or", 
	array('equal', 'code', '123456'),
	array('equal', 'password', '123456'),
	1
);
echo json_encode($condition) . '<br />';
$result = buildCondition($condition);
assertEquals($result, "`code`='123456' or `password`='123456' or 1");