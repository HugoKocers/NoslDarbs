import { createApp } from 'vue'
import { createPinia } from 'pinia'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

import App from './App.vue'
import router from './router'

const app = createApp(App)

const vuetify = createVuetify({
  components,
  directives,
  theme: {
    defaultTheme: 'dark',
    themes: {
      dark: {
        colors: {
          primary: '#9333ea',
          secondary: '#a855f7',
          accent: '#06b6d4',
          error: '#ef4444',
          warning: '#f59e0b',
          info: '#3b82f6',
          success: '#10b981',
        }
      }
    }
  }
})

app.use(createPinia())
app.use(router)
app.use(vuetify)

app.mount('#app')

// Register Service Worker for PWA support (production only)
if ('serviceWorker' in navigator) {
  if (import.meta.env.MODE === 'development') {
    // Unregister service workers in development to avoid caching issues
    navigator.serviceWorker.getRegistrations().then((registrations) => {
      registrations.forEach((registration) => {
        registration.unregister()
        console.log('ServiceWorker unregistered for development')
      })
    })
  } else {
    // Register in production
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('/sw.js').then(
        (registration) => {
          console.log('ServiceWorker registration successful:', registration.scope)
        },
        (err) => {
          console.log('ServiceWorker registration failed: ', err)
        }
      )
    })
  }
}

