<?php
// Simple admin uploader: upload image and attach to item id
$dbFile = __DIR__ . '/data/db.sqlite';
if(!file_exists($dbFile)) die('DB missing');
$db = new PDO('sqlite:'.$dbFile);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$items = $db->query('SELECT id,name FROM items')->fetchAll(PDO::FETCH_ASSOC);
$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $id = intval($_POST['item_id'] ?? 0);
  if(!$id) $msg = 'Pilih item';
  elseif(empty($_FILES['image']['tmp_name'])) $msg = 'Pilih file gambar';
  else{
    $f = $_FILES['image'];
    $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
    $allowed = ['png','jpg','jpeg','gif'];
    if(!in_array(strtolower($ext), $allowed)) $msg = 'Tipe file tidak diizinkan';
    else{
      $targetDir = __DIR__ . '/assets/img/products/';
      if(!is_dir($targetDir)) mkdir($targetDir,0755,true);
      $filename = 'prod_' . $id . '_' . time() . '.' . $ext;
      $dest = $targetDir . $filename;
      if(move_uploaded_file($f['tmp_name'], $dest)){
        $db->prepare('UPDATE items SET image = :img WHERE id = :id')->execute([':img'=>'products/' . $filename, ':id'=>$id]);
        $msg = 'Upload sukses';
      } else $msg = 'Gagal menyimpan file';
    }
  }
}
?><!doctype html>
<html lang="id"><head><meta charset="utf-8"/><meta name="viewport" content="width=device-width,initial-scale=1"/><title>Upload Gambar Produk</title>
<link rel="stylesheet" href="assets/css/style.css"/></head><body>
  <div class="container">
    <h2>Upload Gambar Produk</h2>
    <?php if($msg): ?><div class="card small"><?=htmlspecialchars($msg)?></div><?php endif; ?>
    <div class="card">
      <form method="post" enctype="multipart/form-data">
        <div class="field"><label>Produk</label>
          <select name="item_id" class="input">
            <option value="0">-- pilih --</option>
            <?php foreach($items as $it): ?>
              <option value="<?= $it['id'] ?>"><?= htmlspecialchars($it['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field"><label>Gambar (png/jpg)</label><input type="file" name="image" accept="image/*" /></div>
        <div><button class="btn" type="submit">Upload</button> <a class="btn" href="admin_orders.php">Kembali</a></div>
      </form>
    </div>
  </div>
</body></html>