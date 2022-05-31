
import Transition from '@/views/Transition.vue'
class routeTool {
    /**
     * 生成根布局路由
     */
    getRootLayoutRoutes(layouts) {
        let rootLayoutRoutes = []
        Object.keys(layouts).forEach((path, index) => {
            let rootName = path.split('/').pop().slice(0, -10)

            const name = rootName.charAt(0).toLowerCase() + rootName.slice(1)

            const component = layouts[path].default
            return rootLayoutRoutes.push({
                name: name,
                path: `/${name}`,
                component: component,
                meta: { level: 1, layout: true },
                children: []
            })
        })
        return rootLayoutRoutes
    }
    //最大级别路由level数
    getMaxLevel() {
        Object.keys(views)
            .sort((pre, cur) => cur.split('/').length - pre.split('/').length)[0]
            .split('/').length - 2
    }

    /**
     * 
     * 格式化路由
     * 
     */
    formatViewsRoutes(views) {
        //路由不自动注册时，将组件中的route:false
        let routeArr = []
        Object.keys(views).filter((path) => {
            if (views[path].default.route == false) {
                return
            } else {
                let pathname = path.replace(/(\.+\/views\/)|(.vue)/g, '')

                let name = path.replace(/(\.+\/views\/)|(.vue)/g, '').replace(/\//g, ".")

                let level = this.getLevel(name, '.')


                let component = views[path].default
                let title = views[path].default.meta
                    ? (views[path].default.meta.title ? views[path].default.meta.title : '') : ''
                // 是否需要验证
                let requiresAuth = views[path].default.meta
                    ? (views[path].default.meta.requiresAuth ? views[path].default.meta.requiresAuth : false) : false
                let meta = { level: level, title: title, requiresAuth: requiresAuth }
                routeArr.push({
                    name: component.name ? component.name : name,
                    path: component.path ? component.path : `/${pathname}`,
                    meta: meta,
                    component: component,
                    children: []
                })
            }

        })

        /**
         * 当仅仅为文件夹的时候，对应后台菜单
         * 去掉末尾的组件路径，找出组，产生fold展开项目，值为唯一的
         */
        let foldIndexs = new Set()

        routeArr.map(route => {
            let l = route.name.split('.').length
            let pathArr = route.name.split('.')
            if (l > 2) {
                pathArr.pop()
                foldIndexs.add(pathArr.join('.'))
            }
        })
        foldIndexs.forEach((item) => {
            routeArr.push({
                name: item,
                path: `/${item.replace(/\./g, '/')}`,
                meta: { fold: true, level: this.getLevel(item, '.') },//只要是有fold的说明是菜单项，起到下拉功能
                component: Transition
            })
        })
        return routeArr
    }

    /**
    * 路由name中有几个点.
    * 那么加上1成为级别level
    */
    getLevel(scrstr, armstr) { //scrstr 源字符串 armstr 特殊字符
        var count = 0;
        while (scrstr.indexOf(armstr) != -1) {
            scrstr = scrstr.replace(armstr, "")
            count++;
        }
        return count + 1;//系统需要加1
    }

    /**
     * 转换树形结构
     * ==随意传递一个路由，返回由其生成的树形结构==
     * 这个地方把rootLayoutRoutes传进去
     */
    generateTreeComponent(rootRoute, allRoutes) {
        //获取当前路由level
        let level = rootRoute.meta.level
        //获取下级level的所有路由
        let innerLevelRoutes = allRoutes.filter(route => route.meta.level == (level + 1))
        //匹配名称
        let matchRoutes = innerLevelRoutes.filter(route => route.name.includes(rootRoute.name))
        rootRoute.children = matchRoutes
        rootRoute.children.map(route => {
            return this.generateTreeComponent(route, allRoutes)
        })
        return rootRoute
    }

}

export default routeTool
