const express = require('express');
const mysql = require('mysql2/promise');
const dotenv = require('dotenv');
const cors = require('cors');


dotenv.config();

const app = express();
app.use(cors());
const port = process.env.PORT || 3000;

// Database connection configuration
const dbConfig = {
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,
};

// Create a route to count users and admins
app.get('/api/count', async (req, res) => {
    console.log('Received request for /api/count');
    let connection;
    try {
      console.log('Attempting to connect to database...');
      connection = await mysql.createConnection(dbConfig);
      console.log('Database connection established successfully');
  
      const sql = `
        SELECT 
          (SELECT COUNT(*) FROM user) AS user_count,
          (SELECT COUNT(*) FROM admins) AS admin_count
      `;
  
      console.log('Executing SQL query:', sql);
      const [results] = await connection.execute(sql);
  
      console.log('Query results:', results);
      res.json({
        user_count: results[0].user_count,
        admin_count: results[0].admin_count
      });
    } catch (error) {
      console.error('Error occurred while counting users and admins:', error);
      res.status(500).json({
        error: 'Internal server error',
        message: error.message,
        stack: error.stack
      });
    } finally {
      if (connection) {
        await connection.end();
        console.log('Database connection closed');
      }
    }
  });

// Start the server
app.listen(port, () => {
  console.log(`Server running on port ${port}`);
});