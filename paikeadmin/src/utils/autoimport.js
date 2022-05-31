// 自动注册全局组件

// 公共组件
const globalComponents = import.meta.globEager("../components/**/*.vue");
const globalIcons = import.meta.globEager("../icons/**/*.vue");
Object.assign(globalComponents, globalIcons)
//  app全局注册
export default function autoImport(app) {
  Object.keys(globalComponents).forEach((path) => {
    const name = path.split("/").pop().slice(0, -4);
    const component = globalComponents[path].default;
    app.component(`Y${name}`, component)
  });
}
