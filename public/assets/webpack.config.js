const ExtractTextPlugin = require('extract-text-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const path = require('path');
const webpack = require('webpack');


const env = process.env.MIX_ENV || 'dev';
const prod = env === 'prod';


const DEV_ENTRIES = [];
const APP_ENTRIES = ['bootstrap-loader', './js/app.js'];

const plugins = [
    new ExtractTextPlugin('../css/app.css'),
    new webpack.EnvironmentPlugin({
        NODE_ENV: 'development',
    }),
    new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
        Tether: 'tether',
        'window.Tether': 'tether',
        Popper: ['popper.js', 'default'],
        Alert: 'exports-loader?Alert!bootstrap/js/dist/alert',
        Button: 'exports-loader?Button!bootstrap/js/dist/button',
        Carousel: 'exports-loader?Carousel!bootstrap/js/dist/carousel',
        Collapse: 'exports-loader?Collapse!bootstrap/js/dist/collapse',
        Dropdown: 'exports-loader?Dropdown!bootstrap/js/dist/dropdown',
        Modal: 'exports-loader?Modal!bootstrap/js/dist/modal',
        Popover: 'exports-loader?Popover!bootstrap/js/dist/popover',
        Scrollspy: 'exports-loader?Scrollspy!bootstrap/js/dist/scrollspy',
        Tab: 'exports-loader?Tab!bootstrap/js/dist/tab',
        Tooltip: 'exports-loader?Tooltip!bootstrap/js/dist/tooltip',
        Util: 'exports-loader?Util!bootstrap/js/dist/util',
    }),
    new BrowserSyncPlugin(
        {
            proxy: 'localhost',
            files: [
                {   
                    match: [
                        '../../*/*.php',
                        '../../*/*.tmpl',
                    ],
                    fn: function(event, file) {
                        if (event === "change") {
                            const bs = require('browser-sync').get('bs-webpack-plugin');
                            bs.reload();
                        }
                    },
                }
            ],
        },
        {
            reload: true
        })
];

module.exports = {
    entry: {
        app: prod ? APP_ENTRIES : DEV_ENTRIES.concat(APP_ENTRIES),
    },
    devtool: prod ? false : 'cheap-module-eval-source-map',
    output: {
        path: path.resolve(__dirname, '../', 'static', 'js'),
        filename: 'app.js',
        publicPath: path.resolve(__dirname, 'static', 'js'),
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        cacheDirectory: true,
                        presets: [
                            'flow',
                            'stage-0',
                            'env'
                        ],
                    },
                },
            },
            {
                test: /\.scss$/,
                use: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: ['css-loader', 'sass-loader']
                }),
                exclude: /node_modules/
            },
            {
                test: /\.(jpe?g|png|gif|svg|woff2?)$/,
                use: [{
                        loader: 'url-loader',
                        options: {
                            limit: 40000
                        },
                    },
                    'image-webpack-loader',
                ],
            },
            {
                test: /bootstrap[/\\]dist[/\\]js[/\\]umd[/\\]/,
                use: 'imports-loader?jQuery=jquery',
            },
        ],
    },
    plugins,
    watchOptions: {
        aggregateTimeout: 300,
        poll: 1500,
    },
    resolve: {
        modules: ['node_modules', path.join(__dirname, 'assets', 'js')],
        extensions: ['.js'],
    },
};
