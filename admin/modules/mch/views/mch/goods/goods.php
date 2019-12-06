<?php
defined('YII_ENV') or exit('Access Denied');
use yii\widgets\LinkPager;

$urlManager = Yii::$app->urlManager;
$imgurl = Yii::$app->request->baseUrl;
$this->title = '商品列表';
$this->params['active_nav_group'] = 2;

?>
<style>
    .modal-dialog{
        position:fixed;
        top:20%;
        left:45%;
        width:240px;
    }
    .modal-content{
        width:240px;
    }
    .modal-body{
        /*height:200px;*/
    }
    table {
        table-layout: fixed;
    }

    th {
        text-align: center;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    td {
        text-align: center;
    }

    .ellipsis {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    td.nowrap {
        white-space: nowrap;
        overflow: hidden;
    }

    .goods-pic {
        width: 3rem;
        height: 3rem;
        display: inline-block;
        background-color: #ddd;
        background-size: cover;
        background-position: center;
    }
</style>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">商品管理</a></li>
    <span>/</span>
    <li>商品列表</li>
</ul>
<?php $this->endBlock(); ?>


<?php
$status = ['已下架', '已上架'];
?>
<div class="pd-white-box">

    <div class="search-box">
        <form class="form-inline custom-inline">
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">商品名称</span>
                    </div>
                    <input type="text" class="form-control" placeholder="输入商品名称">
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
        <a class="btn btn-primary btn-sm blue_new" href="javascript:void(0);">批量导出</a>
    </div>

    <div class="data-content">
        <table class="table">
            <thead>
            <tr>
                <th style="text-align: left;">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input  goods-all" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">ID</label>
                    </div>
                </th>
                <th>商品类型</th>
                <th>商户名称</th>
                <th class="text-left">商品名称</th>
                <th>商品图片</th>
                <th>售价</th>
                <th>库存</th>
                <th>状态</th>
                <th>加入快速购买</th>
                <th>虚拟销量</th>
                <th>排序</th>
                <th>操作</th>
            </tr>
            </thead>
            <col style="width: 5%">
            <tbody>
            <?php foreach ($list as $index => $goods): ?>
                <tr>
                    <td class="nowrap" style="text-align: left;" data-toggle="tooltip"
                        data-placement="top" title="<?=$goods->id?>">
                        <div class="custom-control custom-checkbox">
                            <input data-num="<?= $goods->num ?>" value="<?= $goods->id ?>" type="checkbox" class="custom-control-input  goods-one" id="goods_<?= $goods->id ?>">
                            <label class="custom-control-label" for="goods_<?= $goods->id ?>"><?= $goods->id ?></label>
                        </div>
                    </td>
                    <?php $mch_info = $goods->getMchInfo($goods->mch_id) ?>
                    <td class="ellipsis" data-toggle="tooltip"
                        data-placement="top" title="<?=$goods->getCatListAsString() ?>"><?= $goods->getCatListAsString() ?></td>

                    <td><?= $mch_info['name']?></td>
                    <td class="text-left ellipsis" data-toggle="tooltip"
                        data-placement="top" title="<?=$goods->name?>"><?= $goods->name ?></td>
                    <td class="p-0" style="vertical-align: middle" hidden>
                        <div class="goods-pic" style="background-image: url(<?= $goods->getGoodsPic(0)->pic_url ?>)"></div>
                    </td>
                    <td class="p-0" style="vertical-align: middle">
                        <div class="goods-pic" style="background-image: url(<?= $goods->getGoodsCover() ?>)"></div>
                    </td>
                    <td class="nowrap text-danger"><?= $goods->price ?></td>
                    <td class="nowrap">
                        <?php if ($goods->use_attr): ?>
                            <a href="<?= $urlManager->createUrl(['mch/goods/goods-attr', 'id' => $goods->id]) ?>"><?= $goods->num ?></a>
                        <?php else: ?>
                            <a href="<?= $urlManager->createUrl(['mch/goods/goods-edit', 'id' => $goods->id]) ?>#step3"><?= $goods->num ?></a>
                        <?php endif; ?>
                    </td>
                    <td class="nowrap">
                        <?php if ($goods->status == 1): ?>
                            <span class="badge badge-success"><?= $status[$goods->status] ?></span>
                            |
                            <a href="javascript:" onclick="upDown(<?= $goods->id ?>,'down');">下架</a>
                        <?php else: ?>
                            <span class="badge badge-default"><?= $status[$goods->status] ?></span>
                            |
                            <a href="javascript:" onclick="upDown(<?= $goods->id ?>,'up');">上架</a>
                        <?php endif ?>
                    </td>
                    <td class="nowrap">
                        <?php if ($goods->quick_purchase == 1): ?>
                            <span class="badge badge-success">已加入</span>
                            |
                            <a href="javascript:" onclick="upDown(<?= $goods->id ?>,'close');">关闭</a>
                        <?php else: ?>
                            <span class="badge badge-default">已关闭</span>
                            |
                            <a href="javascript:" onclick="upDown(<?= $goods->id ?>,'start');">加入</a>
                        <?php endif ?>
                    </td>
                    <td class="nowrap">
                        <?= $goods->virtual_sales ?>
                    </td>
                    <td class="nowrap">
                        <?= $goods->sort ?>
                    </td>
                    <td class="nowrap">
                        <?php if ($goods->index_recommend): ?>
                            <a class="btn btn-sm btn-danger recommend" href="<?= $urlManager->createUrl(['mch/mch/goods/cancel-index-recommend', 'id' => $goods->id]) ?>">取消推荐</a>
                        <?php else: ?>
                            <a class="btn btn-sm btn-primary recommend" href="<?= $urlManager->createUrl(['mch/mch/goods/goods-index-recommend', 'id' => $goods->id]) ?>">首页推荐</a>
                        <?php endif;?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>

        </table>
        <nav aria-label="Page navigation example">
            <?php echo LinkPager::widget([
                'pagination' => $pagination,
                'prevPageLabel' => '上一页',
                'nextPageLabel' => '下一页',
                'firstPageLabel' => '首页',
                'lastPageLabel' => '尾页',
                'maxButtonCount' => 5,
                'options' => [
                    'class' => 'pagination',
                ],
                'prevPageCssClass' => 'page-item',
                'pageCssClass' => "page-item",
                'nextPageCssClass' => 'page-item',
                'firstPageCssClass' => 'page-item',
                'lastPageCssClass' => 'page-item',
                'linkOptions' => [
                    'class' => 'page-link',
                ],
                'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
            ])
            ?>
        </nav>
    </div>
</div>

<!--添加规格-->
<div class="modal fade" id="attrAddModal" data-backdrop="static">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">积分设置</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <div class="input-group short-row">
                        <input type="text" step="1" class="form-control short-row" name="integral[give]"
                               value="" placeholder="积分赠送">
                        <span class="input-group-addon">分</span>
                    </div>
                    <div class="fs-sm text-muted">
                        会员购物赠送的积分, 如果不填写或填写0，则默认为不赠送积分，如果带%则为按成交价格的比例计算积分
                    </div>
                </div>
                <div class="form-group mb-3">
                    <div class="input-group short-row">
                        <span class="input-group-addon">最多抵扣</span>
                        <input type="text" step="1" class="form-control short-row" name="integral[forehead]"
                               value="" placeholder="积分抵扣">
                        <span class="input-group-addon">元</span>
                    </div>
                    <div class="input-group short-row">
                        <label class="custom-control custom-checkbox">
                            <input value="1"
                                   name="integral[more]"
                                   type="checkbox"
                                   class="custom-control-input">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">允许多件累计折扣</span>
                        </label>
                    </div>
                    <div class="fs-sm text-muted">
                        如果设置0，则不支持积分抵扣 如果带%则为按成交价格的比例计算抵扣多少元
                    </div>
                </div>

                <div class="form-error text-danger mt-3 modelError" style="display: none">ddd</div>
                <div class="form-success text-success mt-3" style="display: none">sss</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary save-attr-btn">提交</button>
            </div>
        </div>
    </div>
</div>

<!--小程序码开始-->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-show="false">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img id="goods_qrcode" src="" width="200px">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal" id="closeModel">关闭
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--小程序码结束-->


<script>
    $("#myModal").modal({backdrop: "static", keyboard: false});

    $("#closeModel").click(function(){
        $("#goods_qrcode").attr("src",'');
    });

    var GoodsQrcodeUrl = "<?= $urlManager->createUrl(['mch/goods/goods-qrcode']) ?>";

    function getGoodsQrcode(id){
        $.ajax({
            url: GoodsQrcodeUrl,
            type: 'get',
            dataType: 'json',
            data: {
                goods_id:id
            },
            success: function (res) {
                if (res.code == 0) {
                    $("#goods_qrcode").attr("src",res.data.pic_url);
                }else{
                    alert('获取小程序码失败');
                }
            }
        });
    }

    $(document).on('click', '.recommend', function () {
        if (confirm("是否首页推荐？")) {
            $.ajax({
                url: $(this).attr('href'),
                type: 'get',
                dataType: 'json',
                success: function (res) {
                    alert(res.msg);
                    if (res.code == 0) {
                        window.location.reload();
                    }
                }
            });
        }
        return false;
    });

    $(document).on('click', '.del', function () {
        if (confirm("是否删除？")) {
            $.ajax({
                url: $(this).attr('href'),
                type: 'get',
                dataType: 'json',
                success: function (res) {
                    alert(res.msg);
                    if (res.code == 0) {
                        window.location.reload();
                    }
                }
            });
        }
        return false;
    });

    function upDown(id, type) {
        var text = '';
        if (type == 'up') {
            text = "上架";
        }else if(type == 'start'){
            text = "加入快速购买";
        }else if(type == 'close'){
            text = "关闭快速购买";
        }else {
            text = '下架';
        }

        var url = "<?= $urlManager->createUrl(['mch/goods/goods-up-down']) ?>";
        if (confirm("是否" + text + "？")) {
            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                data: {id: id, type: type},
                success: function (res) {
                    if (res.code == 0) {
                        window.location.reload();
                    }
                    if (res.code == 1) {
                        alert(res.msg);
                        if (res.return_url) {
                            location.href = res.return_url;
                        }
                    }
                }
            });
        }
        return false;
    }

    $(document).on('click', '.goods-all', function () {
        var checked = $(this).prop('checked');
        $('.goods-one').prop('checked', checked);
        if (checked) {
            $('.batch').addClass('is_use');
        } else {
            $('.batch').removeClass('is_use');
        }
    });
    $(document).on('click', '.goods-one', function () {
        var checked = $(this).prop('checked');
        var all = $('.goods-one');
        var is_all = true;//只要有一个没选中，全选按钮就不选中
        var is_use = false;//只要有一个选中，批量按妞就可以使用
        all.each(function (i) {
            if ($(all[i]).prop('checked')) {
                is_use = true;
            } else {
                is_all = false;
            }
        });
        if (is_all) {
            $('.goods-all').prop('checked', true);
        } else {
            $('.goods-all').prop('checked', false);
        }
        if (is_use) {
            $('.batch').addClass('is_use');
        } else {
            $('.batch').removeClass('is_use');
        }
    });
    $(document).on('click', '.batch', function () {
        var all = $('.goods-one');
        var is_all = true;//只要有一个没选中，全选按钮就不选中
        all.each(function (i) {
            if ($(all[i]).prop('checked')) {
                is_all = false;
            }
        });
        if (is_all) {
            $.myAlert({
                content: "请先勾选商品"
            });
        }
    });
    // 批量设置积分
    $(document).on('click', '.save-attr-btn', function () {
        var give = $('input[name^="integral[give]"]').val();
        var forehead = $('input[name^="integral[forehead]"]').val();
//        var more = $('input[name^="integral[more]"]').val();
        if ($('input[name^="integral[more]"]').is(':checked')) {
            var more = 1;
        } else {
            var more = '';
        }
        console.log(more);
        var all = $('.goods-one');
        var is_all = true;//只要有一个没选中，全选按钮就不选中
        all.each(function (i) {
            if ($(all[i]).prop('checked')) {
                is_all = false;
            }
        });
        if (is_all) {
            $.myAlert({
                content: "请先勾选商品"
            });
            return;
        }
        var a = $(this);
        var goods_group = [];
        all.each(function (i) {
            if ($(all[i]).prop('checked')) {
                var goods = {};
                goods_group.push($(all[i]).val());
            }
        });

        $.ajax({
            url: "<?= Yii::$app->urlManager->createUrl(['mch/goods/batch-integral']) ?>",
            type: 'get',
            dataType: 'json',
            data: {
                goods_group: goods_group,
                give: give,
                forehead: forehead,
                more: more,
            },
            success: function (res) {
                if (res.code == 0) {
                    window.location.reload();
                } else {
                    $('.modelError').text(res.msg);
                    $('.modelError').css('display', 'block');
                }
            },
//            complete: function () {
//                $.myLoadingHide();
//            }
        });


    });
    $(document).on('click', '.is_use', function () {
        var a = $(this);
        var goods_group = [];
        var all = $('.goods-one');
        all.each(function (i) {
            if ($(all[i]).prop('checked')) {
                var goods = {};
                goods.id = $(all[i]).val();
                goods.num = $(all[i]).data('num');
                goods_group.push(goods);
            }
        });
        $.myConfirm({
            content: a.data('content'),
            confirm: function () {
                $.myLoading();
                $.ajax({
                    url: a.data('url'),
                    type: 'get',
                    dataType: 'json',
                    data: {
                        goods_group: goods_group,
                        type: a.data('type'),
                    },
                    success: function (res) {
                        if (res.code == 0) {
                            $.myAlert({
                                content:res.msg,
                                confirm:function(){
                                    window.location.reload();
                                }
                            });
                        } else {
                            $.myAlert({
                                content:res.msg
                            });
                        }
                    },
                    complete: function () {
                        $.myLoadingHide();
                    }
                });
            }
        })
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
