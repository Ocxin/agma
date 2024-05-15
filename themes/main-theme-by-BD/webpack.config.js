const path = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyPlugin = require('copy-webpack-plugin');





module.exports = {
    context: path.resolve(__dirname, 'src'), // Configura il percorso di base per i file di input
    entry: ['./js/main.js', './scss/main.scss',],
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: 'js/bundle.js'
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [
                    MiniCssExtractPlugin.loader, // Usa questo loader per estrarre CSS in un file separato
                    'css-loader',   // traduce CSS in CommonJS
                    'sass-loader'   // compila Sass in CSS
                ]
            },
            {
                test: /\.(png|svg|jpg|jpeg|gif|webp)$/i,
                type: 'asset/resource',
                generator: {
                    filename: 'images/[path][name][ext]' // Configura il percorso di output per le immagini
                }
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            }
        ]
    },
    plugins: [
        new CleanWebpackPlugin({
            cleanOnceBeforeBuildPatterns: ['**/*', '!images', '!images/**/*'] // Esclude la cartella images dalla pulizia
        }),        new MiniCssExtractPlugin({
            filename: 'css/[name].css' // Configura il nome del file CSS output
        }),
        new CopyPlugin({
            patterns: [
                { from: 'images', to: 'images' }, // Copia il contenuto della cartella images in dist/images
            ],
        }),
    ],
    mode: 'development'
};
