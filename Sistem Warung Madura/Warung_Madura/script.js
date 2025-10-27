function validasiForm() {
  let nama = document.getElementById("nama").value.trim();
  let telepon = document.getElementById("telepon").value.trim();
  if (nama === "" || telepon === "") {
    alert("Nama dan Telepon wajib diisi!");
    return false;
  }
  return true;
}
