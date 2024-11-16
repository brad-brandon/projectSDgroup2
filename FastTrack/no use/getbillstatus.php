<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$some_data = array(
  'billCode' => 'testwebsite',//edit billcode form toyyi
  'billpaymentStatus' => '1'
);  

$curl = curl_init();

curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/getBillTransactions');  
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

// Disable SSL verification
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

$result = curl_exec($curl);

if($result === false) {
    echo 'Curl error: ' . curl_error($curl);
} else {
    echo $result;
	$json_data =$result;
	//$json_data = '[{"billName":"testwebsite","billDescription":"1","billTo":"WONG TIEN FUNG","billEmail":"coolmangame5390@gmail.com","billPhone":"01129639253","billStatus":"1","billpaymentStatus":"1","billpaymentChannel":"FPX B2C","billpaymentAmount":"1.00","billpaymentInvoiceNo":"TP2410213276455101","billSplitPayment":null,"billSplitPaymentArgs":null,"billpaymentSettlement":"Pending Settlement","billpaymentSettlementDate":"0000-00-00 00:00:00","SettlementReferenceNo":"","billPaymentDate":"21-10-2024 07:37:26","billExternalReferenceNo":null,"transactionCharge":"1.00","chargeOn":"Amount"},...]';
$transactions = json_decode($json_data, true);
try {
    $pdo = new PDO('mysql:host=localhost;dbname=fasttrack_gym', 'Webs392024', 'Webs392024'); //edit here for database info
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
foreach ($transactions as $transaction) {
    // Convert date format
    $date = DateTime::createFromFormat('d-m-Y H:i:s', $transaction['billPaymentDate']);
    $formattedDate = $date->format('Y-m-d H:i:s');

    // Check if record exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM transactions WHERE bill_payment_invoice_no = :billPaymentInvoiceNo");
    $stmt->execute([':billPaymentInvoiceNo' => $transaction['billpaymentInvoiceNo']]);
    $recordExists = $stmt->fetchColumn();

    if ($recordExists) {
        // Update existing record
        $stmt = $pdo->prepare("UPDATE transactions SET
            bill_name = :billName, bill_description = :billDescription, bill_to = :billTo, bill_email = :billEmail, 
            bill_phone = :billPhone, bill_status = :billStatus, bill_payment_status = :billPaymentStatus, 
            bill_payment_channel = :billPaymentChannel, bill_payment_amount = :billPaymentAmount, 
            bill_payment_date = :billPaymentDate, transaction_charge = :transactionCharge
            WHERE bill_payment_invoice_no = :billPaymentInvoiceNo");

    } else {
        // Insert new record
        $stmt = $pdo->prepare("INSERT INTO transactions (
            bill_name, bill_description, bill_to, bill_email, bill_phone, bill_status, bill_payment_status, 
            bill_payment_channel, bill_payment_amount, bill_payment_invoice_no, bill_payment_date, transaction_charge
        ) VALUES (:billName, :billDescription, :billTo, :billEmail, :billPhone, :billStatus, :billPaymentStatus, 
                  :billPaymentChannel, :billPaymentAmount, :billPaymentInvoiceNo, :billPaymentDate, :transactionCharge)");
    }

    // Execute the query (whether insert or update)
    $stmt->execute([
        ':billName'           => $transaction['billName'],
        ':billDescription'    => $transaction['billDescription'],
        ':billTo'             => $transaction['billTo'],
        ':billEmail'          => $transaction['billEmail'],
        ':billPhone'          => $transaction['billPhone'],
        ':billStatus'         => $transaction['billStatus'],
        ':billPaymentStatus'  => $transaction['billpaymentStatus'],
        ':billPaymentChannel' => $transaction['billpaymentChannel'],
        ':billPaymentAmount'  => $transaction['billpaymentAmount'],
        ':billPaymentInvoiceNo' => $transaction['billpaymentInvoiceNo'],
        ':billPaymentDate'    => $formattedDate,
        ':transactionCharge'  => $transaction['transactionCharge'],
    ]);
}



}

curl_close($curl);
?>
