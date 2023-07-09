const path = require('path');

module.exports = {
    mode: process.env.NODE_ENV,
    entry: [
        path.resolve(__dirname, './assets/src/js/topics-page.js'),
        path.resolve(__dirname, './assets/src/sass/topics-page.scss'),
    ],
    output: {
        path: path.resolve(__dirname, './assets/dist'),
        filename: '[name].bundle.js'
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                exclude: '/node_modules/',
                use: [
                    {
                        loader: 'file-loader',
                        options: { outputPath: 'css/', name: '[name].css'}
                    },
                    'sass-loader',
                    'postcss-loader'
                ]
            },
            {
                test: /\.js$/,
                exclude: '/node_modules/',
                use: [
                    {
                        loader: 'file-loader',
                        options: { outputPath: 'js/', name: '[name].js'}
                    },
                ]
            }
        ]
    }
}