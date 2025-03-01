<template>
  <div>
    <h2>Выход</h2>
    <button @click="logout">Выйти</button>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  methods: {
    async logout() {
      try {
        await api.post('/logout');
        localStorage.removeItem('token');
        this.$router.push('/login');
      } catch (error) {
        console.log('Ошибка выхода');
      }
    },
  },
};
</script>
