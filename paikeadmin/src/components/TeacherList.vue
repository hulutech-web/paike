<template>
  <div style="display: inline">
    <a-button type="primary" size="small" @click="showDrawer" danger
      >选择老师</a-button
    >
    <a-drawer
      :width="600"
      title="老师选择"
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
      <a-table :dataSource="teachers" :columns="columns" rowKey="id" bordered size="small">
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
import teacherApi from "@/api/teacher";

export default defineComponent({
  components: { CheckOutlined, CloseOutlined },
  emits: ["selectTeacher"],
  props:['teacher'],
  setup(props,ctx) {
    let teachers = ref([]);
    let keyword = ref("");
    onMounted(() => {
      onSearch();
    });
    const visible = ref(false);
    const router = useRouter();
    const onSearch = () => {
      teacherApi.searchTeacher({ keyword: keyword.value }).then((_) => {
        teachers.value = _;
      });
    };
    const showDrawer = () => {
      visible.value = true;
      onSearch();
    };
    const handle = function (record) {
      visible.value = false;
      ctx.emit("selectTeacher", record);
    };

    return {
      columns: [
        {
          title: "ID",
          dataIndex: "id",
          key: "id",
        },
        {
          title: "姓名",
          dataIndex: "name",
          key: "name",
        },
        {
          title: "年龄",
          dataIndex: "age",
          key: "mobile",
        },
        {
          title: "文化程度",
          dataIndex: "degree",
          key: "degree",
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
      teachers,
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
