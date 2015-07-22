/**
 * Gulp modules
 */
var gulp        = require('gulp'),
    concat      = require('gulp-concat-css'),
    minify      = require('gulp-minify-css'),
    rename      = require('gulp-rename'),
    uglify      = require('gulp-uglifyjs'),
    jscpd       = require('gulp-jscpd'),
    gulpif      = require('gulp-if');

/**
 * Build environment
 */
var env = process.env.NODE_ENV;

/**
 * Build params
 */
var build = {
    destination : {
        sources : './build/src/',
        spec    : './build/spec/'
    },
    tpl : {
        app         : './app/**/*.js',
        tests       : './tests/**/*.js',
        plugins     : './plugins/**/*.min.js',
        styles      : './assets/styles/*.css'
    },
    min : {
        app : 'app.min.js',
        tests : 'spec.min.js',
        plugins : 'plugins.min.js',
        styles : 'styles.min.css',
        stylesc: 'styles.css'
    }

};

// Add task by default. Required always!
gulp.task('default', function() {

    // run all tasks
    gulp.start('app', 'plugins', 'tests', 'styles');

    // watch changes above tests
    gulp.watch([
        build.tpl.app,
        build.tpl.tests,
        build.tpl.plugins,
        build.tpl.styles
    ], function() {
        // rebuild watching tasks
        gulp.start('app', 'tests', 'styles');

    });
});

// Build app
gulp.task('app', function() {

    return gulp.src(build.tpl.app)
        .pipe(jscpd({
                  'min-lines': 10,
                  verbose    : true
              }))
        .pipe(gulpif(env === 'production', uglify(build.min.app, {
                  outSourceMap: true
              })))
        .pipe(gulp.dest(build.destination.sources));
});

// Build tests
gulp.task('tests', function() {

    return gulp.src(build.tpl.tests)
        .pipe(jscpd({
                  'min-lines': 10,
                  verbose    : true
              }))
        .pipe(gulpif(env === 'production', uglify(build.min.tests, {
                  outSourceMap: true
              })))
        .pipe(gulp.dest(build.destination.spec));
});

// Build plugins
gulp.task('plugins', function() {

    return gulp.src(build.tpl.plugins)
        .pipe(gulpif(env === 'production', uglify(build.min.plugins, {
                  outSourceMap: true
              })))
        .pipe(gulp.dest(build.destination.sources));
});

// Build styles
gulp.task('styles', function () {
    return gulp.src(build.tpl.styles)
        .pipe(concat(build.min.stylesc))
        .pipe(minify())
        .pipe(rename(build.min.styles))
        .pipe(gulp.dest(build.destination.sources));
});