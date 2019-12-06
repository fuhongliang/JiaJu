<?php
defined('YII_ENV') or exit('Access Denied');
$urlManager = Yii::$app->urlManager;
$this->title = '编辑商户';
$this->params['active_nav_group'] = 1;
?>
<link href="<?= Yii::$app->request->baseUrl ?>/new/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css" rel="stylesheet">


<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">商户管理</a></li>
    <span>/</span>
    <li><?= $this->title?></li>
</ul>
<?php $this->endBlock(); ?>
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=C65BZ-YWY6Q-NJD54-GHNUX-VWHGQ-YBBH2"></script>

<div class="pd-white-box">
    <div class="wrap">
        <form class="form auto-form" method="post" autocomplete="off" style="display: inline-block;width: 45%;"
              data-return="<?= Yii::$app->request->referrer ? Yii::$app->request->referrer : '' ?>">
            <div class="form-body">
                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class=" col-form-label required">联系人</label>
                    </div>
                    <div class="col-9">
                        <input class="form-control" name="realname" value="<?= $model->realname ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class=" col-form-label required">联系电话</label>
                    </div>
                    <div class="col-9">
                        <input class="form-control" name="tel" value="<?= $model->tel ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class=" col-form-label required">店铺名称</label>
                    </div>
                    <div class="col-9">
                        <input class="form-control" name="name" value="<?= $model->name ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class=" col-form-label required">省份</label>
                    </div>
                    <div class="col-9">
                        <input class="form-control" name="province" readonly value="<?= $model->province ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class=" col-form-label required">城市</label>
                    </div>
                    <div class="col-9">
                        <input class="form-control" name="city" readonly value="<?= $model->city ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class=" col-form-label required">地区</label>
                    </div>
                    <div class="col-9">
                        <input class="form-control" name="district" readonly value="<?= $model->district ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class=" col-form-label required">详细地址</label>
                    </div>
                    <div class="col-9">
                        <input class="form-control" name="address" value="<?= $model->address ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class=" col-form-label required">所售类目</label>
                    </div>
                    <div class="col-9">
                        <select class="form-control" name="mch_common_cat_id">
                            <?php foreach ($mch_common_cat_list as $item): ?>
                                <option value="<?= $item->id ?>"
                                    <?= $item->id == $model->mch_common_cat_id ? 'selected' : null ?>><?= $item->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class=" col-form-label required">客服电话</label>
                    </div>
                    <div class="col-9">
                        <input class="form-control" name="service_tel" value="<?= $model->service_tel ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class="col-form-label required">店铺Logo</label>
                    </div>
                    <div class="col-9">
                        <div class="upload-group">
                            <div class="input-group">
                                <input class="form-control file-input" name="logo" value="<?= $model->logo ?>">
                                <div class="input-group-append">
                                    <a class="btn btn-outline-secondary upload-file" href="javascript:void(0);" title="上传文件"><span class="iconfont icon-shangchuan"></span></a>
                                    <a class="btn btn-outline-secondary select-file" href="javascript:void(0);" title="从文件库选择"><span class="iconfont icon-lishituku"></span></a>
                                    <a class="btn btn-outline-secondary delete-file" href="javascript:void(0);" title="删除文件"><span class="iconfont icon-shanchu"></span></a>
                                </div>
                            </div>
                            <div class="upload-preview text-center upload-preview">
                                <span class="upload-preview-tip">100&times;100</span>
                                <img class="upload-preview-img" src="<?= $model->logo ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class="col-form-label required">背景颜色(点击方块)</label>
                    </div>
                    <div id="mch_color" class="col-9 input-group">
                        <input class="form-control" name="mch_color"  value="<?= $model->mch_color ?>"/>
                        <span class="input-group-append">
                            <span class="input-group-text colorpicker-input-addon"><i></i></span>
                        </span>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class="col-form-label required">商家主页头部颜色</label>
                    </div>
                    <div id="header_color" class="col-9 input-group">
                        <input class="form-control" name="header_color"  value="<?= $model->header_color ?>"/>
                        <span class="input-group-append">
                            <span class="input-group-text colorpicker-input-addon"><i></i></span>
                        </span>
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class="col-form-label required">店铺背景（顶部）</label>
                    </div>
                    <div class="col-9">

                        <div class="upload-group">
                            <div class="input-group">
                                <input class="form-control file-input" name="header_bg" value="<?= $model->header_bg ?>">
                                <div class="input-group-append">
                                    <a class="btn btn-outline-secondary upload-file" href="javascript:void(0);" title="上传文件"><span class="iconfont icon-shangchuan"></span></a>
                                    <a class="btn btn-outline-secondary select-file" href="javascript:void(0);" title="从文件库选择"><span class="iconfont icon-lishituku"></span></a>
                                    <a class="btn btn-outline-secondary delete-file" href="javascript:void(0);" title="删除文件"><span class="iconfont icon-shanchu"></span></a>
                                </div>
                            </div>
                            <div class="upload-preview text-center upload-preview">
                                <span class="upload-preview-tip">750&times;300</span>
                                <img class="upload-preview-img" src="<?= $model->header_bg ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class=" col-form-label required">手续费(千分之)</label>
                    </div>
                    <div class="col-9">
                        <input type="number" min="0" max="1000" step="1" class="form-control" name="transfer_rate"
                               value="<?= $model->transfer_rate ?>">
                        <div>商户每笔订单交易金额扣除的手续费，请填写0~1000范围的整数</div>
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class="col-form-label">是否能发布内容</label>
                    </div>
                    <div class="col-sm-6 col-form-label">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input id="radioDialYes" <?= $model->content_permission == 1 ? 'checked' : null ?>
                                   value="1"
                                   name="content_permission" type="radio" class="custom-control-input">
                            <label class="custom-control-label" for="radioDialYes">能</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input id="radioDialNo" <?= $model->content_permission == 0 ? 'checked' : null ?>
                                   value="0"
                                   name="content_permission" type="radio" class="custom-control-input">
                            <label class="custom-control-label" for="radioDialNo">不能</label>
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class=" col-form-label required">排序</label>
                    </div>
                    <div class="col-9">
                        <input type="number" min="0" max="10000000" step="1" class="form-control" name="sort"
                               value="<?= $model->sort ?>">
                        <div>升序，数字越小排的越靠前</div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class=" col-form-label required">门店经度：</label>
                    </div>
                    <div class="col-9">
                        <input class="form-control" type="text" name="longitude" value="<?= $model->longitude ?>">
                        <div class="fs-sm">门店经纬度可以在地图上选择，也可以自己添加</div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-3 text-right">
                        <label class="col-form-label required">门店纬度：</label>
                    </div>
                    <div class="col-9">
                        <input class="form-control" type="text" name="latitude" value="<?= $model->latitude ?>">
                        <div class="fs-sm">门店经纬度可以在地图上选择，也可以自己添加</div>
                    </div>
                </div>
                <?php if ($model->review_status == 0): ?>
                    <div class="form-group row">
                        <div class="col-3 text-right">
                            <label class="col-form-label required">审核状态</label>
                        </div>
                        <div class="col-9">
                            <label class="radio-label">
                                <input type="radio" name="review_status" value="1">
                                <span class="label-icon"></span>
                                <span class="label-text">审核通过</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="review_status" value="2">
                                <span class="label-icon"></span>
                                <span class="label-text">审核不通过</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3 text-right">
                            <label class="col-form-label">审核结果</label>
                        </div>
                        <div class="col-9">
                            <textarea class="form-control" name="review_result"><?= $model->review_result ?></textarea>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="form-group row">
                        <div class="col-3 text-right">
                            <label class="col-form-label">审核状态</label>
                        </div>
                        <div class="col-9">
                            <?php if ($model->review_status == 0): ?>
                                <span class="text-muted">待审核</span>
                            <?php elseif ($model->review_status == 1): ?>
                                <span class="text-success">审核通过</span>
                            <?php elseif ($model->review_status == 2): ?>
                                <span class="text-danger">审核未通过</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3 text-right">
                            <label class="col-form-label">审核结果</label>
                        </div>
                        <div class="col-9 form-group-text"><?= $model->review_result ?></div>
                    </div>
                <?php endif; ?>

                <div class="form-group row">
                    <div class="col-3 text-right">
                    </div>
                    <div class="col-9">
                        <a class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
                    </div>
                </div>
            </div>
        </form>

        <div style="display: inline-block;vertical-align: top;width: 45%">
            <div class="form-group row map">
                <div class="offset-2 col-9">
                    <div class="input-group mb-3">
                        <input class="form-control region" type="text" placeholder="城市">
                        <div class="input-group-append">
                            <span class="input-group-text">和</span>
                        </div>
                        <input class="form-control keyword" style="margin-left: -1px;" type="text" placeholder="关键字">
                        <div class="input-group-append">
                            <a class="input-group-text search" href="javascript:void(0)">搜索</a>
                        </div>
                    </div>
                    <div class="text-info">搜索时城市和关键字必填</div>
                    <div class="text-info">点击地图上的蓝色点，获取经纬度</div>
                    <div class="text-danger map-error mb-3" style="display: none">错误信息</div>
                    <div id="container" style="min-width:600px;min-height:600px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var searchService, map, markers = [], geocoder,marker = null;
    //直接加载地图
    //初始化地图函数  自定义函数名init
    function init() {
        var center = new qq.maps.LatLng(22.572282,113.913745);
        map = new qq.maps.Map(document.getElementById('container'),{
            center: center,
            zoom: 13
        });
        var info = new qq.maps.InfoWindow({map: map});

        var latlngBounds = new qq.maps.LatLngBounds();

        var _that = $(this);

        //调用Poi检索类
        searchService = new qq.maps.SearchService({
            complete: function (results) {
                console.log(results);
                var pois = results.detail.pois;
                $('.map-error').hide();
                if (!pois) {
                    $('.map-error').show().html('关键字搜索不到，请重新输入');
                    return;
                }
                for (var i = 0, l = pois.length; i < l; i++) {
                    (function (n) {
                        var poi = pois[n];
                        latlngBounds.extend(poi.latLng);
                        var marker = new qq.maps.Marker({
                            map: map,
                            position: poi.latLng,
                        });

                        marker.setTitle(n + 1);

                        markers.push(marker);
                        //添加监听事件
                        qq.maps.event.addListener(marker, 'click', function (e) {
                            //获取省 市 地区
                            geocoder = new qq.maps.Geocoder({
                                complete:function(result){
                                    var addressComponents = result.detail.addressComponents;
                                    var province = addressComponents.province;
                                    var city = addressComponents.city;
                                    var district = addressComponents.district;
                                    var street = addressComponents.street;
                                    var streetNumber = addressComponents.streetNumber;
                                    var town = addressComponents.town;
                                    var address = street+streetNumber+town;
                                    $("input[name='province']").val(province);
                                    $("input[name='city']").val(city);
                                    $("input[name='district']").val(district);
                                    $("input[name='address']").val(address);
                                }
                            });
                            var coord=new qq.maps.LatLng(e.latLng.lat,e.latLng.lng);
                            geocoder.getAddress(coord);

                            var address = poi.address;
                            // $("input[name='address']").val(address);
                            $("input[name='longitude']").val(e.latLng.lng);
                            $("input[name='latitude']").val(e.latLng.lat);
                        });
                    })(i);
                }
                map.fitBounds(latlngBounds);
            }

        });
    }
    //清除地图上的marker
    function clearOverlays(overlays) {
        var overlay;
        while (overlay = overlays.pop()) {
            overlay.setMap(null);
        }
    }
    function searchKeyword() {
        var keyword = $(".keyword").val();
        var region = $(".region").val();
        clearOverlays(markers);
        searchService.setLocation(region);
        searchService.search(keyword);
    }

    //调用初始化函数地图
    init();
</script>

<script src="<?= Yii::$app->request->baseUrl ?>/new/plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>


<script>
    $(function () {
        $('#header_color').colorpicker();
        $('#mch_color').colorpicker();
    });

    $(document).on('click', '.search', function () {
        searchKeyword();
    })
</script>
