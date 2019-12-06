<?php
defined('YII_ENV') or exit('Access Denied');

use yii\widgets\LinkPager;

/* @var \app\models\Coupon[] $list */

$urlManager = Yii::$app->urlManager;
$this->title = '打印机管理';
$this->params['active_nav_group'] = 13;
$type = [
    'kdt2' => '365云打印(编号kdt2) ',
    'yilianyun-k4' => '易联云-k4',
    'feie'=>'飞鹅打印机'
];
?>
<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">系统设置</a></li>
    <span>/</span>
    <li><?= $this->title ?></li>
</ul>
<?php $this->endBlock(); ?>

<div class="pd-white-box">
    <div class="table-act-row">
        <a class="btn btn-primary btn-sm blue_new" href="<?= $urlManager->createUrl(['mch/printer/edit']) ?>">添加打印机</a>
        <a class="btn btn-primary btn-sm blue_new" href="<?= $urlManager->createUrl(['mch/printer/setting']) ?>">打印设置</a>
    </div>

    <table class="table table-bordered bg-white">
        <thead>
        <tr>
            <th>打印机名称</th>
            <th>打印机品牌</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($list as $index => $value): ?>
            <tr>
                <td><span><?= $value['name'] ?></span></td>
                <td><?= $type[$value['printer_type']] ?></td>
                <td>
                    <a class="btn btn-sm btn-primary"
                       href="<?= $urlManager->createUrl(['mch/printer/edit', 'id' => $value['id']]) ?>">编辑</a>
                    <a class="btn btn-sm btn-danger del" href="javascript:" data-content="是否删除？"
                       data-url="<?= $urlManager->createUrl(['mch/printer/printer-del', 'id' => $value['id']]) ?>">删除</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="text-center">
        <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination,]) ?>
        <div class="text-muted"><?= $row_count ?>条数据</div>
    </div>
</div>

<script>
    $(document).on('click', '.del', function () {
        var a = $(this);
        $.confirm({
            content: a.data('content'),
            confirm: function () {
                $.ajax({
                    url: a.data('url'),
                    type: 'get',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 0) {
                            window.location.reload();
                        } else {
                            $.alert({
                                title: res.msg
                            });
                        }
                    }
                });
            }
        });
        return false;
    });
</script>
