<?php
defined('YII_ENV') or exit('Access Denied');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/27
 * Time: 11:36
 */

$urlManager = Yii::$app->urlManager;
$this->title = '拼团机器人编辑';
$this->params['active_nav_group'] = 10;
$this->params['is_group'] = 1;
?>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">拼团管理</a></li>
    <span>/</span>
    <li><?= $this->title ?></li>
</ul>
<?php $this->endBlock(); ?>

<div class="pd-white-box">
    <div class="panel-body">
        <form class="form auto-form" method="post" autocomplete="off"
              return="<?= $urlManager->createUrl(['mch/group/robot/index']) ?>">
            <div class="form-body">
                <div class="form-group row">
                    <div class="form-group-label col-sm-2 text-right">
                        <label class=" col-form-label required">机器人名</label>
                    </div>
                    <div class="col-sm-6">
                        <input class="form-control" type="text" name="model[name]" value="<?= $list['name'] ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="form-group-label col-sm-2 text-right">
                        <label class="col-form-label">机器人头像</label>
                    </div>
                    <div class="col-sm-6">
                        <div class="upload-group">
                            <div class="input-group">
                                <input class="form-control file-input" name="model[pic]"
                                       value="<?= $list['pic'] ?>">
                                <div class="input-group-append">
                                    <a class="btn btn-outline-secondary upload-file" href="javascript:void(0);" title="上传文件"><span class="iconfont icon-shangchuan"></span></a>
                                    <a class="btn btn-outline-secondary select-file" href="javascript:void(0);" title="从文件库选择"><span class="iconfont icon-lishituku"></span></a>
                                    <a class="btn btn-outline-secondary delete-file" href="javascript:void(0);" title="删除文件"><span class="iconfont icon-shanchu"></span></a>
                                </div>
                            </div>
                            <div class="upload-preview text-center upload-preview">
                                <span class="upload-preview-tip">200&times;200</span>
                                <img class="upload-preview-img" src="<?= $list['pic'] ?>">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group-label col--sm-2 text-right">
                    </div>
                    <div class="col-sm-6">
                        <a class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
