'use strict';

var path = require('path'),
	gulp = require('gulp'),
	config = require('../../config/gulp');

exports.task = function() {
	return gulp.src(config.site.fonts)
		.pipe(gulp.dest(path.join(
			config.outputDir,
			config.site.fontsBase
		)));
};

exports.watch = config.site.fonts;
