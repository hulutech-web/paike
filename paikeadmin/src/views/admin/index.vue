<template>
  <div class="content_box">
    <a-card title="我的课表" style="width: 900px" >
      <FullCalendar :options="calendarOptions" style="width: 800px" ref="fullCalendar" />
    </a-card>
  </div>
</template>

<script>
import { defineComponent, onMounted, reactive, ref, nextTick, onBeforeUpdate, onUpdated } from "vue";
import "@fullcalendar/core/vdom";
import { Modal } from "ant-design-vue";
import FullCalendar from "@fullcalendar/vue3";
import { IdcardTwoTone } from "@ant-design/icons-vue";
import { useRoute, useRouter } from "vue-router";
import teacherApi from "@/api/teacher";
import classroomApi from "@/api/classroom";
import courseApi from "@/api/course";
import { getCurrentInstance } from "vue";

import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import timeGridPlugin from "@fullcalendar/timegrid";
import momentPlugin from "@fullcalendar/moment";
import zhLocale from "@fullcalendar/core/locales/zh-cn";
import scheduleApi from "@/api/schedule";
export default defineComponent({
  meta: { title: "添加排课" },
  components: {
    FullCalendar,
    IdcardTwoTone,
  },
  setup() {
    // 初始化数据
    const instance = getCurrentInstance();
    const { proxy } = instance;

    /**
     * 日历控件操作相关
     */

    //获取所有事件
    const getEvents = () => {
      return proxy.$refs["fullCalendar"].getApi().view.calendar.getEvents();
    };
    // 通过ID获取事件
    const getEventById = (id) => {
      return proxy.$refs["fullCalendar"]
        .getApi()
        .view.calendar.getEventById(id);
    };
    // 添加事件
    const addEvent = (event) => {
      proxy.$refs["fullCalendar"].getApi().addEvent(event);
    };

    // 通过id删除事件
    const removeEventById = (event) => {
      let calendarApi = proxy.$refs["fullCalendar"].getApi();
      let calendarFunc = calendarApi.view.calendar;
      let getEvents = calendarFunc.getEvents(); //获取数据
      if (getEvents && getEvents.length > 0) {
        //循环删除数据（通过ID）
        getEvents.map((item) => {
          if (item.id === event.id) {
            calendarFunc.getEventById(item.id).remove();
          }
        });
      }
    };

    // 删除所有事件
    const removeAllEvents = () => {
      let calendarApi = proxy.$refs["fullCalendar"].getApi();
      let calendarFunc = calendarApi.view.calendar;
      let getEvents = calendarFunc.getEvents(); //获取数据
      getEvents.map((item) => {
        item.remove()
      });
    };

    const refresh = () => {
      let calendarApi = proxy.$refs["fullCalendar"].getApi()
      calendarApi.refetchEvents()
    }


    const formState = reactive({
      schedule: {},
    });
    let route = useRoute();
    const id = route.params.id;
    let router = useRouter();
    let formTeacher = reactive({
      teacher: {},
    });
    let courses = ref([]);
    let classrooms = ref([]);
    const getClassrooms = async () => {
      classrooms.value = await classroomApi.getClassroomList();
    };
    // 星期
    let weekdays = ref([
      {
        value: "0",
        label: "星期一",
      },
      {
        value: "1",
        label: "星期二",
      },
      {
        value: "2",
        label: "星期三",
      },
      {
        value: "3",
        label: "星期四",
      },
      {
        value: "4",
        label: "星期五",
      },
      {
        value: "5",
        label: "星期六",
      },
      {
        value: "6",
        label: "星期日",
      },
    ]);
    const selectTeacher = async (teacherModel) => {
      formState.schedule.teacher_id = teacherModel.id;
      formTeacher.teacher = teacherModel;
      courses.value = await courseApi.getTeacherCourses(teacherModel.id);
    };

    onMounted(async () => {
      console.log('onMounted')
      await teacherApi.getTeachers();
      await getClassrooms();

    });

    nextTick(() => {

    })



    const submitSchedule = async () => {
      console.log(formState.schedule);
      scheduleApi.addSchedule(formState.schedule);
      // proxy.$refs["form"].resetFields();
    };

    return {
      calendarOptions: {
        plugins: [
          dayGridPlugin,
          interactionPlugin,
          timeGridPlugin,
          momentPlugin,
        ],
        slotMinTime: "00:00:00",
        slotMaxTime: "24:00:00",
        initialView: "timeGridFourDay",
        // dayHeaderFormat: {
        //   weekday: "short",
        // },
        slotDuration: "01:30:00",
        slotLabelInterval: "01:30:00",
        selectMirror: true,
        locale: zhLocale,
        buttonText: {
          month: "月",
          week: "周",
          day: "日",
        },
        headerToolbar: {
          left: "prev,next today",
          center: "title",
          right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        selectable: false,
        weekNumbers: true,
        slotEventOverlap: false, //相同时间段的多个日程视觉上是否允许重叠，默认true允许
        views: {
          timeGridFourDay: {
            type: "timeGrid",
            duration: {
              days: 7,
            },
          },
        },
        events: {
          url: 'api/userSchedule', // 你的后端访问地址 直接返回对应格式的json串即可
          type: 'get',
          data: {},
          error: function () {

          }
        },
        // events: [{
        //   id: 1,
        //   title: "语文：勤学楼1-1",
        //   start: "2022-04-25 09:00:00",
        //   end: "2022-04-25 10:00:00",
        // },
        // {
        //   id: 2,
        //   title: "数学",
        //   start: "2022-04-26 14:00:00",
        //   end: "2022-04-26 15:00:00",
        // },
        // {
        //   id: 3,
        //   title: '个性化事件',
        //   start: '2022-04-26 18:00:00',
        //   end: '2022-04-26 19:00:00',
        //   interactive: true,
        //   className: 'myclass',
        //   editable: true,
        //   color: 'red',
        //   description: '这是一个个性化事件',
        //   // url: 'http://www.baidu.com',//跳转链接
        // }
        // ], //事件事件+文本
        eventColor: "#1890ff", //事件背景颜色
        eventClick: (info) => {
          // 当用户点击一个事件时触发。
          Modal.confirm({
            title: "确定删除吗？",
            content: `您正在删除${info.event.title}`,
            okText: "是",
            okType: "danger",
            cancelText: "否",
            onOk() {
              removeEventById(info.event);
              // 发送网络请求删除事件
              console.error(info.event.id)
              if(info.event.id){
                scheduleApi.deleteSchedule(info.event);
              }
            },

            onCancel() {
              console.log("Cancel");
            },
          });
        },
        // 点击空白处触发
        // dateClick: function (info) {
        //     alert('Clicked on: ' + info.dateStr);
        // },
        eventDidMount: function (info) {
          //每一个事件都会触发
          // console.log('eventDidMount', info)
        },
        select: function (info) {
          // 转换为中国时间


          let startTime = info.startStr.replace("T", " ");
          let endTime = info.endStr.replace("T", " ");

          // 获取星期几

          let weekday = new Date(info.startStr.replace("T", " ")).getDay();


          let date = startTime.substring(0, 10);
          Object.assign(formState.schedule, {
            start_time: startTime,
            end_time: endTime,
            weekday: weekday,
            date: date,
          });
          this.addEvent(info);
          // 重点，这里可以添加日期到右边选框中
        },
        eventAdd: function (info) {
          // 事件被添加时触发
          // console.log('添加事件', info)
        },
        eventChange: function (info) {
          let startTime = info.event.startStr
          let endTime = info.event.endStr
          let weekday = new Date(info.event.startStr).getDay();
          let date = startTime.substring(0, 10);
          Object.assign(formState.schedule, {
            start_time: startTime,
            end_time: endTime,
            weekday: weekday,
            date: date,
          });
          this.addEvent(info);
        },

        editable: true,
        dayMaxEventRows: 1,
        // 设置中国时区【坑】
        timeZone: "Asia/Shanghai",
      },
      formState,
      getEvents,
      getEventById,
      addEvent,
      removeEventById,
      formState,
      formTeacher,
      selectTeacher,
      courses,
      classrooms,
      weekdays,
      submitSchedule,

    };
  },
});
</script>

<style lang="scss" scoped>
.content_box {
  display: flex;
  justify-content: space-evenly;
}

.myclass {
  background-color: #2ed573;
}
</style>
