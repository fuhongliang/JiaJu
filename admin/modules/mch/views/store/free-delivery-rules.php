<?php
defined('YII_ENV') or exit('Access Denied');
$urlManager = Yii::$app->urlManager;
$this->title = '包邮规则';
$this->params['active_nav_group'] = 1;
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
        <a class="btn btn-primary btn-sm blue_new" href="<?= $urlManager->createUrl(['mch/store/free-delivery-rules-edit']) ?>">添加新规则</a>
    </div>

    <table class="table table-bordered bg-white">
        <tr>
            <th>ID</th>
            <th class="min">金额</th>
            <th>省份</th>
            <th class="min">操作</th>
        </tr>
        <?php foreach ($list as $item): ?>
            <tr>
                <td><?= $item->id ?></td>
                <td><?= $item->price ?></td>
                <td>

                    <?php foreach (json_decode($item->city,true) as $i): ?>

                        <span><?= $i['name'] ?></span>
                    <?php endforeach; ?>
                </td>

                <td>
                    <a class="btn btn-sm btn-primary"
                       href="<?= $urlManager->createUrl(['mch/store/free-delivery-rules-edit', 'id' => $item->id]) ?>">修改</a>
                    <a class="btn btn-sm btn-danger rules-del"
                       href="<?= $urlManager->createUrl(['mch/store/free-delivery-rules-delete', 'id' => $item->id]) ?>">删除</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>

<script>

	$(document).on('change', '.default-rule-checkbox', function () {
		$.loading();
		location.href = $(this).attr('data-url');
	});

	$(document).on('click', '.rules-del', function () {
		var a = $(this);
		$.confirm({
			content: "是否删除该规则？",
			confirm: function () {
				$.loading({
					content: "正在处理",
				});
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
<style>
	.min {
		min-width: 110px;
	}
</style>