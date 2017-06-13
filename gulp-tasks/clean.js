'use strict';

var del = require('del'),
	config = require('../config/gulp');

exports.task = function(callback) {
	del([config.outputDir + '**']).then(function() {
		callback();
	}, callback);
};
