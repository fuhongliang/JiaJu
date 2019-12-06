<?php
defined('YII_ENV') or exit('Access Denied');

$urlManager = Yii::$app->urlManager;
$this->title = '师傅';
$this->params['active_nav_group'] = 8;
?>
<style>
    .cover-pic {
        display: block;
        width: 8rem; 
        height: 5rem;
        background-size: cover;
        background-position: center;
    }
</style> 
<div class="panel mb-3">
    <div class="panel-header">
        <span><?= $this->title ?></span>
        <ul class="nav nav-right">
            <li class="nav-item">
                <a class="nav-link" href="<?= $urlManager->createUrl(['mch/master/edit']) ?>">添加师傅</a>
            </li>
        </ul>
    </div>

    <div class="panel-body">
        <table class="table table-bordered bg-white">
            <thead>
            <tr>
                <th>ID</th>
                <th style="min-width:60px">姓名</th>
                <th>图片</th>
                <th>工种</th>
                <th>工龄</th>
                <th>预约电话</th>
                <th>特点</th>
                <th class="text-center">排序</th>
                <th class="text-center">添加时间</th>
                <th class="text-center">操作</th>
            </tr>
            </thead>
            <?php foreach ($list as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?php if($item['name']){echo $item['name'];}else{echo '';} ?> </td>
                    <td>
                        <div></div>
                        <div class="cover-pic" style="background-image: url('<?= $item['cover_pic'] ?>')"></div>
                    </td>
                    <td><?php if($item['job']){echo $item['job'];}else{echo '';} ?> </td>
                    <td><?php if($item['year']){echo $item['year'];}else{echo '';} ?> </td>
                    <td>
                        <div style="max-width: 30rem">
                            <div class="mb-2 text-overflow-ellipsis"><?= $item['mobile'] ?></div>
                        </div>
                    </td>
                    <td>
                        <?= $item['advantage'] ?>
                    </td>
                    <td class="text-center"><?= $item['sort'] ?></td>
                    <td class="text-center"><?= date('Y-m-d H:i:s', $item['addtime']) ?></td>
                    <td class="text-center">
                        <div class="mb-2">
                            <a class="btn btn-sm btn-primary"
                               href="<?= $urlManager->createUrl(['mch/master/edit', 'id' => $item['id']]) ?>">编辑</a>
                        </div>
                        <div>
                            <a class="btn btn-sm btn-danger delete-btn"
                               href="<?= $urlManager->createUrl(['mch/master/delete', 'id' => $item['id']]) ?>">删除</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
        <div class="text-center">
            <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination,]) ?>
            <div class="text-muted"><?= $pagination->totalCount ?>条数据</div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".delete-btn", function () {
        var url = $(this).attr("href");
        $.confirm({
            content: "确认删除？",
            confirm: function () {
                $.loading();
                $.ajax({
                    url: url,
                    dataType: "json",
                    success: function (res) {
                        location.reload();
                    }
                });
            }
        });
        return false;
    });
</script>