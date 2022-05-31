<template>
  <div v-if="errorStore.errors[props.name]" style="margin-top:4px;">
    <a-alert :message="errorStore.errors[props.name][0]" type="error" show-icon />
  </div>
</template>

<script setup>
import useErrorStore from "../store/error"
const errorStore = useErrorStore()
const props = defineProps({
  name: String
})
</script>

<style scoped>
</style>
