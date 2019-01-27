<div ng-app="erpApp" ng-controller="phanquyenController">
	<h2>Các kiểu nhân viên</h2>
	<ul>
		<li ng-repeat="item in staffTypes"><a href="javascript:void(0)" ng-click="selectStaffType(item)"><% item.PAR_NAME %></a></li>
	</ul>
	<h2>Các phòng ban</h2>
	<ul>
		<li ng-repeat="item in departments"><a href="javascript:void(0)" ng-click="selectDepartment(item)"><% item.NAME %></a></li>
	</ul>
	<div ng-show="mode==''">
	<h2>Danh sách nhân viên</h2>
	<ul>
		<li ng-repeat="staff in staffs"><a href="javascript:void(0)" ng-click="editStaff(staff)"><% staff.NAME%> - <% staff.CODE%> - <% staff.BIRTH_DATE%> - <% staff.EMAIL%> - <% staff.TEL_NUMBER%></a></li>
		<li><a href="javascript:void(0)" ng-click="addStaff()">Tạo nhân viên mới</a></li>
	</ul>
	</div>

	<div>
		<div  ng-show="mode=='editStaff'">
			<h2>Sửa nhân viên</h2>
			<div class="row">
				<div class="form-group col-md-3">
					<label>Ngày sinh: </label>
					<input class="form-control" ng-model="selectedStaff.BIRTH_DATE" />
				</div>
				<div class="form-group col-md-3">
					<label>Tên đăng nhập: </label>
					<input class="form-control" ng-model="selectedStaff.CODE" />
				</div>
				<div class="form-group col-md-3">
					<label>Phòng ban: </label>
					<input class="form-control" ng-model="selectedStaff.DEPT_ID" />
				</div>
				<div class="form-group col-md-3">
					<label>Email: </label>
					<input class="form-control" ng-model="selectedStaff.EMAIL" />
				</div>
				<div class="form-group col-md-3">
					<label>Họ tên: </label>
					<input class="form-control" ng-model="selectedStaff.NAME" />
				</div>
				<div class="form-group col-md-3">
					<label>Mã thẻ: </label>
					<input class="form-control" ng-model="selectedStaff.CARD_NO" />
				</div>
				<div class="form-group col-md-3">
					<label>Loại nhân viên: </label>
					<input class="form-control" ng-model="selectedStaff.STAFF_TYPE" />
				</div>
				<div class="form-group col-md-3">
					<label>Trạng thái: </label>
					<input class="form-control" ng-model="selectedStaff.STATUS" />
				</div>
				<div class="form-group col-md-3">
					<label>Số điện thoại: </label>
					<input class="form-control" ng-model="selectedStaff.TEL_NUMBER" />
				</div>
				<div class="form-group col-md-3">
					<label>Ngày vào công ty: </label>
					<input class="form-control" ng-model="selectedStaff.JOIN_DATE" />
				</div>
				<div class="form-group col-md-3">
					<label>Ngày rời công ty: </label>
					<input class="form-control" ng-model="selectedStaff.OUT_DATE" />
				</div>
			</div>
			<div>
				<button ng-click="updateStaff()" class="btn btn-primary">Cập nhật</button>
				<button ng-click="mode=''" class="btn btn-secondary">Hủy</button>
			</div>
		</div>

		<div  ng-show="mode=='addStaff'">
			<h2>Tạo nhân viên</h2>
			<div class="row">
				<div class="form-group col-md-3">
					<label>Ngày sinh: </label>
					<input class="form-control" ng-model="newStaff.BIRTH_DATE" />
				</div>
				<div class="form-group col-md-3">
					<label>Tên đăng nhập: </label>
					<input class="form-control" ng-model="newStaff.CODE" />
				</div>
				<div class="form-group col-md-3">
					<label>Phòng ban: </label>
					<input class="form-control" ng-model="newStaff.DEPT_ID" />
				</div>
				<div class="form-group col-md-3">
					<label>Email: </label>
					<input class="form-control" ng-model="newStaff.EMAIL" />
				</div>
				<div class="form-group col-md-3">
					<label>Họ tên: </label>
					<input class="form-control" ng-model="newStaff.NAME" />
				</div>
				<div class="form-group col-md-3">
					<label>Mã thẻ: </label>
					<input class="form-control" ng-model="newStaff.CARD_NO" />
				</div>
				<div class="form-group col-md-3">
					<label>Loại nhân viên: </label>
					<input class="form-control" ng-model="newStaff.STAFF_TYPE" />
				</div>
				<div class="form-group col-md-3">
					<label>Trạng thái: </label>
					<input class="form-control" ng-model="newStaff.STATUS" />
				</div>
				<div class="form-group col-md-3">
					<label>Số điện thoại: </label>
					<input class="form-control" ng-model="newStaff.TEL_NUMBER" />
				</div>
				<div class="form-group col-md-3">
					<label>Ngày vào công ty: </label>
					<input class="form-control" ng-model="newStaff.JOIN_DATE" />
				</div>
				<div class="form-group col-md-3">
					<label>Ngày rời công ty: </label>
					<input class="form-control" ng-model="newStaff.OUT_DATE" />
				</div>
			</div>
			<div>
				<button ng-click="insertStaff()" class="btn btn-primary">Thêm mới</button>
				<button ng-click="mode=''" class="btn btn-secondary">Hủy</button>
			</div>
		</div>
	</div>
</div>