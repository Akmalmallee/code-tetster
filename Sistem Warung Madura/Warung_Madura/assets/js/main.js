// Minimal JS for cart interactions
const cart = {};
function addToCart(id) {
  cart[id] = (cart[id] || 0) + 1;
  renderCart();
}
function removeFromCart(id) {
  if (!cart[id]) return;
  cart[id]--;
  if (cart[id] <= 0) delete cart[id];
  renderCart();
}
function renderCart() {
  const el = document.getElementById("cart-contents");
  if (!el) return;
  el.innerHTML = "";
  let total = 0;
  Object.entries(cart).forEach(([id, qty]) => {
    const item = window.WM_ITEMS.find((i) => i.id == id);
    if (!item) return;
    total += item.price * qty;
    const row = document.createElement("div");
    row.className = "cart-row";
    row.innerHTML = `<div><strong>${
      item.name
    }</strong> x${qty}</div><div class="price">Rp ${formatNumber(
      item.price * qty
    )}</div>`;
    el.appendChild(row);
  });
  document.getElementById("cart-total").textContent =
    "Rp " + formatNumber(total);
  document.getElementById("order_total").value = total;
  document.getElementById("order_items").value = JSON.stringify(cart);
}
function formatNumber(n) {
  return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
window.addEventListener("DOMContentLoaded", () => {
  renderCart();
});
