//  сервис-воркер для PWA
const CACHE_NAME = 'lego-site-v1';
const ASSETS = [
    '/Lego-site3/',
    '/Lego-site3/index.html',
    '/Lego-site3/style.css',
    '/Lego-site3/icon.png'
];

self.addEventListener('install', (e) => {
    e.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(ASSETS);
        })
    );
});

self.addEventListener('fetch', (e) => {
    e.respondWith(
        caches.match(e.request).then((response) => {
            return response || fetch(e.request);
        })
    );
});