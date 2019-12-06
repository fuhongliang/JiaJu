<?php
defined('YII_ENV') or exit('Access Denied');
$this->title = '用户列表';
$urlManager = Yii::$app->urlManager;
$user_login_url = Yii::$app->urlManager->createAbsoluteUrl(['mch/permission/passport/index', 'mch_store_id' => $this->context->store->id]);
?>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">权限管理</a></li>
    <span>/</span>
    <li><?= $this->title ?></li>
</ul>
<?php $this->endBlock(); ?>


<div class="pd-white-box">
    <div class="search-box">
        <div class="form-group">
        <span style="color: red;">管理人员登录入口：</span>
        <a href="<?= $user_login_url ?>" target="_blank"><?= $user_login_url ?></a>
        </div>
    </div>
    <div class="table-act-row">
        <a class="btn btn-primary btn-sm blue_new" href="<?= $urlManager->createUrl(['mch/permission/user/create']) ?>">添加用户</a>
    </div>

    <table class="table table-bordered bg-white">
        <thead>
        <tr>
            <th>账号</th>
            <th>昵称</th>
            <th>创建日期</th>
            <th>操作</th>
        </tr>
        </thead>
        <?php foreach ($list as $item): ?>
            <tr>
                <td><?= $item->username ?></td>
                <td><?= $item->nickname ?></td>
                <td><?= date('Y-m-d H:i:s', $item->addtime) ?></td>
                <td>
                    <a class="btn btn-sm btn-primary"
                       href="<?= $urlManager->createUrl(['mch/permission/user/edit', 'id' => $item->id]) ?>">编辑</a>

                    <a class="btn btn-sm btn-danger article-delete"
                       href="<?= $urlManager->createUrl(['mch/permission/user/destroy', 'id' => $item->id]) ?>">删除</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<script>
    $(document).on("click", ".article-delete", function () {
        var href = $(this).attr("href");
        $.confirm({
            content: "确认删除？",
            confirm: function () {
                $.loading();
                $.ajax({
                    url: href,
                    dataType: "json",
                    success: function (res) {
                        $.myAlert({
                            content: res.msg,
                            confirm: function () {
                                if (res.code == 0) {
                                    location.reload();
                                }
                            }
                        })

                    }
                });
            }
        });
        return false;
    });
</script>