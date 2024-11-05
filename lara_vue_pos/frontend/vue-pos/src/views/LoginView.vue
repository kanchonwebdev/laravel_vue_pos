<template>
  <main>
    <div class="container">
      <div class="row">
        <div class="col-md-6" style="margin: auto;margin-top: 200px">
          <form @submit.prevent="login" class="p-4 border">
            <h2>Login</h2>
            <input type="email" v-model="email" class="form-control" placeholder="Enter your email" required>
            <input type="password" v-model="password" class="form-control" placeholder="Enter your password" required>
            <button type="submit">Login</button>
            <p v-if="loginError" class="text-danger">{{ loginError }}</p>
          </form>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const email = ref('');
const password = ref('');
const loginError = ref('');
const isAuthenticated = ref(false);

const login = () => {
  if (email.value === 'john@gmail.com' && password.value === '1234') {
    isAuthenticated.value = true;
    localStorage.setItem('isAuthenticated', true);
    router.push('/');
  } else {
    loginError.value = 'Invalid email or password';
  }
};

onMounted(() => {
  if (localStorage.getItem('isAuthenticated') === 'true') {
    isAuthenticated.value = true;
  } else {
    router.push('/login');
  }
});

</script>
