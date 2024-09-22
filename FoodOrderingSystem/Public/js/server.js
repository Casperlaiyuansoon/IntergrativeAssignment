const express = require('express');
const bodyParser = require('body-parser');
const db = require('./db.js');

const app = express();
app.use(bodyParser.json());

// Pretty print JSON responses
const prettyPrintJson = (res, data) => {
  res.setHeader('Content-Type', 'application/json');
  res.send(JSON.stringify(data, null, 2)); // Pretty print with 2-space indentation
};

// Get all users
app.get('/users', async (req, res) => {
  try {
    const [rows] = await db.execute("SELECT user_id, username, email, phone_number, createAt, status FROM user");
    prettyPrintJson(res, rows);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Get all admins
app.get('/admins', async (req, res) => {
  try {
    const [rows] = await db.execute("SELECT admin_id, usernameAdmin, emailAdmin, phoneAdmin, createAt, role FROM admins");
    prettyPrintJson(res, rows);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Search users by username
app.get('/users/search', async (req, res) => {
  const { query } = req.query;
  try {
    const [rows] = await db.execute("SELECT * FROM user WHERE username LIKE ?", [`%${query}%`]);
    prettyPrintJson(res, rows);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Search admins by username
app.get('/admins/search', async (req, res) => {
  const { query } = req.query;
  try {
    const [rows] = await db.execute("SELECT * FROM admins WHERE usernameAdmin LIKE ?", [`%${query}%`]);
    prettyPrintJson(res, rows);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

const bcrypt = require('bcrypt');
const saltRounds = 10;

// Add a new user
app.post('/users', async (req, res) => {
  const { username, email, phone_number, password, status } = req.body;
  try {
    const hashedPassword = await bcrypt.hash(password, saltRounds); // Hash password
    await db.execute(
      "INSERT INTO user (username, email, phone_number, password, status, createAt) VALUES (?, ?, ?, ?, ?, NOW())",
      [username, email, phone_number, hashedPassword, status]
    );
    prettyPrintJson(res, { message: 'User added successfully!' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Add a new admin
app.post('/admins', async (req, res) => {
  const { username, email, phone_number, password, role } = req.body;
  try {
    const hashedPassword = await bcrypt.hash(password, saltRounds); // Hash password
    await db.execute(
      "INSERT INTO admins (usernameAdmin, emailAdmin, phoneAdmin, passwordAdmin, role, createAt) VALUES (?, ?, ?, ?, ?, NOW())",
      [username, email, phone_number, hashedPassword, role]
    );
    prettyPrintJson(res, { message: 'Admin added successfully!' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});


// Delete a user
app.delete('/users/:id', async (req, res) => {
  const { id } = req.params;
  try {
    await db.execute("DELETE FROM user WHERE user_id = ?", [id]);
    prettyPrintJson(res, { message: 'User deleted successfully!' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Delete an admin
app.delete('/admins/:id', async (req, res) => {
  const { id } = req.params;
  try {
    await db.execute("DELETE FROM admins WHERE admin_id = ?", [id]);
    prettyPrintJson(res, { message: 'Admin deleted successfully!' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Get user by ID
app.get('/users/:id', async (req, res) => {
  const { id } = req.params;
  try {
    const [rows] = await db.execute("SELECT * FROM user WHERE user_id = ?", [id]);
    prettyPrintJson(res, rows[0]);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Update user
app.put('/users/:id', async (req, res) => {
  const { id } = req.params;
  const { username, email, phone_number, status } = req.body;
  try {
    await db.execute(
      "UPDATE user SET username = ?, email = ?, phone_number = ?, status = ? WHERE user_id = ?",
      [username, email, phone_number, status, id]
    );
    prettyPrintJson(res, { message: 'User updated successfully!' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Update admin
app.put('/admins/:id', async (req, res) => {
  const { id } = req.params;
  const { username, email, phone_number, role } = req.body;
  try {
    await db.execute(
      "UPDATE admins SET usernameAdmin = ?, emailAdmin = ?, phoneAdmin = ?, role = ? WHERE admin_id = ?",
      [username, email, phone_number, role, id]
    );
    prettyPrintJson(res, { message: 'Admin updated successfully!' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Start the server
const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
