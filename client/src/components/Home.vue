<template>
  <div>
    <h2>Домашняя страница</h2>
    <div v-if="loading">Загрузка...</div>
    <div v-if="loadingComplete">
      <div v-if="user">
        <h3>Привет, {{ user.full_name }}</h3>
        <p>Email: {{ user.email }}</p>
        <p>Телефон: {{ user.phone_number }}</p>
        <p>Образовательная организация: {{ user.educational_organization }}</p>
        <p>Данные ребенка:</p>
        <ul>
          <li>ФИО: {{ child.full_name }}</li>
          <li>Возраст: {{ child.age }}</li>
          <li>Пол: {{ child.gender }}</li>
          <li>Статус: {{ child.status }}</li>
        </ul>
      </div>
      <div v-else>
        <p>Вы не авторизованы. Пожалуйста, войдите в систему.</p>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../services/api'; 

export default {
  data() {
    return {
      user: null,
      child: null,
      errorMessage: '',
      loading: true,
      loadingComplete: false,
    };
  },
  mounted() {
    this.getUserInfo();
  },
  methods: {
    async getUserInfo() {
      try {
        const token = localStorage.getItem('token');
        if (token) {
          const response = await api.get('/user', {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          });
          const responseChild = await api.get('/user/child', {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          });
          this.child = responseChild.data;
          this.user = response.data;
        } else {
          this.errorMessage = 'Вы не авторизованы.';
        }
      } catch (error) {
        this.errorMessage = 'Не удалось получить данные пользователя. Возможно, вы не авторизованы.';
      } finally {
        this.loading = false;
        this.loadingComplete = true;
      }
    },
  },
};
</script>

<style scoped>
/* Стили для компонента */
h3 {
  color: #4CAF50;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  margin: 5px 0;
}

/* Стиль для индикатора загрузки */
div[v-if="loading"] {
  font-size: 18px;
  color: #888;
}
</style>
