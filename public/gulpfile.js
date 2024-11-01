var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var minify = require('gulp-minify');

gulp.task('sass', function () {
  return gulp.src('dev-css/wfw-public.scss')
  .pipe(sourcemaps.init())
  .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('css/'));
});

gulp.task('js', function() {
    return gulp.src('dev-js/*.js')
        .pipe(minify({
              ext: {
                   min:'.min.js'
              },
              noSource: true
            }))
        .pipe(gulp.dest('js/'));
});
