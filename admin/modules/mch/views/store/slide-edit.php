<?php
defined('YII_ENV') or exit('Access Denied');
$urlManager = Yii::$app->urlManager;
$this->title = '轮播图编辑';
$this->params['active_nav_group'] = 1;
?>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">小程序</a></li>
    <span>/</span>
    <li><?= $this->title;?></li>
</ul>
<?php $this->endBlock(); ?>


<div class="pd-white-box" id="app">
    <div class="wrap">

        <form class="auto-form" method="post" return="<?= $urlManager->createUrl(['mch/store/slide']) ?>">
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">标题</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="model[title]" value="<?= $list['title'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">小程序页面链接</label>
                </div>
                <div class="col-sm-6">
                    <div class="input-group page-link-input">
                        <input class="form-control link-input"
                               name="model[page_url]"
                               readonly
                               value="<?= $list['page_url'] ?>">
                        <input class="link-open-type" name="model[open_type]" value="<?= $list['open_type'] ?>" type="hidden">
                        <div class="input-group-append">
                            <a class="btn btn-secondary pick-link-btn" href="javascript:">选择链接</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">排序</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" type="number" step="1" name="model[sort]"
                           value="<?= $list['sort'] ? $list['sort'] : 100 ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">图片</label>
                </div>
                <div class="col-sm-6">
                    <div class="upload-group">
                        <div class="input-group">
                            <input class="form-control file-input" name="model[pic_url]" value="<?= $list['pic_url'] ?>">
                            <div class="input-group-append">
                                <a class="btn btn-outline-secondary upload-file" href="javascript:void(0);" title="上传文件"><span class="iconfont icon-shangchuan"></span></a>
                                <a class="btn btn-outline-secondary select-file" href="javascript:void(0);" title="从文件库选择"><span class="iconfont icon-lishituku"></span></a>
                                <a class="btn btn-outline-secondary delete-file" href="javascript:void(0);" title="删除文件"><span class="iconfont icon-shanchu"></span></a>
                            </div>
                        </div>
                        <div class="upload-preview text-center upload-preview">
                            <span class="upload-preview-tip">750&times;360</span>
                            <img class="upload-preview-img" src="<?= $list['pic_url'] ?>">
                        </div>
                    </div>
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
</div>






