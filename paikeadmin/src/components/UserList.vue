<template>
  <div style="display: inline">
    <a-button type="primary" size="small" @click="showDrawer" danger
      >选择用户</a-button
    >
    <a-drawer
      :width="600"
      title="用户选择"
      placement="right"
      :visible="visible"
      @close="visible = false"
    >
      <div>
        <a-input-search
          style="width: 200px"
          v-model:value="keyword"
          placeholder="关键字搜索"
          enter-button
          @search="onSearch"
        />
      </div>
      <a-table :dataSource="users" :columns="columns" rowKey="id" bordered size="small">
        <template #bodyCell="{ record, column }" style="position: relative">
          <a-button
            type="primary"
            v-if="column.key == 'action'"
            @click="handle(record)"
            >选择</a-button
          >
        </template>
      </a-table>
    </a-drawer>
  </div>
</template>
<script>
import { onMounted, ref,defineComponent } from "vue";
import { useRouter } from "vue-router";
import { CheckOutlined, CloseOutlined } from "@ant-design/icons-vue";
import userApi from "@/api/user";

export default defineComponent({
  components: { CheckOutlined, CloseOutlined },
  emits: ["selectUser"],
  props:['user'],
  setup(props,ctx) {
    let users = ref([]);
    let keyword = ref("");
    onMounted(() => {
      onSearch();
    });
    const visible = ref(false);
    const router = useRouter();
    const onSearch = () => {
      userApi.searchUser({ keyword: keyword.value }).then((_) => {
        users.value = _;
      });
    };
    const showDrawer = () => {
      visible.value = true;
      onSearch();
    };
    const handle = function (record) {
      ctx.emit("selectUser", record);
      visible.value = false;
    };

    return {
      columns: [
        {
          title: "ID",
          dataIndex: "id",
          key: "id",
        },
        {
          title: "昵称",
          dataIndex: "nickname",
          key: "nickname",
        },
        {
          title: "电话",
          dataIndex: "mobile",
          key: "mobile",
        },
        {
          title: "操作",
          dataIndex: "action",
          key: "action",
        },
      ],
      keyword,
      onSearch,
      showDrawer,
      visible,
      handle,
      users,
    };
  },
});
</script>
<style lang="scss" scoped>
.full-modal {
  .ant-modal {
    max-width: 100%;
    top: 0;
    padding-bottom: 0;
    margin: 0;
  }
  .ant-modal-content {
    display: flex;
    flex-direction: column;
    height: calc(100vh);
  }
  .ant-modal-body {
    flex: 1;
  }
}
</style>
