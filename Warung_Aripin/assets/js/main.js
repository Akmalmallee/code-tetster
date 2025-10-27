const cart = {};
function addToCart(id) {
  const item = window.WA_ITEMS.find((i) => i.id == id);
  if (!item) return;
  const current = cart[id] || 0;
  if (item.stock !== undefined && current >= item.stock) {
    // show temporary message
    flashMessage("Jumlah melebihi stok tersedia");
    return;
  }
  cart[id] = current + 1;
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
    const item = window.WA_ITEMS.find((i) => i.id == id);
    if (!item) return;
    total += item.price * qty;
    const row = document.createElement("div");
    row.className = "cart-row";
    row.innerHTML = `<div><strong>${
      item.name
    }</strong> <div class="small">Rp ${formatNumber(
      item.price
    )} x ${qty}</div></div><div class="cart-controls"><button onclick="removeFromCart('${id}')" class="btn" style="background:#f59e0b">-</button><div class="price">Rp ${formatNumber(
      item.price * qty
    )}</div></div>`;
    el.appendChild(row);
  });
  document.getElementById("cart-total").textContent =
    "Rp " + formatNumber(total);
  const ot = document.getElementById("order_total");
  const oi = document.getElementById("order_items");
  if (ot) ot.value = total;
  if (oi) oi.value = JSON.stringify(cart);
  // update buttons disabling when stock reached and per-item badge
  const buttons = document.querySelectorAll("#items-list .item");
  let totalCount = 0;
  buttons.forEach((el) => {
    const id = el
      .querySelector('button[onclick*="addToCart"]')
      ?.getAttribute("onclick")
      ?.match(/addToCart\('?([0-9]+)'?\)/)?.[1];
    const badge = document.getElementById("badge-" + id);
    const item = window.WA_ITEMS.find((i) => i.id == id);
    const qty = cart[id] || 0;
    if (badge) badge.textContent = qty;
    totalCount += qty;
    const addBtn = el.querySelector('button[onclick*="addToCart"]');
    if (item && addBtn) {
      if (item.stock !== undefined && qty >= item.stock) {
        addBtn.disabled = true;
        addBtn.textContent = "Max";
        addBtn.style.opacity = "0.7";
      } else {
        addBtn.disabled = false;
        addBtn.textContent = "+";
        addBtn.style.opacity = "1";
      }
    }
  });
  const cartBadge = document.getElementById("cart-badge");
  if (cartBadge) cartBadge.textContent = totalCount;
}

function flashMessage(text) {
  let el = document.getElementById("wm-flash");
  if (!el) {
    el = document.createElement("div");
    el.id = "wm-flash";
    el.style.position = "fixed";
    el.style.right = "18px";
    el.style.top = "18px";
    el.style.background = "#111827";
    el.style.color = "#fff";
    el.style.padding = "10px 12px";
    el.style.borderRadius = "8px";
    el.style.zIndex = "9999";
    document.body.appendChild(el);
  }
  el.textContent = text;
  el.style.display = "block";
  setTimeout(() => (el.style.display = "none"), 1500);
}
function formatNumber(n) {
  return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
window.addEventListener("DOMContentLoaded", () => {
  renderCart();
});

// filter items by search box
function filterItems() {
  const q = (document.getElementById("item-search")?.value || "")
    .trim()
    .toLowerCase();
  const list = document.querySelectorAll("#items-list .item");
  list.forEach((el) => {
    const name = el.getAttribute("data-name") || "";
    if (!q || name.indexOf(q) !== -1) el.style.display = "";
    else el.style.display = "none";
  });
}
document.addEventListener("input", (e) => {
  if (e.target && e.target.id === "item-search") filterItems();
});
