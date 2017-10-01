const functions = require('firebase-functions');
const admin = require('firebase-admin');

// admin.initializeApp(functions.config().firebase);

exports.getOrder = functions.https.onRequest((request, response) => {
  // const params = request.url.split("/");
  // const eventId = params[1];
  return admin.database().ref('/orders/-KvM9atGT8lWt28k5avB').once('value', (snapshot) => {
      var event = snapshot.val();
      var key = Object.keys(event.menus);
      response.send('test:' + key);
   });
});
