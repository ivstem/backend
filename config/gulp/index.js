'use strict';

var args = require('minimist')(process.argv.slice(2));

module.exports = exports = {
	// client: require('./client'),
	site: require('./site'),

	outputDir: 'frontend/',

	proxy: {
		source: '/api',
		// target: 'http://192.168.1.153:8080',
		// target: 'http://django-slaawwa.c9.io',
		target: 'http://app.receiptattacher.com',
		// target: 'http://dev.receiptattacher.com',
		// cookies: {stripDomain: false},
	},

	// CONSTANTS
	ROOT: require('path').normalize(__dirname + '/../..'),
	VERSION: args.version || require('../../package.json').version,
	LR_PORT: args.port || args.p || 80,
	IS_DEV: args.dev,
	SHA: args.sha,
	ARGS: args
};
