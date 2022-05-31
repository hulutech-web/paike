<template>
  <div>
    <a-card title="登录信息">
      <a-table :columns="columns" :data-source="infos" rowKey="id" size="small" bordered />
    </a-card>
  </div>
</template>
<script>
export default {
  meta: { title: "登录信息" },
};
</script>
<script setup>
import LogininfoApi from "@api/logininfo";
import { onMounted, ref } from "@vue/runtime-core";
let infos = ref([]);
const columns = [
  {
    title: "ID",
    dataIndex: "id",
    key: "id",
  },
  {
    title: "Tokenable_id",
    dataIndex: "tokenable_id",
    key: "tokenable_id",
  },
  {
    title: "方式",
    dataIndex: "name",
    key: "name",
  },
  {
    title: "能力",
    dataIndex: "abilities",
    key: "abilities",
    width: 300,
  },
];
const getLogininfo = () => {
  LogininfoApi.getlogininfo().then((_) => {
    infos.value = _;
  });
};
onMounted(() => {
  getLogininfo();
});
</script>

<style lang="scss" scoped>
</style>
