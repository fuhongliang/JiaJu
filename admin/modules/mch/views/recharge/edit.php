<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/25
 * Time: 15:42
 */
defined('YII_ENV') or exit('Access Denied');
/** @var \app\models\Recharge $model */
$urlManager = Yii::$app->urlManager;
$this->title = '充值编辑';
$this->params['active_nav_group'] = 12;
$returnUrl = Yii::$app->request->referrer;
if (!$returnUrl)
    $returnUrl = $urlManager->createUrl(['mch/recharge/index']);
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
        <form class="form auto-form" method="post" autocomplete="off" return="<?= $returnUrl ?>">
            <div class="form-body">
                <div class="form-group row">
                    <div class="form-group-label col-2 text-right">
                        <label class="col-form-label required">充值名称</label>
                    </div>
                    <div class="col-6">
                        <input class="form-control" name="name" value="<?=$model->name?>">
                        <div class="fs-sm text-danger">在充值管理显示</div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="form-group-label col-2 text-right">
                        <label class="col-form-label required">支付金额</label>
                    </div>
                    <div class="col-6">
                        <input class="form-control" type="number" name="pay_price" value="<?=$model->pay_price?>">
                        <div class="text-danger fs-sm">用户支付多少就充值多少</div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="form-group-label col-2 text-right">
                        <label class="col-form-label">赠送金额</label>
                    </div>
                    <div class="col-6">
                        <input class="form-control" type="number" name="send_price" value="<?=$model->send_price?>">
                        <div class="text-danger fs-sm">用户充值时，赠送的金额，默认为0</div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group-label col-2 text-right">
                    </div>
                    <div class="col-6">
                        <a class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>