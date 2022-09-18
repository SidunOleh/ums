<?php

// routes
return [    
	'/users/update/([0-9]+)' => 'user/update/$1',
	'/users/status/([0,1])'  => 'user/changeStatus/$1',
	'/users/delete'   => 'user/delete',
	'/users/create'   => 'user/create',
	'/users/([0-9]+)' => 'user/view/$1',
	'/' => 'user/viewAll',
];
