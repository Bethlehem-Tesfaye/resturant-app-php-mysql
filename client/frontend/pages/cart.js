function updateSubtotal() {
  let subtotal = 0;
  const cartItems = []; 

  document.querySelectorAll('.cart-item').forEach(item => {
    const id = item.dataset.id;
    const price = parseFloat(item.dataset.price);
    const quantity = parseInt(item.querySelector('.quantity').innerText);
    const total = price * quantity;

    item.querySelector('.item-total').innerText = '$' + total.toFixed(2);
    subtotal += total;

    cartItems.push({
      id: id,
      price: price,
      quantity: quantity
    });
  });

  document.getElementById('subtotal').innerText = subtotal.toFixed(2);
  document.getElementById('subtotalInput').value = subtotal.toFixed(2);

  document.getElementById('cartItemsInput').value = JSON.stringify(cartItems);
}



document.querySelectorAll('.increase').forEach(button => {
  button.addEventListener('click', () => {
    const quantitySpan = button.parentElement.querySelector('.quantity');
    quantitySpan.innerText = parseInt(quantitySpan.innerText) + 1;
    updateSubtotal();
  });
});

document.querySelectorAll('.decrease').forEach(button => {
  button.addEventListener('click', () => {
    const quantitySpan = button.parentElement.querySelector('.quantity');
    let qty = parseInt(quantitySpan.innerText);
    if (qty > 1) {
      quantitySpan.innerText = qty - 1;
      updateSubtotal();
    }
  });
});
updateSubtotal();
