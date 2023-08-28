const webpack = require('webpack');

module.exports = {
  transpileDependencies: true,

  configureWebpack: {
    resolve: {
      fallback: {
        crypto: require.resolve('crypto-browserify'),
        util: require.resolve('util/'),
        stream: require.resolve('stream-browserify'),
      },
    },
    plugins: [
      // Provide the 'process' object for modules that depend on it
      new webpack.ProvidePlugin({
        process: 'process/browser',
      }),
    ],
  },
};
