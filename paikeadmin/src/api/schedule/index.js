import axios from "@/plugins/axios.js";
class ScheduleApi {
    __construct(params) {
        this.params = params
    }
    getSchedules = async (params) => {
        return await axios.get("schedule", params)
    };
    showSchedule = async (params) => {
        return await axios.get(`schedule/${params.id}`).then(_ => _)
    }
    addSchedule = async (params) => {
        return await axios.post(`schedule`, params).then(_ => _)
    }
    updateSchedule = async (params) => {
        return await axios.put(`schedule/${params.id}`, params)
    }
    deleteSchedule = async (params) => {
        return await axios.delete(`schedule/${params.id}`).then(_ => _)
    }
    // 按关键词查询用户
    searchSchedule = async (params) => {
        return await axios.post('schedule/search', params).then(_ => _)
    }
    getScheduleList=async()=>{
        return await axios.post('schedule/list').then(_=>_)
    }

    // 当前用户的课表
    getCurrentUserSchedule = async (params) => {
        return await axios.get(`schedule/getUserSchedule`).then(_ => _)
    }
}
const scheduleApi = new ScheduleApi();
export default scheduleApi;
