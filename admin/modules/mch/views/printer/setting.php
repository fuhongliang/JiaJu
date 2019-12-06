<?php
defined('YII_ENV') or exit('Access Denied');

use yii\widgets\LinkPager;
use \app\models\Option;

/* @var \app\models\Printer[] $list */
/* @var \app\models\PrinterSetting $model */

$urlManager = Yii::$app->urlManager;
$this->title = '打印设置';
$this->params['active_nav_group'] = 13;
?>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">系统设置</a></li>
    <span>/</span>
    <li><?= $this->title ?></li>
</ul>
<?php $this->endBlock(); ?>

<div class="pd-white-box" id="app">
    <div class="wrap">
        <form class="auto-form" method="post">
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">选择打印机</label>
                </div>
                <div class="col-sm-6">
                    <select class="form-control" name="printer_id">
                        <?php foreach ($list as $index => $value): ?>
                            <option value="<?= $value->id ?>" <?= $model->printer_id == $value['id'] ? "selected" : "" ?>><?= $value->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>


            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">订单打印方式</label>
                </div>
                <div class="col-sm-6 col-form-label">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input id="radioOrder1"
                               value="1" <?= $model->type['order'] == 1 ? "checked" : "" ?>
                               name="type[order]" type="checkbox" class="custom-control-input">
                        <label class="custom-control-label" for="radioOrder1">下单打印</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input id="radioOrder2"
                               value="1" <?= $model->type['pay'] == 1 ? "checked" : "" ?>
                               name="type[pay]" type="checkbox" class="custom-control-input">
                        <label class="custom-control-label" for="radioOrder2">付款打印</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input id="radioOrder3"
                               value="1" <?= $model->type['confirm'] == 1 ? "checked" : "" ?>
                               name="type[confirm]" type="checkbox" class="custom-control-input">
                        <label class="custom-control-label" for="radioOrder3">确认收货打印</label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">是否打印规格</label>
                </div>
                <div class="col-sm-6 col-form-label">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input id="isAttrYes" <?= $model->is_attr == 1 ? 'checked' : null ?>
                               value="1"
                               name="is_attr" type="radio" class="custom-control-input">
                        <label class="custom-control-label" for="isAttrYes">开启</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input id="isAttrNo" <?= $model->is_attr == 0 ? 'checked' : null ?>
                               value="0"
                               name="is_attr" type="radio" class="custom-control-input">
                        <label class="custom-control-label" for="isAttrNo">关闭</label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary auto-form-btn" href="javascript:void(0);">保存</a>
                </div>
            </div>
        </form>
    </div>
</div>
