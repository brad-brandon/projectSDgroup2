<?php
session_start();
require 'config.php'; // Include your database config

// Establish connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve URL parameters
$status_id = $_GET['status_id'] ?? null;
$billcode = $_GET['billcode'] ?? null;
$order_id = $_GET['order_id'] ?? null;

// Check if the payment was successful
if ($status_id == 1 && $billcode) {
    // Retrieve transaction details from ToyyibPay
    $some_data = [
        'billCode' => $billcode
    ];
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/getBillTransactions');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    
    $response = curl_exec($curl);
    curl_close($curl);
    
    // Decode the response
    $transactions = json_decode($response, true);
    if ($transactions && isset($transactions[0])) {
        $transaction = $transactions[0];

        // Update or Insert transaction data into your transactions table
        $sql = "INSERT INTO transactions (bill_name, bill_description, bill_to, bill_email, bill_phone, 
                bill_status, bill_payment_status, bill_payment_channel, bill_payment_amount, 
                bill_payment_invoice_no, bill_payment_date, transaction_charge) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                bill_name=VALUES(bill_name), bill_description=VALUES(bill_description), bill_to=VALUES(bill_to),
                bill_email=VALUES(bill_email), bill_phone=VALUES(bill_phone), bill_status=VALUES(bill_status),
                bill_payment_status=VALUES(bill_payment_status), bill_payment_channel=VALUES(bill_payment_channel),
                bill_payment_amount=VALUES(bill_payment_amount), bill_payment_date=VALUES(bill_payment_date),
                transaction_charge=VALUES(transaction_charge)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            'sssssiissdss',
            $transaction['billName'],
            $transaction['billDescription'],
            $transaction['billTo'],
            $transaction['billEmail'],
            $transaction['billPhone'],
            $transaction['billStatus'],
            $transaction['billpaymentStatus'],
            $transaction['billpaymentChannel'],
            $transaction['billpaymentAmount'],
            $transaction['billpaymentInvoiceNo'],
            date('Y-m-d H:i:s', strtotime($transaction['billPaymentDate'])),
            $transaction['transactionCharge']
        );
        $stmt->execute();
        $stmt->close();

        // Update user's membership based on the bill_name (membership type)
        $membershipType = $transaction['billName'];
		if($membershipType=='Student Membership'){
			$membershipType='student';
		}else if($membershipType=='Normal Membership'){
			$membershipType='normal';
		}
		else{
			$membershipType='advanced';
		}
        $billEmail = $transaction['billEmail'];

        $sql = "UPDATE users SET membership_type = ?, status = 'active' WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $membershipType, $billEmail);
        $stmt->execute();
        $stmt->close();

        echo "Payment successful, and membership has been updated.";
    } else {
        echo "Error retrieving transaction details from ToyyibPay.";
    }
} else {
    echo "Payment not successful or invalid request.";
}

$conn->close();
?>
