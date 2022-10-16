const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.webpackConfig({
    resolve: {
        alias: {
            '@': __dirname + '/resources/assets',
            'chart.js': 'chart.js/dist/Chart.js'
        },
    },
        // Set up all the aliases we use in our app.
    module: {
        rules: [
            {
                test: /\.(graphql|gql)$/,
                exclude: /node_modules/,
                loader: 'graphql-tag/loader',
            }
        ]
    }
});

mix.sourceMaps(process.env.NODE_ENV !== 'production');
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

