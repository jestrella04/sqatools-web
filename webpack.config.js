const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = (env, argv) => {
    return {
        devtool: 'none',
        mode: process.env.NODE_ENV,

        entry: {
            main: './resources/js/src/index.js',
            jquery: './resources/js/src/jquery.js',
        },

        output: {
            filename: '[name].bundle.js',
            path: path.resolve(__dirname, 'resources/js'),
        },

        plugins: [new MiniCssExtractPlugin({ filename: "../css/bundle.css", chunkFilename: "[id].css" })],

        module: {
            rules: [
                {
                    test: /\.s[ac]ss$/i,
                    use: [
                        MiniCssExtractPlugin.loader,
                        'css-loader',
                        'sass-loader',
                    ],
                },

                {
                    test: /\.(svg|eot|ttf|woff|woff2)$/i,
                    use: {
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]',
                            outputPath: '../fonts'
                        }
                    },
                } ,

                {
                    test: /\.m?js$/, 
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader'
                    }
                }
            ],
        },
    }
};