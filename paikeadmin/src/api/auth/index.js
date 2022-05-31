import axios from "@/plugins/axios.js";
class AuthApi {
    __construct(params) {
        this.params = params
    }
    login = async (params) => {
        return await axios.post("login", params);
    };
    logout = async () => {
        return await axios.post('logout');
    }
    getQr = async (params) => {
        return await axios.post('scanQr', params)
    }
    scanLogin = async (params) => {
        return await axios.post('scanLogin', params)
    }
}
const authApi = new AuthApi();
export default authApi;
