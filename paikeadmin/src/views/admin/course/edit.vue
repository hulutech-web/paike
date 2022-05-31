<template>
    <div>
        <a-card title="修改课程">
            <a-form layout="inline" :model="formState.course" @finish="updateCourse">
                <a-row :gutter="[16, 8]">
                    <a-col :span="12">
                        <a-form-item label="标题" has-feedback name="title"
                            :rules="[{ required: true, message: '请填写标题' }]">
                            <a-input v-model:value="formState.course.title" aria-required="请输入姓名" placeholder="请输入姓名" />
                        </a-form-item>
                    </a-col>
                    <a-col :span="12">
                        <a-form-item label="名称" has-feedback name="name"
                            :rules="[{ required: true, message: '请填写课程名称' }]">
                            <a-input v-model:value="formState.course.name" aria-required="请填写课程名称"
                                placeholder="请填写课程名称" />
                        </a-form-item>
                    </a-col>
                    <a-col :span="12">
                        <a-form-item label="描述" has-feedback name="description"
                            :rules="[{ required: true, message: '请填写课程描述' }]">
                            <a-textarea v-model:value="formState.course.description" placeholder="请填写课程描述"
                                :auto-size="{ minRows: 4, maxRows: 10 }" allow-clear />
                        </a-form-item>
                    </a-col>
                    <a-col :span="12">
                        <a-form-item label="描述" has-feedback name="preview">
                            <y-upload-image v-model:value="formState.course.preview" @changeUrl="changeUrl"
                                :imageUrl="formState.course.preview"></y-upload-image>
                        </a-form-item>
                    </a-col>
                </a-row>
                <a-col :span="12">
                    <a-form-item>
                        <a-button type="primary" html-type="submit">提交</a-button>
                    </a-form-item>
                </a-col>
            </a-form>

        </a-card>
    </div>
</template>

<script>
import courseApi from '@api/course';
import { useRoute } from 'vue-router'
import { onMounted, reactive } from 'vue'
export default {
    path: '/admin/course/:id/edit',
    setup() {
        const route = useRoute();
        let formState = reactive({
            course: {}
        })
        onMounted(() => {
            courseApi.showCourse({ id: route.params.id }).then(res => {
                formState.course = res;
            })
        })
        const updateCourse = () => {
            courseApi.updateCourse(formState.course)
        }
        return {
            formState,
            updateCourse
        }
    }
}
</script>

<style>
</style>