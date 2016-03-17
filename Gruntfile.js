module.exports = function(grunt) {

// 1. Toutes les configurations vont ici: 
grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    concat: {
        // 2. la configuration pour la concaténation va ici.
        dist: {
	        src: [
	            'src/AccueilBundle/Resources/public/css/*.css',
	            'src/TestsBundle/Resources/public/css/*.css',
	            'src/BigButtonBundle/Resources/public/css/*.css',
	        ],
	        dest: 'web/build/production.css'
	    }
    },

    concat: {
        // 2. la configuration pour la concaténation va ici.
        dist: {
	        src: [
	            'src/AccueilBundle/Resources/public/js/*.js',
	            'src/TestsBundle/Resources/public/js/*.js',
	            'src/BigButtonBundle/Resources/public/js/*.js',
	        ],
	        dest: 'web/build/production.js'
	    }
    },

    uglify: {
	    build: {
	        src: 'web/build/production.js',
	        dest:'web/build/production.min.js'
    }
}

});

// 3. Nous disons à Grunt que nous voulons utiliser ce plug-in.
grunt.loadNpmTasks('grunt-contrib-concat');
grunt.loadNpmTasks('grunt-contrib-uglify');

// 4. Nous disons à Grunt quoi faire lorsque nous tapons "grunt" dans la console.
grunt.registerTask('default', ['concat', 'uglify']);

};
