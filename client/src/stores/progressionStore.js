import { defineStore } from 'pinia';
import { api } from 'src/boot/axios';

export const useProgressionStore = defineStore('progression', {
  state: () => ({
    ticketProgression: 0,
    lastUpdated: null,
  }),
  actions: {
    async loadProgressionData($q) {
      try {
        const token = localStorage.getItem('authToken');
        if (!token) {
          console.warn('Токен отсутствует, требуется авторизация');
          return;
        }

        // Загружаем данные из кэша
        const cachedData = localStorage.getItem('progressionData');
        if (cachedData) {
          const parsedData = JSON.parse(cachedData);
          this.setProgressionData(parsedData);
          return;
        }

        // Если данных нет в кэше, загружаем с сервера
        const response = await api.get('/lessons/completed', {
          headers: { Authorization: `Bearer ${token}` },
        });

        if (response.data) {
          this.setProgressionData({
            ticketProgression: response.data.completed_lessons.length,
            lastUpdated: new Date().getTime(),
          });
          localStorage.setItem('progressionData', JSON.stringify({
            ticketProgression: this.ticketProgression,
            lastUpdated: this.lastUpdated,
          }));
        } else {
          throw new Error('Некорректные данные о прогрессе');
        }
      } catch (error) {
        console.error('Ошибка загрузки данных о прогрессе:', error);
        if ($q) {
          $q.notify({
            color: 'negative',
            message: 'Ошибка при загрузке данных о прогрессе!',
            icon: 'report_problem',
          });
        }
      }
    },
    refreshProgressionData($q) {
      console.log("Обновляем данные");
      localStorage.removeItem('progressionData');
      this.loadProgressionData($q);
    },
    setProgressionData(data) {
      this.ticketProgression = data.ticketProgression;
      this.lastUpdated = data.lastUpdated;
    },
  },
});
