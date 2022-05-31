import axios from 'axios'
const uploadImg = async (url = 'uploadCloud', params) => {
    return await axios.post(url, params, {}).then(_ => _)
}
export default uploadImg