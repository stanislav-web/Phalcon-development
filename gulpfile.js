var gulp        = require('gulp'),
    concat      = require('gulp-concat-css'),
    minify      = require('gulp-minify-css'),
    notify      = require('gulp-notify'),
    rename      = require('gulp-rename'),
    uglify      = require('gulp-uglifyjs');

gulp.task('default', ['css', 'js']);

gulp.task('css', function () {
    return gulp.src('assets/**/*.css')
        .pipe(concat("styles.css"))
        .pipe(minify())
        .pipe(rename("styles.min.css"))
        .pipe(gulp.dest('assets/phl/'))
        .pipe(notify('Done!'));
});

gulp.task('js', function () {
    return gulp.src(['assets/phl/js/*.js', 'assets/phl/app/*.js'])
        .pipe(uglify('app.min.js', {
            outSourceMap: true
        }))
        .pipe(gulp.dest('assets/phl/'))
        .pipe(notify('Done!'));
});

gulp.task('watch', function () {
    // watch files inside and run default
    gulp.watch('assets/**/*.css', ['css']);
    gulp.watch(['assets/phl/js/*.js', 'assets/phl/app/*.js'], ['js']);
});