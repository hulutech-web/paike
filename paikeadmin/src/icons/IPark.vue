<template>
  <svg class="iconpark-icon" style="width: 1em; height: 1em">
    <use :href="type"></use>
  </svg>
</template>
<script>
export default {
  props: {
    type: {
      type: String,
      default: () => {
        return "#dashboard";
      },
    },
  },
};
</script>
<style scope>
.iconclass {
  margin-right: 10px;
}
</style>
