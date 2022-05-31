<template>
  <a-upload v-model:file-list="fileList" name="file" :maxCount="1" list-type="picture-card" class="avatar-uploader"
    :show-upload-list="false" :action="action" :before-upload="beforeUpload" @change="handleChange" :headers="headers"
    :withCredentials="true">
    <img v-if="localImageUrl" :src="localImageUrl" alt="avatar" class="imagepreview"
      style="width:100px;height:100px;" />
    <div v-else>
      <loading-outlined v-if="loading"></loading-outlined>
      <plus-outlined v-else></plus-outlined>
      <div class="ant-upload-text">上传</div>
    </div>
  </a-upload>
</template>
<script>
import { PlusOutlined, LoadingOutlined } from "@ant-design/icons-vue";
import { message } from "ant-design-vue";
import { ref, watch } from "vue";

export default {
  emits: ["changeUrl"],
  props: ["imageUrl"],
  components: {
    LoadingOutlined,
    PlusOutlined,
  },
  setup(props, ctx) {
    let action = ref("");
    action = props.imageUrl ? props.imageUrl : "http://paike.test/api/uploadCloud";
    // 验证
    const token = localStorage.getItem("token");
    const headers = { authorization: `Bearer ${token}` };
    const fileList = ref([]);
    const loading = ref(false);
    let imageUrl = props.imageUrl;
    let localImageUrl = ref("");
    watch(
      () => props.imageUrl,
      (n) => {
        localImageUrl.value = n;
      },
      { immediate: true }
    );

    const handleChange = (info) => {
      if (info.file.status === "uploading") {
        loading.value = true;
        return;
      }
      if (info.file.status === "done") {
        imageUrl = info.file.response.path;
        localImageUrl.value = imageUrl;
        ctx.emit("changeUrl", imageUrl);
        loading.value = false;
      }

      if (info.file.status === "error") {
        loading.value = false;
        message.error("upload error");
      }
    };

    const beforeUpload = (file) => {
      const isJpgOrPng = file.type === "image/jpeg" || file.type === "image/png";

      if (!isJpgOrPng) {
        message.error("You can only upload JPG file!");
      }

      const isLt2M = file.size / 1024 / 1024 < 2;

      if (!isLt2M) {
        message.error("Image must smaller than 2MB!");
      }

      return isJpgOrPng && isLt2M;
    };

    return {
      action,
      headers,
      loading,
      localImageUrl,
      fileList,
      handleChange,
      beforeUpload,
    };
  },
};
</script>
<style scoped>
.avatar-uploader>.ant-upload {
  width: 128px;
  height: 128px;
}

.ant-upload-select-picture-card i {
  font-size: 32px;
  color: #999;
}

.ant-upload-select-picture-card .ant-upload-text {
  margin-top: 8px;
  color: #666;
}

.imagepreview {
  width: 128px;
  height: 128px;
}
</style>
