self.addEventListener("push", (event) => {
    const notification = event.data.json();
    // {"title":"hello" , "body":"something amazing" , "url":"./"}
    event.waitUntil(
        self.registration.showNotification(notification.title, {
            body: notification.body,
            icon: notification.icon,
            data: {
                url: notification.url,
            },
            vibrate: [200, 100, 200], // Optional, vibration pattern
        })
    );
});

self.addEventListener("notificationclick", (event) => {
    event.waitUntil(clients.openWindow(event.notification.data.url));
});
