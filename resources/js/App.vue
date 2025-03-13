<template>
  <Toast :show="showToast" :message="toastMessage"/>
  <div class="container text-center mt-5">
    <h5 style="background: rgb(126, 211, 33); padding: 10px; text-align: center; color: white; max-width: 350px; margin: 0 auto;">Ворота Просто</h5>
    <div v-for="gate in gates" :key="gate.id">
      <GateButton :title="gate.title" :gate-id="gate.id" :is-loading="loading === gate.id" @open-gate="openGate"/>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Toast from './components/Toast.vue';
import GateButton from './components/GateButton.vue';

export default {
  components: {
    Toast,
    GateButton,
  },
  data() {
    return {
      loading: null,
      showToast: false,
      toastMessage: '',
      loadingDuration: 5000,
      gates: null,
    };
  },
  methods: {
    async fetchData() {
      try {
        const response = await axios.get('/api/v1/gates');
        this.gates = response.data;
      } catch (error) {
        console.error('Error fetching gates', error);
      }
    },
    async openGate(gateId) {
      if (this.loading !== null) return; // Не позволяем нажимать, пока идет загрузка

      this.loading = gateId;
      this.toastMessage = 'Ожидание...';
      this.showToast = true;

      // Установка таймера для скрытия сообщения через 5 секунд
      const hideToast = () => {
        this.showToast = false;
      };

      // Скрыть сообщение через 5 секунд, если получен ответ
      const timer = setTimeout(hideToast, this.loadingDuration);

      try {
        const response = await axios.post(`/api/v1/gate/open`, {gate : gateId});
        this.toastMessage = response.data.message || 'Ворота открываются';
        clearTimeout(timer);
        setTimeout(hideToast, this.loadingDuration);
      } catch (error) {
        this.toastMessage = error.response.data.message || 'Ошибка';
        clearTimeout(timer);
        setTimeout(hideToast, this.loadingDuration);
      } finally {
        // Сбрасываем состояние загрузки через 5 секунд
        setTimeout(() => {
          this.loading = null; // Сбрасываем состояние загрузки
        }, this.loadingDuration);
      }
    },
  },
  mounted() {
    this.fetchData(); // Загружаем данные при монтировании компонента
  },
};
</script>
