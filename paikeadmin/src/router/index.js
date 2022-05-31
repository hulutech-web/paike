import routes from "./routes";

import { createRouter, createWebHashHistory } from "vue-router";

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  // console.log(to)
  // 如果用户未能验证身份，则 `next` 会被调用两次
  next()
})

export default router;
