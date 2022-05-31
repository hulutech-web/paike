<template>
  <div>
    <a-card title="添加老师" size="small" :headStyle="{ fontSize: '18px', fontWeight: '900' }">
      <a-form layout="inline" :model="formState.teacher" @finish="submitTeacher" ref="form">
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
            <a-form-item label="所教课程" has-feedback name="course" :rules="[{ required: true, message: '请填写课程' }]">
              <a-select v-model:value="formState.teacher.course" mode="tags" style="width: 100%" placeholder="请选择课程"
                :options="courses"></a-select>
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
            <a-form-item label="文化程度" has-feedback name="degree" :rules="[{ required: true, message: '请填写文化程度' }]">
              <a-auto-complete v-model:value="formState.teacher.degree" :options="options" style="width: 200px"
                placeholder="文化程度" />
            </a-form-item>
          </a-col>
          <a-col :span="12">
            <a-form-item label="简介" has-feedback name="introduce" :rules="[{ required: true, message: '请输入简介' }]">
              <a-textarea v-model:value="formState.teacher.introduce" placeholder="请输入简介"
                :auto-size="{ minRows: 4, maxRows: 10 }" allow-clear />
            </a-form-item>
          </a-col>
          <a-col :span="12">
            <a-form-item label="工作经验" has-feedback name="experience" :rules="[{ required: true, message: '请输入工作经验' }]">
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

    <a-card title="教师列表">
      <template #extra>
        <a-space>
          <a-input-search style="width: 200px" v-model:value="keyword" placeholder="关键字搜索" enter-button
            @search="onSearch" />
        </a-space>
      </template>
      <a-table :dataSource="teachers" :columns="columns" rowKey="id" bordered size="small">
        <template #bodyCell="{ record, column }">
          <template v-if="column.dataIndex === 'action'">
            <a-radio-group>
              <a-button size="small" type="primary" @click="edit(record)">编辑</a-button>
              <a-popconfirm :title="`确认删除【${record.name}】吗？`" ok-text="是的" cancel-text="再等等"
                @confirm="deleteTeacher(record)">
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
import { useRouter } from "vue-router";
import TeacherApi from "@api/teacher";
import CourseApi from "@api/course";
export default {
  components: { IdcardTwoTone },
  meta: { title: "教师列表" },
  setup() {
    let teachers = ref([]);
    let courses = ref([])
    let user = ref();
    let keyword = ref("");
    const router = useRouter();
    const getTeacher = () => {
      TeacherApi.getTeachers().then((_) => {
        teachers.value = _;
      });
    };
    const { proxy } = getCurrentInstance();
    const getCourse = () => {
      CourseApi.getCourseList().then((_) => {
        courses.value = _;
      });
    };
    onMounted(() => {
      getTeacher();
      getCourse();
    });
    const onSearch = () => {
      TeacherApi.searchTeacher({ keyword: keyword.value }).then((_) => {
        teachers.value = _;
      });
    };
    const deleteTeacher = (teacher) => {
      TeacherApi.deleteTeacher(teacher)
      teachers.value.splice(teachers.value.indexOf(teacher), 1);
    }
    const selectUser = (userModel) => {
      user.value = userModel;
      formState.teacher.user_id = user.value.id;
    };
    const formState = reactive({
      teacher: {},
    });
    const deleteteacher = async (record) => {
      await TeacherApi.deleteTeacher(record).then((_) => {
        // 重新获取一下数据
        getTeacher();
      });
    };
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

    const handleChange = (e) => {
      console.log(e);
    };
    const openModal = () => {
      // 打开对话框
      visible.value = true;
    };
    const submitTeacher = async () => {
      await TeacherApi.addTeacher(formState.teacher);
      await getTeacher();
      proxy.$refs['form'].resetFields();
      // 关闭对话框
      visible.value = false;
    };
    const edit = (record) => {
      router.push({ path: `/admin/teacher/${record.id}/edit` });
    };
    return {
      formState,
      courses,
      submitTeacher,
      openModal,
      teachers,
      onSearch,
      getTeacher,
      deleteTeacher,
      handleChange,
      edit,
      keyword,
      options,
      politics,
      selectUser,
      user,
      columns: [
        {
          title: "ID",
          dataIndex: "id",
          key: "id",
        },
        {
          title: "教师姓名",
          dataIndex: "name",
          key: "name",
        },
        {
          title: "年龄",
          dataIndex: "age",
          key: "age",
          width: 300,
        },
        {
          title: "工作经验",
          dataIndex: "experience",
          key: "experience",
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
