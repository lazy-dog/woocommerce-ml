var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', function(done) {
    gulp.src('assets/src/main.scss', { allowEmpty: true })
        .pipe(sass({style: 'expanded'}))
        .pipe(gulp.dest('assets/dist/main.css'));

    done();
});
