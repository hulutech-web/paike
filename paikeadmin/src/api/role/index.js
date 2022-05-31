import axios from "@/plugins/axios.js";
class RoleApi {
    __construct(params) {
        this.params = params
    }
    getRoles = async (id) => {
        return await axios.get(`company/${id}/role`).then(_ => _);
    };
    //获取单个角色
    getRole = async (id) => {
        return await axios.get(`role/${id}`)
    }
    // 获取公司的单个角色
    showRole = async (id, params) => {
        return await axios.get(`company/${id}/role/${params.id}`)
    }
    //创建角色
    createRole = async (id, params) => {
        return await axios.post(`company/${id}/role`, params).then(_ => _)
    }

    updateRole = async (id, params) => {
        return await axios.put(`/company/${id}/role/${params.id}`, params)
    }
    deleteRole = async (id, params) => {
        return await axios.delete(`company/${id}/role/${params.id}`).then(_ => _)
    }

    //同步管理员角色
    syncMangerRoles = async (mid, params) => {
        return await axios.post(`manager/${mid}/role/sync`, params).then(_ => _)
    }
    //获取当前管理员的角色
    getManagerRoles = async (mid) => {
        return await axios.get(`manager/${mid}/role`).then(_ => _)
    }
}
const roleApi = new RoleApi();
export default roleApi;
