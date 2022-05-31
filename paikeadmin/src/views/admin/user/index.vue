<template>
  <div>
    <a-spin :spinning="spinning" class="spin">
      <a-card title="用户列表">
        <template #extra>
          <a-space>
            <a-button type="primary" @click="openModal">添加用户</a-button>
            <a-input-search style="width: 200px" v-model:value="keyword" placeholder="关键字搜索" enter-button @search="onSearch" />
          </a-space>
        </template>
        <a-table :dataSource="users" :columns="columns" rowKey="id" bordered size="small">
          <template #bodyCell="{ record, column }">
            <template v-if="column.dataIndex === 'action'">
              <a-radio-group>
                <a-button size="small" type="primary" @click="edit(record)">编辑</a-button>
                <a-popconfirm :title="`确认删除【${record.name}】吗？`" ok-text="是的" cancel-text="再等等" @confirm="deleteuser(record)">
                  <a-button size="small" type="primary" danger>删除</a-button>
                </a-popconfirm>
              </a-radio-group>
            </template>
            <template v-if="column.dataIndex === 'avatar'">
              <div>
                <a-avatar shape="square" :src="record.avatar" style="width: 32px; height: 32px"></a-avatar>
              </div>
            </template>
          </template>
        </a-table>
      </a-card>
    </a-spin>
    <div>


      <a-modal v-model:visible="visible" title="请填写用户信息" @ok="submitUser">
        <a-form ref="formRef" :model="userModel" :label-col="{ style: { width: '80px' } }" autocomplete="off">
          <a-form-item label="昵称" name="nickname">
            <a-input v-model:value="userModel.nickname" />
          </a-form-item>
          <a-form-item label="手机号" name="mobile">
            <a-input v-model:value="userModel.mobile" />
          </a-form-item>
          <a-form-item label="密码" name="password">
            <a-input v-model:value="userModel.password" />
          </a-form-item>
          <a-form-item label="邮箱" name="email">
            <a-input type="email" v-model:value="userModel.email" />
          </a-form-item>
        </a-form>
      </a-modal>

      
    </div>
  </div>
</template>
<script>
import { onMounted, reactive, ref } from "vue";
import { useRouter } from "vue-router";
import UserApi from "@api/user";
export default {
  meta: { title: "用户列表" },
  setup() {
    let users = ref([]);
    let userModel = reactive({ nickname: "", password: "", email: "", mobile: "" });
    let spinning = ref(false);
    let keyword = ref("");
    const router = useRouter();
    let visible = ref(false);
    const formRef = ref();
    const getUser = () => {
      spinning.value = true;
      UserApi.searchUser().then((_) => {
        users.value = _;
        spinning.value = false;
      });
    };
    onMounted(() => {
      getUser();
    });
    //用户搜索

    const onSearch = () => {
      spinning.value = true;
      UserApi.searchUser({ keyword: keyword.value }).then((_) => {
        users.value = _;
        spinning.value = false;
      });
    };

    const deleteuser = async (record) => {
      await UserApi.deleteUser(record).then((_) => {
        // 重新获取一下数据
        getUser();
      });
    };
    const openModal = () => {
      // 打开对话框
      visible.value = true;
    };
    const submitUser = async () => {
      await UserApi.addUser(userModel).then(() => {
        visible.value = false;
        formRef.value.resetFields(); //重置表单
        // 重新获取一下数据
        getUser();
      });
    };
    const edit = (record) => {
      router.push({ name: "admin.user.edit", params: { id: record.id } });
    };
    return {
      formRef,
      submitUser,
      openModal,
      onSearch,
      users,
      userModel,
      getUser,
      deleteuser,
      edit,
      keyword,
      visible,
      spinning,
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
          title: "邮箱",
          dataIndex: "email",
          key: "email",
          width: 300,
        },
        {
          title: "手机号",
          dataIndex: "mobile",
          key: "mobile",
        },
        {
          title: "头像",
          dataIndex: "avatar",
          key: "avatar",
        },
        {
          title: "创建时间",
          dataIndex: "created_at",
          key: "created_at",
          width: 300,
        },
        {
          title: "操作",
          dataIndex: "action",
          key: "action",
        },
      ],
    };
  },
};
</script>
<style lang="scss" scoped></style>
