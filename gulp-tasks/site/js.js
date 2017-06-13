'use strict';

var path = require('path'),
	gulp = require('gulp'),
	$ = require('gulp-load-plugins')(),
	/*babel = require('gulp-babel'),
	concat = require('gulp-concat'),
	header = require('gulp-header'),
	footer = require('gulp-footer'),
	uglify = require('gulp-uglify'),
	replace = require('gulp-replace'),
	sourcemaps = require('gulp-sourcemaps'),
	ngAnnotate = require('gulp-ng-annotate'),*/
	config = require('../../config/gulp');

exports.task = function() {
	// Single js
	gulp.src(config.site.js)
		.pipe($.plumber())
		.pipe($.sourcemaps.init())
		.pipe($.babel({
			presets: ['es2015']
		}))
		.pipe($.replace(/('use strict'|"use strict");?/g, '$1'))
		// .pipe(concat('bundle.js'))
		.pipe($.ngAnnotate({
			single_quotes: true
		}))
		.pipe($.header('(function(window,document,undefined){\n"use strict";\n'))
		.pipe($.footer('\n})(window,document);\n'))
		.pipe($.uglify())
		.pipe($.sourcemaps.write('/'))
		.pipe(gulp.dest(path.join(
			config.outputDir,
			config.site.jsBase
		)));

	// Bundle js
	gulp.src(config.site.jsBundle)
		.pipe($.plumber())
		.pipe($.sourcemaps.init())
		.pipe($.babel({
			presets: ['es2015']
		}))
		// .pipe($.replace(/('use strict'|"use strict");?/g, '$1'))
		.pipe($.concat('bundle.js'))
		.pipe($.ngAnnotate({
			single_quotes: true
		}))
		// .pipe($.header('(function(window,document){\n"use strict";\n'))
		// .pipe($.footer('\n})(window,document);\n'))
		.pipe($.uglify())
		.pipe($.sourcemaps.write('/'))
		.pipe(gulp.dest(path.join(
			config.outputDir,
			config.site.jsBase
		)));

	// Libraries bundle js
	return gulp.src(config.site.jsBundleLib)
		.pipe($.plumber())
		.pipe($.sourcemaps.init())
		.pipe($.concat('bundleLib.js'))
		.pipe($.ngAnnotate({
			single_quotes: true
		}))
		.pipe($.uglify())
		.pipe($.sourcemaps.write('/'))
		.pipe(gulp.dest(path.join(
			config.outputDir,
			config.site.jsBase
		)));
};

exports.watch = config.site.jsBundle;
