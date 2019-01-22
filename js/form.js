PzkForm = PzkObj.pzkExt({
	init: function() {
		var self = this;
		this.$().submit(function(evt) {
			var $form = $(evt.target);
			var data = $form.serializeForm();
			self.execute(data.task, data);
			return false;
		});

		if (this.controller) {
			eval('this.controller = new Pzk' + this.controller.ucfirst() + 'Controller();' );
			this.controller.form = this;
		}
	},
	doAdd: function(data) {
		pzk.elements.admin.loadMode('add');
		return false;
	},
	doEdit: function(data) {
		if (typeof data.ids != 'undefined') {
			for(var id in data.ids) {
				data.id = id;
				data.element = 'editForm';
				pzk.elements.admin.loadMode('edit', data);
				break;
			}
		}
		return false;
	},
	doDelete: function(data) {
		if (typeof data.ids != 'undefined' && confirm('Are you sure you want to delete?')) {
			data.element = 'deleteForm';
			data.task = 'Submit';
			pzk.elements.admin.loadMode('delete', data);
		}
		return false;
	},
	doSubmit: function(data) {
		var self = this;
		if (this.controller) {
			if (this.task) {
				if (this.controller[this.task](data, function(){
					if (self.redirect) {
						window.location = '/' + self.redirect + '.html'; 
					}
				})) {
					this.submitted = true;
				}
			}
		}
		return false;
	},
	doRefresh: function(data) {
		pzk.elements.admin.loadMode(null, {});
		return false;
	},
	doCancel: function(data) {
		pzk.elements.admin.loadMode('list', {});
	},
	doSearch: function(data) {
		pzk.elements.list.filters = data.filters;
		pzk.elements.list.refresh();
	}
});