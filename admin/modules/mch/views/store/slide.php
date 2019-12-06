<?php
defined('YII_ENV') or exit('Access Denied');

use yii\widgets\LinkPager;

$urlManager = Yii::$app->urlManager;
$this->title = '商城首页轮播图';
$this->params['active_nav_group'] = 1;
?>
<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">小程序</a></li>
    <span>/</span>
    <li><?= $this->title;?></li>
</ul>
<?php $this->endBlock(); ?>

<div class="pd-white-box" id="app">
    <div class="table-act-row">
        <a class="btn btn-primary btn-sm blue_new" href="<?= $urlManager->createUrl(['mch/store/slide-edit']) ?>">添加轮播图</a>
    </div>

    <?php foreach ($list as $index => $value): ?>
        <div class="card mb-3" style="display: inline-block;width: 300px">
            <div class="card-img-top" data-responsive="750:400"
                 style="background-image: url(<?= $value['pic_url'] ?>);background-size: cover;background-position: center"></div>
            <div class="card-body p-3">
                <p>标题：<?= $value['title'] ?></p>
                <div style="white-space: nowrap;overflow: hidden;word-break: break-all;text-overflow: ellipsis;">链接：<?= $value['page_url'] ?></div>
            </div>

            <div class="card-footer text-muted">
                <a class="btn btn-sm btn-primary"
                   href="<?= $urlManager->createUrl(['mch/store/slide-edit', 'id' => $value['id']]) ?>">修改</a>
                <a class="btn btn-sm btn-danger del"
                   href="<?= $urlManager->createUrl(['mch/store/slide-del', 'id' => $value['id']]) ?>">删除</a>
            </div>
        </div>
    <?php endforeach; ?>

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
    $(document).on('click', '.del', function () {
        var a = $(this);
        $.confirm({
            content: '确认删除？',
            confirm: function () {
                $.loading();
                $.ajax({
                    url: a.attr('href'),
                    type: 'get',
                    dataType: 'json',
                    success: function (res) {
                        $.loadingHide();
                        $.alert({
                            content: res.msg,
                            confirm: function () {
                                if (res.code == 0) {
                                    window.location.reload();
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