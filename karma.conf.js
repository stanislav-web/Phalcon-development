// Karma configuration
// Generated on Tue Jul 14 2015 23:10:33 GMT+0300 (MSK)

module.exports = function(config) {

  'use strict';

  config.set({

    // base path that will be used to resolve all patterns (eg. files, exclude)
    basePath: '',

    // plugins to use

    plugins: [
      'karma-chrome-launcher',
      'karma-firefox-launcher',
      'karma-phantomjs-launcher',
      'karma-coverage',
      'karma-htmlfile-reporter',
      'karma-jasmine',
      'karma-json-reporter'
    ],

    // frameworks to use
    // available frameworks: https://npmjs.org/browse/keyword/karma-adapter
    frameworks: ['jasmine'],


    // list of files / patterns to load in the browser
    files: [
      './build/src/*.js',
      './build/spec/*.js'
    ],

    // list of files to exclude
    exclude: [
    ],


    // preprocess matching files before serving them to the browser
    // available preprocessors: https://npmjs.org/browse/keyword/karma-preprocessor
    preprocessors: {
      './build/src/*.js' : ['coverage']
    },

    // test results reporter to use
    // possible values: 'dots', 'progress'
    // available reporters: https://npmjs.org/browse/keyword/karma-reporter
    reporters: ['progress', 'coverage',  'html', 'json'],

    // HTML reports configuration
    htmlReporter: {
      outputFile: './build/reports/report.html', // where to put the reports
      pageTitle: 'Karma Unit testing', // page title for reports; browser info by default
      subPageTitle: 'Frontend'
    },

    // JSON file reporters
    jsonReporter: {
      stdout: false,
      outputFile: './build/reports/report.json' // defaults to none
    },

    // web server port
    port: 9876,

    // web server host
    hostname: 'frontend.local',

    // enable / disable colors in the output (reporters and logs)
    colors: true,

    // level of logging
    // possible values: config.LOG_DISABLE || config.LOG_ERROR || config.LOG_WARN || config.LOG_INFO || config.LOG_DEBUG
    logLevel: config.LOG_INFO,

    // enable / disable watching file and executing tests whenever any file changes
    autoWatch: true,

    // start these browsers
    // available browser launchers: https://npmjs.org/browse/keyword/karma-launcher
    browsers: ['Chrome', 'Firefox', 'PhantomJS'],

    phantomjsLauncher: {
      // Have phantomjs exit if a ResourceError is encountered (useful if karma exits without killing phantom)
      exitOnResourceError: true
    },

    // Continuous Integration mode
    // if true, Karma captures browsers, runs the tests and exits
    singleRun: false
  });
};