<template>
  <div style="position: absolute; right: 0; top: 0;" class="text-end me-5 mt-2" v-if="isAuth">
    <button @click="logout" class="btn btn-sm btn-outline-danger">Выйти</button>
  </div>
  <div class="container text-center mt-5">
    <router-link style="text-decoration: none;" to="/">
      <h5 style="background: rgb(126, 211, 33); padding: 10px; text-align: center; color: white;">Ворота Просто</h5>
    </router-link>
  </div>
  <router-view />
</template>

<script>
import axios from 'axios';

export default {
  computed: {
    isAuth() {
      return !!localStorage.getItem('token');
    }
  },
  methods: {
    async logout() {
      try {
        await axios.post('/api/v1/logout');
      } catch (e) {
        // Ошибку можно игнорировать
      } finally {
        localStorage.removeItem('token');
        delete axios.defaults.headers.common['Authorization'];
        this.$router.push('/login');
      }
    }
  },
  mounted() {
    const token = localStorage.getItem('token');
    if (token) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    }
  }
};
</script>
