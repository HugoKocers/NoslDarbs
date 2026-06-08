const CACHE_NAME = 'cardquest-v2'
const START_URL = '/'
const STATIC_ASSETS = [
  '/',
  '/index.html',
  '/manifest.json'
]

// Install event - cache essential assets and prepare for fast loading
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(STATIC_ASSETS)
    }).then(() => self.skipWaiting())
  )
})

// Activate event - clean up old caches
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          if (cacheName !== CACHE_NAME) {
            return caches.delete(cacheName)
          }
        })
      )
    }).then(() => self.clients.claim())
  )
})

function networkFirst(request) {
  return fetch(request)
    .then((response) => {
      if (!response || response.status !== 200 || response.type === 'error') {
        return caches.match(request)
      }

      const responseToCache = response.clone()
      caches.open(CACHE_NAME).then((cache) => {
        cache.put(request, responseToCache)
      })

      return response
    })
    .catch(() => caches.match(request).then((cached) => cached || caches.match(START_URL)))
}

function cacheFirst(request) {
  return caches.match(request).then((cached) => {
    if (cached) {
      return cached
    }

    return fetch(request).then((response) => {
      if (!response || response.status !== 200 || response.type === 'error') {
        return response
      }

      const responseToCache = response.clone()
      caches.open(CACHE_NAME).then((cache) => {
        cache.put(request, responseToCache)
      })

      return response
    }).catch(() => caches.match(START_URL))
  })
}

// Fetch event - serve index from network first, cache other static assets
self.addEventListener('fetch', (event) => {
  const { request } = event
  const url = new URL(request.url)

  if (request.method !== 'GET') {
    return
  }

  if (url.pathname.startsWith('/api/')) {
    event.respondWith(
      fetch(request).catch(() => {
        return new Response(
          JSON.stringify({ error: 'Offline - API not available' }),
          { status: 503, headers: { 'Content-Type': 'application/json' } }
        )
      })
    )
    return
  }

  if (url.pathname === '/' || url.pathname === '/index.html') {
    event.respondWith(networkFirst(request))
    return
  }

  event.respondWith(cacheFirst(request))
})

// Handle background sync (for future implementation)
self.addEventListener('sync', (event) => {
  if (event.tag === 'sync-battles') {
    event.waitUntil(syncBattles())
  }
})

async function syncBattles() {
  // Future implementation for syncing battle data
  console.log('Syncing battles...')
}
