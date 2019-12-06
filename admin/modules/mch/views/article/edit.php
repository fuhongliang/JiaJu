<?php
defined('YII_ENV') or exit('Access Denied');
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/6/19
 * Time: 16:52
 */
$cat = [
    1 => '关于我们',
    2 => '服务中心',
    13 => '保证金协议',
];
$cat_id = Yii::$app->request->get('cat_id', 2);
$urlManager = Yii::$app->urlManager;
$this->title = $cat[$cat_id];
$returnUrl = Yii::$app->request->referrer;
if (!$returnUrl)
    $returnUrl = $urlManager->createUrl(['mch/article/index', 'cat_id' => $cat_id]);
$this->params['page_navs'] = [
    [
        'name' => '关于我们',
        'active' => $cat_id == 1,
        'url' => $urlManager->createUrl(['mch/article/index', 'cat_id' => 1,]),
    ],
    [
        'name' => '服务中心',
        'active' => $cat_id == 2,
        'url' => $urlManager->createUrl(['mch/article/index', 'cat_id' => 2,]),
    ],
    [
        'name' => '保证金协议',
        'active' => $cat_id == 13,
        'url' => $urlManager->createUrl(['mch/article/index', 'cat_id' => 13,]),
    ],
];
?>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <?php if (is_array($this->params['page_navs'])): ?>
        <?php foreach ($this->params['page_navs'] as $page_nav): ?>
            <li class="<?= $page_nav['active'] ? 'active' : '' ?>"><a href="<?= $page_nav['url'] ?>"><?= $page_nav['name'] ?></a></li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>
<?php $this->endBlock(); ?>

<div class="pd-white-box" id="page">
    <div class="wrap">
        <form class="auto-form" method="post" return="<?= $returnUrl ?>">
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label required">标题</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control cat-name" name="title" value="<?= $model->title ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label required">排序</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control cat-name" name="sort"
                           value="<?= $model->sort ? $model->sort : 100 ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">内容</label>
                </div>
                <div class="col-sm-6">
                        <textarea id="editor" style="width: 100%"
                                  name="content"><?= $model->content ?></textarea>
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

<script src="<?= Yii::$app->request->baseUrl ?>/statics/ueditor/ueditor.config.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/statics/ueditor/ueditor.all.min.js"></script>
<script>
    var ue = UE.getEditor('editor', {
        serverUrl: "<?=$urlManager->createUrl(['upload/ue'])?>",
    });
</script>
