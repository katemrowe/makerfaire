module.exports = function( grunt ) {

	// All configurations go here
	grunt.initConfig({

		// Reads the package.json file
		pkg: grunt.file.readJSON( 'package.json' ),

		// Each Grunt plugins configurations will go here
		// Compile the less to css
		less: {
			development: {
		    options: {
		      compress: true
		    },
				files: {
					'css/style.css': 'less/style.less',
				}
			}
		},
		// Watch for changes on save and livereload
		watch: {
			css: {
				files: ['less/**/*.less'],
				tasks: ['less']
			},
			reload: {
				files: ['less/**/*.less'],
				tasks: ['less'],
				options: {
					livereload: true
				}
			}
		}
	});

	// Load up tasks
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');

	// Register the tasks with Grunt
	// To only watch for less changes and process without browser reload type in "grunt"
	grunt.registerTask( 'default', ['less', 'watch:css'] );

	// To watch for less changes and process them with livereload type in "grunt reload"
	grunt.registerTask( 'reload', ['less', 'watch:reload'] );

};