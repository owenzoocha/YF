/**
 * Gruntfile for fca Theme.
 * This Gruntfile contains all the task definitions related to the build of the thehm,
 * e.g. SCSS compilation, linting, etc
 * Mostly for reference
 */
"use strict();";

module.exports = function(grunt) {
  // Define the core Grunt config object


  var gruntConfig = {
    //Common vars and paths
    paths : {
      base : '.',
      css  : 'css',
      scss : 'scss',
      js   : 'js',
      img  : 'images'
    },
    // Set this to the main SCSS file with all your imports in, the base CSS file.
    // Will compile to a CSS file of the same name.
    baseCSSFile: 'style',

    //SASS subtask
    sass: {
      // Development target
      development : {
       // Any dev-specific options are declared here (e.g. sourceMaps)
        options: {
          sourceMap       : true,                   // The default source map - generate with relative URIs
          sourceComments  : false,
          trace           : true,                   // Generate a full traceback on error
          style           : 'expanded',             // Show compiled neatly and readable - best for debugging
          compass         : false,                  // Current false, but may be used if we import the Platon core CSS
          cacheLocation   : '/tmp/sasscache',       // Stores the SASS cache files in /tmp/, to keep the repo cle
          // debugInfo    : true,                   // Extra info that can be used by the FireSass plugin
          // lineNumbers     : true                 // Show source line numbers in compiled output
        },
        // The files to compile. This is in the format DESTINATION.CSS:SOURCE.SCSS
        files: {
          // '<%= paths.css %>/bootstrap.css' : '<%= paths.scss %>/bootstrap-custom.scss',
          '<%= paths.css %>/<%= baseCSSFile %>.css' : '<%= paths.scss %>/<%= baseCSSFile %>.scss'
        }
      },
    },

    // postCSS subtask
    postcss: {
      options: {
        map: true,       // Generate a sourcemap
        remove: false,
        processors: [
          require('pixrem')(),
          require('autoprefixer')({ browsers : ['last 2 versions', 'ie 9', 'ie 8']})   // autoprefixer
        ]
      },
      dev: {
        files: {
          // '<%= paths.css %>/bootstrap.css' : '<%= paths.css %>/bootstrap.css',
          '<%= paths.css %>/<%= baseCSSFile %>.css' : '<%= paths.css %>/<%= baseCSSFile %>.css'
        }
      }
    },

    /**
     * Linting - JS and CSS
     */
    jshint: {
      options: {
        curly: true,
        eqeqeq: true,
        eqnull: true,
        nocomma: true,
        browser: true,
        debug: true,
        evil: true,
        esnext: 'esversion: 6',
        globals: {
          jQuery: true,
          Drupal: true,
          drupalSettings: true
        },
      },
      beforeconcat: ['<%= paths.js %>/**/*.js', '!<%= paths.js %>/**/*.min.js', '!<%= paths.js %>/vendor/*.js', ]
    },
    /**
     * Lint SCSS files at source for coding style errors
     */
    stylelint: {
      dev: {
        src: ['scss/**/*.scss', '!scss/overrides/drupal/**/*.scss', '!scss/_variables.scss'],
        extends: ["stylelint-config-standard"],
        verbose: true
      }
    },
    /**
     * Concatenate, then compile the JS with Babel
     */
    concat: {
      js: {
        src: [
          'js/**/*.js',
          '!js/**/*/min.js'
        ],
        dest: 'dist/js/global.build.js'
      }
    },

    babel: {
      options: {
        sourceMap: true,
        presets: ['es2015']
      },
      dist: {
        files: {
          'dist/<%= paths.js %>/global.build.js': 'dist/<%= paths.js %>/global.build.js'
        }
      }
    },

    // Grunt Watch subtask - use this to run subtasks when file(s) change
    watch: {
      js: {
        files :['<%= paths.js %>/**/*.js'],
        tasks: ['js']
      },
      css: {
        options : {
          spawn: false
        },
        files: ['<%= paths.scss %>/**/*.scss'],
        tasks: ['css']
      }
    },
  };
  grunt.initConfig(gruntConfig);


  // Load any reuqired plugins here
  require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

  // Set up tasks to run the subtasks declared in gruntConfig
  grunt.registerTask('lint', ['stylelint', 'jshint']);
  grunt.registerTask('css', ['lint', 'sass:development', 'postcss']);
  grunt.registerTask('js', [/*, 'concat', 'babel'*/]);

  grunt.registerTask('dev', ['css', 'js'/*, 'babel'*/]);
  grunt.registerTask('default', ['dev', 'watch']);

  // On watch events configure sttylelint to only run on changed file
  grunt.event.on('watch', function(action, filepath) {
    grunt.config('stylelint.dev.src', filepath);
  });
};
