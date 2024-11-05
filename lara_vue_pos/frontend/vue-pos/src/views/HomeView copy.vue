<template>
  <main>
    <div class="container-fluid">
      <div v-if="message" :class="['alert', messageType === 'success' ? 'alert-success' : 'alert-warning']"
        role="alert">
        {{ message }}
      </div>

      <div class="row">
        <div class="col-md-8">
          <div class="row">
            <div v-for="product in products" :key="product.id" class="col-md-4">
              <div class="card mb-3">
                <img :src="'http://127.0.0.1:8000/' + product.image" class="card-img-top" alt="product-img"
                  style="width: 200px; height: 200px; object-fit: cover; margin: auto;">
                <div class="card-body">
                  <h5 class="card-title">{{ product.name }}</h5>
                  <p class="card-text">{{ product.description }}</p>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"><b>Price:</b> {{ product.price }} BDT</li>
                  <li class="list-group-item"><b>Unit:</b> {{ product.unit }}</li>
                  <li class="list-group-item"><b>Category:</b> {{ product.category }}</li>
                  <li class="list-group-item"><b>Promo Code:</b> {{ product.promo_code }}</li>
                  <li class="list-group-item"><b>Available Qty:</b> {{ product.qty }}</li>
                  <li class="list-group-item"><b>Max Order:</b> {{ product.max_order }}</li>
                </ul>
                <div class="card-body">
                  <span v-if="product.qty > 0">
                    <a href="#" @click.prevent="addToCart(product, product.max_order)"
                      class="card-link btn btn-success text-white d-block">Add to Cart</a>
                  </span>
                  <span v-else>
                    <div class="bg-danger btn btn-danger d-block">Out ot Quantity</div>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <h1 class="bg-success text-white p-4 text-center">Cart Details</h1>
          <div class="row">
            <div v-if="cart.length === 0" class="col-12 text-center">
              <p class="text-warning">Your cart is empty. Please add items.</p>
            </div>
            <div v-else class="col-12">
              <div class="row">
                <div v-for="(item, index) in cart" :key="item.id" class="col-md-6">
                  <div class="card mb-3">
                    <img :src="'http://127.0.0.1:8000/' + item.image"
                      style="width: 100px; height: 100px; object-fit: cover; margin: auto;" class="card-img-top"
                      alt="product-img">
                    <div class="card-body">
                      <h5 class="card-title">{{ item.name }}</h5>
                      <p>Price: {{ item.price }} BDT</p>
                      {{ item.qty }}
                      <input type="number" v-model.number="item.quantity" @input="updateQuantity(index, item.quantity)"
                        min="1" max="10" class="form-control mb-2" placeholder="Cart item quantity">
                      <a href="#" @click.prevent="removeFromCart(index)" class="card-link btn btn-danger d-block">Remove
                        Cart</a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="d-flex">
                  <input type="text" v-model="promoCode" class="form-control" placeholder="Enter Promo Code">
                  <a href="#" @click.prevent="applyPromoCode()" class="btn btn-primary">Apply Promo Code</a>
                </div>
              </div>

              <h4 class="mt-3 border p-4">Grand Total: {{ calculateGrandTotal() }} BDT</h4>

              <div class="col-md-12">
                <input type="text" v-model="customerName" class="form-control mb-2" placeholder="Enter your name">
                <input type="text" v-model="customerPhone" class="form-control mb-2"
                  placeholder="Enter your phone number">
              </div>

              <div class="col-md-12">
                <button @click="checkout" class="btn btn-success form-control mt-3">Checkout</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Invoice Modal -->
      <div v-if="showModal" class="modal">
        <div class="modal-content">
          <span class="close" @click="closeModal">&times;</span>
          <h2 class="border-bottom pb-2">Invoice Details</h2>
          <p><b>Customer Name:</b> {{ customerName }}</p>
          <p><b>Customer Phone:</b> {{ customerPhone }}</p>
          <p><b>Promo Code:</b> {{ promoCode }}</p>
          <p><b>Discount:</b> {{ discount }} BDT</p>
          <h4>Cart Items:</h4>
          <ul class="list-group">
            <li v-for="item in cart" :key="item.id" class="list-group-item d-flex align-items-center">
              <img :src="'http://127.0.0.1:8000/' + item.image"
                style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;" alt="product-img">
              {{ item.name }} - {{ item.quantity }} pcs - {{ item.price }} BDT each
            </li>
          </ul>
          <h4 class="mt-4 border-top pt-2">Grand Total: {{ calculateGrandTotal() }} BDT</h4>
          <button @click="printPDF" class="btn btn-primary mt-3">Print PDF</button>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import jsPDF from 'jspdf';

const products = ref([]);
const cart = ref(JSON.parse(localStorage.getItem('cart')) || []);
const message = ref('');
const messageType = ref('');
const promoCode = ref('');
const discount = ref(0);
const customerName = ref('');
const customerPhone = ref('');
const showModal = ref(false);

const saveCartToLocalStorage = () => {
  localStorage.setItem('cart', JSON.stringify(cart.value));
};

onMounted(async () => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/product/productlist');
    products.value = response.data;
  } catch (error) {
    console.error("Error fetching products:", error);
  }
});

const addToCart = (product, max_order) => {
  const itemInCart = cart.value.find(item => item.id === product.id);
  if (itemInCart) {
    if (itemInCart.quantity < max_order) {
      itemInCart.quantity += 1;
      message.value = 'Cart updated successfully!';
      messageType.value = 'success';
    } else {
      message.value = `Maximum quantity of ${max_order} reached for this item.`;
      messageType.value = 'warning';
    }
  } else {
    cart.value.push({ ...product, quantity: 1 });
    message.value = 'Product added to cart successfully!';
    messageType.value = 'success';
  }
  saveCartToLocalStorage();
  clearMessage();
};

const updateQuantity = (index, quantity) => {
  if (quantity >= 1 && quantity <= 10) {
    cart.value[index].quantity = quantity;
    message.value = 'Cart updated successfully!';
    messageType.value = 'success';
  } else if (quantity > 10) {
    message.value = 'Maximum quantity is 10.';
    messageType.value = 'warning';
  }
  saveCartToLocalStorage();
  clearMessage();
};

const removeFromCart = (index) => {
  cart.value.splice(index, 1);
  message.value = 'Item removed from cart successfully!';
  messageType.value = 'success';
  saveCartToLocalStorage();
  clearMessage();
};

const clearMessage = () => {
  setTimeout(() => {
    message.value = '';
    messageType.value = '';
  }, 2000);
};

const calculateGrandTotal = () => {
  let total = 0;
  cart.value.forEach(item => {
    total += item.price * item.quantity;
  });
  return total - discount.value;
};

const applyPromoCode = () => {
  if (promoCode.value === 'DISCOUNT10') {
    discount.value = 10;
    message.value = 'Promo code applied successfully!';
    messageType.value = 'success';
  } else {
    message.value = 'Invalid promo code.';
    messageType.value = 'warning';
  }
  clearMessage();
};

const checkout = async () => {
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  if (cart.value.length === 0) {
    message.value = 'Your cart is empty. Please add items to checkout.';
    messageType.value = 'warning';
    clearMessage();
  } else if (!customerName.value || !customerPhone.value) {
    message.value = 'Please provide your name and phone number.';
    messageType.value = 'warning';
    clearMessage();
  } else {
    showModal.value = true;
    const cartData = {
      customername: customerName.value,
      phone: customerPhone.value,
      status: 'paid',
      amount: calculateGrandTotal(),
      sales_by: 'kanchon',
      desc: cart.value
    };
    console.log(cart.value);
    try {
      const response = await axios.post('http://127.0.0.1:8000/invoice/store', cartData, {
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'Content-Type': 'application/json',
        }
      });

      if (response.status === 200) {
        console.log(response);
      }
    } catch (error) {
      console.log(error);
    }
  }
};

const closeModal = () => {
  showModal.value = false;
  cart.value = [];
  promoCode.value = '';
  discount.value = 0;
  customerName.value = '';
  customerPhone.value = '';
  saveCartToLocalStorage();
};

const printPDF = () => {
  const doc = new jsPDF();
  doc.text(`Invoice Details`, 20, 20);
  doc.text(`Customer Name: ${customerName.value}`, 20, 30);
  doc.text(`Customer Phone: ${customerPhone.value}`, 20, 40);
  doc.text(`Promo Code: ${promoCode.value}`, 20, 50);
  doc.text(`Discount: ${discount.value} BDT`, 20, 60);

  let y = 70;
  cart.value.forEach(item => {
    doc.text(`${item.name} - ${item.quantity} pcs - ${item.price} BDT each`, 20, y);
    y += 10;
  });

  doc.text(`Grand Total: ${calculateGrandTotal()} BDT`, 20, y + 10);
  doc.save('invoice.pdf');

};
</script>

<style>
.container-fluid {
  margin-top: 15px;
}

.modal {
  display: block;
  /* Show modal */
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: white;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
  position: relative;
  top: 50%;
  transform: translateY(-50%);
}

.close {
  position: absolute;
  right: 10px;
  top: 10px;
  font-size: 20px;
  cursor: pointer;
}

.alert-success,
.alert-warning {
  position: absolute;
  top: 20px;
  right: 20px;
}
</style>
