<template>
    <a-card title="编辑老师" size="small" :headStyle="{ fontSize: '18px', fontWeight: '900' }">
        <a-form layout="inline" :model="formState.teacher" @finish="updateTeacher">
            <a-row :gutter="[16, 8]">
                <a-col :span="8">
                    <a-form-item label="用户" :rules="[{ required: true, message: '请选择用户' }]">
                        <y-user-list @selectUser="selectUser"></y-user-list>
                        <a-tag color="processing" v-if="user" style="margin-left: 16px">
                            <template #icon>
                                <idcard-two-tone />
                            </template>
                            {{ user.nickname }}
                        </a-tag>
                    </a-form-item>
                </a-col>
                <a-col :span="8">
                    <a-form-item label="姓名" has-feedback name="name" :rules="[{ required: true, message: '请填写姓名' }]">
                        <a-input v-model:value="formState.teacher.name" aria-required="请输入姓名" placeholder="请输入姓名" />
                    </a-form-item>
                </a-col>
                <a-col :span="8">
                    <a-form-item label="所教课程" has-feedback name="course"
                        :rules="[{ required: true, message: '请填写课程' }]">
                        <a-select v-model:value="formState.teacher.course" mode="tags" style="width: 100%"
                            placeholder="请选择课程" :options="courses"></a-select>
                    </a-form-item>
                </a-col>
                <a-col :span="8">
                    <a-form-item label="年龄" has-feedback name="age" :rules="[{ required: true, message: '请填写年龄' }]">
                        <a-input v-model:value="formState.teacher.age" type="number" placeholder="请输入年龄" />
                    </a-form-item>
                </a-col>
                <a-col :span="8">
                    <a-form-item label="政治面貌" has-feedback name="politics_status"
                        :rules="[{ required: true, message: '请填写政治面貌' }]">
                        <a-input-group compact>
                            <a-auto-complete v-model:value="formState.teacher.politics_status" :options="politics"
                                style="width: 200px" placeholder="政治面貌" />
                        </a-input-group>
                    </a-form-item>
                </a-col>
                <a-col :span="8">
                    <a-form-item label="文化程度" has-feedback name="degree"
                        :rules="[{ required: true, message: '请填写文化程度' }]">
                        <a-auto-complete v-model:value="formState.teacher.degree" :options="options"
                            style="width: 200px" placeholder="文化程度" />
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="简介" has-feedback name="introduce"
                        :rules="[{ required: true, message: '请输入简介' }]">
                        <a-textarea v-model:value="formState.teacher.introduce" placeholder="请输入简介"
                            :auto-size="{ minRows: 4, maxRows: 10 }" allow-clear />
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="工作经验" has-feedback name="experience"
                        :rules="[{ required: true, message: '请输入工作经验' }]">
                        <a-textarea v-model:value="formState.teacher.experience" placeholder="请输入工作经验"
                            :auto-size="{ minRows: 4, maxRows: 10 }" allow-clear />
                    </a-form-item>
                </a-col>
            </a-row>
            <a-form-item style="margin-top: 20px">
                <a-button type="primary" html-type="submit">提交</a-button>
            </a-form-item>
        </a-form>
    </a-card>
</template>

<script>
import TeacherApi from '@api/teacher'
import { useRoute, useRouter } from 'vue-router'
import { IdcardTwoTone } from "@ant-design/icons-vue";
import { onMounted, reactive, ref } from 'vue-demi';
import CourseApi from "@api/course";
export default {
    components: { IdcardTwoTone },
    path: '/admin/teacher/:id/edit',
    setup() {
        let route = useRoute()
        const id = route.params.id
        let router = useRouter()
        let user = ref();
        let courses = ref([])
        const getCourse = () => {
            CourseApi.getCourseList().then((_) => {
                courses.value = _;
            });
        };
        let formState = reactive({
            teacher: {
            }
        })
        const selectUser = (userModel) => {
            user.value = userModel;
            formState.teacher.user_id = user.value.id;
        };
        onMounted(() => {
            TeacherApi.showTeacher({ id: id }).then(res => {
                // console.log(res)
                formState.teacher = res
                user.value=res.user
            })
            getCourse()
        })
        //学历选项
        let options = ref([
            { value: "博士" },
            { value: "硕士" },
            { value: "本科" },
            { value: "专科" },
            { value: "高中" },
            { value: "初中" },
            { value: "小学" },
        ]);
        // 政治面貌
        let politics = ref([
            { value: "中共党员" },
            { value: "中共预备党员" },
            { value: "共青团员" },
            { value: "无党派民主人士" },
            { value: "群众" },
        ]);
        const updateTeacher = async () => {
            await TeacherApi.updateTeacher(formState.teacher)
            router.go(-1)
        }
        return {
            user,
            courses,
            formState,
            updateTeacher,
            options,
            politics,
            selectUser
        }
    }
}
</script>

<style>
</style>