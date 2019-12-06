<?php
$this->title = '保证金';
$url_manager = Yii::$app->urlManager;
?>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="<?= !isset($get['status']) || $get['status'] == -1 ? 'active' : null ?>"><a href="<?= $url_manager->createUrl(['mch/cash/mch-deposit', 'status' => -1]) ?>">全部</a></li>
    <li class="<?= !isset($get['status']) || $get['status'] == 0 ? 'active' : null ?>"><a href="<?= $url_manager->createUrl(['mch/cash/mch-deposit', 'status' => 0]) ?>">待审核</a></li>
    <li class="<?= isset($get['status']) && $get['status'] == 1 ? 'active' : null ?>"><a href="<?= $url_manager->createUrl(['mch/cash/mch-deposit', 'status' => 1]) ?>">已通过</a></li>
    <li class="<?= isset($get['status']) && $get['status'] == 2 ? 'active' : null ?>"><a href="<?= $url_manager->createUrl(['mch/cash/mch-deposit', 'status' => 2]) ?>">未通过</a></li>
</ul>
<?php $this->endBlock(); ?>

<div class="pd-white-box">
    <?php if (!$list || count($list) == 0): ?>
        <div class="p-5 text-center text-muted">暂无申请记录</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>商户</th>
                <th>转账图片</th>
                <th>金额</th>
                <th>审核状态</th>
                <th>时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <?php foreach ($list as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= $item['name'] ?></td>
                    <td><img src="<?= $item['image_url'] ?>" style="width: 3rem;height: 3rem;" /> </td>
                    <td><?=$item['price']?></td>
                    <td><?php if ($item['status'] == 0): ?><span class="badge badge-pill badge-warning">未审核</span>
                        <?php elseif($item['status'] == 1): ?><span class="badge badge-pill badge-success">审核通过</span>
                        <?php else: ?><span class="badge badge-pill badge-danger">已拒绝</span><?php endif;?>
                    </td>
                    <td><?= date('Y-m-d H:i',$item['created_at'])?></td>
                    <td>
                        <a href="javascript:void(0);" class="btn btn-primary" onclick="showImage('<?= $item['image_url'] ?>');">查看详情</a>
                        <?php if ($item['status'] == 0): ?>
                            <a class="transfer-confirm btn btn-primary" data-warning="确认通过？"
                               data-toggle="tooltip" data-placement="bottom"
                               title="审核通过"
                               href="<?= $url_manager->createUrl(['mch/cash/mch-deposit-submit', 'status' => 1, 'id' => $item['id'],]) ?>">审核通过</a>
                            <a class="transfer-confirm btn btn-primary" data-warning="确认拒绝？"
                               data-toggle="tooltip" data-placement="bottom"
                               title="审核不通过"
                               href="<?= $url_manager->createUrl(['mch/cash/mch-deposit-submit', 'status' => 2, 'id' => $item['id'],]) ?>">拒绝</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]) ?>
    <?php endif; ?>

</div>

<div class="modal" tabindex="-1" role="dialog" id="imageModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">转账大图</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="imageUrl" src="" />
            </div>
        </div>
    </div>
</div>


<script>
    function showImage(url)
    {
        $('#imageUrl').attr('src', url);
        $('#imageModal').modal('show');
    }

    $(document).on('click', '.transfer-confirm', function () {
        var btn = $(this);
        $.confirm({
            content: btn.attr('data-warning'),
            confirm: function () {
                $.loading();
                $.ajax({
                    url: btn.attr('href'),
                    dataType: 'json',
                    success: function (res) {
                        $.alert({
                            content: res.msg,
                            confirm: function () {
                                location.reload();
                            }
                        });
                    }
                });
            },
        });
        return false;
    });
</script>
