import axios from "axios";
import { message } from "ant-design-vue";
import useErrorStore from '@/store/error.js'
import router from '@/router'
const instance = axios.create({
  headers: {
    "Content-Type": "application/json",
    'Authorization': `Bearer ${window.localStorage.getItem('token')}`
  },
});

/**
 *  
 */
instance.defaults.withCredentials = true;
instance.interceptors.request.use(
  function (config) {
    const baseUrl = import.meta.env.MODE == "development" ? "/api" : "/";
    config.baseURL = baseUrl;
    const token = window.localStorage.getItem("token");
    if (token) config.headers.Authorization = `Bearer ${token}`;
    return config;
  },
  function (error) {
    return Promise.reject(error);
  }
);

instance.interceptors.response.use(
  function (response) {
    const { data } = response;
    if (data.message) {
      message.success(data.message);
    }
    return data;
  },
  function (error) {
    if (!error.response) return
    let { status, data } = error.response
    switch (status) {
      case 422:
        const errorsStore = useErrorStore()
        errorsStore.$patch((state) => {
          state.errors = (data.errors)
        })
        break;
      case 401:
        message.error('登录已过期');
        location.href = "#/auth/login";
        break;
      case 429:
        message.error("请求次数过多");
        break;
      case 404:
        message.error("找不到资源");
        break;
      case 403:
        message.error("禁止访问");
        router.go(-1)
        break;
      case 500:
        message.error("服务器错误");
        break;
      default:
        message.error(data.message);
    }
    return Promise.reject(error);
  }
);

export default instance;
