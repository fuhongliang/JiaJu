<?php
defined('YII_ENV') or exit('Access Denied');
use yii\widgets\LinkPager;

$urlManager = Yii::$app->urlManager;
$this->title = '首页导航图标';
$this->params['active_nav_group'] = 1;
?>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">小程序</a></li>
    <span>/</span>
    <li><?= $this->title ?></li>
</ul>
<?php $this->endBlock(); ?>

<div class="pd-white-box">
    <div class="table-act-row">
        <a class="btn btn-primary btn-sm blue_new" href="<?= $urlManager->createUrl(['mch/store/home-nav-edit']) ?>">添加图标</a>
    </div>
    <table class="table table-bordered bg-white">
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>图标</th>
            <th>页面</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($list as $index => $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= $item['name'] ?></td>
                <td><img src="<?= $item['pic_url'] ?>"
                         style="width: 20px;height: 20px;"></td>
                <td><?= $item['url']; ?></td>
                <td><?= $item['sort']; ?></td>
                <td>
                    <a class="btn btn-sm btn-primary"
                       href="<?= $urlManager->createUrl(['mch/store/home-nav-edit', 'id' => $item['id']]) ?>">修改</a>
                    <a class="btn btn-sm btn-danger nav-del"
                       href="<?= $urlManager->createUrl(['mch/store/home-nav-del', 'id' => $item['id']]) ?>">删除</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>

</div>


<script>
    $(document).on('click', '.nav-del', function () {
        var a = $(this);
        $.confirm({
            content: "确认删除？",
            confirm: function () {
                $.loading();
                $.ajax({
                    url: a.attr("href"),
                    dataType: "json",
                    success: function (res) {
                        $.loadingHide();
                        $.alert({
                            content: res.msg,
                            confirm: function () {
                                if (res.code == 0) {
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            }
        });
        return false;
    });
</script>