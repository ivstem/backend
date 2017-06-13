'use strict';

var runSequence = require('run-sequence');

exports.task = function(callback) {
	return runSequence(
		'clean',
		[
			'watch',
			'build'
		],
        // 'server',
		callback
	);
};
