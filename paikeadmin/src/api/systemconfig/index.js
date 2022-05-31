import axios from "@/plugins/axios.js";
class SystemConfigApi {
    __construct(params) {
        this.params = params
    }
    getSystemConfig = async () => {
        return await axios.post("systemconfig").then(_=>_);
    };

    updateSystemConfig = async (params) => {
        return await axios.post(`updateSystemConfig`, params)
    }
}
const systemConfigApi = new SystemConfigApi();
export default systemConfigApi;
