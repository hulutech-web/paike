<template>
  <div :class="classname" :style="hiddenStyle">
    <div style="font-weight: bold"><slot /></div>
    <a class="close" @click="hiddenHandle"></a>
  </div>
</template>

<script>
import { reactive, computed, ref } from "vue";
export default {
  props: ["type"],
  setup(props) {
    const data = reactive({
      type: props.type,
    });
    let hiddenStyle = ref("");
    const hiddenHandle = () => {
      hiddenStyle.value = "display: none;";
    };
    let classname = computed(() => {
      switch (data.type) {
        case "success":
          return "yh_tip_success";
          break;
        case "warning":
          return "yh_tip_warning";
          break;
        case "error":
          return "yh_tip_error";
          break;
        default:
          return "yh_tip_default";
      }
    });
    return {
      classname,
      hiddenHandle,
      hiddenStyle,
    };
  },
};
</script>

<style lang="scss" scoped>
.yh_tip_success {
  display: flex;
  justify-content: space-between;
  box-sizing: border-box;

  align-content: center;
  width: 100%;
  margin: 4px;
  text-align: start;
  padding: 5px;
  border: 1px solid rgb(228 228 231);
  background-color: rgb(220 252 231);
  border-radius: 3px;
}

.yh_tip_warning {
  display: flex;
  margin: 4px;
  box-sizing: border-box;

  justify-content: space-between;
  align-content: center;
  width: 100%;
  text-align: start;
  padding: 5px;
  border: 1px solid rgb(228 228 231);
  background-color: rgb(254 252 232);
  border-radius: 3px;
}
.yh_tip_error {
  display: flex;
  margin: 4px;
  box-sizing: border-box;

  justify-content: space-between;
  align-content: center;
  width: 100%;
  text-align: start;
  padding: 5px;
  border: 1px solid rgb(228 228 231);
  background-color: rgb(254 226 226);
  border-radius: 3px;
}
.yh_tip_default {
  display: flex;
  margin: 4px;
  box-sizing: border-box;
  justify-content: space-between;
  align-content: center;
  width: 100%;
  text-align: start;
  padding: 5px;
  border: 1px solid rgb(228 228 231);
  background-color: rgb(245 245 244);
  border-radius: 3px;
}

.yh_tip_success,
.yh_tip_warning,
.yh_tip_error,
.yh_tip_default {
  .close {
    float: right;
    font-size: 20px;
    font-weight: bold;
    line-height: 20px;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    filter: alpha(opacity=20);
    opacity: 0.2;
    &::before {
      content: "×";
    }
  }
}
</style>
