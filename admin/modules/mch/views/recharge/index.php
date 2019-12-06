<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/15
 * Time: 11:14
 */
defined('YII_ENV') or exit('Access Denied');
use yii\widgets\LinkPager;


$urlManager = Yii::$app->urlManager;
$this->title = '充值管理';
$this->params['active_nav_group'] = 12;
?>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">营销活动</a></li>
    <span>/</span>
    <li><?= $this->title ?></li>
</ul>
<?php $this->endBlock(); ?>

<div class="pd-white-box">
    <div class="panel-body">
        <a class="btn btn-primary mb-3" href="<?= $urlManager->createUrl(['mch/recharge/edit']) ?>">添加充值方案</a>
        <a class="btn btn-primary mb-3" href="<?= $urlManager->createUrl(['mch/recharge/setting']) ?>">设置</a>
        <div class=" bg-white">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>充值名称</td>
                    <td>支付金额(元)</td>
                    <td>赠送金额(元)</td>
                    <td>创建时间</td>
                    <td>操作</td>
                </tr>
                </thead>
                <col style="width: 10%;">
                <col style="width: 20%;">
                <col style="width: 20%;">
                <col style="width: 20%;">
                <col style="width: 15%;">
                <col style="width: 15%;">
                <tbody>
                <?php foreach($list as $index=>$value):?>
                    <tr>
                        <td><?=$value['id']?></td>
                        <td><?=$value['name']?></td>
                        <td><?=$value['pay_price']?></td>
                        <td><?=$value['send_price']?></td>
                        <td><?=date('Y-m-d H:i',$value['addtime']);?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="<?=$urlManager->createUrl(['mch/recharge/edit','id'=>$value['id']])?>">修改</a>
                            <a class="btn btn-danger btn-sm del" href="javascript:"
                               data-content="是否删除？"
                               data-url="<?=$urlManager->createUrl(['mch/recharge/del','id'=>$value['id']])?>">删除</a>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).on("click", ".del", function () {
        var a = $(this);
        $.myConfirm({
            content: a.data('content'),
            confirm: function () {
                $.myLoading();
                $.ajax({
                    url: a.data('url'),
                    dataType: "json",
                    success: function (res) {
                        if (res.code == 0) {
                            location.reload();
                        } else {
                            $.myLoadingHide();
                            $.myAlert({
                                content: res.msg,
                            });
                        }
                    }
                });
            },
        });
        return false;
    });
</script>
