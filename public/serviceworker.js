console.log('Service Worker is running.', self);

self.addEventListener('install', function(event) {
    self.skipWaiting();
});

self.addEventListener('push', function(event) {
    event.waitUntil(
        self.registration.showNotification('Push Received', {
            body: 'Push Notification Received',
            tag: 'push-notification-tag' 
        })
    );
});

self.addEventListener("notificationclick", function(event) {
    event.notification.close();
}, false);