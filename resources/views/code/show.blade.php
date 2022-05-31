@extends('app')
@section('content')
    <!-- The button to open modal -->
    <div class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-md">
                <h1 class="text-5xl rounded font-bold text-green-500">扫码完成</h1>
                <p class="py-6">点击如下按钮查看验证码</p>
                <label for="my-modal" class="btn modal-button">查看验证码</label>
            </div>
        </div>
    </div>

    <!-- Put this part before </body> tag -->
    <input type="checkbox" id="my-modal" class="modal-toggle">
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">您的验证码是</h3>
            <p class="py-4">验证码：【{$code}】</p>
            <div class="modal-action">
                <label for="my-modal" class="btn">确定</label>
            </div>
        </div>
    </div>
    <script>
    </script>
@endsection