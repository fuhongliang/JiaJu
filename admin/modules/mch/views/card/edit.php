<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/25
 * Time: 15:42
 */
defined('YII_ENV') or exit('Access Denied');

$urlManager = Yii::$app->urlManager;
$this->title = '卡券编辑';
$this->params['active_nav_group'] = 12;
$returnUrl = Yii::$app->request->referrer;
if (!$returnUrl)
    $returnUrl = $urlManager->createUrl(['mch/card/index']);
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
                        <label class="col-form-label required">卡券名称</label>
                    </div>
                    <div class="col-6">
                        <input class="form-control" name="name" value="<?= $model->name ?>">
                        <div class="fs-sm text-danger">在商品编辑--选择卡券时显示</div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="form-group-label col-2 text-right">
                        <label class="col-form-label required">卡券图片</label>
                    </div>
                    <div class="col-6">

                        <div class="upload-group">
                            <div class="input-group">
                                <input class="form-control file-input" name="pic_url" value="<?=$model->pic_url?>">
                                <div class="input-group-append">
                                    <a class="btn btn-outline-secondary upload-file" href="javascript:void(0);" title="上传文件"><span class="iconfont icon-shangchuan"></span></a>
                                    <a class="btn btn-outline-secondary select-file" href="javascript:void(0);" title="从文件库选择"><span class="iconfont icon-lishituku"></span></a>
                                    <a class="btn btn-outline-secondary delete-file" href="javascript:void(0);" title="删除文件"><span class="iconfont icon-shanchu"></span></a>
                                </div>
                            </div>
                            <div class="upload-preview text-center upload-preview">
                                <span class="upload-preview-tip">88&times;88</span>
                                <img class="upload-preview-img" src="<?=$model->pic_url?>">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group-label col-2 text-right">
                        <label class="col-form-label required">卡券描述</label>
                    </div>
                    <div class="col-6">
                        <input class="form-control" name="content" value="<?= $model->content ?>">
                        <div>用于线下营销</div>
                        <div class="text-danger fs-sm">卡券会在用户付款后，自动发放给用户</div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group-label col-3 text-right">
                    </div>
                    <div class="col-9">
                        <a class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).on('click', '.del', function () {
        var a = $(this);
        $.myConfirm({
            content: a.data('content'),
            confirm: function () {
                $.ajax({
                    url: a.data('url'),
                    type: 'get',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 0) {
                            window.location.reload();
                        } else {
                            $.myAlert({
                                title: res.msg
                            });
                        }
                    }
                });
            }
        });
        return false;
    });
</script>

