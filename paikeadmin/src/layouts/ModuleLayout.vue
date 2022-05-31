<template>
    <a-layout style="min-height: 100vh">
        <a-layout-sider collapsible>
            <div class="logo">
                <a-image src="/images/logo.jpg" style="border-radius: 50%" :width="40" alt />
                <span>XIAO.H.P</span>
            </div>
            <y-menu />
        </a-layout-sider>
        <a-layout>
            <a-layout-header style="background: #fff; padding: 0">
                <div style="margin: auto 16px">
                    <div style="display: flex; justify-content: space-between">
                        <div>
                            <a-tag color="pink" closable change="alert(3)">pink</a-tag>
                            <a-tag color="red" closable>red</a-tag>
                            <a-tag color="orange" closable>orange</a-tag>
                            <a-tag color="green" closable>green</a-tag>
                            <a-tag color="cyan" closable>cyan</a-tag>
                            <a-tag color="blue" closable>blue</a-tag>
                            <a-tag color="purple" closable>purple</a-tag>
                        </div>
                        <div>
                            <a-dropdown>
                                <a class="ant-dropdown-link" @click.prevent>
                                    <a-avatar :size="32" :src="avatar"></a-avatar>
                                    {{ name }}
                                </a>
                                <template #overlay>
                                    <a-menu>
                                        <a-menu-item>
                                            <a href="javascript:;">个人中心</a>
                                        </a-menu-item>
                                        <a-menu-item>
                                            <a href="javascript:;">设置</a>
                                        </a-menu-item>
                                        <a-menu-item>
                                            <a href="javascript:;" @click="logout">退出登录</a>
                                        </a-menu-item>
                                    </a-menu>
                                </template>
                            </a-dropdown>
                        </div>
                    </div>
                </div>
            </a-layout-header>
            <a-layout-content style="margin: 0 16px">
                <y-breadcrumb />
                <router-view></router-view>
            </a-layout-content>
            <a-layout-footer style="text-align: center">Ant Design ©2022 模块</a-layout-footer>
        </a-layout>
    </a-layout>
</template>

<script setup>
import { ref } from "vue";
import AuthApi from "@api/auth";
import { useRouter } from "vue-router";
const userinfo = JSON.parse(localStorage.getItem("userinfo")) ? JSON.parse(localStorage.getItem("userinfo")) : "";
const avatar = ref(userinfo.avatar);
const name = ref(userinfo.name);
const router = useRouter();
const logout = async () => {
    await AuthApi.logout().then(() => {
        localStorage.removeItem("token");
        router.push({ name: "auth.login" });
    });
};
</script>
<style>
#components-layout-demo-side .logo {
    height: 28px;
    background: rgba(255, 255, 255, 0.3);
}
.logo {
    color: white;
    display: flex;
    margin-top: 10px;
    flex-direction: column;
    justify-items: center;
    align-items: center;
}
.site-layout .site-layout-background {
    background: #fff;
}
[data-theme="dark"] .site-layout .site-layout-background {
    background: #141414;
}
</style>
