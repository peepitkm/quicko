const functions = require('firebase-functions');
const admin = require('firebase-admin');

// init
admin.initializeApp(functions.config().firebase);

// our functions
const order = require('./order');
const chefModule = require('./chef')

exports.getOrder = chefModule.getOrder;

// add menus
exports.addMenus = functions.https.onRequest((req, res) => {
  const item_name = req.query.name;
  const item_no = req.query.no;
  const item_type = req.query.type;
  const item_category_id = req.query.category_id;
  const item_price = req.query.price;

  let new_menu = {};
  let name = 'name';
  let no = 'no';
  let type = 'type';
  let category = 'category';
  let price = 'price';
  new_menu[name] = item_name;
  new_menu[no] = item_no;
  new_menu[type] = item_type;
  new_menu[category] = item_category_id;
  new_menu[price] = item_price;

  admin.database().ref('/menus').push(new_menu).then(snapshot => {
    console.log('A new menu item was added');
  });
});

// exports.addMenus = order.addOrder();

exports.addOrder = functions.https.onRequest((req, res) => {

  const item_table = req.query.table;
  const item_customer = req.query.customer;

  console.log(item_table, item_customer);

  let data = {};
  let table = 'table';
  let customer = 'customer';

  data[table] = item_table;
  data[customer] = item_customer;
  data['menus'] = {
    'M1':'1',
    'M2':'2'
  };

  console.log(data);

  admin.database().ref('/orders').push(data).then(snapshot => {
    console.log('A new menu item was added');
  });
});
