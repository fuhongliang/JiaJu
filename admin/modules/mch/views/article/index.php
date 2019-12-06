<?php
defined('YII_ENV') or exit('Access Denied');

$cat = [
    1 => '关于我们',
    2 => '服务中心',
];
$urlManager = Yii::$app->urlManager;
$this->title = $cat[$cat_id];
$this->params['page_navs'] = [
    [
        'name' => '关于我们',
        'active' => $cat_id == 1,
        'url' => $urlManager->createUrl(['mch/article/index', 'cat_id' => 1,]),
    ],
    [
        'name' => '服务中心',
        'active' => $cat_id == 2,
        'url' => $urlManager->createUrl(['mch/article/index', 'cat_id' => 2,]),
    ],
    [
        'name' => '保证金协议',
        'active' => $cat_id == 13,
        'url' => $urlManager->createUrl(['mch/article/index', 'cat_id' => 13,]),
    ],
];
?>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <?php if (is_array($this->params['page_navs'])): ?>
        <?php foreach ($this->params['page_navs'] as $page_nav): ?>
        <li class="<?= $page_nav['active'] ? 'active' : '' ?>"><a href="<?= $page_nav['url'] ?>"><?= $page_nav['name'] ?></a></li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>
<?php $this->endBlock(); ?>


<div class="pd-white-box">

    <div class="table-act-row">
        <?php if ($cat_id == 2): ?>
        <a class="btn btn-primary btn-sm blue_new" href="<?= $urlManager->createAbsoluteUrl(['mch/article/edit', 'cat_id' => 2]) ?>">添加文章</a>
        <?php endif; ?>
    </div>


    <table class="table table-bordered bg-white">
        <thead>
        <tr>
            <th>ID</th>
            <th>类别</th>
            <th>标题</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        </thead>
        <?php foreach ($list as $item): ?>
            <tr>
                <td><?= $item->id ?></td>
                <td><?= $cat[$item->article_cat_id] ?></td>
                <td><?= $item->title ?></td>
                <td><?= $item->sort ?></td>
                <td>
                    <a class="btn btn-sm btn-primary"
                       href="<?= $urlManager->createUrl(['mch/article/edit', 'cat_id' => $item->article_cat_id, 'id' => $item->id]) ?>">编辑</a>
                    <?php if ($cat_id == 2): ?>
                        <a class="btn btn-sm btn-primary copy"
                           data-clipboard-text="/pages/article-detail/article-detail?id=<?= $item->id ?>"
                           href="javascript:" hidden>复制链接</a>
                        <a class="btn btn-sm btn-danger article-delete"
                           href="<?= $urlManager->createUrl(['mch/article/delete', 'id' => $item->id]) ?>">删除</a>
                    <?php else: ?>
                        <a class="btn btn-sm btn-primary copy"
                           data-clipboard-text="/pages/article-detail/article-detail?id=about_us"
                           href="javascript:" hidden>复制链接</a>
                    <?php endif; ?>
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
                        location.reload();
                    }
                });
            }
        });
        return false;
    });
</script>
