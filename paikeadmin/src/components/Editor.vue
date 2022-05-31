<template>
    <div style="border: 1px solid #ccc" v-if="modelValue">
        <Toolbar style="border-bottom: 1px solid #ccc" :editor="editorRef" :defaultConfig="toolbarConfig"
            :mode="mode" />
        <Editor style="height: 500px; overflow-y: hidden;" v-model="valueHtml" :defaultConfig="editorConfig"
            @onChange="handleChange" :mode="mode" @onCreated="handleCreated" />
    </div>
</template>
<script>
import '@wangeditor/editor/dist/css/style.css' // 引入 css

import { onBeforeUnmount, ref, shallowRef, watch } from 'vue'
import { Editor, Toolbar } from '@wangeditor/editor-for-vue'

export default {
    components: { Editor, Toolbar },
    props: {
        modelValue: {
            type: String,
            default: ' '
        },
        mode: {
            type: String,
            default: 'default'
        },
        uploadUrl: {
            type: String,
            default: ''
        }
    },
    emits: ['update:modelValue'],
    setup(props, ctx) {
        let valueHtml = ref(props.modelValue)

        watch(
            () => props.modelValue,
            (newModelValue) => {
                valueHtml.value = newModelValue
            },
            { deep: true, immediate: true },
        ) // 监听富文本输入值变动
        const editorRef = shallowRef()

        const toolbarConfig = {}

        const editorConfig = { placeholder: '请输入内容...', MENU_CONF: {} }

        editorConfig.MENU_CONF['uploadImage'] = {
            server: props.uploadUrl ? props.uploadUrl : `/api/wangUploadCloud`,
            timeout: 5 * 1000, // 5s
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            onSuccess(file, res) {
                console.log('onSuccess', file, res)
            },
            onError(file, err, res) {
                alert(err.message)
                console.error('onError', file, err, res)
            },
            onFailed(file, res) {
                alert(res.message)
                console.log('onFailed', file, res)
            },
        }
        const handleChange = (editor) => {
            valueHtml.value = editor.getHtml()
            // 传递给父级
            ctx.emit('update:modelValue', valueHtml.value)
        }

        onBeforeUnmount(() => {
            const editor = editorRef.value
            if (editor == null) return
            editor.destroy()
        })

        const handleCreated = (editor) => {
            editorRef.value = editor
        }

        return {
            editorRef,
            valueHtml,
            handleChange,
            mode: 'default',
            toolbarConfig,
            editorConfig,
            handleCreated
        };
    }
}
</script>