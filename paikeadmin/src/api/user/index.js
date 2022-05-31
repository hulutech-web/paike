import axios from "@/plugins/axios.js";
class UserApi {
    __construct(params) {
        this.params = params
    }
    getUserInfo = async (id) => {

    }
    getUsers = async (params) => {
        return await axios.get("user", params);
    };
    showUser = async (params) => {
        return await axios.get(`user/${params.id}`).then(_ => _)
    }
    addUser = async (params) => {
        return await axios.post(`user`, params)
    }
    updateUser = async (params) => {
        return await axios.put(`user/${params.id}`, params)
    }
    deleteUser = async (params) => {
        return await axios.delete(`user/${params.id}`).then(_ => _)
    }
    // 按关键词查询用户
    searchUser = async (params) => {
        return await axios.post('user/search', params).then(_ => _)
    }
}
const userApi = new UserApi();
export default userApi;
