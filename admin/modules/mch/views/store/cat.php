<?php
defined('YII_ENV') or exit('Access Denied');
use yii\widgets\LinkPager;

$urlManager = Yii::$app->urlManager;
$this->title = '商品分类';
$this->params['active_nav_group'] = 2;
?>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">商品管理</a></li>
    <span>/</span>
    <li>分类列表</li>
</ul>
<?php $this->endBlock(); ?>

<div class="pd-white-box">

    <div class="search-box">
        <form class="form-inline custom-inline">
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">分类名称</span>
                    </div>
                    <input type="text" class="form-control" placeholder="输入分类名称">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group mb-3">
                    <button type="button" class="btn btn-primary btn-sm" id="searchButton">搜索</button>
                </div>
            </div>
        </form>
    </div>
    <div class="table-act-row">
        <a class="btn btn-primary btn-sm blue_new" href="<?= $urlManager->createAbsoluteUrl(['mch/store/cat-edit']) ?>">添加分类</a>
    </div>

    <div class="data-content">
        <table class="table" id="treeTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>分类名称</th>
                <th>图标</th>
                <th>排序</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cat_list as $index => $cat): ?>
                <tr id="<?= $cat['id'] ?>" pId="<?= $cat['parent_id'] ?>">
                    <td><?= $cat['id'] ?></td>
                    <td><?= $cat['name'] ?></td>
                    <td><?php if (!empty($cat['pic_url'])): ?>
                            <img src="<?= $cat['pic_url'] ?>"style="width: 20px;height: 20px;">
                        <?php endif; ?>
                    </td>
                    <td><?= $cat['sort']; ?></td>
                    <td>
                        <a class="btn btn-sm btn-primary"
                           href="<?= $urlManager->createUrl(['mch/store/cat-edit', 'id' => $cat['id']]) ?>">修改</a>
                        <a class="btn btn-sm btn-primary copy" data-clipboard-text="/pages/cat/cat"
                           href="javascript:" hidden>复制链接</a>
                        <a class="btn btn-sm btn-danger del" href="javascript:void(0);" url="<?= $urlManager->createUrl(['mch/store/cat-del', 'id' => $cat['id']]) ?>">删除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<script src="<?= Yii::$app->request->baseUrl ?>/new/plugins/treeTable/js/jquery.treeTable.js"></script>

<script>
    jQuery(document).ready(function($) {
        let option = {
            theme:'vsStyle',
            url:"<?= Yii::$app->request->baseUrl ?>/new/plugins/treeTable/css/jquery.treeTable.css",
            expandLevel : 2,
            beforeExpand : function($treeTable, id) {
                //判断id是否已经有了孩子节点，如果有了就不再加载，这样就可以起到缓存的作用
                if ($('.' + id, $treeTable).length) { return; }
            },
            onSelect : function($treeTable, id) {
                window.console && console.log('onSelect:' + id);
            }
        };
        option.theme = 'default';
        $('#treeTable').treeTable(option);
    });

    $(document).on('click', '.nav-item1', function () {
        if($(this).find(".trans")[0].style.display=='inline-block'){
            $(this).find(".trans")[0].style.display='inline';
        }else{
            $(this).find(".trans")[0].style.display='inline-block';
        }
        $('.bg-'+$(this).index(".nav-item1")).toggle();
    });
    $(document).on('click', '.bg-faded', function () {
        if($(this).find(".trans")[0].style.display=='inline-block'){
            $(this).find(".trans")[0].style.display='inline';
        }else{
            $(this).find(".trans")[0].style.display='inline-block';
        }
        $('.bg-n-'+$(this).attr("data-id")).toggle();
    });

    $(document).on('click', '.del', function () {
        let _that = $(this);
        $.confirm({
            content: "确定删除?",
            confirmText: "确定",
            cancelText: "取消",
            confirm: function () {
                $.ajax({
                    url: _that.attr('url'),
                    type: 'get',
                    dataType: 'json',
                    success: function (res) {
                        console.log(res);
                        if (res.code == 0) {
                           window.location.reload();
                        }
                    }
                });
            },
            cancel: function(){return false;}
        });
        return true;
    });
</script>
<script>
    $(document).ready(function () {
        var clipboard = new Clipboard('.copy');
        clipboard.on('success', function (e) {
            $.myAlert({
                title: '提示',
                content: '复制成功'
            });
        });
        clipboard.on('error', function (e) {
            $.myAlert({
                title: '提示',
                content: '复制失败，请手动复制。链接为：' + e.text
            });
        });
    })
</script>
