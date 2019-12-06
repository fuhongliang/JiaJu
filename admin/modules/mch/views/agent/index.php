<?php
defined('YII_ENV') or exit('Access Denied');
$this->title = '代理列表';
$urlManager = Yii::$app->urlManager;
?>
<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">代理管理</a></li>
    <span>/</span>
    <li><?= $this->title ?></li>
</ul>
<?php $this->endBlock(); ?>


<div class="pd-white-box">
    <div class="search-box">
        <form class="form-inline custom-inline">
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">代理名称</span>
                    </div>
                    <input type="text" class="form-control" placeholder="输入名称">
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
        <a class="btn btn-primary btn-sm blue_new" href="<?= $urlManager->createUrl(['mch/agent/create']) ?>">添加代理</a>
    </div>

    <table class="table table-bordered bg-white">
        <thead>
        <tr>
            <th>账号</th>
            <th>昵称</th>
            <th>省份</th>
            <th>城市</th>
            <th>代理地区</th>
            <th>操作</th>
        </tr>
        </thead>
        <?php foreach ($list as $item): ?>
            <tr>
                <td><?= $item['username'] ?></td>
                <td><?= $item['nickname'] ?></td>
                <td><?= $item['province'] ?></td>
                <td><?= $item['city'] ?></td>
                <td><?= $item['district_name'] ?></td>
                <td>
                    <a class="btn btn-sm btn-primary"
                       href="<?= $urlManager->createUrl(['mch/agent/update', 'id' => $item['id']]) ?>">编辑</a>
                    <a class="btn btn-sm btn-danger agent-delete"
                       href="<?= $urlManager->createUrl(['mch/agent/destroy', 'id' => $item['id']]) ?>">删除</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<script>
    $(document).on("click", ".agent-delete", function () {
        var href = $(this).attr("href");
        $.confirm({
            content: "确认删除？",
            confirm: function () {
                $.loading();
                $.ajax({
                    url: href,
                    dataType: "json",
                    success: function (res) {
                        $.myAlert({
                            content: res.msg,
                            confirm: function () {
                                if (res.code == 0) {
                                    location.reload();
                                }
                            }
                        })

                    }
                });
            }
        });
        return false;
    });
</script>