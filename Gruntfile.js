module.exports = function(grunt) {
    grunt.initConfig({ //object with all tasks.
        phpcs: {
            application: {
                src: ['./**/*.php', '!./node_modules/**']
            },
            options: {
                standard: 'WordPress',
                errorSeverity: 1
            }
        },
        phpcbf: {
            files: {
                src: ['./**/*.php', '!./node_modules/**']
            },
            options: {
                standard: 'WordPress',
                errorSeverity: 1
            }
        },

        jshint: {
            all: ['Gruntfile.js', 'assets**/*.js'],
            options : {
                curly : true,
                eqeqeq : true,
                immed : true,
                latedef : true,
                newcap : false,
                noarg : true,
                sub : true,
                undef : true,
                unused : true,
                boss : true,
                eqnull : true,
                browser : true,
                jquery : true,
                globals : {objectL10n : true, module : true, require : true}
            }
        }

    });

    grunt.registerTask('lint', [
        'jshint',
        'phpcs'
    ]);

    grunt.registerTask('test', [
        'jshint',
        'phpcs'
    ]);

    grunt.registerTask('build', [
        'phpcbf',
        'jshint',
        'phpcs',
        'phpunit'
    ]);


    grunt.loadNpmTasks('grunt-phpcs');
    grunt.loadNpmTasks('grunt-phpcbf');
    grunt.loadNpmTasks('grunt-contrib-jshint');

};
