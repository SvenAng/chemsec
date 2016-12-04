var gulp            = require('gulp'),
    plumber         = require('gulp-plumber'),
    rename          = require('gulp-rename'),
    autoprefixer    = require('gulp-autoprefixer'),
    concat          = require('gulp-concat'),
    jshint          = require('gulp-jshint'),
    uglify          = require('gulp-uglify'),
    cache           = require('gulp-cache'),
    minifycss       = require('gulp-minify-css'),
    less            = require('gulp-less');

// Compile and merge html5shiv-printshiv.min.js and respond.min.js
gulp.task('html5shiv-respond', function(){
    return gulp.src(['includes/js/vendor/html5shiv-printshiv.min.js', 'includes/js/vendor/respond.min.js'])
        .pipe(plumber({
            errorHandler: function (error) {
            console.log(error.message);
            this.emit('end');
        }}))
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(concat('html5shiv-printshiv-respond.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('includes/js/'))
});

// Compile and merge vendor JS files. Exclude html5shiv-printshiv.min.js and respond.min.js since we only want those for IE
gulp.task('vendors', function(){
    return gulp.src(['includes/js/vendor/**/*.js', '!includes/js/vendor/html5shiv-printshiv.min.js', '!includes/js/vendor/respond.min.js'])
        .pipe(plumber({
            errorHandler: function (error) {
            console.log(error.message);
            this.emit('end');
        }}))
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(concat('vendors.js'))
        // .pipe(uglify())
        .pipe(gulp.dest('includes/js/'))
});

// First run vendors and then compile and merge main JS files
gulp.task('scripts', ['vendors'], function(){
    return gulp.src(['includes/js/vendors.js', 'includes/js/main.js'])
        .pipe(plumber({
            errorHandler: function (error) {
            console.log(error.message);
            this.emit('end');
        }}))
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(concat('main.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('includes/js/'))
});

// Compile and merge main LESS files
gulp.task('main', function(){
    gulp.src(['includes/less/core.less'])
        .pipe(plumber({
            errorHandler: function (error) {
                console.log(error.message);
                this.emit('end');
            }
        }))
        .pipe(less())
        .pipe(autoprefixer(['last 2 versions', 'ie'], {cascade: false}))
        .pipe(minifycss({keepSpecialComments:0}))
        .pipe(rename('main.min.css'))
        .pipe(gulp.dest('includes/css/'))
});

// Compile and merge admin LESS files
gulp.task('admin', function(){
    gulp.src(['includes/less/admin.less'])
        .pipe(plumber({
            errorHandler: function (error) {
                console.log(error.message);
                this.emit('end');
            }
        }))
        .pipe(less())
        .pipe(autoprefixer(['last 2 versions', 'ie'], {cascade: false}))
        .pipe(minifycss({keepSpecialComments:0}))
        .pipe(rename('admin.min.css'))
        .pipe(gulp.dest('includes/css/'))
});

// Compile and merge editor LESS files
gulp.task('editor', function(){
    gulp.src(['includes/less/editor.less'])
        .pipe(plumber({
            errorHandler: function (error) {
                console.log(error.message);
                this.emit('end');
            }
        }))
        .pipe(less())
        .pipe(autoprefixer(['last 2 versions', 'ie'], {cascade: false}))
        .pipe(minifycss({keepSpecialComments:0}))
        .pipe(rename('editor.min.css'))
        .pipe(gulp.dest('includes/css/'))
});

// Compile and merge editor LESS files
gulp.task('ie', function(){
    gulp.src(['includes/less/ie.less'])
        .pipe(plumber({
            errorHandler: function (error) {
                console.log(error.message);
                this.emit('end');
            }
        }))
        .pipe(less())
        .pipe(autoprefixer(['last 2 versions', 'ie'], {cascade: false}))
        .pipe(minifycss({keepSpecialComments:0}))
        .pipe(rename('ie.min.css'))
        .pipe(gulp.dest('includes/css/'))
});

// Task to watch LESS and JS files for changes
gulp.task('watch', function() {
    gulp.watch('includes/less/**/*.less', ['main', 'admin', 'editor', 'ie']);
    gulp.watch('includes/js/**/*.js', ['scripts']);
    gulp.watch(['includes/js/vendor/html5shiv-printshiv.min.js', 'includes/js/vendor/respond.min.js'], ['html5shiv-respond']);
});

// Compile everything once and then watch for changes.
gulp.task('default', ['main', 'admin', 'editor', 'ie', 'scripts', 'html5shiv-respond', 'watch']);
