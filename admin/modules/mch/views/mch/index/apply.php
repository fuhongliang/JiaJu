<?php
$this->title = '入住商审核';
$url_manager = Yii::$app->urlManager;
?>
<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="<?= !isset($get['review_status']) || $get['review_status'] == 0 ? 'active' : null ?>"><a href="<?= $url_manager->createUrl(['mch/mch/index/apply', 'review_status' => 0]) ?>">待审核</a></li>
    <li class="<?= isset($get['review_status']) && $get['review_status'] == 1 ? 'active' : null ?>"><a href="<?= $url_manager->createUrl(['mch/mch/index/apply', 'review_status' => 1]) ?>">已通过</a></li>
    <li class="<?= isset($get['review_status']) && $get['review_status'] == 2 ? 'active' : null ?>"><a href="<?= $url_manager->createUrl(['mch/mch/index/apply', 'review_status' => 2]) ?>">未通过</a></li>
</ul>
<?php $this->endBlock(); ?>


<div class="pd-white-box">

    <?php if (!$list || count($list) == 0): ?>
        <div class="p-5 text-center text-muted">暂无商户</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>店铺</th>
                <th>电话</th>
                <th>城市</th>
                <th>地区</th>
                <th>联系人</th>
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
                    <td><?=$item['tel'] ?></td>
                    <td><?= $item['city'] ?></td>
                    <td><?= $item['district'] ?></td>
                    <td><?= $item['realname'] ?></td>
                    <td>
                        <?php if ($item['review_status'] == 0): ?>
                            <a href="<?= $url_manager->createUrl(['mch/mch/index/edit', 'id' => $item['id'],]) ?>">审核</a>
                        <?php else: ?>
                            <a href="<?= $url_manager->createUrl(['mch/mch/index/edit', 'id' => $item['id'],]) ?>">详情</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
    <?php endif; ?>


</div>