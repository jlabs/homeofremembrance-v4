module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    
    watch: {
	    sass: {
	    	files: ['css/*.scss','css/libs/*.scss'],
			tasks: ['sass'],
	    },
	    cssmin: {
		    files: ['css/build/*.css','css/libs/*.css'],
		    tasks: ['cssmin'],
	    },
	    uglify: {
		    files: ['js/libs/*.js','js/script.js'],
		    tasks: ['uglify'],
	    },
    },
    
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
      },
      build: {
        src: ['js/libs/jquery-2.0.3.js',
        	'js/libs/bootstrap-datepicker.js',
        	'js/libs/bootstrap.min.js',
        	'js/libs/jquery.backstretch.min.js',
        	'js/script.js'],
        dest: 'js/build/global.min.js'
      }
    },
    
	sass: {
		dist: {                            // Target
			options: {                       // Target options
				style: 'compressed'
			},
			files: {                         // Dictionary of files
				'css/build/style.css': 'css/style.scss',
				'css/build/signin.css': 'css/signin.scss',
				'css/build/datepicker.css': 'css/libs/datepicker.scss'
			}
		}
	},
	
	cssmin: {
	  add_banner: {
	    options: {
	      banner: '/* My minified css file */'
	    },
	    files: {
	      'css/build/global.css': ['css/libs/bootstrap.css',
	      	'css/build/style.css',
	      	'css/build/datepicker.css',
	      	'css/libs/font-awesome.css',
	      	'css/build/signin.css']
	    }
	  }
	}
    
  });

  // Load the plugin that provides the "uglify" task.
  grunt.loadNpmTasks('grunt-contrib-uglify');  
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task(s).
  grunt.registerTask('default', ['uglify', 'sass', 'cssmin']);

};