/**
 * Gulp File by dorzki
 */

// Gulp Libraries
var gulp = require( 'gulp' );
var autoprefixer = require( 'gulp-autoprefixer' );
var scss = require( 'gulp-sass' );
var concat = require( 'gulp-concat' );
var sourcemaps = require( 'gulp-sourcemaps' );
var uglify = require( 'gulp-uglify' );
var plumber = require( 'gulp-plumber' );

// File Paths
var SCSS_PATH = 'src/scss/*.scss';
var JS_PATH = 'src/js/*.js';
var DIST = 'assets/';

// Gulp Tasks
gulp.task( 'scss', function () {

	var task;

	console.log( '### Starting SCSS Task ###' );

	task = gulp
		.src( SCSS_PATH )
		.pipe( plumber( function ( err ) {

			console.log( '! ERROR !' );
			console.log( err );

			this.emit( 'end' );

		} ) )
		.pipe( sourcemaps.init() )
		.pipe( autoprefixer() )
		.pipe( scss( {
			outputStyle: 'compressed'
		} ) )
		.pipe( concat( 'admin-styles.min.css' ) )
		.pipe( sourcemaps.write( './' ) )
		.pipe( gulp.dest( DIST ) );

	console.log( '### Finished SCSS Task ###' );

	return task;

} );

gulp.task( 'js', function () {

	var task;

	console.log( '### Starting JS Task ###' );

	task = gulp
		.src( JS_PATH )
		.pipe( plumber( function ( err ) {

			console.log( '! ERROR !' );
			console.log( err );

			this.emit( 'end' );

		} ) )
		.pipe( sourcemaps.init() )
		.pipe( uglify() )
		.pipe( concat( 'admin-scripts.min.js' ) )
		.pipe( sourcemaps.write( './' ) )
		.pipe( gulp.dest( DIST ) );

	console.log( '### Finished JS Task ###' );

	return task;

} );

gulp.task( 'watch-scss', function () {

	console.log( '[[[ Watching SCSS Task ]]]' );

	gulp.watch( SCSS_PATH, [ 'scss' ] );

} );

gulp.task( 'watch-js', function () {

	console.log( '[[[ Watching JS Task ]]]' );

	gulp.watch( JS_PATH, [ 'js' ] );

} );