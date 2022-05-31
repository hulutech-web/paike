<template>
  <div class="container">
    <div class="bg"></div>
    <div class="content">
      <section>
        <div>
          <span>欢迎登录</span>
          <h1>请登录账号</h1>
        </div>
        <a-form
          :model="user"
          name="basic"
          :label-col="{ span: 8 }"
          :wrapper-col="{ span: 16 }"
          autocomplete="off"
          @finish="onSubmit"
          @finishFailed="onSubmitFailed"
        >
          <a-form-item
            label="手机号"
            name="mobile"
            :rules="[{ required: true, message: '请输入账号' }]"
          >
            <a-input v-model:value="user.mobile" />
          </a-form-item>

          <a-form-item
            v-if="loginType == 'pwd'"
            label="密码"
            name="password"
            :rules="[{ required: true, message: '请输入密码' }]"
          >
            <a-input-password v-model:value="user.password" />
          </a-form-item>
          <a-form-item
            v-if="loginType == 'code'"
            label="验证码"
            name="code"
            :rules="[{ required: true, message: '请输入验证码' }]"
          >
            <a-input-password v-model:value="user.code" />
          </a-form-item>
          <a-form-item :wrapper-col="{ offset: 8, span: 16 }">
            <a-button type="primary" html-type="submit">登录</a-button>
          </a-form-item>
        </a-form>
        <div style="width: 100%; flex-direction: column; text-align: center">
          <a-divider :plain="true">快捷登录</a-divider>
          <div
            style="display:flex;justify-content: center; align-items: center;text-align: center;"
          >
            <div @click="QLogin" style="cursor: pointer;margin:0 12px; ">
              <img style="width: 50px" src="/images/weixin.png" />
            </div>

            <a-popover
              v-model:visible="visible"
              :title="`请扫码获取：${time}s`"
              trigger="click"
              placement="top"
              @visibleChange="() => visibleChange()"
              arrow-point-at-center
            >
              <template #content style="display:flex;justify-content:center;text-align: center;">
                <img :src="`data:image/png;base64,${Qrimg}`" alt />
              </template>
              <a-button @click="displayQr" type="primary" ghost size="large">
                <template #icon>
                  <ExpandOutlined />
                </template>
                扫码登录
              </a-button>
            </a-popover>

            <a-button type="link" v-if="loginType == 'code'" @click="loginType = 'pwd'">密码登录</a-button>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue";
import AuthApi from "@api/auth";
import { message, } from 'ant-design-vue'
import { ExpandOutlined } from '@ant-design/icons-vue';
let loginType = ref('pwd')//登录类型
const Qrimg = ref('');
const time = ref(60)
const visible = ref(false);
let interval = '' //定时器
const user = reactive({
  mobile: "",
  password: "",
  code: ""
});

const onFinishFailed = (errorInfo) => {
  console.log("Failed:", errorInfo);
};

const onSubmit = () => {
  if (loginType.value == 'pwd') {
    AuthApi.login(user).then((_) => {
      const token = _.token;
      window.localStorage.setItem("token", token);
      window.localStorage.setItem("userinfo", JSON.stringify(_.data));
      location.href = "#/admin/index";
    });
  } else {
    scanLogin()
  }

};
const onSubmitFailed = (errorInfo) => {
  console.log("Failed:", errorInfo);
};
const QLogin = () => {
  console.log("一键登录");
};
// 显示隐藏回调
const visibleChange = () => {
  // 立即清除定时器
  clearInterval(interval)
}
const scanLogin = () => {
  AuthApi.scanLogin(user).then((_) => {
    const token = _.token;
    window.localStorage.setItem("token", token);
    window.localStorage.setItem("userinfo", JSON.stringify(_.data));
    location.href = "#/admin/index";
  })
}
const displayQr = () => {
  if (user.mobile == "") {
    message.warn('请先填写手机号');
    return
  } else {
    loginType.value = 'code'
    AuthApi.getQr().then((_) => {
      if (time.value !== 60) {
        time.value = 60
      }
      Qrimg.value = _
      visible.value = true
      // 开启一个倒计时定时器
      interval = setInterval(() => {
        if (time.value > 0) {
          time.value--
        }
        else {
          clearInterval(interval)
        }
      }, 1000)
    })
  }
}
</script>

<style lang="scss" scoped>
.container {
  min-height: 100vh;
  width: 100vw;
  overflow: hidden;
  .bg {
    position: fixed;
    left: 0;
    top: 0;
    width: 50%;
    height: 100vh;
    margin: 0;
    padding: 0;
    display: inline-block;
    background-image: url("/images/bg-art.jpg");
    background-repeat: no-repeat;
  }
  .content {
    float: right;
    width: 50%;
    height: 100vh;
    display: flex;
    flex-flow: column;
    justify-content: center;
    align-items: center;
    section {
      display: flex;
      flex-direction: column;
      justify-items: center;
      align-items: center;
    }
  }
}
</style>
