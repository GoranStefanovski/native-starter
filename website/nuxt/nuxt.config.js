const routesResponse = async () => {
  return new Promise((resolve) => {
    setTimeout(() => {
      resolve([
        {
          name: 'home',
          path: '/',
          file: '~/pages/index.vue',
          query: {}
        },
        {
          name: 'about',
          path: '/about',
          file: '~/components/about.vue'
        }
      ])
    }, 200)
  })
}

export default defineNuxtConfig({
  modules: [
    '@nuxthq/ui'
  ],
  ui: {
    global: true
  },
  hooks: {
    async 'pages:extend'(pages) {
      const routes = await routesResponse()
      routes.forEach((route) => {
        pages.push(route)
      })
      return pages;
    }
  }
})
