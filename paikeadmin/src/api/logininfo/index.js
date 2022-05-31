import axios from "@/plugins/axios.js";
class LogininfoApi {
    __construct(params) {
        this.params = params
    }
    getlogininfo = async (params) => {
        return await axios.get("logininfo", params);
    };
}
const logininfoApi = new LogininfoApi();
export default logininfoApi;
