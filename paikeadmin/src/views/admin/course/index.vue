<template>
    <div>
        <a-card title="添加课程">
            <a-form layout="inline" :model="formState.course" @finish="submitCourse" ref="form">
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
                        <a-form-item label="封面" has-feedback name="preview">
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




        <a-card title="课程列表">

            <a-table :dataSource="courses" :columns="columns" size="small" bordered>
                <template #bodyCell="{ record, column }">
                    <template v-if="column.dataIndex === 'action'">
                        <a-radio-group>
                            <a-button size="small" type="primary" @click="edit(record)">编辑</a-button>
                            <a-popconfirm :title="`确认删除【${record.name}】吗？`" ok-text="是的" cancel-text="再等等"
                                @confirm="deleteCourse(record)">
                                <a-button size="small" type="primary" danger>删除</a-button>
                            </a-popconfirm>
                        </a-radio-group>
                    </template>
                    <template v-if="column.dataIndex === 'preview'">
                        <div>
                            <a-popover :mouseEnterDelay="0.02" placement="right">
                                <template #content>
                                    <a-avatar shape="square" :src="record.preview" style="width: 64px; height: 64px"
                                        @changeUrl="changeUrl">
                                    </a-avatar>
                                </template>
                                <a-avatar shape="square" :src="record.preview" style="width: 32px; height: 32px">
                                </a-avatar>
                            </a-popover>
                        </div>
                    </template>
                </template>
            </a-table>
        </a-card>
    </div>
</template>

<script>
import { onMounted, reactive, ref, getCurrentInstance } from "vue"
import courseApi from "@api/course"
import { useRouter } from 'vue-router'
export default {
    meta: { title: "课表列表" },
    setup() {
        let courses = ref([])
        const router = useRouter();
        const { proxy } = getCurrentInstance();
        onMounted(() => {
            courseApi.getCourses().then((_) => {
                courses.value = _
            })
        })
        let formState = reactive({
            course: {}
        })
        let columns = ref([
            {
                title: '课程标题',
                dataIndex: 'title',
                key: 'title',
            },
            {
                title: '英文名称',
                dataIndex: 'name',
                key: 'name',
            },
            {
                title: '描述',
                dataIndex: 'description',
                key: 'description',
            },
            {
                title: '封面',
                dataIndex: 'preview',
                key: 'preview',
                width: 300,
            },
            {
                title: '操作',
                dataIndex: 'action',
                key: 'action',
            }
        ])
        const deleteCourse = (course) => {
            courseApi.deleteCourse(course)
            courses.value.splice(courses.value.indexOf(course), 1)
        }
        const submitCourse = async () => {
            await courseApi.addCourse(formState.course)
            await courseApi.getCourses().then((_) => {
                courses.value = _
            })
            proxy.$refs['form'].resetFields()
        }
        const changeUrl = (url) => {
            console.log(url)
            formState.course.preview = url
        }
        const edit = (record) => {
            router.push({ name: 'admin.course.edit', params: { id: record.id } })
        }
        return {
            courses,
            columns,
            formState,
            changeUrl,
            deleteCourse,
            submitCourse,
            edit
        }
    }

}
</script>

<style>
</style>