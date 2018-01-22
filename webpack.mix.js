/* globals path */
let mix = require('laravel-mix')

mix.webpackConfig({
  resolve: {
    alias: {
      '@components': path.resolve(__dirname, 'resources/assets/js/components/'),
      '@lib': path.resolve(__dirname, 'resources/assets/js/lib/'),

    }
  }
})

mix.js('resources/assets/js/app.js', 'public/js')
  .extract([
    'axios',
    'vue',
    'vuex'
  ])
  .sass('resources/assets/sass/app.scss', 'public/css')
  .sourceMaps()
  .version()
