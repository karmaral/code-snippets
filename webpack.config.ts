import * as path from 'path';
import * as webpack from 'webpack';

const config: webpack.Configuration = {
	mode: 'production',
	entry: {
		manage: './js/manage.ts',
		edit: {
			import: './js/edit/edit.ts',
			dependOn: 'editor'
		},
		tags: './js/edit/tags.ts',
		settings: {
			import: './js/settings/settings.ts',
			dependOn: 'editor'
		},
		mce: './js/mce.ts',
		prism: './js/prism.ts',
		editor: './js/editor-lib.ts'
	},
	output: {
		path: path.resolve(__dirname),
		filename: '[name].js',
	},
	externalsType: 'window',
	externals: {
		codemirror: ['wp', 'CodeMirror'],
		tinymce: 'tinymce',
	},
	resolve: {
		extensions: ['.ts', '.js', '.json'],
		alias: {
			'php-parser': path.resolve(__dirname, 'node_modules/php-parser/src/index.js')
		}
	},
	module: {
		rules: [{
			test: /\.[jt]sx?$/,
			exclude: /node_modules/,
			use: {
				loader: 'babel-loader',
				options: {
					plugins: [
						['prismjs', {
							languages: ['php', 'php-extras'],
							plugins: ['line-highlight', 'line-numbers'],
						}]
					]
				}
			}
		}]
	},
	plugins: [
		new webpack.DefinePlugin({
			'process.arch': JSON.stringify('x64')
		})
	]
};

export default config;
