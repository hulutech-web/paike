<template>
  <div>
    <a-sub-menu :key="menuInfo.path">
      <template #title>
        <y-i-park :type="menuInfo.icon" />
        <span>{{ menuInfo.title }}</span>
      </template>
      <template v-for="item of menuInfo.children" :key="item.path">
        <template v-if="!item.children">
          <a-menu-item :key="item.path" @click="navigate(item)">
            <y-i-park :type="item.icon" />
            {{ item.title }}
          </a-menu-item>
        </template>

        <template v-else>
          <y-menu-item :menuInfo="item" :key="item.path" />
        </template>
      </template>
    </a-sub-menu>
  </div>
</template>

<script>
import { toRefs } from "vue";
import { useRouter } from "vue-router";
export default {
  props: ["menuInfo"],
  setup(props) {
    const { menuInfo } = toRefs(props);
    const router = useRouter();
    const navigate = (route) => {
      router.push({ name: route.name });
    };
    return { menuInfo, navigate };
  },
};
</script>

<style lang="scss" scoped></style>
