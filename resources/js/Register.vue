<template>
  <div class="container text-center mt-5">
    <h3>Регистрация</h3>
    <input v-model="name" placeholder="Имя" class="form-control mb-2" />
    <input v-model="email" placeholder="Email" class="form-control mb-2" />
    <input v-model="password" type="password" placeholder="Пароль" class="form-control mb-2" />
    <input v-model="password_confirmation" type="password" placeholder="Подтверждение пароля" class="form-control mb-2" />
    <button @click="register" class="btn bg-warning fw-bold">Зарегистрироваться</button>
    <p class="mt-3">
      Уже есть аккаунт? <router-link to="/login">Войти</router-link>
    </p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    };
  },
  methods: {
    async register() {
      try {
        await axios.post('/api/v1/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        });

        alert('Регистрация успешна, войдите в систему');
        this.$router.push('/login');
      } catch (error) {
        alert(error.response.data.message || 'Ошибка регистрации');
      }
    }
  }
};
</script>
