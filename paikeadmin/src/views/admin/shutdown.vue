<template>
  <div :style="style">
    <y-tips type="error">如需开启：请联系开发人员执行命令 php artisan xhp startup</y-tips>
    <a-result status="warning" title="危险操作：网站将进入维护模式，如需开启请联系开发工程师">
      <template #extra>
        <a-button key="console" type="primary" @click="fool">关闭网站</a-button>
      </template>
    </a-result>
  </div>
</template>

<script setup>
import { useRouter } from "vue-router";
import { Modal } from "ant-design-vue";
import foolApi from "@/api/fool";
const router = useRouter();

let style = "";
if (router.currentRoute.value.meta.level <= 3) {
  style = "padding: 20px;  background: white;min-height:100%";
} else {
  style = "background: white;min-height:100%";
}

const fool = () => {
  Modal.confirm({
    title: "确定关闭吗？",
    content: "关闭后将不能访问网站，请谨慎操作！",
    okText: "确定",
    okType: "danger",
    cancelText: "取消",
    onOk: () => {
      foolApi.foolPlatform();
    },
  });
};
</script>

<style lang="scss" scoped></style>
