import axios from "@/plugins/axios.js";
class CourseApi {
    __construct(params) {
        this.params = params
    }
    getCourses = async (params) => {
        return await axios.get("course", params).then(_ => _)
    };
    showCourse = async (params) => {
        return await axios.get(`course/${params.id}`).then(_ => _)
    }
    addCourse = async (params) => {
        return await axios.post(`course`, params).then(_ => _)
    }
    updateCourse = async (params) => {
        return await axios.put(`course/${params.id}`, params)
    }
    deleteCourse = async (params) => {
        return await axios.delete(`course/${params.id}`).then(_ => _)
    }
    // 按关键词查询用户
    searchCourse = async (params) => {
        return await axios.post('course/search', params).then(_ => _)
    }
    getCourseList = async () => {
        return await axios.post('course/list').then(_ => _)
    }

    // 教师的课程
    getTeacherCourses = async (id) => {
        return await axios.post(`teacher/${id}/courses`).then(_ => _)
    }
}
const courseApi = new CourseApi();
export default courseApi;