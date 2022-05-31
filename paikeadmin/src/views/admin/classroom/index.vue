<template>
    <div>
        <a-card title="添加教室" size="small" :headStyle="{ fontSize: '18px', fontWeight: '900' }">
            <a-form layout="inline" :model="formState.classroom" @finish="submitClassroom" ref="formRef"
                @resetFields="handleReset">
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
                            <a-input v-model:value="formState.classroom.location" placeholder="请填写位置" auto-size />
                        </a-form-item>
                    </a-col>
                    <a-col :span="12">
                        <a-form-item label="描述" has-feedback name="description"
                            :rules="[{ required: true, message: '请填写描述' }]">
                            <a-textarea v-model:value="formState.classroom.description" :rows="4" placeholder="请输入描述" />
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



        <a-card title="教师列表">
            <template #extra>
                <a-space>
                    <a-input-search style="width: 200px" v-model:value="keyword" placeholder="关键字搜索" enter-button
                        @search="onSearch" />
                </a-space>
            </template>
            <a-table :dataSource="classrooms" :columns="columns" rowKey="id" bordered size="small">
                <template #bodyCell="{ record, column }">
                    <template v-if="column.dataIndex === 'action'">
                        <a-radio-group>
                            <a-button size="small" type="primary" @click="edit(record)">编辑</a-button>
                            <a-popconfirm :title="`确认删除【${record.name}】吗？`" ok-text="是的" cancel-text="再等等"
                                @confirm="deleteClassroom(record)">
                                <a-button size="small" type="primary" danger>删除</a-button>
                            </a-popconfirm>
                        </a-radio-group>
                    </template>
                    <template v-if="column.dataIndex === 'avatar'">
                        <div>
                            <a-avatar shape="square" :src="record.avatar" style="width: 32px; height: 32px"></a-avatar>
                        </div>
                    </template>
                </template>
            </a-table>
        </a-card>

    </div>
</template>
<script>
import { onMounted, reactive, ref, getCurrentInstance } from "vue";
import { IdcardTwoTone } from "@ant-design/icons-vue";
import { Form } from 'ant-design-vue';
import { useRouter } from "vue-router";
import classroomApi from "@api/classroom";
export default {
    meta: { title: "教室列表" },
    components: { IdcardTwoTone },
    setup() {
        let classrooms = ref([]);
        const useForm = Form.useForm;
        const { proxy } = getCurrentInstance();
        let keyword = ref("");
        const router = useRouter();
        const formState = reactive({
            classroom: {},
        });

        const { resetFields } = useForm(formState.classroom);

        const getClassroom = () => {
            classroomApi.getClassrooms().then((_) => {
                classrooms.value = _;
            });
        };

        onMounted(() => {
            getClassroom();
        });
        const onSearch = () => {
            classroomApi.searchClassroom({ keyword: keyword.value }).then((_) => {
                classrooms.value = _;
            });
        };
        const deleteClassroom = (classroom) => {
            classroomApi.deleteClassroom(classroom)
            classrooms.value.splice(classrooms.value.indexOf(classroom), 1);
        }
        const submitClassroom = async () => {
            await classroomApi.addClassroom(formState.classroom).then(() => {
                getClassroom();
            })
            proxy.$refs['formRef'].resetFields()
        };
        const edit = (record) => {
            router.push({ path: `/admin/classroom/${record.id}/edit` });
        };
        return {
            formState,
            submitClassroom,
            classrooms,
            onSearch,
            getClassroom,
            deleteClassroom,
            edit,
            keyword,
            columns: [
                {
                    title: "ID",
                    dataIndex: "id",
                    key: "id",
                },
                {
                    title: "教室名称",
                    dataIndex: "name",
                    key: "name",
                },
                {
                    title: "座位",
                    dataIndex: "seat",
                    key: "seat",
                    width: 300,
                },
                {
                    title: "描述",
                    dataIndex: "description",
                    key: "description",
                },
                {
                    title: "操作",
                    dataIndex: "action",
                    key: "action",
                },
            ],
        };
    },
};
</script>
<style lang="scss" scoped>
</style>
