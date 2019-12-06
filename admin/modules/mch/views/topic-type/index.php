<?php
defined('YII_ENV') or exit('Access Denied');
use yii\widgets\LinkPager;

$urlManager = Yii::$app->urlManager;
$this->title = '专题分类';
$this->params['active_nav_group'] = 8;
?>
<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">内容管理</a></li>
    <span>/</span>
    <li><?= $this->title ?></li>
</ul>
<?php $this->endBlock(); ?>
<style>
    .cover-pic {
        display: block;
        width: 8rem;
        height: 5rem;
        background-size: cover;
        background-position: center;
    }
</style>

<div class="pd-white-box">
    <div class="table-act-row">
        <a class="btn btn-primary btn-sm blue_new" href="<?= $urlManager->createUrl(['mch/topic-type/edit']) ?>">添加专题分类</a>
    </div>

    <table class="table table-bordered bg-white">
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        </thead>
        <col style="width: 20%">
        <col style="width: 40%">
        <col style="width: 20%">
        <col style="width: 20%">
        <tbody>
        <?php foreach ($list as $item): ?>
            <tr>
                <td><?= $item->id ?></td>
                <td><?= $item->name ?></td>
                <td><?= $item->sort ?></td>
                <td>
                    <a class="btn btn-sm btn-primary"
                       href="<?= $urlManager->createUrl(['mch/topic-type/edit', 'id' => $item->id]) ?>">编辑</a>

                    <a class="btn btn-sm btn-danger delete-btn"
                       href="<?= $urlManager->createUrl(['mch/topic-type/delete', 'id' => $item->id]) ?>">删除</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    <nav aria-label="Page navigation example">
        <?php echo LinkPager::widget([
            'pagination' => $pagination,
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
            'maxButtonCount' => 5,
            'options' => [
                'class' => 'pagination',
            ],
            'prevPageCssClass' => 'page-item',
            'pageCssClass' => "page-item",
            'nextPageCssClass' => 'page-item',
            'firstPageCssClass' => 'page-item',
            'lastPageCssClass' => 'page-item',
            'linkOptions' => [
                'class' => 'page-link',
            ],
            'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
        ])
        ?>
    </nav>
</div>

<script>
    $(document).on("click", ".delete-btn", function () {
        var url = $(this).attr("href");
        $.confirm({
            content: "确认删除？",
            confirm: function () {
                $.loading();
                $.ajax({
                    url: url,
                    dataType: "json",
                    success: function (res) {
                        location.reload();
                    }
                });
            }
        });
        return false;
    });
</script>