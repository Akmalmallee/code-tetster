<?php
$id = intval($_POST['id'] ?? 0);
$dbFile = __DIR__ . '/data/db.sqlite';
if(!$id || !file_exists($dbFile)){
  header('Location: admin_orders.php'); exit;
}
$db = new PDO('sqlite:'.$dbFile);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// ensure status and canceled_at columns exist
$cols = $db->query("PRAGMA table_info(orders)")->fetchAll(PDO::FETCH_ASSOC);
$hasStatus = false; $hasCanceledAt = false;
foreach($cols as $c){ if($c['name']==='status') $hasStatus=true; if($c['name']==='canceled_at') $hasCanceledAt=true; }
if(!$hasStatus) $db->exec("ALTER TABLE orders ADD COLUMN status TEXT DEFAULT 'ok';");
if(!$hasCanceledAt) $db->exec("ALTER TABLE orders ADD COLUMN canceled_at TEXT;");

// begin transaction: restore stock and mark canceled
$db->beginTransaction();
try{
  $stmt = $db->prepare('SELECT * FROM orders WHERE id = :id'); $stmt->execute([':id'=>$id]); $order = $stmt->fetch(PDO::FETCH_ASSOC);
  if(!$order) throw new Exception('Order not found');
  if(isset($order['status']) && $order['status']==='canceled') throw new Exception('Order already canceled');
  $items = json_decode($order['items'], true) ?: [];
  foreach($items as $it){
    $u = $db->prepare('UPDATE items SET stock = stock + :qty WHERE id = :id');
    $u->execute([':qty'=>intval($it['qty']), ':id'=>intval($it['id'])]);
  }
  $u2 = $db->prepare('UPDATE orders SET status = :st, canceled_at = :ca WHERE id = :id');
  $u2->execute([':st'=>'canceled', ':ca'=>date('c'), ':id'=>$id]);
  $db->commit();
  header('Location: order_view.php?id='.$id.'&msg=canceled'); exit;
}catch(Exception $e){
  $db->rollBack();
  header('Location: order_view.php?id='.$id.'&msg=error'); exit;
}
