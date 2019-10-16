const path = require('path');
// const MiniCssExtractPlugin = require('mini-css-extract-plugin');
// const HtmlWebpackPlugin = require('html-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const WebpackCdnPlugin = require('webpack-cdn-plugin');

module.exports = {
  mode: 'development',
  watch: true,
  entry: {
    course: './index.js',
    register: './register.js',
    welcome: './welcome.js',
    dwolla: './dwolla/dwolla.js',
    adminWelcome: './admin/adminWelcome.js'
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'dist')
  },
  module: {
    rules: [
      {
        test: /\.(scss|css)$/,
        // include: path.resolve(__dirname, 'admin/datepicker'),
        use: [
          'style-loader',
          'css-loader',
          'sass-loader'
        ]
      }
    ]
  },
  optimization: {
    minimize: true,
    minimizer: [
      // https://goo.gl/yWD5vm - List of reasons we're using Terser instead (Webpack is too!).
      new TerserPlugin({ // https://goo.gl/YgdtKb
        cache: true, // https://goo.gl/QVWRtq
        parallel: true, //https://goo.gl/hUkvnK
        terserOptions: { // https://goo.gl/y3psR1
          ecma: 5,
          output: {
            comments: false
          }
        }
      })
    ]
  },
  plugins: [
    new HtmlWebpackPlugin(),
    new WebpackCdnPlugin({
      modules: [
        {
          name: 'welcome',
          path: 'dist/welcome.js'
        },
      ],
      publicPath: '/node_modules'
    })
  ]
};