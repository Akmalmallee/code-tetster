<?php
// send_receipt.php?id=ORDER_ID&to=you@example.com
$id = intval($_GET['id'] ?? 0);
$to = trim($_GET['to'] ?? '');
if(!$id || !$to){ echo "Missing id or to\n"; exit; }
$dbFile = __DIR__ . '/data/db.sqlite';
if(!file_exists($dbFile)){ echo "DB not found\n"; exit; }
$db = new PDO('sqlite:'.$dbFile);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->prepare('SELECT o.*, c.name,c.address,c.phone FROM orders o LEFT JOIN customers c ON c.id = o.customer_id WHERE o.id = :id');
$stmt->execute([':id'=>$id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$order){ echo "Order not found\n"; exit; }
$items = json_decode($order['items'], true) ?: [];
$body = "Order #{$order['id']}\nCustomer: {$order['name']}\nPhone: {$order['phone']}\n\nItems:\n";
foreach($items as $s) $body .= "- {$s['name']} x{$s['qty']} = Rp " . number_format($s['subtotal'],0,',','.') . "\n";
$body .= "\nTotal: Rp " . number_format($order['total'],0,',','.') . "\n";

$subject = "Struk Pesanan #{$order['id']} - Warung Aripin";
// try mail()
if(function_exists('mail')){
  $ok = mail($to, $subject, $body, "From: no-reply@warung-aripin.local\r\n");
  echo $ok ? "Email sent\n" : "Failed to send email (mail returned false)\n";
} else {
  // fallback: save to file and instruct user
  $out = __DIR__ . "/data/receipt_{$order['id']}.txt";
  file_put_contents($out, $body);
  echo "mail() not available. Receipt saved to: $out\n";
}
