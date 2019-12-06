<?php
defined('YII_ENV') or exit('Access Denied');
$urlManager = Yii::$app->urlManager;
$this->title = '运费规则';
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
        <a class="btn btn-primary btn-sm blue_new" href="<?= $urlManager->createUrl(['mch/store/postage-rules-edit']) ?>">添加新规则</a>
    </div>

    <table class="table">
        <tr>
            <th>规则名称</th>
            <th hidden>快递公司</th>
            <th>是否默认</th>
            <th>操作</th>
        </tr>
        <?php foreach ($list as $item): ?>
            <tr>
                <td><?= $item->name ?></td>
                <td hidden><?= $item->express ? $item->express : '无' ?></td>
                <td>
                    <label class="checkbox-label">
                        <input type="checkbox" <?= $item->is_enable == 1 ? 'checked' : null ?>
                               name="checkbox1[]"
                               class="default-rule-checkbox"
                               data-url="<?= $urlManager->createUrl(['mch/store/postage-rules-set-enable', 'id' => $item->id, 'type' => $item->is_enable == 1 ? 0 : 1]) ?>">
                        <span class="label-icon"></span>
                        <span class="label-text">默认</span>
                    </label>
                </td>
                <td>
                    <a class="btn btn-sm btn-primary"
                       href="<?= $urlManager->createUrl(['mch/store/postage-rules-edit', 'id' => $item->id]) ?>">修改</a>
                    <a class="btn btn-sm btn-danger rules-del"
                       href="<?= $urlManager->createUrl(['mch/store/postage-rules-delete', 'id' => $item->id]) ?>">删除</a>
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