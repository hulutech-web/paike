import axios from "@/plugins/axios.js";
class PermissionApi {
    __construct(params) {
        this.params = params
    }
    // 初始化权限
    initPermission = async () => {
        return axios.post('permission/init').then(_ => _)
    }
    // 禁用权限(单个)
    disablePermission = async (params) => {
        return axios.post(`permission/${params.id}/disablePermission`).then(_ => _)
    }
    // 启用权限
    enablePermissions = async (params) => {
        return axios.post('permission/enablePermissions', params).then(_ => _)
    }
    // 获取已禁用的权限
    getDisabledPermissions = async () => {
        return axios.get('permission/disabledPermissions').then(_ => _)
    }
    //获取系统所有权限
    getPermissions = async () => {
        return await axios.get(`permission`).then(_ => _);
    };
    // 更新系统权限
    updatePermissions = async (params) => {
        return axios.put(`permission`, params).then(_ => _);
    }
    // 获取公司权限
    showCompanyPermission = async (id) => {
        return await axios.get(`company/${id}/permission`)
    }
    // 角色拥有的权限
    getRoleHasPermission = async (id) => {
        return await axios.get(`role/${id}/permission`).then(_ => _)
    }
    // 同步角色的权限
    asyncRolePermissions = async (id, params) => {
        return await axios.post(`role/${id}/permission/sync`, params)
    }
}
const permissionApi = new PermissionApi();
export default permissionApi;
