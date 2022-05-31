import dayjs from "dayjs";
import "dayjs/locale/zh-cn";
import relativeTime from 'dayjs/plugin/relativeTime'
dayjs.extend(relativeTime)
dayjs.locale("zh-cn");
const plugin = {
    install: (app, options) => {
        app.mixin({
            methods: {
                format(value) {
                    return dayjs(value).format('YYYY年MM月DD日')
                },
                formatFromNow(value) {
                    return dayjs(value).fromNow()
                },
                truncate(value, len = 20, ex = '...') {
                    if (value) {
                        return value.length > len ? value.substr(0, len) + ex : value
                    }
                }
            },
        })
    }
}
export default plugin