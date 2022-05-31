<template>
  <div>
    <a-breadcrumb separator="/" class="flex justify-start align-center" v-if="pathArr.length > 0">
      <a-breadcrumb-item v-for="(r, index) in pathArr" :key="index">
        <span v-if="r">{{ r }}</span>
      </a-breadcrumb-item>
    </a-breadcrumb>
    <a-breadcrumb separator="/" class="flex justify-start align-center" v-else>
      <a-breadcrumb-item> <span>加载中...</span></a-breadcrumb-item>
    </a-breadcrumb>
  </div>
</template>

<script>
import { onBeforeRouteUpdate } from "vue-router";
import { ref } from "vue";
export default {
  setup() {
    let pathArr = ref([]);
    const routeLaies = (path) => {
      pathArr.value = path.split("/");
      pathArr.value.shift();
      return pathArr;
    };

    onBeforeRouteUpdate((to) => {
      routeLaies(to.path);
    });
    return { pathArr };
  },
};
</script>

<style lang="scss" scoped></style>
