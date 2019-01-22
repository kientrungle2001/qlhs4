<?php
$btabs = 'div class="easyui-tabs"';
$etabs = 'div';
// combobox
$asset_sql = 'select id as value, 
     name as label from `asset` order by name ASC';
$room_sql = 'select id as value, 
     name as label from `room` order by name ASC';
$subject_sql = 'select id as value, 
     name as label from `subject` order by name ASC';
$subject_online_sql = 'select id as value, 
     name as label from `subject` where online=1 order by name ASC';
$subject_center_sql = 'select id as value, 
					name as label from `subject` where online=0 order by name ASC';
$class_sql = 'select id as value, 
                    name as label, subjectId, level from `classes` where status=1 order by name ASC';
$class_online_sql = 'select id as value, 
                    name as label, subjectId, level from `classes` where status=1 and online=1 order by name ASC';
$class_center_sql = 'select id as value, 
                    name as label, subjectId, level from `classes` where status=1 and online=0 order by name ASC';
$class_ontest_sql = 'select id as value, 
                    name as label, subjectId, level from `classes` where status=1 and online=0 and classed=-1 order by name ASC';
$employee_sql = "select id as value, 
                    name as label from `employee` order by name ASC";
$payment_period_sql = 'select id as value, 
                    name as label from `payment_period` where status=1 order by startDate DESC';
$test_sql = 'select id as value, 
                    name as label from `test` order by id DESC';
$teacher_sql = "select id as value, 
                    name as label from `teacher` order by name ASC";
$class_level_sql = "select distinct(level) as value, level as label from classes order by label asc";
$class_status_sql = "select distinct(status) as value, status as label from classes order by label asc";
$current_date = date('Y-m-d');

// add, edit
