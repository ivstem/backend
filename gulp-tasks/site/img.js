'use strict';

var gulp = require('gulp'),
	path = require('path'),
	$ = require('gulp-load-plugins'),
	// imagemin = require('gulp-imagemin'),
	config = require('../../config/gulp');

exports.task = function() {
	return gulp.src(config.site.image)
		.pipe($.imagemin())
		.pipe(gulp.dest(path.join(
			config.outputDir,
			config.site.imageBase
		)));
};

exports.watch = config.site.watch;
