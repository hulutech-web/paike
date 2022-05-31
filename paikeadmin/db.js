const Mock = require("mockjs");
//Mock.Random 是一个工具类，用于生成各种随机数据
const Random = Mock.Random;

const RandomIconNames = [
  "application",
  "building-four",
  "message-emoji",
  "connection-point",
  "link-cloud",
  "enquire",
  "tiktok",
  "history-query",
  "transaction",
  "peoples",
  "fingerprint-three",
  "database-code",
];
const generateIcon = (iconsArr) => {
  return RandomIconNames[Math.floor(Math.random(0, iconsArr.length) * 10)];
};

module.exports = () => {
  //定义json-server需要的数据结构
  let data = {
    users: [],
    menus: [],
    permissions: [],
  };

  const paths=['/admin/']
  //添加20条包含中文的内容
  for (let i = 1; i <= 5; i++) {
    data.menus.push({
      id: i,
      title: Random.cword(3, 6),
      icon: generateIcon(RandomIconNames),
      name: "admin.shop.index",
      path: "/admin/shop/index",
    });
  }

  for (let m = 1; m < 10; m++) {
    data.users.push({
      id: m,
      name: Random.name(),
      address: Random.province() + Random.city() + Random.county(),
      mobile: Mock.mock({
        regexp: /1([358][0-9]|4[579]|66|7[0135678]|9[89])[0-9]{8}/,
      }),
    });
  }

  return data;
};
