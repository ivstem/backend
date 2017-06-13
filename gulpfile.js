'use strict';

// Require modules
var gulp = require('gulp'),
	fs = require('fs');

// Define constants
const JS_REGEXP = /\.js$/i,
	SLASH_GLOBAL_REGEXP = /[\/\\]/g;

function getWatchFunction(path, triggerTasks) {
	return function() {
		return gulp.watch(path, triggerTasks);
	};
}

// Create tasks for gulp
(function getJsRecursive(base, files) {
	return fs
		.readdirSync('./gulp-tasks/' + base)
		.reduce(function(files, element) {
			if (JS_REGEXP.test(element)) {
				files.push(base + element);
			}
			else {
				getJsRecursive(base + element + '/', files);
			}
			return files;
		}, files);
})('', []).forEach(function(path) {
	var contents = require('./gulp-tasks/' + path),
		watchTask = contents.watch,
		name = path
			.substr(0, path.length - 3)
			.replace(SLASH_GLOBAL_REGEXP, '-');

	gulp.task(name, contents.dependencies, contents.task);
	if (watchTask) {
		if (typeof watchTask !== 'function') {
			watchTask = getWatchFunction(watchTask, contents.watchTasks || [name]);
		}
		gulp.task(
			name + '-watch',
			contents.watchDependencies,
			watchTask
		)
	}
});
