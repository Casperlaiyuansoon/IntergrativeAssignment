from flask import Flask, request, jsonify
import mysql.connector
from mysql.connector import Error
import os
import logging
from functools import wraps

app = Flask(__name__)

# Configure logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

# Database configuration
db_config = {
    'host': os.getenv('DB_HOST', 'localhost'),
    'user': os.getenv('DB_USER', 'root'),
    'password': os.getenv('DB_PASS', ''),
    'database': os.getenv('DB_NAME', 'promotion_system')
}

# Function to create a database connection
def create_connection():
    try:
        connection = mysql.connector.connect(**db_config)
        if connection.is_connected():
            return connection
    except Error as e:
        logger.error(f"Database connection error: {e}")
    return None

# Centralized error handler
@app.errorhandler(500)
def internal_error(error):
    logger.error(f"Internal error: {error}")
    return jsonify({"success": False, "message": "Internal server error."}), 500

@app.errorhandler(400)
def bad_request(error):
    return jsonify({"success": False, "message": str(error)}), 400

# API to get all promotions
@app.route('/promotions', methods=['GET'])

def get_promotions():
    connection = create_connection()
    if not connection:
        return jsonify({"success": False, "message": "Database connection failed."}), 500

    cursor = connection.cursor(dictionary=True)
    cursor.execute("SELECT * FROM promotions")
    promotions = cursor.fetchall()
    cursor.close()
    connection.close()
    return jsonify({"success": True, "data": promotions})

# API to get all notifications
@app.route('/notifications', methods=['GET'])

def get_notifications():
    connection = create_connection()
    if not connection:
        return jsonify({"success": False, "message": "Database connection failed."}), 500

    cursor = connection.cursor(dictionary=True)
    cursor.execute("SELECT * FROM notifications")
    notifications = cursor.fetchall()
    cursor.close()
    connection.close()
    return jsonify({"success": True, "data": notifications})

# API to create a new notification
@app.route('/notifications', methods=['POST'])

def create_notification():
    data = request.json
    logger.info("Incoming data for creation: %s", data)

    # Validate incoming data
    required_fields = ['customer_id', 'promotion_id', 'message']
    if not all(field in data for field in required_fields):
        return jsonify({"success": False, "message": f"All fields ({', '.join(required_fields)}) are required."}), 400

    connection = create_connection()
    if not connection:
        return jsonify({"success": False, "message": "Database connection failed."}), 500

    try:
        cursor = connection.cursor()
        cursor.execute("""
            INSERT INTO notifications (customer_id, promotion_id, message, status, created_at, updated_at)
            VALUES (%s, %s, %s, %s, NOW(), NOW())
        """, (data['customer_id'], data['promotion_id'], data['message'], 'pending'))
        connection.commit()
        new_notification_id = cursor.lastrowid
        cursor.close()
        connection.close()
        return jsonify({"success": True, "message": "Notification created", "data": {"id": new_notification_id, **data}}), 201
    except Error as e:
        logger.error(f"Error creating notification: {e}")
        return jsonify({"success": False, "message": "Failed to create notification.", "error": str(e)}), 500

# API to update a notification
@app.route('/notifications/<int:id>', methods=['PUT'])

def update_notification(id):
    data = request.json
    logger.info("Incoming data for update: %s", data)

    # Validate incoming data
    if not any(k in data for k in ('customer_id', 'promotion_id', 'message', 'status')):
        return jsonify({"success": False, "message": "At least one field (customer_id, promotion_id, message, status) is required to update."}), 400

    connection = create_connection()
    if not connection:
        return jsonify({"success": False, "message": "Database connection failed."}), 500

    try:
        cursor = connection.cursor()
        cursor.execute("""
            UPDATE notifications 
            SET customer_id = %s, promotion_id = %s, message = %s, status = %s, updated_at = NOW() 
            WHERE id = %s
        """, (
            data.get('customer_id', None),
            data.get('promotion_id', None),
            data.get('message', None),
            data.get('status', 'pending'),
            id
        ))
        connection.commit()
        cursor.close()
        connection.close()
        return jsonify({"success": True, "message": "Notification updated"}), 200
    except Error as e:
        logger.error(f"Error updating notification: {e}")
        return jsonify({"success": False, "message": "Failed to update notification.", "error": str(e)}), 500

# API to delete a notification
@app.route('/notifications/<int:id>', methods=['DELETE'])

def delete_notification(id):
    connection = create_connection()
    if not connection:
        return jsonify({"success": False, "message": "Database connection failed."}), 500

    cursor = connection.cursor()
    cursor.execute("DELETE FROM notifications WHERE id = %s", (id,))
    connection.commit()
    cursor.close()
    connection.close()
    return jsonify({"success": True, "message": "Notification deleted"}), 200

if __name__ == '__main__':
    app.run(debug=True)
