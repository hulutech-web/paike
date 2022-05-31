<template>
  <div :style="style">
    <router-view></router-view>
  </div>
</template>

<script setup>
import { useRouter } from "vue-router";
const router = useRouter();
let style = "";
if (router.currentRoute.value.meta.level <= 3) {
  style = "padding: 20px;  background: white;min-height:calc(100% - 64px)";
} else {
  style = "background: white;min-height:calc(100% - 64px)";
}
</script>
<script>
export default {};
</script>
<style lang="scss" scoped></style>
