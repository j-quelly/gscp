module.exports = (grunt) ->
	grunt.initConfig
		path: require "path"
		client: "0.11.1"
		server: "0.14.0"

		# list our available tasks
		availabletasks:
			tasks:
				options:
					filter: "include",
					tasks: [
						"string-replace"
					]
					descriptions:
						"string-replace:server": "Version bump server"
						"string-replace:client": "Version bump client"




		# used for version bumping
		'string-replace':
			client:
				files:
					'package.json' : 'package.json',
					'README.md' : 'README.md',
				options:
					replacements: [
						{
							pattern: /("version": "(\d){1,}\.(\d){1,}\.(\d){1,}")/ig,
							replacement: '"version": "<%= client %>"'
						},
						{
							pattern: /(## client version (\d){1,}\.(\d){1,}\.(\d){1,})/ig,
							replacement: '## client version <%= client %>'
						},
					]
			server:
				files:
					'..<%= path.sep %>readme.md' : '..<%= path.sep %>readme.md',
				options:
					replacements: [
						{
							pattern: /(## server version (\d){1,}\.(\d){1,}\.(\d){1,})/ig,
							replacement: '## server version <%= server %>'
						},
					]

	# require our tasks
	grunt.loadNpmTasks "grunt-string-replace"

	# register our grunt tasks
	grunt.registerTask("bump", ["string-replace:client", "string-replace:server"])