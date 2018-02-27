layui.use(['element', 'form', 'layer'], function () {
    var element = layui.element,
        form = layui.form,
        layer = layui.layer;

    var api = './index.php';

    // 登录提交事件
    form.on('submit(formLogin)', function (data) {
        $.ajax({
            type: "POST",
            url: api + "?c=user&a=login",
            data: data.field,
            success: function (response) {
                if (typeof response == 'string') {
                    layer.msg(response);
                } else if (response.status == 1) {
                    layer.alert(response.msg, {
                        icon: 1,
                        title: '登录成功'
                    });
                } else {
                    layer.alert(response.msg, {
                        icon: 2,
                        title: '登录失败'
                    });
                }
            }
        });
        return false;
    });

    // 注册提交事件
    form.on('submit(formRegister)', function (data) {
        $.ajax({
            type: "POST",
            url: api + "?c=user&a=register",
            data: data.field,
            success: function (response) {
                if (typeof response == 'string') {
                    layer.msg(response);
                } else if (response.status == 1) {
                    layer.alert(response.msg, {
                        icon: 1,
                        title: '注册成功'
                    });
                    // 更换号码
                    genPhone();
                } else {
                    layer.alert(response.msg, {
                        icon: 2,
                        title: '注册失败'
                    });
                }
            }
        });
        return false;
    });

    // 生成测试号码
    function genPhone() {
        $(".form-register [name='phone']").val('13' + Date.parse(new Date()).toString().substr(1, 9))
    }
    genPhone();

});
