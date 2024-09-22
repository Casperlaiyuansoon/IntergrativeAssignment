const mysql = require('mysql2');

const pool = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: '', 
  database: 'foodorderingsystem', 
});

module.exports = pool.promise();
