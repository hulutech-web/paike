import { createPinia } from 'pinia'
export default function setupPinia(app) {
  app.use(createPinia())
}