import axios from "@/plugins/axios.js";
class ClassroomApi {
    __construct(params) {
        this.params = params
    }
    getClassrooms = async (params) => {
        return await axios.get("classroom", params);
    };
    showClassroom = async (params) => {
        return await axios.get(`classroom/${params.id}`).then(_ => _)
    }
    addClassroom = async (params) => {
        return await axios.post(`classroom`, params)
    }
    updateClassroom = async (params) => {
        return await axios.put(`classroom/${params.id}`, params)
    }
    deleteClassroom = async (params) => {
        return await axios.delete(`classroom/${params.id}`).then(_ => _)
    }
    // 按关键词查询用户
    searchClassroom = async (params) => {
        return await axios.post('classroom/search', params).then(_ => _)
    }

    // 教室列表
    getClassroomList = async () => {
        return await axios.post('classroom/list').then(_ => _)
    }
}
const classroomApi = new ClassroomApi();
export default classroomApi;
