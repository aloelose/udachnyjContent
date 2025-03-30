import { defineStore } from 'pinia';
import { api } from 'src/boot/axios';

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null,
    child: null,
    login: '',
    phoneNumber: '',
    child_fio: '',
    child_age: null,
    parent_fio: '',
    diagnosis_status: '',
    diagnosis_cipher: ''
  }),
  actions: {
    async loadUserData($q) {
      try {
        const token = localStorage.getItem('authToken');
        if (!token) {
          console.warn('Токен отсутствует, требуется авторизация');
          return;
        }
        const cachedData = localStorage.getItem('userData');
        if (cachedData) {
          const parsedData = JSON.parse(cachedData);
          this.setUserData(parsedData);
          return;
        }
        const response = await api.get('/info', {
          headers: { Authorization: `Bearer ${token}` }
        });
        if (response.data?.user && response.data?.child) {
          this.setUserData(response.data);
          localStorage.setItem('userData', JSON.stringify(response.data));
        } else {
          throw new Error('Некорректный формат данных');
        }
      } catch (error) {
        console.error('Ошибка загрузки данных:', error);
        if ($q) {
          $q.notify({
            color: 'negative',
            message: 'Ошибка при загрузке данных!',
            icon: 'report_problem'
          });
        }
      }
    },
    refreshUserData($q) {
      localStorage.removeItem('userData');
      this.loadUserData($q);
    },
    setUserData(data) {
      const { user, child } = data;
      this.user = user;
      this.child = child;
      this.login = user.email;
      this.phoneNumber = user.phone_number;
      this.child_fio = child.full_name;
      this.child_age = child.age;
      this.parent_fio = user.full_name;
      this.diagnosis_status = child.status;
      this.diagnosis_cipher = child.pmpk_code;
    }
  }
});
