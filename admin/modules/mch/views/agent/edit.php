<?php
defined('YII_ENV') or exit('Access Denied');
$this->title = '编辑代理';
$urlManager = Yii::$app->urlManager;
?>
<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">代理管理</a></li>
    <span>/</span>
    <li><?= $this->title ?></li>
</ul>
<?php $this->endBlock(); ?>
<link href="<?= Yii::$app->request->baseUrl ?>/new/plugins/chosen/chosen.min.css" rel="stylesheet">

<div class="pd-white-box">
    <form class="auto-form" method="post"
          action="<?= $urlManager->createUrl(['mch/agent/update', 'id' => $edit->id]) ?>">
        <div class="form-group row">
            <div class="form-group-label col-sm-2 text-right">
                <label class="col-form-label required">昵称</label>
            </div>
            <div class="col-sm-6">
                <input class="form-control cat-name" value="<?= $edit->nickname ?>" name="nickname">
            </div>
        </div>
        <div class="form-group row">
            <div class="form-group-label col-sm-2 text-right">
                <label class="col-form-label required">用户名</label>
            </div>
            <div class="col-sm-6">
                <input class="form-control cat-name" value="<?= $edit->username ?>" name="username">
            </div>
        </div>

        <div class="form-group row">
            <div class="form-group-label col-sm-2 text-right">
                <label class=" col-form-label required">省份</label>
            </div>
            <div class="col-sm-6"><span class="form-control" readonly><?= $province->name ?></span></div>
        </div>

        <div class="form-group row">
            <div class="form-group-label col-sm-2 text-right">
                <label class="col-form-label required">城市</label>
            </div>
            <div class="col-sm-6"><span class="form-control" readonly><?= $city->name ?></span></div>
        </div>

        <div class="form-group row">
            <div class="form-group-label col-sm-2 text-right">
                <label class=" col-form-label required">选择地区</label>
            </div>
            <div class="col-sm-6">
                <select data-placeholder="请选择地区" class="form-control chosen-select" id="district" name="district[]" multiple>
                    <?php foreach($district_list as $k=>$v) : ?>
                    <option value="<?= $v['id'] ?>" <?php if(in_array($v['id'],$district_id)): ?>
                    selected <?php endif; ?>
                    ><?= $v['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="form-group-label col-sm-2 text-right">
            </div>
            <div class="col-sm-6">
                <a class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
            </div>
        </div>
    </form>
</div>

<script src="<?= Yii::$app->request->baseUrl ?>/new/plugins/chosen/chosen.jquery.min.js"></script>
<script>
    $(document).ready(function(evt) {
        var config = {
            '.chosen-select'           : {},
            '.chosen-select-deselect'  : { allow_single_deselect: true },
            '.chosen-select-no-single' : { disable_search_threshold: 10 },
            '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
            '.chosen-select-rtl'       : { rtl: true },
            '.chosen-select-width'     : { width: '95%' }
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    });
</script>
