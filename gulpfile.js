/**
 * Gulp Plugins
 */
const gulp = require( 'gulp' );
const prefixer = require( 'gulp-autoprefixer' );
const css = require( 'gulp-clean-css' );
const cmq = require( 'gulp-group-css-media-queries' );
const plumber = require( 'gulp-plumber' );
const scss = require( 'gulp-sass' );
const svgmin = require( 'gulp-svgmin' );
const rename = require( 'gulp-rename' );
const uglify = require( 'gulp-uglify' );


/**
 * Gulp Configuration
 */
let config = {
	dev : {
		scss : '__src/scss/**/*.scss',
		js : '__src/js/**/*.js',
		svg : '__src/svg/**/*.svg',
	},
	prod : {
		base : 'assets/',
		css : 'admin-styles.min.css',
		js : 'admin-scripts.min.js',
		svg : 'assets/icons/',
	},
};


/**
 * Gulp Tasks
 */

// Compile SCSS & Group Media Queries.
function build_scss() {

	return gulp
		.src( config.dev.scss )
		.pipe( plumber() )
		.pipe( scss() )
		.pipe( prefixer() )
		.pipe( cmq() )
		.pipe( css() )
		.pipe( rename( config.prod.css ) )
		.pipe( gulp.dest( config.prod.base ) );

}

// Minify & Combine JavaScript.
function build_js() {

	return gulp
		.src( config.dev.js )
		.pipe( plumber() )
		.pipe( uglify() )
		.pipe( rename( config.prod.js ) )
		.pipe( gulp.dest( config.prod.base ) );

}

// Minify SVG files.
function compress_svg() {

	return gulp
		.src( config.dev.svg )
		.pipe( plumber() )
		.pipe( svgmin() )
		.pipe( gulp.dest( config.prod.svg ) );

}


/**
 * Gulp Exports
 */
exports.scss = build_scss;
exports.js = build_js;
exports.svg = compress_svg;

exports.build = gulp.series( build_scss, build_js, compress_svg );
