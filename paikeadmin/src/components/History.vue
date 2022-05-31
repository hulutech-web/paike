<template>
  <div>
    <a-tag v-for="(r, index) in routes" :key="index" style="cursor: pointer" closable @click="changeRoute(r)">
      <a-badge :color="r.name == route.name ? 'green' : 'geekblue'" :text="r.meta.title" />
    </a-tag>
  </div>
</template>

<script>
import { watchEffect, ref } from "vue";
import { useRoute, useRouter, onBeforeRouteUpdate } from "vue-router";
export default {
  setup() {
    let route = useRoute();
    let router = useRouter();
    let routes = ref([]);
    console.log(route.name);
    onBeforeRouteUpdate((to) => {
      watchEffect(() => {
        // console.log("History-to.meta.title", to.meta.title);
        if (to.meta.title !== "") {
          if (routes.value.length > 6) {
            routes.value.splice(0, 1);
          }
          if (!routes.value.some((item) => item.meta.title === to.meta.title)) {
            routes.value.push(to);
          }
        }
      });
    });

    const changeRoute = (route) => {
      router.replace({ path: route.path });
    };
    return {
      routes,
      changeRoute,
      route,
    };
  },
};
</script>

<style lang="scss" scoped></style>
