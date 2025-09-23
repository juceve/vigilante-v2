const cacheName = 'vigilancia-cache-v1';
const assetsToCache = [
    '/',
    '/css/styles.css',
    '/web/js/scripts.js',
    '/images/logo_shield.png'
];

// Instalación del SW
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(cacheName)
            .then(cache => cache.addAll(assetsToCache))
    );
});

// Activación
self.addEventListener('activate', event => {
    console.log('Service Worker activado');
});

// Interceptar requests
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => response || fetch(event.request))
    );
});
