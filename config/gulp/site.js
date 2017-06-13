'use strict';

var s = {
	// Pages
	pages: {
		src: [
			'src/pug/page/**/*.pug',
			// '!src/@(admin|client|layout)/**/*.pug' // ??????
		],
		base: 'pug',
		appTmplModule: 'app-templates',
		srcTmpl: [
			'src/pug/ngPage/**/*.pug',
		],
		watch: [
			'src/pug/**/*.pug',
		],

		extraSrc: 'src/pug/extra/**/*.pug',
		extraPath: 'extra',
	},

	// Js
	js: {
		base: 'js',

		// Single script
		src: [
			'src/static/js/*.js',
			'!src/static/js/bundle/**/*.js',
		],
		// Custom script who use all time
		srcBundle: [
			'src/static/js/bundle/**/*.js',
		],
		// Libs scripts
		srcBundleLib: [
			// jQuery
			'src/static/lib/jquery/dist/jquery.min.js',
			// Bootstrap
			'src/static/lib/bootstrap/dist/js/bootstrap.min.js',
			// Angular
			'src/static/lib/angular/angular.js',
			'src/static/lib/angular-animate/angular-animate.js',
			'src/static/lib/angular-aria/angular-aria.js',
			'src/static/lib/angular-bootstrap/ui-bootstrap-tpls.js',
			'src/static/lib/angular-cookies/angular-cookies.js',
			'src/static/lib/angular-resource/angular-resource.js',
			'src/static/lib/angular-route/angular-route.js',
		],
		watch: [
			'src/static/js/**/*.js'
		]
	},

	// Styles
	styles: {
		base: 'css',
		src: [
			'src/less/*.less',
			'!src/less/main.less',
			'!src/less/template/**/*.less',
			'!src/less/include/**/*.less'
		],

		// Bundle to main.css
		srcBundle: [
			'src/less/main.less',
			'src/less/template/**/*.less',
			//'src/less/ngHome/**/*.less',
			//'src/less/ngClient/**/*.less',
		],
		watch: [
			'src/less/**/*.less',
		]
	},

	// Fonts
	fonts: {
		src: [
			'bower_components/bootstrap/fonts/**',
			'bower_components/font-awesome/fonts/**',
			'bower_components/Ionicons/fonts/**',
			'bower_components/material-design-iconic-font/dist/fonts/**',
			'bower_components/themify-icons/fonts/**'
		],
		base: 'fonts',
	},
	image: {
		base: 'img',
		src: [
			'src/img/*.@(png|jpg|gif|svg|ico)'
		],
		watch: [
			'src/img/*.@(png|jpg|gif|svg|ico)'
		]
	}
}

module.exports = exports = {
	// Pages
	pagesBase: 		s.pages.base,
	appTmplModule:	s.pages.appTmplModule,
	pages: 			s.pages.src,
	pagesTmpl: 		s.pages.srcTmpl,
	pagesWatch: 	s.pages.watch,
	pagesExtraSrc: 	s.pages.extraSrc,
	pagesExtraPath: s.pages.extraPath,

	// Js
	jsBase: 		s.js.base,
	js: 			s.js.src,
	jsBundle:		s.js.srcBundle,
	jsBundleLib:	s.js.srcBundleLib,
	jsWatch:		s.js.watch,

	// Styles
	stylesBase:		s.styles.base,
	styles: 		s.styles.src,
	stylesBundle: 	s.styles.srcBundle,
	stylesWatch: 	s.styles.watch,

	// Fonts
	fonts: 			s.fonts.src,
	fontsBase:		s.fonts.base,

	// Image
	imageBase:		s.image.base,
	image:			s.image.src,
	imageWatch:		s.image.watch,
};
