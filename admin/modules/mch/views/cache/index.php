<?php
defined('YII_ENV') or exit('Access Denied');
$urlManager = Yii::$app->urlManager;
$this->title = '清除缓存';
$this->params['active_nav_group'] = 1;
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
                    <label class="col-form-label">清除项目</label>
                </div>
                <div class="col-sm-6 col-form-label">
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input id="one" name="data" type="checkbox" class="custom-control-input">
                        <label class="custom-control-label" for="one">数据缓存</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input id="two" name="pic" type="checkbox" class="custom-control-input">
                        <label class="custom-control-label" for="two">临时图片</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input id="three" name="update" type="checkbox" class="custom-control-input">
                        <label class="custom-control-label" for="three">更新缓存</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary auto-form-btn" href="javascript:">提交</a>
                </div>
            </div>
        </form>
    </div>
</div>
