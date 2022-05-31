import axios from "@/plugins/axios.js";
class CateApi {
    __construct(params) {
        this.params = params
    }
    getCates = async (params) => {
        return await axios.get("cate", params).then(_ => _);
    };
    showCate = async (params) => {
        return await axios.get(`cate/${params.id}`).then(_ => _)
    }
    addCate = async (params) => {
        return await axios.post(`cate`, params)
    }
    updateCate = async (params) => {
        return await axios.put(`cate/${params.id}`, params.data)
    }
    deleteCate = async (params) => {
        return await axios.delete(`cate/${params.id}`)
    }
}
const cateApi = new CateApi();
export default cateApi;
