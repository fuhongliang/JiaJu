<?php
defined('YII_ENV') or exit('Access Denied');
$urlManager = Yii::$app->urlManager;
$this->title = '门店设置';
$this->params['active_nav_group'] = 1;
?>
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=C65BZ-YWY6Q-NJD54-GHNUX-VWHGQ-YBBH2"></script>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">内容</a></li>
    <span>/</span>
    <li><?= $this->title ?></li>
</ul>
<?php $this->endBlock(); ?>
<div class="pd-white-box">
    <div class="table-act-row">
        <a class="btn btn-primary btn-sm blue_new" href="<?= $urlManager->createUrl(['mch/store/shop-edit']) ?>">添加门店</a>
    </div>


    <table class="table table-bordered bg-white">
        <thead>
        <tr>
            <th>ID</th>
            <th>门店名称</th>
            <th>联系方式</th>
            <th>门店地址</th>
            <th>经纬度</th>
            <th>核销订单</th>
            <th>销售总额</th>
            <th>核销卡券</th>
            <th>默认门店</th>
            <th>操作</th>
        </tr>
        </thead>
        <?php foreach ($list as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= $item['name'] ?></td>
                <td><?= $item['mobile'] ?></td>
                <td><?= $item['address'] ?></td>
                <td>
                    <?php if ($item['longitude']): ?>
                        <?= "(" . $item['longitude'] . "," . $item['latitude'] . ")" ?>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= $urlManager->createUrl(['mch/order/index', 'shop_id' => $item['id']]) ?>"><?= $item['order_count'] ?></a>
                </td>
                <td><?= $item['total_price'] ?></td>
                <td>
                    <a href="<?= $urlManager->createUrl(['mch/user/card', 'shop_id' => $item['id']]) ?>"><?= $item['card_count'] ?></a>
                </td>
                <td>
                    <?php if ($item['is_default'] == 1): ?>
                        <span class="badge badge-success">已开启</span>
                        |
                        <a href="javascript:" onclick="upDown(<?= $item['id'] ?>,0);">关闭</a>
                    <?php else: ?>
                        <span class="badge badge-default">已关闭</span>
                        |
                        <a href="javascript:" onclick="upDown(<?= $item['id'] ?>,1);">开启</a>
                    <?php endif ?>
                </td>
                <td>
                    <a class="btn btn-primary btn-sm"
                       href="<?= $urlManager->createUrl(['mch/store/shop-edit', 'id' => $item['id']]) ?>">修改</a>
                    <a class="btn btn-danger btn-sm del" href="javascript:"
                       data-url="<?= $urlManager->createUrl(['mch/store/shop-del', 'id' => $item['id']]) ?>"
                       data-content="是否删除？">删除</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="text-center">
        <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination,]) ?>
        <div class="text-muted"><?= $row_count ?>条数据</div>
    </div>

</div>

<script>
    $(document).on('click', '.del', function () {
        var a = $(this);
        $.myConfirm({
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
                            $.myAlert({
                                title: "提示",
                                content: res.msg
                            });
                        }
                    }
                });
            }
        });
        return false;
    });

    function upDown(id, type) {
        var text = '';
        if (type == 1) {
            text = "开启默认门店";
        } else {
            text = '关闭默认门店';
        }

        var url = "<?= $urlManager->createUrl(['mch/store/shop-up-down']) ?>";
        if (confirm("是否" + text + "？")) {
            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                data: {id: id, type: type},
                success: function (res) {
                    if (res.code == 0) {
                        window.location.reload();
                    }
                    if (res.code == 1) {
                        alert(res.msg);
                        if (res.return_url) {
                            location.href = res.return_url;
                        }
                    }
                }
            });
        }
        return false;
    }
</script>
