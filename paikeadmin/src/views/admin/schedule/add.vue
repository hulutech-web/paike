<template>
    <a-card title="添加排课" size="small">
        <a-form :model="formState.schedule" @finish="submitSchedule" :label-col="{ style: '150px' }" ref="form">
            <a-row :gutter="24">
                <a-col :span="8">
                    <a-form-item label="教师" :rules="[{ required: true, message: '请选择教师' }]">
                        <y-teacher-list @selectTeacher="selectTeacher"></y-teacher-list>
                        <a-tag color="processing" v-if="formTeacher.teacher.name" style="margin-left: 16px">
                            <template #icon>
                                <idcard-two-tone />
                            </template>
                            {{ formTeacher.teacher.name }}
                        </a-tag>
                    </a-form-item>
                </a-col>
                <a-col :span="8">
                    <a-form-item label="所教课程" has-feedback name="course_id"
                        :rules="[{ required: true, message: '请填写课程' }]">
                        <a-select v-model:value="formState.schedule.course_id" :options="courses" style="width: 200px"
                            placeholder="请选择课程" />
                    </a-form-item>
                </a-col>
                <a-col :span="8">
                    <a-form-item label="教室" has-feedback name="classroom_id"
                        :rules="[{ required: true, message: '请填写教室' }]">
                        <a-select v-model:value="formState.schedule.classroom_id" style="width: 100%"
                            placeholder="请选择教室" :options="classrooms"></a-select>
                    </a-form-item>
                </a-col>
            </a-row>
            <a-row :gutter="24">
                <a-col :span="8">
                    <a-form-item label="星期" has-feedback name="weekday" :rules="[{ required: true, message: '请填写星期' }]">
                        <a-select v-model:value="formState.schedule.weekday" style="width: 100%" placeholder="请选择星期"
                            :options="weekdays"></a-select>
                    </a-form-item>
                </a-col>
                <a-col :span="8">

                    <a-form-item label="开始时间" has-feedback name="start_time"
                        :rules="[{ required: true, message: '请选择开始时间' }]">
                        <a-time-picker v-model:value="formState.schedule.start_time" use12-hours value-format="HH:mm:ss" />

                    </a-form-item>
                </a-col>
                <a-col :span="8">
                    <a-form-item label="结束时间" has-feedback name="end_time"
                        :rules="[{ required: true, message: '请选择结束时间' }]">
                        <a-time-picker v-model:value="formState.schedule.end_time" use12-hours value-format="HH:mm:ss" />
                    </a-form-item>
                </a-col>
            </a-row>
            <a-row :gutter="24">
                <a-col :span="24">
                    <a-form-item style="margin-top: 20px">
                        <a-button type="primary" html-type="submit">提交</a-button>
                    </a-form-item>
                </a-col>
            </a-row>
        </a-form>
    </a-card>
</template>

<script>
import courseApi from '@api/course'
import teacherApi from '@api/teacher'
import classroomApi from '@api/classroom'
import scheduleApi from '@api/schedule'
import { useRoute, useRouter } from 'vue-router'
import { IdcardTwoTone } from "@ant-design/icons-vue";
import { onMounted, reactive, ref, getCurrentInstance } from 'vue';
export default {
    components: { IdcardTwoTone },
    setup() {
        let route = useRoute()
        const id = route.params.id
        let router = useRouter()
        let formTeacher = reactive({
            teacher: {}
        });
        const {proxy} = getCurrentInstance()
        let courses = ref([]);
        let classrooms = ref([])
        let formState = reactive({
            schedule: {

            }
        })
        const getClassrooms = async () => {
            classrooms.value = await classroomApi.getClassroomList()
        }
        // 星期
        let weekdays = ref([
            {
                value: '0',
                label: '星期一'
            },
            {
                value: '1',
                label: '星期二'
            },
            {
                value: '2',
                label: '星期三'
            },
            {
                value: '3',
                label: '星期四'
            },
            {
                value: '4',
                label: '星期五'
            },
            {
                value: '5',
                label: '星期六'
            },
            {
                value: '6',
                label: '星期日'
            }
        ])
        const selectTeacher = async (teacherModel) => {
            formState.schedule.teacher_id = teacherModel.id;
            formTeacher.teacher = teacherModel;
            courses.value = await courseApi.getTeacherCourses(teacherModel.id)
        };
        onMounted(async () => {
            await teacherApi.getTeachers()
            await getClassrooms()
        })
        const submitSchedule = async () => {
            scheduleApi.addSchedule(formState.schedule)
            proxy.$refs['form'].resetFields()
        }       
        return {
            formState,
            formTeacher,
            selectTeacher,
            courses,
            classrooms,
            weekdays,
            submitSchedule
        }
    }
}
</script>

<style>
</style>