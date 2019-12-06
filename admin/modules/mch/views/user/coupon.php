<?php
defined('YII_ENV') or exit('Access Denied');

use yii\widgets\LinkPager;

$urlManager = Yii::$app->urlManager;
$this->title = '领取记录';
$this->params['active_nav_group'] = 4;
$status = Yii::$app->request->get('status');
$user_id = Yii::$app->request->get('user_id');
$condition = ['user_id' => $user_id];
if ($status === '' || $status === null || $status == -1)
    $status = -1;
?>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="<?= $status == -1 ? 'active' : null ?>"><a href="<?= $urlManager->createUrl(array_merge(['mch/user/coupon'], $condition)) ?>">全部</a></li>
    <li class="<?= $status == 0 ? 'active' : null ?>"><a href="<?= $urlManager->createUrl(array_merge(['mch/user/coupon'], $condition, ['status' => 0])) ?>">未使用<?= $data['status_0'] ? '(' . $data['status_0'] . ')' : null ?></a></li>
    <li class="<?= $status == 1 ? 'active' : null ?>"><a href="<?= $urlManager->createUrl(array_merge(['mch/user/coupon'], $condition, ['status' => 1])) ?>">已使用<?= $data['status_1'] ? '(' . $data['status_1'] . ')' : null ?></a></li>
    <li class="<?= $status == 2 ? 'active' : null ?>"><a href="<?= $urlManager->createUrl(array_merge(['mch/user/coupon'], $condition, ['status' => 2])) ?>">已过期<?= $data['status_2'] ? '(' . $data['status_2'] . ')' : null ?></a></li>
</ul>
<?php $this->endBlock(); ?>

<div class="pd-white-box" id="app">

    <div class="search-box">

        <form method="get">
            <?php $_s = ['keyword', 'date_start', 'date_end'] ?>
            <?php foreach ($_GET as $_gi => $_gv):if (in_array($_gi, $_s)) continue; ?>
                <input type="hidden" name="<?= $_gi ?>" value="<?= $_gv ?>">
            <?php endforeach; ?>
            <div flex="dir:left">
                <div class="mr-4">
                    <div class="form-group row w-20">
                        <div class="col-sm-10" style="padding-left: 15px">
                            <input class="form-control"
                                   name="keyword"
                                   placeholder="微信昵称"
                                   autocomplete="off"
                                   value="<?= isset($_GET['keyword']) ? trim($_GET['keyword']) : null ?>">
                        </div>
                    </div>
                </div>
                <div class="mr-4">
                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label required">领取时间：</label>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input class="form-control" id="date_start" name="date_start"
                                       autocomplete="off"
                                       value="<?= isset($_GET['date_start']) ? trim($_GET['date_start']) : '' ?>">
                                <div class="input-group-append">
                                    <a class="btn btn-outline-secondary" id="show_date_start" href="javascript:"><span class="iconfont icon-date_range"></span></a>
                                </div>
                                <span class="middle-center" style="padding:0 4px">至</span>
                                <input class="form-control" id="date_end" name="date_end"
                                       autocomplete="off"
                                       value="<?= isset($_GET['date_end']) ? trim($_GET['date_end']) : '' ?>">
                                <div class="input-group-append">
                                    <a class="btn btn-outline-secondary" id="show_date_end" href="javascript:"><span class="iconfont icon-date_range"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="middle-center">
                            <a href="javascript:" class="new-day btn btn-primary" data-index="7">近7天</a>
                            <a href="javascript:" class="new-day btn btn-primary" data-index="30">近30天</a>
                        </div>
                    </div>
                </div>
            </div>
            <div flex="dir:left">
                <div class="mr-4">
                    <div class="form-group">
                        <button class="btn btn-primary mr-4">筛选</button>
                    </div>
                </div>
            </div>
            <div flex="dir:left">
                <div class="mr-4">
                    <?php if ($user): ?>
                        <span class="status-item mr-3">会员：<?= $user->nickname ?>的优惠券</span>
                    <?php endif; ?>
                </div>
            </div>
        </form>

    </div>

    <div class="data-content">
    <table class="table table-bordered bg-white">
        <thead>
        <tr>
            <th>昵称</th>
            <th>优惠券名称</th>
            <th>最低消费金额（元）</th>
            <th>优惠方式</th>
            <th>有效时间</th>
            <th>领取时间</th>
            <th>获取方式</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <?php foreach ($list as $item): ?>
            <tr>
                <td><?= $item['nickname'] ?></td>
                <td><?= $item['name'] ?></td>
                <td><?= $item['min_price'] ?></td>
                <td>
                    <div>优惠：<?= $item['discount_type'] == 2 ? $item['sub_price'] . '元' : "--" ?></div>
                    <!--<div>折扣：<?= $item['discount_type'] == 1 ? $item['discount'] : "--" ?></div>-->
                </td>
                <td>
                    <?php if ($item['expire_type'] == 1): ?>
                        <span>领取<?= $item['expire_day'] ?>天过期</span>
                    <?php else: ?>
                        <span><?= date('Y-m-d', $item['begin_time']) ?>
                            -<?= date('Y-m-d', $item['end_time']) ?></span>
                    <?php endif; ?>
                </td>
                <td><?= date('Y-m-d H:i', $item['uc_time']) ?></td>
                <td><?= $item['event_desc'] ?></td>
                <td><?= $item['is_expire'] == 0 ? ($item['is_use'] == 0 ? "未使用" : "已使用") : "已过期" ?></td>
                <td><a class="btn btn-sm btn-danger del" href="javascript:"
                       data-url="<?= $urlManager->createUrl(['mch/user/coupon-del', 'id' => $item['uc_id']]) ?>"
                       data-content="是否删除？">删除</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
        <div class="text-center">
            <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination,]) ?>
            <div class="text-muted"><?= $row_count ?>条数据</div>
        </div>
    </div>



</div>


<?= $this->render('/layouts/ss') ?>
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
                                title: '提示',
                                content: res.msg
                            });
                        }
                    }
                });
            }
        });
        return false;
    });
</script>
