const path = require('path');
const webpack = require('webpack');

module.exports = {

	entry:{
		boardList:'/www/entry/boardList.js',
		login:'/www/entry/login.js'
	},
	output: {
		path: path.resolve(__dirname, 'www/dist'),
		filename: '[name]_bundle.js'
	},
	module: {
		rules:[
			{
				test: /\.js$/,
				loader:"babel-loader",
				exclude: /node_modules/,
				options: {
					presets:['@babel/preset-env']
				}
			},
		]
	},
	plugins: [
		new webpack.ProvidePlugin({
		  $: 'jquery',
		  jQuery: 'jquery',
		}),
	],
}