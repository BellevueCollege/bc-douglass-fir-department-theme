// Dependencies
var gulp         = require('gulp');
var sass         = require('gulp-sass')(require('sass'));
var notify       = require('gulp-notify');
var sourcemaps   = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var uglify       = require('gulp-uglify');
var saveLicense  = require('uglify-save-license');


// Path Configs
var config = {
  sassPath: './sass',
  cssPath:  '.',
  npmPath:  './node_modules',
  globalsPath:  './node_modules/globals/g/4'
}

/**
 * Sass Configurations
 *
 * Dev and Prod configuration profiles for sass
 *
 **/

// Production
var sassOptions = {
  outputStyle: 'compressed',
  sourceComments: false,
  includePaths: [
      config.npmPath + '/bootstrap/scss',
      config.npmPath + '/@fortawesome/fontawesome-free/scss',
      config.sassPath
  ],
  precision: 10
}

//Dev
var sassDevOptions = {
  outputStyle: 'expanded',
  sourceComments: true,
  includePaths: [
      config.npmPath + '/bootstrap/scss',
      config.npmPath + '/@fortawesome/fontawesome-free/scss',
      config.sassPath
  ],
  precision: 10
}

/**
 * Uglify Options
 *
 * Tell uglify to keep certiain comments, etc
 *
 **/
var uglifyOptions = {
  output: {
    comments: saveLicense
  }
}

/**
 * Sass Compilers
 *
 * Dev and Prod compilers
 *
 **/

gulp.task('sass-dev', function() {
  return gulp
      .src(config.sassPath + '/style.scss')
      .pipe(sourcemaps.init())
      .pipe(sass(sassDevOptions).on('error', notify.onError(function (error) {
          return "Error: " + error.message;
      })))
      .pipe(autoprefixer())
      .pipe(sourcemaps.write())
      .pipe(gulp.dest(config.cssPath));
});

gulp.task('editor-sass-dev', function() {
  return gulp
      .src(config.sassPath + '/block-editor.scss')
      .pipe(sourcemaps.init())
      .pipe(sass(sassDevOptions).on('error', notify.onError(function (error) {
          return "Error: " + error.message;
      })))
      .pipe(autoprefixer())
      .pipe(sourcemaps.write())
      .pipe(gulp.dest('./css'));
});

gulp.task('sass', function() {
  return gulp
      .src(config.sassPath + '/style.scss')
      .pipe(sass(sassOptions).on('error', notify.onError(function (error) {
          return "Error: " + error.message;
      })))
      .pipe(autoprefixer())
      .pipe(gulp.dest(config.cssPath));
});

gulp.task('editor-sass', function() {
  return gulp
      .src(config.sassPath + '/block-editor.scss')
      .pipe(sass(sassOptions).on('error', notify.onError(function (error) {
          return "Error: " + error.message;
      })))
      .pipe(autoprefixer())
      .pipe(gulp.dest('./css'));
});

// Watch function (sass) - dev use only
gulp.task('watch',function() {
  gulp
    .watch(config.sassPath + '/**/*.scss', gulp.parallel(
      'sass-dev',
      'editor-sass-dev'
    ));
});

// Dev - full dev build
gulp.task('dev', gulp.parallel(
            'sass-dev',
            'editor-sass-dev'
          ));

// Default - full production build
gulp.task('default', gulp.parallel(
            'sass',
            'editor-sass'
          ));
