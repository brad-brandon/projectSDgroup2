<?php
// payment_callback.php
require 'config.php';
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve POST data
$refno = $_POST['refno'] ?? null;
$status = $_POST['status'] ?? null;
$billcode = $_POST['billcode'] ?? null;

if ($refno && $status && $billcode) {
    $some_data = ['billCode' => $billcode];
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/getBillTransactions');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    $response = curl_exec($curl);
    curl_close($curl);
    
    $transactions = json_decode($response, true);
    if ($transactions && isset($transactions[0])) {
        $transaction = $transactions[0];

        $sql = "INSERT INTO transactions (bill_name, bill_description, bill_to, bill_email, 
                bill_phone, bill_status, bill_payment_status, bill_payment_channel, 
                bill_payment_amount, bill_payment_invoice_no, bill_payment_date, transaction_charge) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE bill_status=VALUES(bill_status), 
                bill_payment_status=VALUES(bill_payment_status), bill_payment_date=VALUES(bill_payment_date)";
                
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

        if ($status == 1) { // success status
            $membershipType = $transaction['billName'];
            $billEmail = $transaction['billEmail'];
            
            $updateSql = "UPDATE users SET membership_type = ? WHERE email = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("ss", $membershipType, $billEmail);
            $stmt->execute();
            $stmt->close();
        }
    }
}

$conn->close();
http_response_code(200);
echo "Callback handled successfully.";
?>
