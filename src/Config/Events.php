<?php namespace Album\Config;

use Album\Controllers\Filters\RecordNotFound;
use CodeIgniter\Events\Events;

Events::on('pre_system', function () {
	$filters = service('filters');
	$filters->addFilter(RecordNotFound::class, 'recordNotFound');
});
