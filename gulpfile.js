const gulp = require('gulp');

gulp.task('compile', function () {
    'use strict';
    const twig = require('gulp-twig');

    return gulp.src('./App/View/**/*/*.twig')
        .pipe(twig({
            data: {
                title: 'Gulp and Twig',
                benefits: [
                    'Fast',
                    'Flexible',
                    'Secure'
                ]
            }
        }))
        .pipe(gulp.dest('./'));
});

gulp.task('default', ['compile']);