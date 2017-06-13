'use strict';

var gulp = require('gulp'),
	path = require('path'),
	$ = require('gulp-load-plugins')(),
	/*pug = require('gulp-pug'),
	concat = require('gulp-concat'),
	header = require('gulp-header'),
	footer = require('gulp-footer'),
	uglify = require('gulp-uglify'),
	htmlmin = require('gulp-htmlmin'),
	ngtemplate = require('gulp-ngtemplate'),*/
	config = require('../../config/gulp');

exports.task = function() {
	
	gulp.src(['src/\.htaccess'])
		.pipe(gulp.dest(config.outputDir));
	
	gulp.src(config.site.pages)
		.pipe($.plumber())
		.pipe($.pug({
			locals: {
				VERSION: config.VERSION,
				IS_DEV: config.IS_DEV
			},
			pretty: true
		}))
		.pipe($.htmlmin({
			removeComments: true,
			collapseWhitespace: true
		}))
		.pipe(gulp.dest(config.outputDir));


	gulp.src(config.site.pagesExtraSrc)
		.pipe($.plumber())
		.pipe($.pug({
			locals: {
				VERSION: config.VERSION,
				IS_DEV: config.IS_DEV
			},
			pretty: true
		}))
		.pipe($.htmlmin({
			removeComments: true,
			collapseWhitespace: true
		}))
		.pipe(gulp.dest(path.join(
			config.outputDir,
			config.site.pagesExtraPath
		)));

	return gulp.src(config.site.pagesTmpl)
		.pipe($.plumber())
		.pipe($.pug({
			locals: {
				VERSION: config.VERSION,
				IS_DEV: config.IS_DEV
			},
			pretty: true
		}))
		.pipe($.htmlmin({
			removeComments: true,
			collapseWhitespace: true
		}))
		.pipe($.ngtemplate({
			// pathPrefix: '/' + config.site.pagesBase + '/',
			header: '',
			footer: '',
			useStrict: false
		}))
		.pipe($.concat('app-templates.js'))
		.pipe($.header('"use strict";\nangular.module("' + config.site.appTmplModule + '",[]).run(["$templateCache",function($templateCache){\n'))
		.pipe($.footer('\n}]);'))
		.pipe($.uglify())
		.pipe(gulp.dest(path.join(
			config.outputDir,
			config.site.jsBase
		)));
};

exports.watch = config.site.pagesWatch;
