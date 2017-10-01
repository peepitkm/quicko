const functions = require('firebase-functions');
const admin = require('firebase-admin');
admin.initializeApp(functions.config().firebase);

const chefModule = require('./chef')

exports.getOrder = chefModule.getOrder;
