module.exports = {
  /*
  ** Headers of the page
  */
  head: {
    title: 'client',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'A foraging application' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },
  /*
  ** Customize the progress bar color
  */
  loading: { color: '#3B8070' },

  /**
   *  External Libraries
   */
  modules: [
      '@nuxtjs/axios',
      '@nuxtjs/auth',
      'bootstrap-vue/nuxt',

      ['bootstrap-vue/nuxt', { css: false }],
  ],

  axios: {
      // baseURL: 'http://foragingapplication.test/api'
      baseURL: 'https://frozen-temple-33483.herokuapp.com/api'
  },

  auth: {
      endpoints: {
          login: {
              url: '/auth/login', method: 'post', propertyName: 'meta.token'
          },
          user: {
              url: '/auth/me', method: 'get', propertyName: 'data'
          },
          logout: {
              url: '/auth/logout', method: 'post'
          }
      },
      redirect: {
          login: '/auth/login',
          home: '/'
      }
  },

    router: {
        middleware: [
            'clearValidationErrors'
        ]
    },

    plugins: [
        './plugins/mixins/user.js',
        './plugins/mixins/validation.js',
        './plugins/axios.js',
        './plugins/mixins/messages.js',
        './plugins/mixins/googlemaps.js',
        './plugins/vue-cropper.js'
    ],

  /*
  ** Build configuration
  */
  build: {
      vendor: ['vuejs-datepicker', 'vue-image-crop-upload'],
    /*
    ** Run ESLint on save
    */
    extend (config, { isDev, isClient }) {
      if (isDev && isClient) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })
      }
    }
  }
}
