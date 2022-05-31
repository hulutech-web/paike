import axios from "@/plugins/axios.js";
class TeacherApi {
    __construct(params) {
        this.params = params
    }
    getTeachers = async (params) => {
        return await axios.get("teacher", params);
    };
    showTeacher = async (params) => {
        return await axios.get(`teacher/${params.id}`).then(_ => _)
    }
    addTeacher = async (params) => {
        return await axios.post(`teacher`, params)
    }
    updateTeacher = async (params) => {
        return await axios.put(`teacher/${params.id}`, params)
    }
    deleteTeacher = async (params) => {
        return await axios.delete(`teacher/${params.id}`).then(_ => _)
    }
    // 按关键词查询用户
    searchTeacher = async (params) => {
        return await axios.post('teacher/search', params).then(_ => _)
    }

}
const teacherApi = new TeacherApi();
export default teacherApi;
