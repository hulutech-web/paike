<template>
    <div>
        <a-card title="修改教室" size="small" :headStyle="{ fontSize: '18px', fontWeight: '900' }">
            <a-form layout="inline" :model="formState.classroom" @finish="updateClassroom">
                <a-row :gutter="[16, 8]">
                    <a-col :span="12">
                        <a-form-item label="名称" has-feedback name="name"
                            :rules="[{ required: true, message: '请填写名称' }]">
                            <a-input v-model:value="formState.classroom.name" aria-required="请输入名称"
                                placeholder="请输入姓名" />
                        </a-form-item>
                    </a-col>
                    <a-col :span="12">
                        <a-form-item label="座位" has-feedback name="seat"
                            :rules="[{ required: true, message: '请填写数字' }]">
                            <a-input type="number" v-model:value="formState.classroom.seat"></a-input>
                        </a-form-item>
                    </a-col>
                    <a-col :span="12">
                        <a-form-item label="地点" has-feedback name="location"
                            :rules="[{ required: true, message: '请填写位置' }]">
                            <a-input v-model:value="formState.classroom.location"
                                placeholder="请填写位置" auto-size />
                        </a-form-item>
                    </a-col>
                    <a-col :span="12">
                        <a-form-item label="描述" has-feedback name="description"
                            :rules="[{ required: true, message: '请填写描述' }]">
                            <a-textarea v-model:value="formState.classroom.description" :rows="4"
                                placeholder="请输入描述" />
                        </a-form-item>
                    </a-col>
                </a-row>
                <a-col :span="12" style="margin-top:12px;">
                    <a-form-item>
                        <a-button type="primary" html-type="submit">提交</a-button>
                    </a-form-item>
                </a-col>
            </a-form>
        </a-card>
    </div>
</template>

<script>
import classroomApi from '@api/classroom';
import { useRouter,useRoute } from 'vue-router'
import { onMounted, reactive } from 'vue'
export default {
    path: '/admin/classroom/:id/edit',
    setup() {
        const router = useRouter();
        const route = useRoute();
        let formState = reactive({
            classroom: {}
        })
        onMounted(() => {
            classroomApi.showClassroom({ id: route.params.id }).then(res => {
                formState.classroom = res;
            })
        })
        const updateClassroom = async() => {
           await classroomApi.updateClassroom(formState.classroom).then(_=>{
               router.go(-1)
           })

        }
        return {
            formState,
            updateClassroom
        }
    }
}
</script>

<style>
</style>