<!-- Dialog thêm sửa học sinh -->
<wdw.dialog gridId="dg" width="700px" height="auto" title="Học sinh">
	<frm.form gridId="dg">
		<frm.formItem type="hidden" name="id" label="" />
		<frm.formItem name="name" required="true" validatebox="true" label="Tên học sinh" />
		<frm.formItem name="code" required="false" validatebox="false" label="Mã" />
		<frm.formItem name="phone" label="Số điện thoại" />
		<frm.formItem name="email" label="Email" />
		<frm.formItem name="school"  label="Trường" />
		<frm.formItem type="date" name="birthDate" label="Ngày sinh" />
		<frm.formItem name="address" label="Địa chỉ" />
		<frm.formItem name="parentName" label="Phụ huynh" />
		<frm.formItem type="date" name="startStudyDate" label="Ngày nhập học" value="{? echo date('Y-m-d'); ?}" />
		<frm.formItem type="date" name="endStudyDate" label="Ngày dừng học" />
		<frm.formItem name="note" label="Ghi chú" />
		<frm.formItem name="color" label="Màu sắc" type="user-defined">
			<form.combobox name="color" layout="category-select-list" label="Màu sắc">
				<option value="">Bình thường</option>
				<option value="red">Đỏ</option>
				<option value="blue">Xanh da trời</option>
				<option value="green">Xanh lá cây</option>
				<option value="yellow">Vàng</option>
				<option value="purple">Tím</option>
				<option value="grey">Xám</option>
			</form.combobox>
		</frm.formItem>
		<frm.formItem name="fontStyle" label="Kiểu chữ" type="user-defined">
			<form.combobox name="fontStyle" layout="category-select-list" label="Kiểu chữ">
				<option value="">Bình thường</option>
				<option value="bold">Đậm</option>
				<option value="italic">Nghiêng</option>
				<option value="underline">Gạch chân</option>
			</form.combobox>
		</frm.formItem>
		<frm.formItem name="assignId" label="Người phụ trách" type="user-defined">
			<form.combobox label="Người phụ trách" name="assignId"
		sql="{teacher_sql}"
			layout="category-select-list"></form.combobox>
		</frm.formItem>
		<frm.formItem name="online" label="Học tại" type="user-defined">
			<form.combobox name="online" 
					layout="category-select-list" label="Học tại">
				<option value="">Học tại</option>
				<option value="0">Trung tâm</option>
				<option value="1">Trực tuyến</option>
			</form.combobox>
		</frm.formItem>
		<frm.formItem name="classed" label="Đã xếp lớp" type="user-defined">
			<form.combobox name="classed"
			layout="category-select-list" label="Trạng thái xếp lớp">
				<option value="1">Đã xếp lớp</option>
				<option value="0">Chờ xếp lớp</option>
				<option value="-1">Kiểm tra đầu vào</option>
			</form.combobox>
		</frm.formItem>
		<frm.formItem name="type" label="Phân loại" type="user-defined">
			<form.combobox name="type"
					layout="category-select-list" label="Phân loại">
				<option value="1">Đã học</option>
				<option value="0">Tiềm năng</option>
				<option value="2">Lâu năm</option>
			</form.combobox>
		</frm.formItem>
		<frm.formItem name="rating" label="Xếp hạng" type="user-defined">
			<form.combobox name="rating"
					layout="category-select-list" label="Xếp hạng">
				<option value="0">Chưa xếp hạng</option>
				<option value="1">Kém</option>
				<option value="2">Trung Bình</option>
				<option value="3">Khá</option>
				<option value="4">Giỏi</option>
				<option value="5">Xuất Sắc</option>
			</form.combobox>
		</frm.formItem>
		<frm.formItem name="status" label="Đã dừng học" type="user-defined">
			<form.combobox name="status"
					layout="category-select-list" label="Trạng thái học">
				<option value="1">Đang học</option>
				<option value="0">Dừng học</option>
			</form.combobox>
		</frm.formItem>
	</frm.form>
</wdw.dialog>
<!-- Hết dialog thêm sửa học sinh -->