<?php
defined('YII_ENV') or exit('Access Denied');

$urlManager = Yii::$app->urlManager;
$this->title = '版权设置';
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
    <div class="wrap">

        <form class="auto-form" method="post" return="<?=$url?>">

            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">底部版权文字</label>
                </div>
                <div class="col-sm-6" style="max-width: 360px">
                    <textarea class="form-control" name="text" style="resize: none;min-height: 100px;"><?=$data['copyright']['text']?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">底部版权图标</label>
                </div>

                <div class="col-sm-6">
                    <div class="upload-group">
                        <div class="input-group">
                            <input class="form-control file-input" name="icon" value="<?=$data['copyright']['icon']?>">
                            <div class="input-group-append">
                                <a class="btn btn-outline-secondary upload-file" href="javascript:void(0);" title="上传文件"><span class="iconfont icon-shangchuan"></span></a>
                                <a class="btn btn-outline-secondary select-file" href="javascript:void(0);" title="从文件库选择"><span class="iconfont icon-lishituku"></span></a>
                                <a class="btn btn-outline-secondary delete-file" href="javascript:void(0);" title="删除文件"><span class="iconfont icon-shanchu"></span></a>
                            </div>
                        </div>
                        <div class="upload-preview text-center upload-preview">
                            <span class="upload-preview-tip">240&times;60</span>
                            <img class="upload-preview-img" src="<?=$data['copyright']['icon']?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">底部版权链接</label>
                </div>
                <div class="col-sm-6" style="max-width: 360px">
                    <div class="input-group page-link-input">
                        <input class="form-control link-input" readonly name="url" value="<?=$data['copyright']['url']?>">
                        <input class="link-open-type" name="open_type" type="hidden" value="<?=$data['copyright']['open_type']?>">
                        <div class="input-group-append">
                            <a class="btn btn-outline-secondary pick-link-btn" href="javascript:void(0);">选择链接</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">是否开启一键拨号</label>
                </div>
                <div class="col-sm-6 col-form-label">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input id="radioDialYes" <?= $data['copyright']['is_phone'] == 1 ? 'checked' : null ?>
                               value="1"
                               name="is_phone" type="radio" class="custom-control-input">
                        <label class="custom-control-label" for="radioDialYes">开启</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input id="radioDialNo" <?= $data['copyright']['is_phone'] == 0 ? 'checked' : null ?>
                               value="0"
                               name="is_phone" type="radio" class="custom-control-input">
                        <label class="custom-control-label" for="radioDialNo">关闭</label>
                    </div>
                    <div class="fs-sm">若开启一键拨号，则链接失效</div>
                </div>
            </div>

            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">联系电话</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="phone"
                           value="<?= $data['copyright']['phone'] ?>">
                    <div class="fs-sm">若为空，则会拨打“商城设置”中的“联系电话”</div>
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                </div>
                <div class="col-sm-6" style="max-width: 360px">
                    <a class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
                </div>
            </div>
        </form>
    </div>
</div>