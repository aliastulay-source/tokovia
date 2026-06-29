const CACHE_NAME = "tokovia-v1";
const urlsToCache = ["/", "/admin/kasir", "/admin/products", "/manifest.json"];

// Install service worker
self.addEventListener("install", function (event) {
    event.waitUntil(
        caches.open(CACHE_NAME).then(function (cache) {
            return cache.addAll(urlsToCache);
        }),
    );
});

// Fetch dari cache
self.addEventListener("fetch", function (event) {
    event.respondWith(
        caches.match(event.request).then(function (response) {
            if (response) {
                return response;
            }
            return fetch(event.request);
        }),
    );
});

// Hapus cache lama
self.addEventListener("activate", function (event) {
    event.waitUntil(
        caches.keys().then(function (cacheNames) {
            return Promise.all(
                cacheNames
                    .filter(function (name) {
                        return name !== CACHE_NAME;
                    })
                    .map(function (name) {
                        return caches.delete(name);
                    }),
            );
        }),
    );
});
