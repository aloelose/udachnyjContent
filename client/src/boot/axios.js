import axios from 'axios'

const api = axios.create({
  baseURL: 'https://xn----8sblvt6a5a7a.online/api',
  withCredentials: true,
  headers: {
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest'
  }
})

function getCsrfToken() {
  const metaTag = document.querySelector('meta[name="csrf-token"]')
  return metaTag ? metaTag.content : null
}

api.interceptors.request.use(config => {
  const token = getCsrfToken()
  if (token && !config.url?.includes('/sanctum/csrf-cookie')) {
    config.headers['X-XSRF-TOKEN'] = token
  }
  return config
}, error => {
  return Promise.reject(error)
})

api.interceptors.response.use(response => response, async error => {
  if (error.response?.status === 419) {
    await axios.get('https://xn----8sblvt6a5a7a.online/api/sanctum/csrf-cookie', {
      withCredentials: true
    })
    return api(error.config)
  }
  return Promise.reject(error)
})

export default ({ app }) => {
  app.config.globalProperties.$axios = axios
  app.config.globalProperties.$api = api
}

export { api }