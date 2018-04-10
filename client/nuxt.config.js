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
      '@nuxtjs/Auth',
      'bootstrap-vue/nuxt',

      ['bootstrap-vue/nuxt', { css: false }],
  ],

  axios: {
    baseURL: 'http://foragingapplication.test/api'
  },

  auth: {
      endpoints: {
          login: {
              url: '/Auth/login', method: 'post', propertyName: 'meta.token'
          },
          user: {
              url: '/Auth/me', method: 'get', propertyName: 'data'
          },
          logout: {
              url: '/Auth/logout', method: 'post'
          }
      },
      redirect: {
          login: '/Auth/login',
          home: '/'
      }
  },

    router: {
        middleware: [
            'clearValidationErrors'
        ]
    },

    plugins: [
        './plugins/mixins/User.js',
        './plugins/mixins/validation.js',
        './plugins/axios.js',
        './plugins/mixins/messages.js'
    ],

  /*
  ** Build configuration
  */
  build: {
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
