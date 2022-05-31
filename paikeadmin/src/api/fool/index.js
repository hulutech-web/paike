import axios from "@/plugins/axios.js";
class FoolApi {
    __construct(params) {
        this.params = params
    }
    foolPlatform = async () => {
        return await axios.post("/fool");
    };
}
const foolApi = new FoolApi();
export default foolApi;
