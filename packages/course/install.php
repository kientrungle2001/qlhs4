<?php
echo "Course\r\n";
if(!is_dir(BASE_DIR . '/app/qlhs/pages/grid/course')) {
    mkdir(BASE_DIR . '/app/qlhs/pages/grid/course');
}
if(!is_dir(BASE_DIR . '/app/qlhs/pages/grid/course/online')) {
    mkdir(BASE_DIR . '/app/qlhs/pages/grid/course/online');
}
if(!is_dir(BASE_DIR . '/app/qlhs/pages/grid/course/center')) {
    mkdir(BASE_DIR . '/app/qlhs/pages/grid/course/center');
}
if(!is_dir(BASE_DIR . '/app/qlhs/pages/grid/course/unclassed')) {
    mkdir(BASE_DIR . '/app/qlhs/pages/grid/course/unclassed');
}

if(!is_dir(BASE_DIR . '/app/qlhs/pages/grid/course/book')) {
    mkdir(BASE_DIR . '/app/qlhs/pages/grid/course/book');
}

// center
copy(PKG_DIR . DS . 'page.course.center.php', BASE_DIR . '/app/qlhs/pages/grid/course/center.php');
copy(PKG_DIR . DS . 'page.course.center.subject.php', BASE_DIR . '/app/qlhs/pages/grid/course/center/subject.php');
copy(PKG_DIR . DS . 'page.course.center.level.php', BASE_DIR . '/app/qlhs/pages/grid/course/center/level.php');
copy(PKG_DIR . DS . 'page.course.center.teacher.php', BASE_DIR . '/app/qlhs/pages/grid/course/center/teacher.php');
copy(PKG_DIR . DS . 'page.course.center.datagrid.php', BASE_DIR . '/app/qlhs/pages/grid/course/center/datagrid.php');
copy(PKG_DIR . DS . 'page.course.center.form_schedule.php', BASE_DIR . '/app/qlhs/pages/grid/course/center/form_schedule.php');
copy(PKG_DIR . DS . 'page.course.center.schedule.php', BASE_DIR . '/app/qlhs/pages/grid/course/center/schedule.php');
copy(PKG_DIR . DS . 'page.course.center.tuition_fee.php', BASE_DIR . '/app/qlhs/pages/grid/course/center/tuition_fee.php');
copy(PKG_DIR . DS . 'page.course.center.student_datagrid.php', BASE_DIR . '/app/qlhs/pages/grid/course/center/student_datagrid.php');
copy(PKG_DIR . DS . 'page.course.center.student_muster.php', BASE_DIR . '/app/qlhs/pages/grid/course/center/student_muster.php');
copy(PKG_DIR . DS . 'page.course.center.teacher_datagrid.php', BASE_DIR . '/app/qlhs/pages/grid/course/center/teacher_datagrid.php');
copy(PKG_DIR . DS . 'page.course.center.teacher_muster.php', BASE_DIR . '/app/qlhs/pages/grid/course/center/teacher_muster.php');
copy(PKG_DIR . DS . 'page.course.center.student_order.php', BASE_DIR . '/app/qlhs/pages/grid/course/center/student_order.php');
copy(PKG_DIR . DS . 'page.course.center.test_class.php', BASE_DIR . '/app/qlhs/pages/grid/course/center/test_class.php');
copy(PKG_DIR . DS . 'page.course.center.test_mark.php', BASE_DIR . '/app/qlhs/pages/grid/course/center/test_mark.php');
copy(PKG_DIR . DS . 'page.course.center.script.php', BASE_DIR . '/app/qlhs/pages/grid/course/center/script.php');
// online
copy(PKG_DIR . DS . 'page.course.online.php', BASE_DIR . '/app/qlhs/pages/grid/course/online.php');
copy(PKG_DIR . DS . 'page.course.online.subject.php', BASE_DIR . '/app/qlhs/pages/grid/course/online/subject.php');
copy(PKG_DIR . DS . 'page.course.online.level.php', BASE_DIR . '/app/qlhs/pages/grid/course/online/level.php');
copy(PKG_DIR . DS . 'page.course.online.teacher.php', BASE_DIR . '/app/qlhs/pages/grid/course/online/teacher.php');
copy(PKG_DIR . DS . 'page.course.online.datagrid.php', BASE_DIR . '/app/qlhs/pages/grid/course/online/datagrid.php');
copy(PKG_DIR . DS . 'page.course.online.schedule.php', BASE_DIR . '/app/qlhs/pages/grid/course/online/schedule.php');
copy(PKG_DIR . DS . 'page.course.online.tuition_fee.php', BASE_DIR . '/app/qlhs/pages/grid/course/online/tuition_fee.php');
copy(PKG_DIR . DS . 'page.course.online.student.php', BASE_DIR . '/app/qlhs/pages/grid/course/online/student.php');
copy(PKG_DIR . DS . 'page.course.online.advice.php', BASE_DIR . '/app/qlhs/pages/grid/course/online/advice.php');
copy(PKG_DIR . DS . 'page.course.online.problem.php', BASE_DIR . '/app/qlhs/pages/grid/course/online/problem.php');
// unclassed
copy(PKG_DIR . DS . 'page.course.unclassed.php', BASE_DIR . '/app/qlhs/pages/grid/course/unclassed.php');
copy(PKG_DIR . DS . 'page.course.unclassed.datagrid.php', BASE_DIR . '/app/qlhs/pages/grid/course/unclassed/datagrid.php');
copy(PKG_DIR . DS . 'page.course.unclassed.student.php', BASE_DIR . '/app/qlhs/pages/grid/course/unclassed/student.php');
copy(PKG_DIR . DS . 'page.course.unclassed.ontest.php', BASE_DIR . '/app/qlhs/pages/grid/course/unclassed/ontest.php');

// book
copy(PKG_DIR . DS . 'page.course.book.php', BASE_DIR . '/app/qlhs/pages/grid/course/book.php');
copy(PKG_DIR . DS . 'page.course.book.datagrid.php', BASE_DIR . '/app/qlhs/pages/grid/course/book/datagrid.php');
copy(PKG_DIR . DS . 'page.course.book.subject.php', BASE_DIR . '/app/qlhs/pages/grid/course/book/subject.php');
copy(PKG_DIR . DS . 'page.course.book.level.php', BASE_DIR . '/app/qlhs/pages/grid/course/book/level.php');
copy(PKG_DIR . DS . 'page.course.book.teacher.php', BASE_DIR . '/app/qlhs/pages/grid/course/book/teacher.php');
copy(PKG_DIR . DS . 'page.course.book.student.php', BASE_DIR . '/app/qlhs/pages/grid/course/book/student.php');
copy(PKG_DIR . DS . 'page.course.book.advice.php', BASE_DIR . '/app/qlhs/pages/grid/course/book/advice.php');
copy(PKG_DIR . DS . 'page.course.book.problem.php', BASE_DIR . '/app/qlhs/pages/grid/course/book/problem.php');
// course selector
copy(PKG_DIR . DS . 'class.CourseSelector.php', BASE_DIR . '/objects/edu/CourseSelector.php');
copy(PKG_DIR . DS . 'class.CourseSelector.js', BASE_DIR . '/js/edu/courseSelector.js');
copy(PKG_DIR . DS . 'edu.course.selector.php', BASE_DIR . '/default/layouts/edu/course/selector.php');
