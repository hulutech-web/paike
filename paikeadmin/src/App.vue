<template>
  <a-config-provider :locale="locale">
    <Suspense>
      <router-view></router-view>
      <template #fallback>Loading...</template>
    </Suspense>
  </a-config-provider>
</template>


<script>
import zhCN from "ant-design-vue/es/locale/zh_CN";
export default {
  data() {
    return {
      locale: zhCN,
    };
  },
};
</script>
<style>
@import "@/assets/base.css";
</style>
