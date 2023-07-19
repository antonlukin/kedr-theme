const gulp = require( 'gulp' );
const sass = require( 'gulp-sass' )( require( 'sass' ) );
const concat = require( 'gulp-concat' );
const cleanCss = require( 'gulp-clean-css' );
const sassGlob = require( 'gulp-sass-glob' );
const uglify = require( 'gulp-uglify' );
const plumber = require( 'gulp-plumber' );
const prefix = require( 'gulp-autoprefixer' );
const webpack = require( 'webpack-stream' );

gulp.task( 'styles', ( done ) => {
	gulp
		.src( 'src/styles/main.scss' )
		.pipe( plumber() )
		.pipe( sassGlob() )
		.pipe(
			sass( {
				errLogToConsole: true,
			} ),
		)
		.pipe( prefix() )
		.pipe( concat( 'styles.min.css' ) )
		.pipe(
			cleanCss( {
				compatibility: 'ie9',
			} ),
		)
		.pipe( gulp.dest( 'public/assets/' ) );

	done();
} );

gulp.task( 'scripts', ( done ) => {
	gulp
		.src( 'src/scripts/*.js' )
		.pipe( plumber() )
		.pipe(
			webpack( {
				config: require( './webpack.config.js' ),
			} ),
		)
		.pipe( uglify() )
		.pipe( concat( 'scripts.min.js' ) )
		.pipe( gulp.dest( 'public/assets/' ) );

	done();
} );

gulp.task( 'images', ( done ) => {
	gulp.src( 'src/images/**/*' ).pipe( gulp.dest( 'public/assets/images/' ) );

	done();
} );

gulp.task( 'icons', ( done ) => {
	gulp.src( 'src/icons/*.svg' ).pipe( gulp.dest( 'public/assets/images/' ) );

	done();
} );

gulp.task( 'fonts', ( done ) => {
	gulp.src( 'src/fonts/**/*.{ttf,woff,woff2}' ).pipe( gulp.dest( 'public/assets/fonts/' ) );

	done();
} );

gulp.task( 'watch', () => {
	gulp.watch( 'src/styles/**/*', gulp.series( 'styles' ) );
	gulp.watch( 'src/scripts/**/*', gulp.series( 'scripts' ) );
} );

gulp.task( 'build', gulp.parallel( 'styles', 'scripts', 'images', 'icons', 'fonts' ) );

gulp.task( 'default', gulp.series( 'build', 'watch' ) );
