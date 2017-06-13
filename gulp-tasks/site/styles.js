'use strict';

var gulp = require('gulp'),
	$ = require('gulp-load-plugins'),
	/*less = require('gulp-less'),
	concat = require('gulp-concat'),
	cleanCSS = require('gulp-clean-css'),
	sourcemaps = require('gulp-sourcemaps'),*/
	/*browserSync = require('../server').browserSync,*/
	config = require('../../config/gulp');

exports.task = function() {
	gulp.src(config.site.stylesBundle)
		.pipe($.sourcemaps.init())
		.pipe($.less({
			paths: [
				'src/less/include'
			]
		}))
		.pipe($.concat('main.css'))
		.pipe($.cleanCss())
		.pipe($.sourcemaps.write('/'))
		.pipe(gulp.dest(config.outputDir+'css'))
		// .pipe(browserSync.stream({
		// 	match: '**/*.css'
		// }));

	return gulp.src(config.site.styles)
		.pipe($.sourcemaps.init())
		.pipe($.less())
		// .pipe(concat('styles.css'))
		.pipe($.cleanCss())
		.pipe($.sourcemaps.write('/'))
		.pipe(gulp.dest(config.outputDir+'css'))
		// .pipe(browserSync.stream({
		// 	match: '**/*.css'
		// }));

};

exports.watch = config.site.stylesWatch;
