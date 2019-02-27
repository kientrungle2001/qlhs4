<div>
<dg.dataGrid id="dg_classes" title="Quản lý lớp học" scriptable="true" table="classes" 
        width="650px" height="450px" rownumbers="false" pageSize="50" nowrap="false">
    <dg.dataGridItem field="id" width="40">Id</dg.dataGridItem>
    <dg.dataGridItem field="name" width="180" formatter="classInfo">Tên lớp</dg.dataGridItem>
    <!--
    <dg.dataGridItem field="subjectName" width="120">Môn học</dg.dataGridItem>
    -->
    <dg.dataGridItem field="roomName" width="40">Phòng</dg.dataGridItem>
    <dg.dataGridItem field="startDate" width="160" formatter="dateInfo">Khoảng thời gian</dg.dataGridItem>
    <!--
    <dg.dataGridItem field="startDate" width="160">Ngày bắt đầu</dg.dataGridItem>
    <dg.dataGridItem field="endDate" width="160">Ngày kết thúc</dg.dataGridItem>
    -->
    <dg.dataGridItem field="amount" width="100">Học phí</dg.dataGridItem>
    <dg.dataGridItem field="status" width="80" formatter="statusInfo">TT</dg.dataGridItem>
</dg.dataGrid>
<script>
    <![CDATA[
        function classInfo(value, item, index) {
            return [item.name, item.subjectName].join('<br />');
        }
        function dateInfo(value, item, index) {
            return [item.startDate, item.endDate].join('<br />');
        }
        function statusInfo(value, item, index) {
            if(value == '0') {
                return 'Dừng học';
            } else {
                return 'Đang học';
            }
        }
    ]]>
</script>
</div>