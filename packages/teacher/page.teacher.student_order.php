<dg.dataGrid id="dg_student_order" title="Danh sách học phí" scriptable="true" layout="easyui/datagrid/datagrid" 
        nowrap="true" pageSize="50"
        table="student_order" width="850px" height="500px">
    <dg.dataGridItem field="id" width="80">Id</dg.dataGridItem>
    <dg.dataGridItem field="studentName" width="120">Học sinh</dg.dataGridItem>
    <dg.dataGridItem field="className" width="120">Lớp</dg.dataGridItem>
    <dg.dataGridItem field="periodName" width="120">Kỳ thanh toán</dg.dataGridItem>
    <dg.dataGridItem field="amount" width="120">Số tiền</dg.dataGridItem>
    <dg.dataGridItem field="created" width="120">Ngày thanh toán</dg.dataGridItem>
</dg.dataGrid>