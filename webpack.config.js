module.exports = {
	mode: 'production',
	optimization: {
		minimize: false,
	},
	stats: 'errors-only',
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /(node_modules)/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: [ '@wordpress/default' ],
					},
				},
			},
		],
	},
};
