<template>
  <div>
    <a-card title="网站设置" :headStyle="{ fontSize: '18px', fontWeight: '900' }">
      <a-form layout="inline" :model="formState.systemModel" @finish="onSubmit">
        <a-row :gutter="[16, 8]">
          <a-col :span="8">
            <a-form-item label="网站名称" has-feedback name="webname" :rules="[{ required: true, message: '请输入网站名称' }]">
              <a-input v-model:value="formState.systemModel.webname" aria-required="请输入网站名称" placeholder="请输入网站名称" />
            </a-form-item>
          </a-col>
          <a-col :span="8">
            <a-form-item label="关键字" has-feedback name="keywords" :rules="[{ required: true, message: '请填写关键字' }]">
              <a-input v-model:value="formState.systemModel.keywords" aria-required="请输入关键字" placeholder="请输入关键字" />
            </a-form-item>
          </a-col>
          <a-col :span="8">
            <a-form-item label="备案号" has-feedback name="icp" :rules="[{ required: true, message: '请填写备案号' }]">
              <a-input v-model:value="formState.systemModel.icp" aria-required="请输入备案号" placeholder="请输入备案号" />
            </a-form-item>
          </a-col>
          <a-col :span="24">
            <a-form-item label="描述信息" has-feedback name="description" :rules="[{ required: true, message: '请填写描述信息' }]">
              <y-editor v-model="formState.systemModel.description"
                @update:modelValue="formState.systemModel.description = $event">
              </y-editor>
            </a-form-item>
          </a-col>
        </a-row>
        <a-form-item style="margin-top: 20px">
          <a-button type="primary" html-type="submit">提交</a-button>
        </a-form-item>
      </a-form>
    </a-card>

  </div>
</template>

<script>
import { onMounted, reactive } from "vue"
import systemConfigApi from "@/api/systemconfig"
export default {
  async setup() {
    let formState = reactive({
      systemModel: {
      }
    })
    onMounted(async () => {
      let data = await systemConfigApi.getSystemConfig()
      if (data) {
        console.log('data========')
        formState.systemModel=data
      }
    })
    // 接收数据


    const onSubmit = async () => {
      await systemConfigApi.updateSystemConfig(formState.systemModel)
    }
    return {
      formState,
      onSubmit
    }
  }
}
</script>

<style>
</style>