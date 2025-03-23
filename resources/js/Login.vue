<template>
  <div class="container text-center mt-5">
    <h3>Вход</h3>
    <input v-model="email" placeholder="Email" class="form-control mb-2" />
    <input v-model="password" type="password" placeholder="Пароль" class="form-control mb-2" />
    <button @click="login" class="btn bg-warning fw-bold">Войти</button>
    <p class="mt-3">
      Нет аккаунта? <router-link to="/register">Регистрация</router-link>
    </p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('/api/v1/login', {
          email: this.email,
          password: this.password
        });

        localStorage.setItem('token', response.data.access_token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.access_token}`;

        this.$router.push('/');
      } catch (error) {
        alert(error.response.data.message || 'Ошибка входа');
      }
    }
  }
};
</script>
