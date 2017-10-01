const functions = require('firebase-functions');
const admin = require('firebase-admin');

// admin.initializeApp(functions.config().firebase);

exports.getOrder = functions.https.onRequest((request, response) => {
  return admin.database().ref('/messages/KvIlzkm9XlQDNaa12k8').once('value', (snapshot) => {
      var event = snapshot.val();
      response.send('test:' + event.original);
   });
});
