'use strict';

var gulp   = require('gulp');
var watch  = require('gulp-watch');
var concat = require('gulp-concat');
var sass   = require('gulp-sass');
var rename = require('gulp-rename');

var paths = {
	scss_backend: [ 'core/assets/css/scss/**/*.scss', 'core/assets/css/' ],
	frontend_js: ['core/assets/js/init.js', '**/*.frontend.js'],
	all_js: ['core/assets/js/init.js', '**/*.backend.js'],
};

gulp.task('build_scss_backend', function () {
	return gulp.src(paths.scss_backend[0])
		.pipe( sass.sync().on( 'error', sass.logError ) )
		.pipe( gulp.dest( paths.scss_backend[1] ) )
		.pipe( sass.sync({outputStyle: 'compressed'}).on( 'error', sass.logError ) )
		.pipe( rename( './style.min.css' ) )
		.pipe( gulp.dest( paths.scss_backend[1] ) );
});

gulp.task('build_scss_backend_min', function () {
	return gulp.src(paths.scss_backend[0])
		.pipe( sass.sync({outputStyle: 'compressed'}).on( 'error', sass.logError ) )
		.pipe( gulp.dest( paths.scss_backend[1] ) );
});


gulp.task('js', function () {
	return gulp.src(paths.all_js)
		.pipe(concat('backend.min.js'))
		.pipe(gulp.dest('core/assets/js/'))
})

gulp.task('js_frontend', function () {
	return gulp.src(paths.frontend_js)
		.pipe(concat('frontend.min.js'))
		.pipe(gulp.dest('core/assets/js/'))
})

gulp.task('default', function () {
	gulp.watch(paths.scss_backend[0], gulp.series("build_scss_backend"));
	// gulp.watch(paths.scss_backend[0], gulp.series("build_scss_backend_min"));
	gulp.watch(paths.all_js, gulp.series("js"));
	gulp.watch(paths.frontend_js, gulp.series("js_frontend"));
});
