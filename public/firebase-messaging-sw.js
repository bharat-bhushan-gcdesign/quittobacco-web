/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');
   
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
        apiKey: "AIzaSyAa3vfkbLaDCzPakAl_LYI8sScgQW8WhEQ",
    authDomain: "who-app-615c6.firebaseapp.com",
    databaseURL: "https://who-app-615c6.firebaseio.com",
    projectId: "who-app-615c6",
    storageBucket: "who-app-615c6.appspot.com",
    messagingSenderId: "765623951630",
    appId: "1:765623951630:web:494b34ddf2d96e668fb75f",
    measurementId: "G-M8GGVLF90Z"
    });
  
/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    /* Customize notification here */
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };
  
    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});