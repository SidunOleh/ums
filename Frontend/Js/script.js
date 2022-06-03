$(document).ready(function () {

	// modal windows
	let confirm     = $('#confirm-modal');
	let confirmBody = confirm.find('.modal-body');
	
	let warn        = $('#warn-modal');
	let warnBody    = warn.find('.modal-body');
	
	let userModal   = $('#user-form-modal');
	let userTitle   = userModal.find('.modal-title');
	let userErrors  = userModal.find('.errors');
	let userForm    = userModal.find('#user-form');

	// confirmation
	let confirmCallback;

	$('.confirm-bttn').bind('click', function (e) {
		let value = $(this).attr('data-value');

		if (value == 'yes') {
			confirmCallback();
		}

		confirm.modal('hide');
	});

	// delete user
	$(document).on('click', '.bttn-delete', function (e) {
		let user     = $(this).closest('tr');
		let userName = user.find('.user-name').text();
		let userId   = user.attr('data-id');

    confirmBody.text(`Are you sure to delete ${userName}?`);
		confirm.modal('show');

		confirmCallback = function () {
			$.ajax(`/users/delete/${userId}`, {
				type: 'POST',
				success: function (data) {
					data = JSON.parse(data);

					if (! data.status) {
						warnBody.text(data.error.message);
						warn.modal('show');
						return;
					}

					user.remove();
					noUsers();
				},
			});
		};
	});

	// checkboxes
	$(document).on('change', 'table input[type=checkbox]', function (e) {
		let current = $(this);

		if (current.attr('id') == 'all-items') {
			$('table input[type=checkbox]').prop('checked', current.prop('checked'));
		} else {
			$('table input[type=checkbox]#all-items').prop('checked', false);
		}
	});

	// group requests
	$('.bttn-select').bind('click', function (e) {
		let users    = $('tbody input[type=checkbox]:checked').closest('tr');
		let usersIds = jQuery.map(users, (user) => $(user).attr('data-id'));

		if (usersIds.length == 0) {
			warnBody.text('Choose users !');
			warn.modal('show');
			return;
		}

		let select = $(this).closest('.cart-box').find('select');
		let action = select.val();

		if (action == null) {
			warnBody.text('Choose action !');
			warn.modal('show');
			return;
		}
		
    let groupRequest = function () {
    	$.ajax(`/users/${action}`, {
    		type: 'POST',
    		data: { users_ids: usersIds, },
    		success: function (data) {
    			data = JSON.parse(data);
    
    			if (! data.status) {
    				warnBody.text(data.error.message);
    				warn.modal('show');
    				return;
    			}

    			let status = users.find('.user-status');
    
  				switch (action) {
  					case 'delete':
  						users.remove();
  						noUsers();
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

  				$('table input[type=checkbox]').prop('checked', false);
  			},
    	});
    };
    
    if (action != 'delete') {
    	groupRequest();
	    return;
	  }

    confirmCallback = groupRequest;
  	
  	confirmBody.text('Are you sure to delete selected users ?');
    confirm.modal('show');
	});

	// add user form
	$('.bttn-add').bind('click', function (e) {		
		userTitle.text('Add a new user');
		userErrors.text('');

		userForm.attr('action', '/users/create');
		userForm.attr('data-action', 'create');
		userForm.find('input[type=text]').val('');
		userForm.find('select').val('user');
		userForm.find('input[type=checkbox]').prop('checked', false);

		userModal.modal('show');
	});

	// update user form
	$(document).on('click', '.bttn-update', function (e) {
		let userId = $(this).closest('tr').attr('data-id');
		
		let user;
		$.ajax(`/users/${userId}`, {
			type: 'GET',
			async: false,
			success: function (data) {
				data = JSON.parse(data);

				if (! data.status) {
					warnBody.text(data.error.message);
					warn.modal('show');
					return;
				}

				user = data.user;
			},
		});

		if (user == null) {
			return;
		}
		
		userForm.attr('action', `/users/update/${user.id}`);
		userForm.attr('data-action', 'update');
		userForm.find('#first-name').val(user.first_name);
		userForm.find('#last-name').val(user.last_name);
		userForm.find('#role').val(user.role);
		userForm.find('#status').prop('checked', user.status != '0' ? true : false);
		
		userTitle.text('Update user');
		userErrors.text('');
		userModal.modal('show');
	});

	// send user form
	$('.bttn-send').bind('click', function (e) {
		let url    = userForm.attr('action');
		let action = userForm.attr('data-action');
		let user   = {
		    first_name: userForm.find('#first-name').val(),
    		last_name: userForm.find('#last-name').val(),
    		role: userForm.find('#role').val(),
    		status: userForm.find('#status').prop('checked') ? 1 : 0,
		};

		$.ajax(url, {
			type: 'POST',
	    data: { user: user, },
			success: function (data) {
				data = JSON.parse(data);

				if (! data.status) {
					let errors = '';

					errors += '<p class="error">' + data.error.message + '</p>';

					if (data.error.data) {
							Object.values(data.error.data).forEach(function (error) {
								errors += '<p class="error">' + error + '</p>';
							});
					}

					userErrors.html(errors);
					return;
				}

				if (action == 'create') {
					user.id = data.id;
					
					$('tbody').append(userHtml(user));
					noUsers();
				} 

				if (action == 'update') {
					user.id = url.match(/update\/([0-9]+)/)[1];
					
					$(`tbody tr[data-id=${user.id}]`).replaceWith(userHtml(user));
				}

				userModal.modal('hide');
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
            
            <td class="text-nowrap align-middle user-name">
              ${user.first_name + ' ' + user.last_name }
            </td>
            
            <td class="text-nowrap align-middle">
              <span>${user.role}</span>
            </td>
            
            <td class="text-center align-middle">
              <i class="user-status fa fa-circle ${!user.status ? 'not-' : ''}active-circle"></i>
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

	// no users tabel row
	function noUsers() {
		let users = $('tbody tr').not('.no-users');

		if (users.length == 0) {
			$('tbody').prepend('<tr class="no-users"><td colspan="5" class="h4">No Users</td></tr>');
		} else {
			$('.no-users').remove();
		}
	}

});
