<?php
$this->title = '商户列表';
$url_manager = Yii::$app->urlManager;

$user_login_url = Yii::$app->urlManager->createAbsoluteUrl(['user/passport/login', 'entry_store_id' => $this->context->store->id]);
?>
<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">商户管理</a></li>
    <span>/</span>
    <li><?= $this->title ?></li>
</ul>
<?php $this->endBlock(); ?>
<div class="pd-white-box">
    <div class="search-box">
        <form class="form-inline custom-inline" style="margin: -.25rem 0" method="get">
            <input type="hidden" name="r" value="mch/mch/index/index">
            <div class="form-group">
                <div class="input-group mb-3">
                    <input class="form-control" name="keyword" value="<?= $get['keyword'] ?>" placeholder="店铺/用户/联系人">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group mb-3">
                    <button type="button" class="btn btn-primary btn-sm" id="searchButton">搜索</button>
                </div>
            </div>
        </form>
    </div>
    <div class="table-act-row">
        <a class="btn btn-primary btn-sm blue_new" href="<?= Yii::$app->urlManager->createUrl(['mch/mch/index/add']) ?>">添加商户</a>
    </div>


    <?php if (!$list || count($list) == 0): ?>
        <div class="p-5 text-center text-muted">暂无商户</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>店铺</th>
                <th>联系人</th>
                <th>城市</th>
                <th>地区</th>
                <th>排序</th>
                <th>开业</th>
                <th>操作</th>
            </tr>
            </thead>
            <?php foreach ($list as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td>
                        <img src="<?= $item['logo'] ?>"
                             style="width: 25px;height: 25px;margin: -.5rem .5rem -.5rem 0">
                        <?= $item['name'] ?>
                    </td>
                    <td><?= $item['realname'] ?>（<?= $item['tel'] ?>）</td>
                    <td><?= $item['city'] ?></td>
                    <td><?= $item['district'] ?></td>
                    <td><?= $item['sort'] ?></td>
                    <td>
                        <?php if ($item['is_open'] == 1): ?>
                            <label class="switch-label">
                                <input type="checkbox" name="is_open" checked data-id="<?= $item['id'] ?>">
                                <span class="label-icon"></span>
                                <span class="label-text"></span>
                            </label>
                        <?php else: ?>
                            <label class="switch-label">
                                <input type="checkbox" name="is_open" data-id="<?= $item['id'] ?>">
                                <span class="label-icon"></span>
                                <span class="label-text"></span>
                            </label>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= $url_manager->createUrl(['mch/mch/index/edit', 'id' => $item['id']]) ?>">管理</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
    <?php endif; ?>

</div>

<script>
    $(document).on('change', 'input[name=is_open]', function () {
        console.log($(this));
        var id = $(this).attr('data-id');
        var status = 0;
        if ($(this).prop('checked'))
            status = 1;
        else
            status = 0;
        $.loading();
        $.ajax({
            url: '<?=Yii::$app->urlManager->createUrl(['mch/mch/index/set-open-status'])?>',
            dataType: 'json',
            data: {
                id: id,
                status: status,
            },
            success: function (res) {
                $.toast({
                    content: res.msg,
                });
            },
            complete: function () {
                $.loadingHide();
            }
        });
    });
</script>
