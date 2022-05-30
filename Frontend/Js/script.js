$(document).ready(function () {

	// confirmation
	let confirmCallback;

	$('.confirm-bttn').bind('click', function (e) {
		let value = $(this).attr('data-value');

		if (value == 'yes') {
			confirmCallback();
		}

		$('#confirm-modal').modal('hide');
	});

	// delete user
	$(document).on('click', '.bttn-delete', function (e) {
		let user   = $(this).closest('tr');
		let userId = user.attr('data-id');

		$('#confirm-modal').modal('show');

		confirmCallback = function () {
			$.ajax(`/users/delete/${userId}`, {
				type: 'GET',
				success: function (data) {
					data = JSON.parse(data);

					if (data.status) {
						user.remove();
						emptyTable();
					} else {
						let modal = $('#warn-modal');
						modal.find('.modal-body').text(data.error.message);
						modal.modal('show');
					}
				},
			});
		};
	});

	// checkboxes
	$(document).on('change', 'table input[type=checkbox]', function (e) {

		if ($(this).attr('id') == 'all-items') {
			$('table input[type=checkbox]').prop('checked', $(this).prop('checked'));
			return;
		}

		$('table input#all-items').prop('checked', false);
	});

	// select
	$('.bttn-select').bind('click', function (e) {
		let modal     = $('#warn-modal');
		let modalBody = modal.find('.modal-body');

		let users = $('tbody input[type=checkbox]:checked')
			.closest('tr');

		if (users.length == 0) {
			modalBody.text('Choose users!');
			modal.modal('show');
			return;
		}

		let select = $(this).closest('.cart-box').find('select');
		let action = select.val();

		if (action == null) {
			modalBody.text('Choose action!');
			modal.modal('show');
			return;
		}

		let usersIds = [];
		users.each(function (i, el) {
			usersIds[i] = $(el).attr('data-id');
		});

		$.ajax(`/users/${action}`, {
			type: 'POST',
			data: {
				users_ids: usersIds,
			},
			success: function (data) {
				data = JSON.parse(data);

				if (data.status) {
					let status = users.find('.user-active');

					switch (action) {
						case 'delete':
							users.remove();
							emptyTable();
						break;
						case 'activate':
							status.removeClass('not-active-circle');
							status.addClass('active-circle');
						break;
						case 'deactivate':
							status.removeClass('active-circle');
							status.addClass('not-active-circle');
						break;
					}
				} else {
					let modal = $('#warn-modal');
					modal.find('.modal-body').text(data.error.message);
					modal.modal('show');
				}
			},
		});
	});

	// add user
	$('.bttn-add').bind('click', function (e) {
		let modal = $('#user-form-modal');
		
		modal.find('.modal-title').text('Add a new user');
		modal.find('.errors').text('');
		modal.modal('show');

		let form = $('#user-form');
		
		form.attr('action', '/users/create');
		form.find('input[type=text]').val('');
		form.find('select').val('user');
		form.find('input[type=checkbox]').prop('checked', false);
	});

	// update user
	$(document).on('click', '.bttn-update', function (e) {
		let userId = $(this).closest('tr').attr('data-id');
		let user;
		
		$.ajax(`/users/${userId}`, {
			type: 'GET',
			async: false,
			success: function (data) {
				data = JSON.parse(data);

				if (! data.status) {
					let modal = $('#warn-modal');
					modal.find('.modal-body').text(data.error.message);
					modal.modal('show');
					return;
				}

				user = data.user;
			},
		});

		if (! user) {
			return;
		}

		let form = $('#user-form');
		
		form.attr('action', `/users/update/${userId}`);
		form.find('input#first-name').val(user.first_name);
		form.find('input#last-name').val(user.last_name);
		form.find('select').val(user.role);
		form.find('input#status').prop('checked', user.status == '1' ? true : false);

		let modal = $('#user-form-modal');
		
		modal.find('.modal-title').text('Update user');
		modal.find('.errors').text('');
		modal.modal('show');
	});

	// send user form
	$('.bttn-send').bind('click', function (e) {
		let modal = $('#user-form-modal');
		let form  = $('#user-form');
		let url   = $(form).attr('action');

		let user = {
		    first_name: form.find('input#first-name').val(),
    		last_name: form.find('input#last-name').val(),
    		role: form.find('select#role').val(),
    		status: form.find('input#status').prop('checked') ? 1 : 0,
		};

		$.ajax(url, {
			type: 'POST',
	        data: { user, },
			success: function (data) {
				data = JSON.parse(data);

				if (data.status) {
					if (url.match(/create/)) {

						user.id = data.id;

						if ((noUsers = $('.no-users')).length) {
							noUsers.replaceWith(userHtml(user))
						} else {
							$('tbody').prepend(userHtml(user));
						}
					} 

					if (id = url.match(/update\/([0-9]+)/)) {
						user.id = id[1];
						$(`tbody tr[data-id=${user.id}]`).replaceWith(userHtml(user));
					}

					modal.modal('hide');
				} else {
					let errors = '';

					errors += '<p class="error">' + data.error.message + '</p>';

					if (data = data.error.data) {
						for (error in data) {
							errors += '<p class="error">' +  data[error] + '</p>';
						}
					}

					modal.find('.errors').html(errors);
				}
			},
		});

	});

	// functions

	// returns user's data in html
	function userHtml(user) {
		return `<tr data-id="${user.id}">
                                
            <td class="align-middle">
              <div
                class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                <input type="checkbox" class="custom-control-input" id="item-${user.id}">
                <label class="custom-control-label" for="item-${user.id}"></label>
              </div>
            </td>
            
            <td class="text-nowrap align-middle">
              ${user.first_name + ' ' + user.last_name }
            </td>
            
            <td class="text-nowrap align-middle">
              <span>${user.role}</span>
            </td>
            
            <td class="text-center align-middle">
              <i class="user-active fa fa-circle ${!user.status ? 'not-' : ''}active-circle"></i>
            </td>
            
            <td class="text-center align-middle">
              <div class="btn-group align-top">
                <button class="btn btn-sm btn-outline-secondary badge bttn-update" type="button">Edit</button>
                <button class="btn btn-sm btn-outline-secondary badge bttn-delete" type="button">
                  <i class="fa fa-trash"></i>
                </button>
              </div>
            </td>
          
          </tr>`;
	}

	// empty table
	function emptyTable() {
		let users = $('tbody tr');

		if (users.length == 0) {
			$('tbody').prepend('<tr class="no-users"><td colspan="5" class="h4">No Users</td></tr>');
		}
	}

});
