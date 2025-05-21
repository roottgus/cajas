// public/service-worker.js

self.addEventListener('install', e => {
  // Hace que el SW pase a activo sin esperar
  self.skipWaiting();
});

self.addEventListener('activate', e => {
  // Toma el control de las páginas abiertas en el scope
  e.waitUntil(self.clients.claim());
});
