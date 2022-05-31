import { createApp } from 'vue'
import App from './App.vue'
import 'ant-design-vue/dist/antd.css';
import '@/css/index.css'
import { message } from 'ant-design-vue';
import format from './utils/format';//文本格式化
import routes from './router'
import autoImport from '@/utils/autoimport.js'
import setupPinia from './store';
const app = createApp(App)
setupPinia(app)//状态管理
autoImport(app)//注册全局组件
format.install(app)//注册全局插件
// 特殊树形结构组件
app.config.globalProperties.$message = message;//全局消息提示
app.use(routes)
window.vm = app.mount('#app')

