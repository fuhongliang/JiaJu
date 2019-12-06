<?php
defined('YII_ENV') or exit('Access Denied');
use yii\widgets\LinkPager;
$urlManager = Yii::$app->urlManager;
$this->title = '角色列表';
?>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">权限管理</a></li>
    <span>/</span>
    <li><?= $this->title ?></li>
</ul>
<?php $this->endBlock(); ?>

<div class="pd-white-box">
    <div class="table-act-row">
        <a class="btn btn-primary btn-sm blue_new" href="<?= $urlManager->createUrl(['mch/permission/role/create']) ?>">添加角色</a>
    </div>

    <table class="table table-bordered bg-white">
        <thead>
        <tr>
            <th>角色</th>
            <th>描述</th>
            <th>创建日期</th>
            <th>操作</th>
        </tr>
        </thead>
        <?php foreach ($list as $item): ?>
            <tr>
                <td><?= $item->name ?></td>
                <td><?= $item->description ?></td>
                <td><?= date('Y-m-d H:i:s', $item->created_at) ?></td>
                <td>
                    <a class="btn btn-sm btn-primary"
                       href="<?= $urlManager->createUrl(['mch/permission/role/edit', 'id' => $item->id]) ?>">编辑</a>

                    <?php if($item->id != 6): ?>
                    <a class="btn btn-sm btn-danger destroy"
                       href="<?= $urlManager->createUrl(['mch/permission/role/destroy', 'id' => $item->id]) ?>">删除</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="text-center">
        <?php if (!empty($pagination)): ?>
            <?= LinkPager::widget(['pagination' => $pagination]) ?>
        <?php endif; ?>
    </div>

</div>

<script>
    $(document).on("click", ".destroy", function () {
        var href = $(this).attr("href");
        $.confirm({
            content: "确认删除？",
            confirm: function () {
                $.loading();
                $.ajax({
                    url: href,
                    dataType: "json",
                    success: function (res) {
                        console.log(res);
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