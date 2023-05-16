import axios from "axios";
import store from "./js/store/app";

const axiosClient = axios.create({
baseURL: `http://tonote-app.herokuapp.com/api`
})
axiosClient.interceptors.request.use(config => {
    config.headers.Authorization = `Bearer ${store.state.user.token}`
    return config;
})
export default axiosClient;
