const mix = require('laravel-mix');
const path = require('path');
const TerserPlugin = require('terser-webpack-plugin');
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { VueLoaderPlugin } = require('vue-loader')
// const PurgecssPlugin = require('purgecss-webpack-plugin');
// const glob = require('glob-all');
require('laravel-mix-purgecss');

//this seems to have no effect
/*module.exports = {
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                        options: {
                            // you can specify a publicPath here
                            // by default it uses publicPath in webpackOptions.output
                            // publicPath: '../',
                            hmr: process.env.NODE_ENV === 'development',
                        },
                    },
                    'css-loader',
                ],
            },
        ],
    },
};*/

const webpackConfig = {
    devtool: mix.inProduction() ? false : 'inline-source-map',
    module: {
        rules: [
            {
                test: /\.js$/,
                include: [
                    path.resolve(__dirname, 'node_modules/vue-socialmedia-share'),
                    path.resolve(__dirname, 'node_modules/vue2-google-maps'),
                    path.resolve(__dirname, 'node_modules/vuejs-datepicker')
                ],
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            ['@babel/preset-env', { targets: { node: 'current' } }]
                        ],
                        plugins: [
                            ["@babel/plugin-proposal-decorators", { "version": "legacy" }]
                        ]
                    }
                }
            },
            {
                test: /\.ts(x?)$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: 'babel-loader',
                        options: Config.babel()
                    },
                    {
                        loader: 'ts-loader',
                        options: {
                            appendTsSuffixTo: [/\.vue$/],
                            transpileOnly: true
                        }
                    }
                ]
            },
            {
              test: /\.vue$/,
              loader: 'vue-loader'
            },
            {
                test: /\.sass$/,
                use: [
                    'vue-style-loader',
                    'css-loader',
                    {
                        loader: 'sass-loader',
                        options: {
                            indentedSyntax: true,
                            // sass-loader version >= 8
                            sassOptions: {
                                indentedSyntax: true
                            }
                        }
                    }
                ]
            }
            // {
            //     enforce: 'pre',
            //     test: /\.(js|vue)$/,
            //     loader: 'eslint-loader',
            //     exclude: /node_modules/
            // }
        ]
    },
    resolve: {
        extensions: ['*', '.js', '.jsx', '.vue', '.ts', '.tsx', '.css', '.scss', '.sass'],
        alias: {
            // 'vue$': (process.env.NODE_ENV !== 'production')? 'vue/dist/vue.esm.js': 'vue/dist/vue.runtime.esm.js',
            styles: path.resolve(__dirname, 'client/sass'),
            '@': path.resolve(__dirname, 'client/src'),
            '@styles': path.resolve(__dirname, 'client/sass')
        }
    }
};

const mixOptions = {
    processCssUrls: false,
    purifyCss: false,
    imgLoaderOptions: {
        enabled: false
    },
    entry: {
        app: './js/app.js',
        app_admin: './js/app_admin.js'//tried to enable multiple entry points for webpack but it does not seem to be supported
    },
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: '[name].js'
    },
    optimization: {
        minimize: true,
        minimizer: [
            new TerserPlugin({
                parallel: 4
            }),
            new CssMinimizerPlugin({
                minimizerOptions: {
                    preset: [
                        "default",
                        {
                            //TODO: Debug this part, doesn't remove comments with /*!
                            //which it should and @media rules seems to have issues
                            //on production build
                            discardComments: { removeAll: true }
                        }
                    ]
                }
            })
        ],
        runtimeChunk: 'single',
        splitChunks: {//This whole section has no effect
            chunks: 'all',
            maxInitialRequests: Infinity,
            minSize: 0,
            cacheGroups: {
                vendor: {
                    // chunks: 'initial',
                    // name: 'vendor',
                    // filename: 'vendor.js',
                    test: /[\\/]node_modules[\\/]/,
                    name(module) {
                        // get the name. E.g. node_modules/packageName/not/this/part.js
                        // or node_modules/packageName
                        const packageName = module.context.match(/[\\/]node_modules[\\/](.*?)([\\/]|$)/)[1];

                        // npm package names are URL-safe, but some servers don't like @ symbols
                        return `npm.${packageName.replace('@', '')}`;
                    }
                }
            }
        }
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[name].css',
            chunkFilename: '[id].css',
            ignoreOrder: false // Enable to remove warnings about conflicting order
        }),
        new VueLoaderPlugin()
    ]
};

const purgeCssConfig = {
    enabled: mix.inProduction(),
    // Your custom globs are merged with the default globs. If you need to
    // fully replace the globs, use the underlying `paths` option instead.
    globs: [
        path.join(__dirname, 'node_modules/simplemde/!**!/!*.js')
    ],
    // customSyntax: path.join(__dirname, '/node_modules/postcss-sass'),
    extensions: ['html', 'js', 'php', 'vue'],
    // Other options are passed through to Purgecss
    whitelistPatterns: [/language/, /hljs/,/^hooper-/,/^slick-/,/^pswp/],
    whitelistPatternsChildren: [/^markdown$/,/^hooper-/,/^slick-/,/^pswp/],
    whitelist: ['custom-control-input']
}

const sassConfig = {
    implementation: require("sass")
}

const vueConfig = {
    extractStyles: false,
    globalStyles: 'client/sass/webpack-resources.scss'
}

mix.webpackConfig(webpackConfig);
mix.options(mixOptions);

mix.disableSuccessNotifications();
mix.sourceMaps();
mix.version();

mix.sass('client/sass/app.scss', 'public/css', sassConfig).purgeCss(purgeCssConfig);
mix.sass('client/sass/app-admin.scss', 'public/css', sassConfig).purgeCss(purgeCssConfig);

mix.js('client/src/app.ts', 'public/js').vue(vueConfig);
// mix.js('resources/assets/vue/app_admin.ts', 'public/js');

mix.copyDirectory('client/fonts', 'public/fonts');
