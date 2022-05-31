<template>
  <a-card title="编辑用户">
    <a-form :model="formState" name="basic" :label-col="{ style: { width: '120px' } }" :wrapper-col="{ span: 8 }" autocomplete="off" @finish="onFinish" @finishFailed="onFinishFailed">
      <a-form-item label="Id" name="id" :rules="[{ required: true, message: 'Please input your id!' }]">
        <a-input v-model:value="formState.id" />
      </a-form-item>
      <a-form-item label="姓名" name="nickname" :rules="[{ required: true, message: 'Please input your name!' }]">
        <a-input v-model:value="formState.nickname" />
      </a-form-item>
      <a-form-item label="邮箱" name="email" :rules="[{ required: true, message: 'Please input your email!' }]">
        <a-input type="email" v-model:value="formState.email" />
      </a-form-item>
      <a-form-item label="头像" name="avatar">
        <a-upload v-model:value="formState.avatar" name="avatar" list-type="picture-card" class="avatar-uploader" :show-upload-list="false" :action="formState.avatar" @change="handleChange">
          <img v-if="formState.avatar" :src="formState.avatar" alt="avatar" />
        </a-upload>
      </a-form-item>
      <a-form-item>
        <a-button type="primary" html-type="submit">提交</a-button>
      </a-form-item>
    </a-form>
  </a-card>
</template>
<script>
import { reactive, defineComponent } from "vue";
import { useRoute, useRouter } from "vue-router";
import userApi from "@api/user";
export default defineComponent({
  path: "/admin/user/:id/edit",
  async setup() {
    const route = useRoute();
    const router = useRouter();

    const id = route.params.id;
    const user = await userApi.showUser({ id: id });

    // 对象解构展开赋值
    let formState = reactive({ ...user });
    const onFinish = async (values) => {
      await userApi.updateUser(values).then(() => {
        router.back();
      });
    };
    const onFinishFailed = (errorInfo) => {
      console.log("Failed:", errorInfo);
    };
    const handleChange = (info) => {
      if (info.file.status === "uploading") {
      }
    };
    return {
      handleChange,
      formState,
      onFinish,
      onFinishFailed,
    };
  },
});
</script>
