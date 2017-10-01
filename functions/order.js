const functions = require('firebase-functions');
const admin = require('firebase-admin');

exports.addOrder = functions.https.onRequest((req, res) => {

  const table = req.query.table;
  const customer = req.query.customer;

  let data = {
    table : req.query.table,
    customer : req.query.customer
  };

  console.log(req.query);

  // admin.database().ref('/orders').push(data).then(snapshot => {
  //   console.log('A new menu item was added');
  // });

});