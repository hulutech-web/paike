<template>
    <div>
        <a-card title="排课列表">
            <a-table :dataSource="schedules" :columns="columns" size="small" bordered>
                <template #bodyCell="{ record, column }">
                    <template v-if="column.dataIndex === 'action'">
                        <a-radio-group>
                            <a-popconfirm :title="`确认删除【${record.course}】吗？`" ok-text="是的" cancel-text="再等等"
                                @confirm="deleteSchedule(record)">
                                <a-button size="small" type="primary" danger>删除</a-button>
                            </a-popconfirm>
                        </a-radio-group>
                    </template>
                    <template v-if="column.dataIndex === 'preview'">
                        <div>
                            <a-popover :mouseEnterDelay="0.02" placement="right">
                                <template #content>
                                    <a-avatar shape="square" :src="record.preview" style="width: 64px; height: 64px"
                                        @changeUrl="changeUrl">
                                    </a-avatar>
                                </template>
                                <a-avatar shape="square" :src="record.preview" style="width: 32px; height: 32px">
                                </a-avatar>
                            </a-popover>
                        </div>
                    </template>
                </template>
            </a-table>
        </a-card>
    </div>
</template>

<script>
import { onMounted, ref } from 'vue'
import scheduleApi from '@api/schedule'
export default {
    meta: { title: "排课列表" },
    setup() {
        let schedules = ref([])
        let columns = ref([
            {
                title: 'ID',
                dataIndex: 'id',
                key: 'id',
            },
            {
                title: '课程标题',
                dataIndex: 'course',
                key: 'course',
            },
            {
                title: '授课老师',
                dataIndex: 'teacher',
                key: 'teacher',
            },
            {
                title: '教室',
                dataIndex: 'classroom',
                key: 'classroom',
            },
            {
                title: '星期',
                dataIndex: 'weekday',
                key: 'weekday',
                width: 80,
            },
            {
                title: '日期',
                dataIndex: 'date',
                key: 'date',
                width: 200,
            },
            {
                title: '开始时间',
                dataIndex: 'start_time',
                key: 'start_time',
                width: 150,
            },
            {
                title: '结束时间',
                dataIndex: 'end_time',
                key: 'end_time',
                width: 150,
            },
            {
                title: '操作',
                dataIndex: 'action',
                key: 'action',
                width: 80,
            },
        ])
        const deleteSchedule = async (record) => {
            await scheduleApi.deleteSchedule(record)
            schedules.value = await scheduleApi.getSchedules()
        }
        const getAllSchedules = async () => {
            schedules.value = await scheduleApi.getSchedules()
        }
        onMounted(async () => {
            await getAllSchedules()
        })
        return {
            columns,
            schedules,
            deleteSchedule
        }
    }

}
</script>

<style>
</style>