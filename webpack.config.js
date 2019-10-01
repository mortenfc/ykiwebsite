const path = require('path');

module.exports = {
  mode: 'development',
  watch: true,
  entry: './index.js',
  output: {
    filename: 'main.js',
    path: path.resolve(__dirname, 'dist')
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: [
          'style-loader',
          'css-loader'
        ]
      }
    ]
  }
};

// module.exports = {
//   module: {
//     rules: [
//       {
//         test: /\.css$/,
//         use: [
//           // style-loader
//           { loader: 'style-loader' },
//           // css-loader
//           {
//             loader: 'css-loader',
//             options: {
//               modules: true
//             }
//           },
//           // sass-loader
//           { loader: 'sass-loader' }
//         ]
//       }
//     ]
//   }
// };