import axios from 'axios';

// Создаем экземпляр axios для обращения к вашему API
const api = axios.create({
  baseURL: 'http://localhost:8000/api', // Ваш URL API
  headers: {
    'Content-Type': 'application/json',
  },
});

api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`; 
    }
    return config;
  },
  (error) => Promise.reject(error)
);

export default api;
