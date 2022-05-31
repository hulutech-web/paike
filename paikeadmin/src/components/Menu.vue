<template>
  <div>
    <a-menu mode="inline" theme="dark" :inline-collapsed="collapsed">
      <template v-for="menu in menus" :key="menu.path">
        <template v-if="!menu.children">
          <a-menu-item @click="navigateMenu(menu)" :key="menu.path">
            <template #icon>
              <y-i-park :type="menu.icon" />
            </template>
            <span>{{ menu.title }}</span>
          </a-menu-item>
        </template>

        <template v-else class="flex">
          <y-menu-item :key="menu.path" :menuInfo="menu" />
        </template>
      </template>
    </a-menu>
  </div>
</template>

<script>
import { ref } from "vue";
import menuApi from "@api/menu";
import { useRouter, useRoute } from "vue-router";
export default {
  async setup() {
    const menus = ref([]);
    const collapsed = ref(false);
    const selectedKeys = ref(["1"]);
    const router = useRouter();
    const route = useRoute();

    const navigateMenu = (menu) => {
      router.push({ name: menu.name });
    };

    const selectItem = ({ item, key, keyPath }) => {
      router.push({ path: menus.value[key].path });
    };
    menus.value = await menuApi.getMenus();
    return { navigateMenu, menus, selectItem, collapsed };
  },
};
</script>

<style lang="scss" scoped></style>
