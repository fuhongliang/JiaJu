<?php
defined('YII_ENV') or exit('Access Denied');

$urlManager = Yii::$app->urlManager;
$this->title = '师傅编辑';
$this->params['active_nav_group'] = 8;
?>
<style>
    .goods-item,
    .video-item {
        margin: 1rem 0;
    }

    .goods-item .goods-name,
    .video-item .video-name {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<div class="panel mb-3" id="app">
    <div class="panel-header"><?= $this->title ?></div>
    <div class="panel-body">
        <form class="auto-form" method="post" return="<?= $urlManager->createUrl(['mch/master/index']) ?>">
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label required">姓名</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" name="name" value="<?= str_replace("\"","&quot",$model->name) ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label required">工种</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" name="job" value="<?= str_replace("\"","&quot",$model->job) ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label required">工龄</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" name="year" value="<?= str_replace("\"","&quot",$model->year) ?>">
                </div>
            </div>

            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label required">手机</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" name="mobile" value="<?= str_replace("\"","&quot",$model->mobile) ?>">
                </div>
            </div>

            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label required">特点</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" name="advantage" value="<?= str_replace("\"","&quot",$model->advantage) ?>">
                </div>
            </div>

            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label required">图片</label>
                </div>
                <div class="col-sm-6">
                    <div class="upload-group">
                        <div class="input-group">
                            <input class="form-control file-input" name="cover_pic" value="<?= $model->cover_pic ?>">
                            <span class="input-group-btn">
                                <a class="btn btn-secondary upload-file" href="javascript:" data-toggle="tooltip"
                                   data-placement="bottom" title="上传文件">
                                    <span class="iconfont icon-cloudupload"></span>
                                </a>
                            </span>
                            <span class="input-group-btn">
                                <a class="btn btn-secondary select-file" href="javascript:" data-toggle="tooltip"
                                   data-placement="bottom" title="从文件库选择">
                                    <span class="iconfont icon-viewmodule"></span>
                                </a>
                            </span>
                            <span class="input-group-btn">
                                <a class="btn btn-secondary delete-file" href="javascript:" data-toggle="tooltip"
                                   data-placement="bottom" title="删除文件">
                                    <span class="iconfont icon-close"></span>
                                </a>
                            </span>
                        </div>
                        <div class="upload-preview text-center upload-preview">
                            <span class="upload-preview-tip">268&times;202</span>
                            <img class="upload-preview-img" src="<?= $model->cover_pic ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">排序</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" name="sort" value="<?= $model->sort ?>">
                    <div class="text-muted fs-sm">升序，数字越小排序越靠前，默认1000</div>
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">个人简介</label>
                </div>
                <div class="col-sm-6">
                    <div flex="dir:left box:first">
                        <div>
                                <textarea class="short-row" id="editor"
                                          style="width: 30rem"
                                          name="info"><?= $model->info ?></textarea>
                        </div>

                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <input name="addtime" type="hidden" value="<?= $model->addtime ?>">
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
                </div>
            </div>
        </form>

    </div>
</div>

<script src="<?= Yii::$app->request->baseUrl ?>/statics/ueditor/ueditor.config.js?v=1.6.2"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/statics/ueditor/ueditor.all.min.js"></script>
<script>
    var app = new Vue({
        el: "#app",
        data: {
            goods_list: null,
            video_list: null,
        },
    });
    var ue = UE.getEditor('editor', {
        serverUrl: "<?=$urlManager->createUrl(['upload/ue'])?>",
        enableAutoSave: false,
        saveInterval: 1000 * 3600,
        enableContextMenu: false,
        autoHeightEnabled: false,
    });

</script>