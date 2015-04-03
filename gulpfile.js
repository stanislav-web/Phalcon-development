var gulp        = require('gulp'),
    concat      = require('gulp-concat-css'),
    minify      = require('gulp-minify-css'),
    notify      = require('gulp-notify')
    rename      = require('gulp-rename');

gulp.task('default', function () {
    return gulp.src('assets/**/*.css')
        .pipe(concat("styles.css"))
        .pipe(minify())
        .pipe(rename("styles.min.css"))
        .pipe(gulp.dest('assets/phl/'))
        .pipe(notify('Done!'));
});

gulp.task('watch', function () {
    // watch files inside and run default
    gulp.watch('assets/**/*.css', ['default']);
});