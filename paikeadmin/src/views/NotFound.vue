<template>
  <a-result status="404" title="404" sub-title="SORRY！ 页面不存在">
    <template #extra>
      <router-link :to="{ name: 'auth.login' }">
        <a-button type="primary">返回登录</a-button>
      </router-link>
    </template>
  </a-result>
</template>
