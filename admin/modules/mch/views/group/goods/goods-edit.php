<?php
defined('YII_ENV') or exit('Access Denied');
$urlManager = Yii::$app->urlManager;
$this->title = '商品编辑';
$staticBaseUrl = Yii::$app->request->baseUrl . '/statics';
$this->params['active_nav_group'] = 2;
$returnUrl = Yii::$app->request->referrer;
if (!$returnUrl)
    $returnUrl = $urlManager->createUrl(['mch/group/goods/index']);
?>
<script src="<?= $staticBaseUrl ?>/mch/js/uploadVideo.js"></script>
<style>
    .cat-box {
        border: 1px solid rgba(0, 0, 0, .15);
    }

    .cat-box .row {
        margin: 0;
        padding: 0;
    }

    .cat-box .col-6 {
        padding: 0;
    }

    .cat-box .cat-list {
        border-right: 1px solid rgba(0, 0, 0, .15);
        overflow-x: hidden;
        overflow-y: auto;
        height: 10rem;
    }

    .cat-box .cat-item {
        border-bottom: 1px solid rgba(0, 0, 0, .1);
        padding: .5rem 1rem;
        display: block;
        margin: 0;
    }

    .cat-box .cat-item:last-child {
        border-bottom: none;
    }

    .cat-box .cat-item:hover {
        background: rgba(0, 0, 0, .05);
    }

    .cat-box .cat-item.active {
        background-color: #47B34F;
        color: #fff;
    }

    .cat-box .cat-item input {
        display: none;
    }
    .edui-editor,
    #edui1_toolbarbox {
        z-index: 2 !important;
    }
    .attr-group {
        border: 1px solid #eee;
        padding: .5rem .75rem;
        margin-bottom: .5rem;
        border-radius: .15rem;
    }

    .attr-group-delete {
        display: inline-block;
        background: #eee;
        color: #fff;
        width: 1rem;
        height: 1rem;
        text-align: center;
        line-height: 1rem;
        border-radius: 999px;
    }

    .attr-group-delete:hover {
        background: #ff4544;
        color: #fff;
        text-decoration: none;
    }

    .attr-list > div {
        vertical-align: top;
    }

    .attr-item {
        background: #eee;
        margin-right: 1rem;
        margin-top: .5rem;
        overflow: hidden;
    }

    .attr-item .attr-name {
        padding: .15rem .75rem;
        display: inline-block;
    }

    .attr-item .attr-delete {
        padding: .35rem .75rem;
        background: #d4cece;
        color: #fff;
        font-size: 1rem;
        font-weight: bold;
    }

    .attr-item .attr-delete:hover {
        text-decoration: none;
        color: #fff;
        background: #ff4544;
    }
</style>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">商品管理</a></li>
    <span>/</span>
    <li>商品编辑</li>
</ul>
<?php $this->endBlock(); ?>

<div class="pd-white-box" id="page">
    <div class="wrap">

        <form class="auto-form" method="post" return="<?= $returnUrl ?>">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#basic-info" role="tab"
                       aria-controls="basic-info" aria-selected="true">基本信息</a>
                    <a class="nav-item nav-link" id="stock-attr-tab" data-toggle="tab" href="#stock-attr" role="tab"
                       aria-controls="stock-attr" aria-selected="false">库存规格</a>
                    <a class="nav-item nav-link" id="image-video-tab" data-toggle="tab" href="#image-video" role="tab"
                       aria-controls="image-video" aria-selected="false">商品图片</a>
                    <a class="nav-item nav-link" id="goods-desc-tab" data-toggle="tab" href="#goods-desc" role="tab"
                       aria-controls="goods-desc" aria-selected="false">商品描述</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="basic-info-tab">

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label">平台分类</label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control parent" name="model[cat_id]">
                                <option value="0">无</option>
                                <?php foreach ($cat_list as $key=>$cat): ?>
                                    <option value="<?= $cat->id ?>" <?= $cat->id== $goods['cat_id'] ? 'selected' : '' ?>><?= $cat->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label">拉取商城商品</label>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group short-row">
                                <input class="form-control copy-mall-id" name="mall_id" type="number"
                                       placeholder="请输入商城商品ID">
                                <span class="input-group-btn">
                                    <a class="btn btn-secondary mall-copy-btn" href="javascript:">立即获取</a>
                                </span>
                            </div>
                            <div class="short-row text-muted fs-sm">若不使用，则该项为空</div>
                            <div class="copy-error text-danger fs-sm" hidden></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label required">商品名称</label>
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control short-row" type="text" name="model[name]"
                                   value="<?= str_replace("\"", "&quot", $goods['name']) ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label">单位</label>
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control short-row" type="text" name="model[unit]"
                                   value="<?= $goods['unit'] ? $goods['unit'] : '件' ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label">商品排序</label>
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control short-row" type="text" name="model[sort]"
                                   value="<?= $goods['sort'] ?>">
                            <div class="text-muted fs-sm">排序按升序排列</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label">虚拟销量</label>
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control short-row" type="number" name="model[virtual_sales]"
                                   value="<?= $goods['virtual_sales'] ?>" min="0" max="999999">
                            <div class="text-muted fs-sm">前端展示的销量=实际销量+虚拟销量</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label">重量</label>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control"
                                       name="model[weight]"
                                       value="<?= $goods['weight'] ? $goods['weight'] : 0 ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text">克</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label required">团购价</label>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control"
                                       name="model[price]" min="0.01"
                                       value="<?= $goods['price'] ? $goods['price'] : 1 ?>">
                                <span class="input-group-addon">元</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label required">单买价</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="number" step="0.01" class="form-control short-row"
                                   name="model[original_price]" min="0"
                                   value="<?= $goods['original_price'] ? $goods['original_price'] : 1 ?>">
                            <div class="fs-sm text-muted">单买价大于团购价</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label required">团长优惠</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="number" step="0.01" class="form-control short-row"
                                   name="model[colonel]" min="0"
                                   value="<?= $goods['colonel'] ? $goods['colonel'] : 1 ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label required">是否允许单买</label>
                        </div>

                        <div class="col-sm-6 col-form-label">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input id="is_only_allow" <?= $goods['is_only'] == 1 ? 'checked' : 'checked' ?>
                                       value="1"
                                       name="model[is_only]" type="radio" class="custom-control-input">
                                <label class="custom-control-label" for="is_only_allow">允许</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input id="is_only_not" <?= $goods['is_only'] == 0 ? 'checked' : null ?>
                                       value="0"
                                       name="model[is_only]" type="radio" class="custom-control-input">
                                <label class="custom-control-label" for="is_only_not">不允许</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label required">拼团限时</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control short-row"
                                   name="model[limit_time]"
                                   id="limit_time"
                                   value="<?= $goods['limit_time'] ? date('Y-m-d H:i:s', $goods['limit_time']) : '' ?>">
                            <div class="fs-sm text-muted">拼团限时为空则为不参与限时</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class=" col-form-label required">拼团人数</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="number" step="1" class="form-control short-row"
                                   name="model[group_num]" min="2"
                                   value="<?= $goods['group_num'] ? $goods['group_num'] : 2 ?>">
                            <div class="fs-sm text-muted">拼团人数必须大于等于2人</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class=" col-form-label required">拼团时间 </label>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group short-row">
                                <input type="number" step="1" class="form-control"
                                       name="model[grouptime]" min="1"
                                       value="<?= $goods['grouptime'] ? $goods['grouptime'] : 1 ?>">
                                <span class="input-group-addon">时</span>
                                <div class="fs-sm text-muted"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label required">购买次数限制</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="number" step="1" class="form-control short-row"
                                   name="model[buy_limit]" min="2"
                                   value="<?= $goods['buy_limit'] ? $goods['buy_limit'] : 0 ?>">
                            <div class="fs-sm text-muted">个人购买次数限制，默认是0，没有次数限制</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class=" col-form-label required">单次购买数量限制</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="number" step="1" class="form-control short-row"
                                   name="model[one_buy_limit]" min="2"
                                   value="<?= $goods['one_buy_limit'] ? $goods['one_buy_limit'] : 0 ?>">
                            <div class="fs-sm text-muted">单笔订单购买数量，默认是0，没有次数限制</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label">运费设置</label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control short-row" name="model[freight]">
                                <option value="0">默认模板</option>
                                <?php foreach ($postageRiles as $p): ?>
                                    <option
                                            value="<?= $p->id ?>" <?= $p->id == $goods['freight'] ? 'selected' : '' ?>><?= $p->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class=" col-form-label">送货方式</label>
                        </div>

                        <div class="col-sm-6 col-form-label">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input id="shsm" <?= $goods['type'] == 1 ? 'checked' : 'checked' ?>
                                       value="1"
                                       name="model[type]" type="radio" class="custom-control-input">
                                <label class="custom-control-label" for="shsm">送货上门</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input id="ddzt" <?= $goods['type'] == 2 ? 'checked' : null ?>
                                       value="2"
                                       name="model[type]" type="radio" class="custom-control-input">
                                <label class="custom-control-label" for="ddzt">到店自提</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input id="yhzx" <?= $goods['type'] == 3 ? 'checked' : null ?>
                                       value="3"
                                       name="model[type]" type="radio" class="custom-control-input">
                                <label class="custom-control-label" for="yhzx">用户自选</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label">服务内容</label>
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control short-row" name="model[service]"
                                   value="<?= $goods['service'] ?>">
                            <div class="fs-sm text-muted">例子：正品保障,极速发货,7天退换货。多个请使用英文逗号<kbd>,</kbd>分隔</div>
                        </div>
                    </div>

                </div>

                <div class="tab-pane fade" id="stock-attr" role="tabpanel" aria-labelledby="stock-attr-tab">

                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label required">商品库存</label>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group short-row">
                                <input class="form-control" name="model[goods_num]"
                                       value="<?= $goods->getDNum() ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text">件</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label">商品货号</label>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group short-row">
                                <input class="form-control" name="model[goods_no]"
                                       value="<?= $goods->getGoodsNo() ?>">
                            </div>
                        </div>
                    </div>

                    <!-- 规格开关 -->
                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label">是否使用规格</label>
                        </div>
                        <div class="col-sm-6 col-form-label">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                       name="model[use_attr]"
                                       value="1"
                                    <?= $goods->use_attr ? 'checked' : null ?>
                                       class="custom-control-input use-attr" id="useAttr">
                                <label class="custom-control-label" for="useAttr">使用规格</label>
                            </div>
                        </div>
                    </div>

                    <!-- 有规格 -->
                    <div class="attr-edit-block">
                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label required">规格组和规格值</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group short-row mb-2" v-if="attr_group_list.length<3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">规格组</span>
                                    </div>
                                    <input class="form-control add-attr-group-input" placeholder="如颜色、尺码、套餐">
                                    <div class="input-group-append">
                                        <a class="btn btn-outline-secondary add-attr-group-btn" href="javascript:void(0);">添加</a>
                                    </div>
                                </div>
                                <div v-else class="mb-2">最多只可添加3个规格组</div>
                                <div v-for="(attr_group,i) in attr_group_list" class="attr-group">
                                    <div>
                                        <b>{{attr_group.attr_group_name}}</b>
                                        <a v-bind:index="i" href="javascript:" class="attr-group-delete">×</a>
                                    </div>
                                    <div class="attr-list">
                                        <div v-for="(attr,j) in attr_group.attr_list" class="attr-item">
                                            <span class="attr-name">{{attr.attr_name}}</span>
                                            <a v-bind:group-index="i" v-bind:index="j" class="attr-delete" href="javascript:">×</a>
                                        </div>
                                        <div style="margin-top: .5rem">
                                            <div class="input-group attr-input-group" style="border-radius: 0">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" style="padding: .35rem .35rem;font-size: .8rem">规格值</span>
                                                </div>
                                                <input class="form-control add-attr-input" placeholder="如红色、白色">
                                                <div class="input-group-append">
                                                    <a v-bind:index="i" class="btn btn-outline-secondary add-attr-btn test" href="javascript:void(0);">添加</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group-label col-sm-2 text-right">
                                <label class="col-form-label required">价格和库存</label>
                            </div>
                            <div class="col-sm-10">
                                <div v-if="attr_group_list && attr_group_list.length>0">
                                    <table class="table table-bordered attr-table">
                                        <thead>
                                        <tr>
                                            <th v-for="(attr_group,i) in attr_group_list"
                                                v-if="attr_group.attr_list && attr_group.attr_list.length>0">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">{{attr_group.attr_group_name}}</span>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">库存</span>
                                                    </div>
                                                    <input class="form-control" type="number">
                                                    <div class="input-group-append">
                                                        <a class="btn btn-outline-secondary bat" href="javascript:void(0);" data-index="0">设置</a>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">价格</span>
                                                    </div>
                                                    <input class="form-control" type="number">
                                                    <div class="input-group-append">
                                                        <a class="btn btn-outline-secondary bat" href="javascript:void(0);" data-index="1">设置</a>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">货号</span>
                                                    </div>
                                                    <input class="form-control" type="number">
                                                    <div class="input-group-append">
                                                        <a class="btn btn-outline-secondary bat" href="javascript:void(0);" data-index="2">设置</a>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">规格图片</span>
                                                </div>
                                            </th>
                                        </tr>
                                        <col style="width: 20%">
                                        <col style="width: 17.5%">
                                        <col style="width: 17.5%">
                                        <col style="width: 20%">
                                        <col style="width: 25%">
                                        </thead>
                                        <tr v-for="(item,index) in checked_attr_list">
                                            <td v-for="(attr,attr_index) in item.attr_list">
                                                <input type="hidden"
                                                       v-bind:name="'attr['+index+'][attr_list]['+attr_index+'][attr_id]'"
                                                       v-bind:value="attr.attr_id">
                                                <input type="hidden"
                                                       v-bind:name="'attr['+index+'][attr_list]['+attr_index+'][attr_name]'"
                                                       v-bind:value="attr.attr_name">
                                                <input type="hidden"
                                                       v-bind:name="'attr['+index+'][attr_list]['+attr_index+'][attr_group_name]'"
                                                       v-bind:value="attr.attr_group_name">
                                                <span>{{attr.attr_name}}</span>
                                            </td>
                                            <td>
                                                <input class="form-control" type="number" min="0" step="1" v-bind:name="'attr['+index+'][num]'" v-model="item.num" v-on:change="change(item,index)">
                                            </td>
                                            <td>
                                                <input class="form-control" type="number" min="0" step="0.01" v-bind:name="'attr['+index+'][price]'" v-model="item.price" v-on:change="change(item,index)">
                                            </td>
                                            <td>
                                                <input class="form-control" v-bind:name="'attr['+index+'][no]'" v-model="item.no" v-on:change="change(item,index)">
                                            </td>
                                            <td>
                                                <div class="input-group" v-bind:data-index="index">
                                                    <input class="form-control" style="width: 40px"
                                                           v-bind:name="'attr['+index+'][pic]'"
                                                           v-model="item.pic" v-on:change="change(item,index)">
                                                    <div class="input-group-append">
                                                        <a class="btn btn-outline-secondary upload-attr-pic" href="javascript:void(0);" title="上传文件"><span class="iconfont icon-shangchuan"></span></a>
                                                        <a class="btn btn-outline-secondary select-attr-pic" href="javascript:void(0);" title="从文件库选择"><span class="iconfont icon-lishituku"></span></a>
                                                        <a class="btn btn-outline-secondary delete-attr-pic" href="javascript:void(0);" title="删除文件"><span class="iconfont icon-shanchu"></span></a>
                                                    </div>
                                                </div>
                                                <img v-if="item.pic" v-bind:src="item.pic"
                                                     style="width: 50px;height: 50px;margin: 2px 0;border-radius: 2px">
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="text-muted fs-sm">规格价格0表示保持原售价</div>
                                </div>
                                <div v-else class="pt-2 text-muted">请先填写规格组和规格值</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="image-video" role="tabpanel" aria-labelledby="image-video-tab">
                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label required">商品缩略图</label>
                        </div>
                        <div class="col-sm-6">
                            <div class="upload-group">
                                <div class="input-group">
                                    <input type="text" class="form-control file-input" name="model[cover_pic]" value="<?= $goods->cover_pic ?>">
                                    <div class="input-group-append">
                                        <a class="btn btn-outline-secondary upload-file" href="javascript:void(0);" title="上传文件"><span class="iconfont icon-shangchuan"></span></a>
                                        <a class="btn btn-outline-secondary select-file" href="javascript:void(0);" title="从文件库选择"><span class="iconfont icon-lishituku"></span></a>
                                        <a class="btn btn-outline-secondary delete-file" href="javascript:void(0);" title="删除文件"><span class="iconfont icon-shanchu"></span></a>
                                    </div>
                                </div>
                                <div class="upload-preview text-center upload-preview">
                                    <span class="upload-preview-tip">325&times;325</span>
                                    <img class="upload-preview-img" src="<?= $goods->cover_pic ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label required">商品图片</label>
                        </div>
                        <div class="col-sm-6">
                            <div class="upload-group multiple short-row">
                                <div class="input-group">
                                    <input class="form-control file-input" readonly>
                                    <div class="input-group-append">
                                        <a class="btn btn-outline-secondary upload-file" href="javascript:void(0);" title="上传文件"><span class="iconfont icon-shangchuan"></span></a>
                                        <a class="btn btn-outline-secondary select-file" href="javascript:void(0);" title="从文件库选择"><span class="iconfont icon-lishituku"></span></a>
                                    </div>
                                </div>
                                <div class="upload-preview-list">
                                    <div v-if="goods_pic_list.length>0">
                                        <div class="upload-preview text-center" v-for="item in goods_pic_list">
                                            <input type="hidden" class="file-item-input"
                                                   name="model[goods_pic_list][]"
                                                   v-bind:value="item">
                                            <span class="file-item-delete">&times;</span>
                                            <span class="upload-preview-tip">750&times;750</span>
                                            <img class="upload-preview-img" v-bind:src="item">
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="upload-preview text-center">
                                            <input type="hidden" class="file-item-input" name="model[goods_pic_list][]">
                                            <span class="file-item-delete">&times;</span>
                                            <span class="upload-preview-tip">750&times;750</span>
                                            <img class="upload-preview-img" src="">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="goods-desc" role="tabpanel" aria-labelledby="goods-desc-tab">
                    <div class="form-group row">
                        <div class="form-group-label col-sm-2 text-right">
                            <label class="col-form-label required">图文详情</label>
                        </div>
                        <div class="col-sm-6">
                            <textarea class="short-row" style="width: 380px;" id="editor" name="model[detail]"><?= $goods['detail'] ?></textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary auto-form-btn" href="javascript:void(0);">保存</a>
                </div>
            </div>

        </form>


    </div>
</div>

<script src="<?= Yii::$app->request->baseUrl ?>/statics/ueditor/ueditor.config.js?v=1.9.6"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/statics/ueditor/ueditor.all.min.js?v=1.9.6"></script>
<script>
    var Map = function () {
        this._data = [];
        this.set = function (key, val) {
            for (var i in this._data) {
                if (this._data[i].key == key) {
                    this._data[i].val = val;
                    return true;
                }
            }
            this._data.push({
                key: key,
                val: val,
            });
            return true;
        };
        this.get = function (key) {
            for (var i in this._data) {
                if (this._data[i].key == key)
                    return this._data[i].val;
            }
            return null;
        };
        this.delete = function (key) {
            for (var i in this._data) {
                if (this._data[i].key == key) {
                    this._data.splice(i, 1);
                }
            }
            return true;
        };
    };
    var map = new Map();
    var page = new Vue({
        el: "#page",
        data: {
            sub_cat_list: [],
            end_cat_list: [],
            attr_group_list: JSON.parse('<?=json_encode($goods->getAttrData(), JSON_UNESCAPED_UNICODE)?>'),//可选规格数据
            checked_attr_list: JSON.parse('<?=json_encode($goods->getCheckedAttrData(), JSON_UNESCAPED_UNICODE)?>'),//已选规格数据
            goods_pic_list: JSON.parse('<?=json_encode($goods->goodsPicList, JSON_UNESCAPED_UNICODE)?>'),
            select_i: ''
        },
        methods: {
            change: function (item, index) {
                this.checked_attr_list[index] = item;
            }
        }
    });

    var ue = UE.getEditor('editor', {
        serverUrl: "<?=$urlManager->createUrl(['upload/ue'])?>",
        enableAutoSave: false,
        saveInterval: 1000 * 3600,
        enableContextMenu: false,
        autoHeightEnabled: false,
    });
    $(document).on("change", ".cat-item input", function () {
        if ($(this).prop("checked")) {
            $(".cat-item").removeClass("active");
            $(this).parent(".cat-item").addClass("active");
        } else {
            $(this).parent(".cat-item").removeClass("active");
        }

    });

    $(document).on("change", ".parent-cat-list input", function () {
        getSubCatList();
    });
    $(document).on("change", ".second-cat-list input", function () {
        getEndCatList();
    });

    //分类设置
    $(document).on('click', '.cat-modal', function () {
        page.select_i = $(this).data('index');
    });
    //选择分类
    $(document).on("click", ".cat-confirm", function () {
        var cat_name = $.trim($(".cat-item.active").text());
        var cat_id = $(".cat-item.active input").val();
        if (cat_name && cat_id) {
//            $(".cat-name").val(cat_name);
//            $(".cat-id").val(cat_id);
            page.goods_cat_list[page.select_i]['cat_id'] = cat_id;
            page.goods_cat_list[page.select_i]['cat_name'] = cat_name;
        }
        $("#catModal").modal("hide");
    });
    //添加新分类
    $(document).on('click', '.addcat', function () {
        var cat = {};
        cat.cat_name = '';
        cat.cat_id = '';
        page.goods_cat_list.push(cat);
    });
    //删除分类
    $(document).on('click', '.delete-cat', function () {
        page.goods_cat_list.splice($(this).data('index'), 1);
        if (page.goods_cat_list.length == 0) {
            var cat = {};
            cat.cat_name = '';
            cat.cat_id = '';
            page.goods_cat_list.push(cat);
        }
    });

    function getSubCatList() {
        var parent_id = $(".parent-cat-list input:checked").val();
        page.sub_cat_list = [];
        $.ajax({
            url: "<?=$urlManager->createUrl(['mch/goods/get-cat-list'])?>",
            data: {
                parent_id: parent_id,
            },
            success: function (res) {
                console.log(res);
                if (res.code == 0) {
                    page.sub_cat_list = res.data;
                    if(page.sub_cat_list.length > 0){
                        if ($(".second-cat-list input").length > 0) {
                            $(".second-cat-list input")[0].prop('checked');
                        }
                        getEndCatList();
                    }

                }
            }
        });
    }
    function getEndCatList() {
        var parent_id = $(".second-cat-list input:checked").val();
        page.end_cat_list = [];
        $.ajax({
            url: "<?=$urlManager->createUrl(['mch/goods/get-cat-list'])?>",
            data: {
                parent_id: parent_id,
            },
            success: function (res) {
                if (res.code == 0) {
                    page.end_cat_list = res.data;
                }
            }
        });
    }

    getSubCatList();


    $(document).on("change", ".attr-select", function () {
        var name = $(this).attr("data-name");
        var id = $(this).val();
        if ($(this).prop("checked")) {
        } else {
        }
    });

    $(document).on("click", ".add-attr-group-btn", function () {
        var name = $(".add-attr-group-input").val();
        name = $.trim(name);
        if (name == "")
            return;
        page.attr_group_list.push({
            attr_group_name: name,
            attr_list: [],
        });
        $(".add-attr-group-input").val("");
        page.checked_attr_list = getAttrList();
    });

    $(document).on("click", ".add-attr-btn", function () {
        var name = $(this).parents(".attr-input-group").find(".add-attr-input").val();
        var index = $(this).attr("index");
        name = $.trim(name);
        console.log(name);
        if (name == "")
            return;
        page.attr_group_list[index].attr_list.push({
            attr_name: name,
        });
        $(this).parents(".attr-input-group").find(".add-attr-input").val("");
        page.checked_attr_list = getAttrList();
    });


    $(document).on("click", ".attr-group-delete", function () {
        var index = $(this).attr("index");
        page.attr_group_list.splice(index, 1);
        page.checked_attr_list = getAttrList();
    });

    $(document).on("click", ".attr-delete", function () {
        var index = $(this).attr("index");
        var group_index = $(this).attr("group-index");
        page.attr_group_list[group_index].attr_list.splice(index, 1);
        page.checked_attr_list = getAttrList();
    });


    function getAttrList() {
        var array = [];
        for (var i in page.attr_group_list) {
            for (var j in page.attr_group_list[i].attr_list) {
                var object = {
                    attr_group_name: page.attr_group_list[i].attr_group_name,
                    attr_id: null,
                    attr_name: page.attr_group_list[i].attr_list[j].attr_name,
                };
                if (!array[i])
                    array[i] = [];
                array[i].push(object);
            }
        }
        var len = array.length;
        var results = [];
        var indexs = {};

        function specialSort(start) {
            start++;
            if (start > len - 1) {
                return;
            }
            if (!indexs[start]) {
                indexs[start] = 0;
            }
            if (!(array[start] instanceof Array)) {
                array[start] = [array[start]];
            }
            for (indexs[start] = 0; indexs[start] < array[start].length; indexs[start]++) {
                specialSort(start);
                if (start == len - 1) {
                    var temp = [];
                    for (var i = len - 1; i >= 0; i--) {
                        if (!(array[start - i] instanceof Array)) {
                            array[start - i] = [array[start - i]];
                        }
                        if (array[start - i][indexs[start - i]]) {
                            temp.push(array[start - i][indexs[start - i]]);
                        }
                    }
                    var key = [];
                    for (var i in temp) {
                        key.push(temp[i].attr_id);
                    }console.log(temp);
                    var oldVal = map.get(key.sort().toString());
                    if (oldVal) {
                        results.push({
                            num: oldVal.num,
                            price: oldVal.price,
                            no: oldVal.no,
                            pic: oldVal.pic,
                            attr_list: temp
                        });
                    } else {
                        results.push({
                            num: 0,
                            price: 0,
                            no: '',
                            pic: '',
                            attr_list: temp
                        });
                    }
                }
            }
        }

        specialSort(-1);
        return results;
    }


    $(document).on("change", "input[name='model[individual_share]']", function () {
        setShareCommission();
    });
    setShareCommission();

    function setShareCommission() {
        console.log($("input[name='model[individual_share]']:checked").val());
        if ($("input[name='model[individual_share]']:checked").val() == 1) {
            $(".share-commission").show();
        } else {
            $(".share-commission").hide();
        }
    }

    $(document).on("change", "input[name='model[quick_purchase]']", function () {
        setShareCommissions();
    });
    setShareCommissions();

    function setShareCommissions() {
        if ($("input[name='model[quick_purchase]']:checked").val() == 1) {
            $(".share-commissions").show();
        } else {
            $(".share-commissions").hide();
        }
    }

    function checkUseAttr() {
        if ($('.use-attr').length == 0)
            return;
        if ($('.use-attr').prop('checked')) {
            $('input[name="model[goods_num]"]').val(0).prop('readonly', true);
            $('input[name="model[goods_no]"]').val(0).prop('readonly', true);
            $('.attr-edit-block').show();
        } else {
            $('input[name="model[goods_num]"]').prop('readonly', false);
            $('input[name="model[goods_no]"]').prop('readonly', false);
            $('.attr-edit-block').hide();
        }
    }

    $(document).on('change', '.use-attr', function () {
        checkUseAttr();
    });

    checkUseAttr();

</script>
<script>
    $(document).on('change', '.video', function () {
        $('.video-check').attr('href', this.value);
    });
</script>
<script>
    $(document).on('click', '.copy-btn', function () {
//        var url = $('.copy-url').val();
        var btn = $(this);
        var url = $(btn.parent().prev()[0]).val();
        var error = $('.copy-error');
        error.prop('hidden', true);
        if (url == '' || url == undefined) {
            error.prop('hidden', false).html('请填写宝贝链接');
            return;
        }
        btn.btnLoading('信息获取中');
        $.myLoading();
        $.ajax({
            url: "<?=$urlManager->createUrl(['mch/goods/copy'])?>",
            type: 'get',
            dataType: 'json',
            data: {
                url: url,
            },
            success: function (res) {
                $.myLoadingHide();
                btn.btnReset();
                if (res.code == 0) {
                    $("input[name='model[name]']").val(res.data.title);
                    $("input[name='model[virtual_sales]']").val(res.data.sale_count);
                    $("input[name='model[price]']").val(res.data.sale_price);
                    $("input[name='model[original_price]']").val(res.data.price);
                    page.attr_group_list = res.data.attr_group_list;
                    page.checked_attr_list = res.data.checked_attr_list;
                    ue.setContent(res.data.detail_info + "");
                    var pic = res.data.picsPath;

                    if (pic) {
                        var cover_pic = $("input[name='model[cover_pic]']");
                        var cover_pic_next = $(cover_pic.parent().next('.upload-preview')[0]).children('.upload-preview-img');
                        cover_pic.val(pic[0]);
                        $(cover_pic_next).prop('src', pic[0]);
//                        $(cover_pic_next).css('background-image', "url(" + pic[0] + ")");
//                    if (pic.length > 1) {
//                        var goods_pic_list = $(".picker-multiple-list");
//                        goods_pic_list.empty();
//                        $(pic).each(function (i) {
//                            if (i == 0) {
//                                return true;
//                            }
//                            var goods_pic = '<div class="image-picker-view-item"><input class="image-picker-input" type="hidden" name="model[goods_pic_list][]" value="' +
//                                pic[i] + '"> <div class="image-picker-view" data-responsive="750:700" style="width:224px;height:209px;background-image: url(' + "'" +
//                                pic[i] + "'" + ')"> <span class="picker-tip">750×750</span> <span class="picker-delete">×</span></div></div>';
//                            goods_pic_list.append(goods_pic);
//                        });
//
//                    }
                        if (pic.length > 1) {
                            var goods_pic_list = $(".upload-preview-list");
                            goods_pic_list.empty();
                            $(pic).each(function (i) {
                                if (i == 0) {
                                    return true;
                                }
                                var goods_pic = ' <div class="upload-preview text-center">' +
                                    '<input type="hidden" class="file-item-input" name="model[goods_pic_list][]" value="' + pic[i] + '"> ' +
                                    '<span class="file-item-delete">&times;</span> <span class="upload-preview-tip">750&times;750</span> ' +
                                    '<img class="upload-preview-img" src="' + pic[i] + '"> ' +
                                    '</div>';
                                goods_pic_list.append(goods_pic);
                            });
                        }
                    }


                } else {
                    error.prop('hidden', false).html(res.msg);
                }
            }
        });
    });

    //卡券设置
    $(document).on('click', '.card-add', function () {
        var index = $('.card-list').val();
        if (index == -1) {
            return;
        }
        page.goods_card_list.push(page.card_list[index]);
    });
    $(document).on('click', '.card-del', function () {
        var index = $(this).data('index');
        page.goods_card_list.splice(index, 1);
    })

    //分销佣金选择
    $(document).on('click', '.share-type', function () {
        var price_type = $(this).children('input');
        if ($(price_type).val() == 1) {
            $('.percent').html('元');
        } else {
            $('.percent').html('%');
        }
    })
</script>
<script>
    $(document).on('click', '.copy-btn-1', function () {
//        var url = $('.copy-url').val();
        var btn = $(this);
        var url = $(btn.parent().prev()[0]).val();
        var error = $('.copy-error');
        error.prop('hidden', true);
        if (url == '' || url == undefined) {
            error.prop('hidden', false).html('请填写宝贝链接');
            return;
        }
        var url_arr = url.split("?");
        var theRequest = {};
        if (url_arr.length >= 2) {
            var strs = url_arr[1].split("&");
            for (var i = 0; i < strs.length; i++) {
                theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
            }
        }
        var id = theRequest.id;
        btn.btnLoading('信息获取中');
        $.myLoading();
        $.ajax({
            url: "http://hws.m.taobao.com/cache/wdetail/5.0/?id=" + id,
            dataType: 'jsonp',
            beforeSend: function (request) {
                request.setRequestHeader("Referer", "http://hws.m.taobao.com");
            },
            success: function (res) {
                $.ajax({
                    url: "<?=$urlManager->createUrl(['mch/goods/tcopy'])?>",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        html: res,
                        _csrf: _csrf
                    },
                    success: function (res) {
                        $.myLoadingHide();
                        btn.btnReset();
                        if (res.code == 0) {
                            $("input[name='model[name]']").val(res.data.title);
                            $("input[name='model[virtual_sales]']").val(res.data.sale_count);
                            $("input[name='model[price]']").val(res.data.sale_price);
                            $("input[name='model[original_price]']").val(res.data.price);

                            page.attr_group_list = res.data.attr_group_list;
                            page.checked_attr_list = res.data.checked_attr_list;
                            ue.setContent(res.data.detail_info + "");
                            var pic = res.data.picsPath;

                            if (pic) {
                                var cover_pic = $("input[name='model[cover_pic]']");
                                var cover_pic_next = $(cover_pic.parent().next('.upload-preview')[0]).children('.upload-preview-img');
                                cover_pic.val(pic[0]);
                                $(cover_pic_next).prop('src', pic[0]);
//                        $(cover_pic_next).css('background-image', "url(" + pic[0] + ")");
//                    if (pic.length > 1) {
//                        var goods_pic_list = $(".picker-multiple-list");
//                        goods_pic_list.empty();
//                        $(pic).each(function (i) {
//                            if (i == 0) {
//                                return true;
//                            }
//                            var goods_pic = '<div class="image-picker-view-item"><input class="image-picker-input" type="hidden" name="model[goods_pic_list][]" value="' +
//                                pic[i] + '"> <div class="image-picker-view" data-responsive="750:700" style="width:224px;height:209px;background-image: url(' + "'" +
//                                pic[i] + "'" + ')"> <span class="picker-tip">750×750</span> <span class="picker-delete">×</span></div></div>';
//                            goods_pic_list.append(goods_pic);
//                        });
//
//                    }
                                if (pic.length > 1) {
                                    var goods_pic_list = $(".upload-preview-list");
                                    goods_pic_list.empty();
                                    $(pic).each(function (i) {
                                        if (i == 0) {
                                            return true;
                                        }
                                        var goods_pic = ' <div class="upload-preview text-center">' +
                                            '<input type="hidden" class="file-item-input" name="model[goods_pic_list][]" value="' + pic[i] + '"> ' +
                                            '<span class="file-item-delete">&times;</span> <span class="upload-preview-tip">750&times;750</span> ' +
                                            '<img class="upload-preview-img" src="' + pic[i] + '"> ' +
                                            '</div>';
                                        goods_pic_list.append(goods_pic);
                                    });
                                }
                            }


                        } else {
                            error.prop('hidden', false).html(res.msg);
                        }
                    }
                });
            }
        });
    });
</script>
<!-- 规格图片 -->
<script>
    $(document).on('click', '.upload-attr-pic', function () {
        var btn = $(this);
        var input = btn.parents('.input-group').find('.form-control');
        var index = btn.parents('.input-group').attr('data-index');
        $.upload_file({
            accept: 'image/*',
            start: function (res) {
                btn.btnLoading('');
            },
            success: function (res) {
                input.val(res.data.url).trigger('change');
                page.checked_attr_list[index].pic = res.data.url;
            },
            complete: function (res) {
                btn.btnReset();
            },
        });
    });
    $(document).on('click', '.select-attr-pic', function () {
        var btn = $(this);
        var input = btn.parents('.input-group').find('.form-control');
        var index = btn.parents('.input-group').attr('data-index');
        $.select_file({
            success: function (res) {
                input.val(res.url).trigger('change');
                page.checked_attr_list[index].pic = res.url;
            }
        });
    });
    $(document).on('click', '.delete-attr-pic', function () {
        var btn = $(this);
        var input = btn.parents('.input-group').find('.form-control');
        var index = btn.parents('.input-group').attr('data-index');
        input.val('').trigger('change');
        page.checked_attr_list[index].pic = '';
    });
</script>
<!--批量设置-->
<script>
    $(document).on('click', '.bat', function () {
        var type = $(this).data('index');
        var val = $($(this).parent().prev('input')).val();
        for (var i in page.checked_attr_list) {
            if (type == 0) {
                page.checked_attr_list[i].num = val
            } else if (type == 1) {
                page.checked_attr_list[i].price = val
            }
            else if (type == 2) {
                page.checked_attr_list[i].no = val
            }
        }
    });
</script>

<script>
    $(document).on('click', '.mall-copy-btn', function () {
        var mall_id = $('.copy-mall-id').val();
        var btn = $(this);
        var error = $('.copy-error');
        error.prop('hidden', true);
        if (mall_id == '' || mall_id == undefined) {
            error.prop('hidden', false).html('请填写商城商品ID');
            return;
        }
        btn.btnLoading('信息获取中');
        $.myLoading();
        $.ajax({
            url: "<?=$urlManager->createUrl(['mch/group/goods/copy'])?>",
            type: 'get',
            dataType: 'json',
            data: {
                mall_id: mall_id,
            },
            success: function (res) {
                $('.no-mall-get').hide();
                $('.mall-get').show();
                $.myLoadingHide();
                btn.btnReset();
                console.log(res);
                if (res.code == 0) {
                    $("input[name='model[name]']").val(res.data.name);
                    $("input[name='model[virtual_sales]']").val(res.data.virtual_sales);
                    $("input[name='model[price]']").val(res.data.price);
                    $("input[name='model[original_price]']").val(res.data.original_price);
//                    $("input[name='model[cover_pic]']").val(res.data.cover_pic);
                    $("input[name='model[unit]']").val(res.data.unit);
                    $("input[name='model[weight]']").val(res.data.weight);
                    $("input[name='model[service]']").val(res.data.service);
                    $("input[name='model[sort]']").val(res.data.sort);

//                    $("#editor").val(res.data.detail);
                    if(res.data.attr_group_list.length>0){
                        $("input[name='model[use_attr]']").prop('checked',true);
                        $('input[name="model[goods_num]"]').val(0).prop('readonly', true);
                        $('input[name="model[goods_no]"]').val(0).prop('readonly', true);
                        $('.attr-edit-block').show();
                    }
                    page.attr_group_list = JSON.parse(res.data.attr_group_list);
                    page.checked_attr_list = JSON.parse(res.data.checked_attr_list);
                    ue.setContent(res.data.detail + "");

                    var cover_pic = $("input[name='model[cover_pic]']");
                    var cover_pic_preview = cover_pic.closest('.input-group').next().find('img');
                    cover_pic.val(res.data.cover_pic);
                    cover_pic_preview.attr('src',res.data.cover_pic);

                    page.goods_pic_list = res.data.pic;

                } else {
                    error.prop('hidden', false).html(res.msg);
                }
            }
        });
    });
</script>
