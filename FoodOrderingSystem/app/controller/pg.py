from flask import Flask, request, jsonify
import mysql.connector
from mysql.connector import Error

app = Flask(__name__)

@app.route('/api/payment', methods=['POST'])
def process_payment():
    data = request.get_json()

    # Extract payment details from request
    card_number = data.get('CardNumber')
    expiry_date = data.get('ExpiryDate')
    cvv = data.get('CVV')

    dcn = data.get('DCN')
    dce = data.get('DCE')
    dcvv = data.get('DCVV')

    # Simulate payment processing logic (implement real payment logic here)
    if (validate_payment(card_number, expiry_date, cvv, dcn, dce, dcvv) == True):
        return jsonify({'status': 'success', 'message': 'Payment processed successfully.'})
    else:
        return jsonify({'status': 'failure', 'message': 'Invalid payment details.'}), 400

def validate_payment(card_number, expiry_date, cvv, dcn, dce, dcvv):

    if(card_number == dcn and expiry_date == dce and cvv == dcvv):
        return True
    else:
        return False

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)