<?php

// routes
return [    
	'/users/update/([0-9]+)' => 'user/update/$1',
	'/users/delete/([0-9]+)' => 'user/delete/$1',
	'/users/activate'   => 'user/activateGroup',
	'/users/deactivate' => 'user/deactivateGroup',
	'/users/delete'   => 'user/deleteGroup',
	'/users/create'   => 'user/create',
	'/users/([0-9]+)' => 'user/view/$1',
	'/' => 'user/viewAll',
];
