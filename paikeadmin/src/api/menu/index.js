import axios from "@/plugins/axios.js";
class MenuApi {
    __construct(params) {
        this.params = params
    }
    getMenus = async (params) => {
        return await axios.get("menus").then(_ => _);
    };
    getMenusOnModule = async (params) => {
        return await axios.get({ name: params.name }).then(_ => _);
    }
}
const menuApi = new MenuApi();
export default menuApi;
