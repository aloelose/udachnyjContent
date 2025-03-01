<template>
  <div>
    <h2>Регистрация</h2>
    <form @submit.prevent="register">
      <input v-model="full_name" type="text" placeholder="ФИО" required />
      <input v-model="email" type="email" placeholder="Email" required />
      <input v-model="phone_number" type="text" placeholder="Телефон" required />
      <input v-model="educational_organization" type="text" placeholder="Образовательная организация" />
      
      <h3>Данные ребенка</h3>
      <input v-model="child_full_name" type="text" placeholder="ФИО ребенка" required />
      <input v-model="child_age" type="number" placeholder="Возраст ребенка" required min="1" max="18" />
      <select v-model="child_gender" required>
        <option value="М">Мужской</option>
        <option value="Ж">Женский</option>
      </select>
      <select v-model="child_status" required>
        <option value="Ребёнок-инвалид">Ребёнок-инвалид</option>
        <option value="Ребёнок с ОВЗ">Ребёнок с ОВЗ</option>
      </select>
      <input v-model="child_pmpk_code" type="text" placeholder="Код ПМПК (необязательно)" />

      <button type="submit">Зарегистрироваться</button>
    </form>
    
    <p v-if="successMessage" style="color: green;">{{ successMessage }}</p>
    <p v-if="errorMessage" style="color: red;">{{ errorMessage }}</p>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  data() {
    return {
      full_name: '',
      email: '',
      phone_number: '',
      educational_organization: '',
      
      // Данные ребенка
      child_full_name: '',
      child_age: '',
      child_gender: '',
      child_status: '',
      child_pmpk_code: '',

      errorMessage: '',
      successMessage: '',
    };
  },
  methods: {
    async register() {
      try {
        const response = await api.post('/register', {
          full_name: this.full_name,
          email: this.email,
          phone_number: this.phone_number,
          educational_organization: this.educational_organization,
          child_full_name: this.child_full_name,
          child_age: this.child_age,
          child_gender: this.child_gender,
          child_status: this.child_status,
          child_pmpk_code: this.child_pmpk_code,
        });
        console.log(response.data);
        if (response.data.message) {
          this.successMessage = response.data.message;
        }
        this.$router.push('/login');
      } catch (error) {
        this.errorMessage = 'Ошибка регистрации. Проверьте введенные данные.';
        console.error(error);
      }
    },
  },
};
</script>

<style scoped>
form {
  max-width: 500px;
  margin: 0 auto;
}

input, select, button {
  width: 100%;
  padding: 8px;
  margin: 10px 0;
}

button {
  background-color: #4CAF50;
  color: white;
  border: none;
  cursor: pointer;
}

button:hover {
  background-color: #45a049;
}

h2 {
  text-align: center;
}

h3 {
  margin-top: 20px;
}
</style>
