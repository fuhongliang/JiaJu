<?php
defined('YII_ENV') or exit('Access Denied');
$urlManager = Yii::$app->urlManager;
$this->title = '导航设置';
$this->params['active_nav_group'] = 11;
?>
<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">小程序</a></li>
    <span>/</span>
    <li><?= $this->title;?></li>
</ul>
<?php $this->endBlock(); ?>

<style>

    .pd-white-box .nav-item {
        border: 1px solid #eee;
        border-radius: 3px;
        margin: 0 5px 5px 0;
        display: inline-block;
        padding: 6px;
        width: 80px;
        height: 80px;
        overflow: hidden;
        position: relative;
        vertical-align: middle;
    }

    .pd-white-box .nav-item .nav-icon {
        display: block;
        width: 35px;
        height: 35px;
        margin: 0 auto 10px auto;
    }

    .pd-white-box .nav-item .nav-text {
        display: block;
        text-align: center;
        font-size: .75rem;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .pd-white-box .nav-delete,
    .pd-white-box .nav-edit {
        position: absolute;
        bottom: 0;
        color: #fff !important;
        font-size: .75rem;
        width: 50%;
        text-align: center;
        display: block;
        padding: 2px 0;
        visibility: hidden;
        opacity: 0;
        transition: 200ms;

        background: rgba(0, 102, 212, 0.73);
        border-radius: 0 0 0 2px;
        left: 0;
    }

    .pd-white-box .nav-item:hover .nav-delete,
    .pd-white-box .nav-item:hover .nav-edit {
        visibility: visible;
        opacity: 1;
    }

    .pd-white-box .nav-delete {
        background: rgba(255, 69, 68, 0.73);
        border-radius: 0 0 2px 0;
        right: 0;
        left: auto;
    }

    .pd-white-box .nav-add {
        cursor: pointer;
        border: 1px dashed #ccc;
    }

    .pd-white-box .nav-add .iconfont {
        display: block;
        font-size: 46px;
        color: #aaa;
        text-align: center;
    }

    .pd-white-box .nav-add:hover {
        background: #f6f6f6;
    }

    .pd-white-box .navigation-bar {
        text-align: center;
        padding: 8px;
        box-shadow: 0 1px 1px 1px rgba(0, 0, 0, .15);
        max-width: 200px;
    }
    .colorback {
        width:66px;
        height:30px;
        display:inline-block;
    }
</style>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/statics/mch/css/themes.css">

<div class="pd-white-box" id="app">
    <div class="wrap">
        <form class="auto-form" method="post">

            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label required">顶部导航栏</label>
                </div>
                <div class="col-sm-4">
                    <div class="mb-3">
                        <label>文字颜色：</label>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input v-if="navigation_bar_color.frontColor=='#000000'"
                                   checked
                                   value="#000000" id="textColorYes" name="navigation_bar_color[frontColor]" type="radio"
                                   class="custom-control-input">
                            <input v-else
                                   value="#000000" id="radio1" name="navigation_bar_color[frontColor]" type="radio"
                                   class="custom-control-input">
                        <label class="custom-control-label" for="textColorYes">黑色</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input v-if="navigation_bar_color.frontColor=='#ffffff'"
                                   checked
                                   value="#ffffff" id="textColorNo" name="navigation_bar_color[frontColor]" type="radio"
                                   class="custom-control-input">
                            <input v-else
                                   value="#ffffff" id="textColorNo" name="navigation_bar_color[frontColor]" type="radio"
                                   class="custom-control-input">
                            <label class="custom-control-label" for="textColorNo">白色</label>
                        </div>
                    </div>
                    <label>背景颜色：</label>
                    <label class="radio-label">
                        <input name="navigation_bar_color[backgroundColor]"
                               v-model="navigation_bar_color.backgroundColor"
                               class="colorback"
                               v-bind:style="{background:navigation_bar_color.backgroundColor}"
                               data-toggle="modal"
                               data-target="#modalback"
                        >
                    </label>


                </div>
                <div class="col-sm-2">
                    <div class="navigation-bar"
                         :style="'color: '+navigation_bar_color.frontColor+';background: '+navigation_bar_color.backgroundColor">
                        顶部导航栏效果
                    </div>
                </div>
            </div>

            <!-- 模态框（Modal） -->
            <div class="modal fade" id="modalback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="width:333px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span></span>
                            <a type="button" style="float:right" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
                        </div>
                        <div class="modal-body" >
                            <div id="color-picker" class="cp-default"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">选择</button>
                        </div>
                    </div>
                </div>
            </div>

            <div hidden>
                <input name="navbar[background_image]" v-bind:value="navbar.background_image">
                <input name="navbar[border_color]" v-bind:value="navbar.border_color">
            </div>

            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">底部导航图标</label>
                </div>
                <div class="col-sm-6">
                    <div style="display: inline-block" id="sortList">
                        <template v-for="(nav,i) in navbar.navs">
                            <div class="nav-item">
                                <img class="nav-icon" :src="nav.icon">
                                <div class="nav-text" :style="'color:'+nav.color">{{nav.text}}</div>
                                <a class="nav-delete" href="javascript:" :data-index="i">删除</a>
                                <a class="nav-edit" href="javascript:" :data-index="i">编辑</a>
                                <div hidden>
                                    <input :name="'navbar[navs][nav'+i+'][url]'" :value="nav.url">
                                    <input :name="'navbar[navs][nav'+i+'][icon]'" :value="nav.icon">
                                    <input :name="'navbar[navs][nav'+i+'][active_icon]'" :value="nav.active_icon">
                                    <input :name="'navbar[navs][nav'+i+'][text]'" :value="nav.text">
                                    <input :name="'navbar[navs][nav'+i+'][color]'" :value="nav.color">
                                    <input :name="'navbar[navs][nav'+i+'][active_color]'" :value="nav.active_color">
                                    <input :name="'navbar[navs][nav'+i+'][open_type]'" :value="nav.open_type">
                                    <template v-if="nav.open_type == 'wxapp'">
                                        <input :name="'navbar[navs][nav'+i+'][appid]'" :value="nav.appid">
                                        <input :name="'navbar[navs][nav'+i+'][path]'" :value="nav.path">
                                    </template>
                                    <template v-if="nav.open_type == 'tel'">
                                        <input :name="'navbar[navs][nav'+i+'][tel]'" :value="nav.tel">
                                    </template>
                                    <template v-if="nav.open_type == 'web'">
                                        <input :name="'navbar[navs][nav'+i+'][web]'" :value="nav.web">
                                    </template>

                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="nav-item nav-add"><i class="iconfont icon-add"></i></div>
                </div>
            </div>

            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
                    <a class="btn btn-secondary reset-navbar"
                       href="<?= Yii::$app->urlManager->createUrl(['mch/store/navbar-reset']) ?>">恢复默认设置</a>
                </div>
            </div>
        </form>

        <div class="modal fade nav-edit-modal" data-backdrop="static" style="z-index: 1041">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">导航菜单编辑</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group row">
                            <div class="col-sm-4 text-right">
                                <label class="col-form-label required">图标</label>
                            </div>

                            <div class="col-sm-6">
                                <div class="upload-group">
                                    <div class="input-group">
                                        <input class="form-control file-input" name="icon_upload">
                                        <div class="input-group-append">
                                            <a class="btn btn-outline-secondary upload-file" href="javascript:void(0);" title="上传文件"><span class="iconfont icon-shangchuan"></span></a>
                                            <a class="btn btn-outline-secondary select-file" href="javascript:void(0);" title="从文件库选择"><span class="iconfont icon-lishituku"></span></a>
                                            <a class="btn btn-outline-secondary delete-file" href="javascript:void(0);" title="删除文件"><span class="iconfont icon-shanchu"></span></a>
                                        </div>
                                    </div>
                                    <div class="upload-preview text-center upload-preview">
                                        <span class="upload-preview-tip">64&times;64</span>
                                        <img class="upload-preview-img" src="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4 text-right">
                                <label class="col-form-label required">选中状态图标</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="upload-group">
                                    <div class="input-group">
                                        <input class="form-control file-input" name="active_icon_upload">
                                        <div class="input-group-append">
                                            <a class="btn btn-outline-secondary upload-file" href="javascript:void(0);" title="上传文件"><span class="iconfont icon-shangchuan"></span></a>
                                            <a class="btn btn-outline-secondary select-file" href="javascript:void(0);" title="从文件库选择"><span class="iconfont icon-lishituku"></span></a>
                                            <a class="btn btn-outline-secondary delete-file" href="javascript:void(0);" title="删除文件"><span class="iconfont icon-shanchu"></span></a>
                                        </div>
                                    </div>
                                    <div class="upload-preview text-center upload-preview">
                                        <span class="upload-preview-tip">64&times;64</span>
                                        <img class="upload-preview-img" src="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div hidden>
                            <input v-model="editnav.icon">
                            <input v-model="editnav.active_icon">
                            <input v-model="editnav.color">
                            <input v-model="editnav.active_color">
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4 text-right">
                                <label class="col-form-label required">名称</label>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" v-model="editnav.text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4 text-right">
                                <label class="col-form-label required">文字选中颜色</label>
                            </div>
                            <div class="col-sm-8 col-form-label">
                                <input v-model="editnav.active_color" class="colorback" v-bind:style="{background:editnav.active_color}"></input>
                                <div id="color-edit-picker" class="cp-default"></div>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4 text-right">
                                <label class="col-form-label required">页面</label>
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control editnav-url" v-model="editnav.url">
                                    <template v-for="(page,i) in pages">
                                        <option :value="page.url" :data-index="page.open_type" v-if="editnav && editnav.url==page.url" selected>
                                            {{page.name}}
                                        </option>
                                        <option :value="page.url" :data-index="page.open_type" v-else>{{page.name}}</option>
                                    </template>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" v-if="editnav.open_type == 'tel'">
                            <div class="col-sm-4 text-right">
                                <label class="col-form-label required">联系电话</label>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" v-model="editnav.tel">
                            </div>
                        </div>
                        <template v-if="editnav.open_type == 'wxapp'">
                            <div class="form-group row">
                                <div class="col-sm-4 text-right">
                                    <label class="col-form-label required">小程序appid</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" v-model="editnav.appid">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4 text-right">
                                    <label class="col-form-label required">跳转路径</label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" v-model="editnav.path">
                                    <div class="fs-sm">打开的页面路径，如pages/index/index，开头请勿加“/”</div>
                                </div>
                            </div>
                        </template>
                        <div class="form-group row" v-if="editnav.open_type == 'web'">
                            <div class="col-sm-4 text-right">
                                <label class="col-form-label required">外链网址</label>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" v-model="editnav.web">
                                <div class="fs-sm">打开的网页链接（注：域名必须已在微信官方小程序平台设置业务域名）</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary save-nav">确认</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/js/Sortable.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/js/colorpicker.js"></script>
<script>
    String.prototype.changeRgbColorToHex = function(){
        var that = this;
        var reg = /^rgb\((\s*[1-2]?[0-9]?[0-9]{1}\,)(\s*[1-2]?[0-9]?[0-9]{1}\,)(\s*[1-2]?[0-9]?[0-9]{1})\)$/;
        if (reg.test(that)){
            var matches = reg.exec(that);
            var hexColor = '#';
            for (var i = 1; i <= 3; i++){
                if (parseInt(matches[i]) < 16){
                    hexColor += '0' + parseInt(matches[i]).toString(16)
                }else{
                    hexColor += parseInt(matches[i]).toString(16);
                }
            }
        }
        return hexColor;
    }
</script>
<script>

    var editnav = {
        index: null,
        url: '',
        icon: '',
        active_icon: '',
        text: '',
        color: '#888',
        active_color: '#ff4544',
        open_type: 'redirect',
    };
    var app = new Vue({
        el: '#app',
        data: {
            navbar: false,
            navigation_bar_color: false,
            editnav: editnav,
            pages: [
                {
                    name: "装修方案列表",
                    url: "/pages/discover/discover",
                },
                {
                    name: "发布图文",
                    url: "/pages/publich-graphic/publich-graphic",
                    open_type:'navigate'
                },
                {
                    name: '首页',
                    url: '/pages/index/index',
                },
                {
                    name: '分类列表',
                    url: '/pages/cat/cat',
                },
                {
                    name: '套餐包-分类',
                    url: '/pages/cat/cat',
                },
                {
                    name: '购物车',
                    url: '/pages/cart/cart',
                },
                {
                    name: '用户中心',
                    url: '/pages/user/user',
                },
                {
                    name: '商品列表',
                    url: '/pages/list/list',
                },
                {
                    name: '搜索',
                    url: '/pages/search/search',
                },
                {
                    name: '专题',
                    url: '/pages/topic-list/topic-list',
                },
                {
                    name: '视频专区',
                    url: '/pages/video/video-list',
                },
                {
                    name: '秒杀',
                    url: '/pages/miaosha/miaosha',
                },
                {
                    name: '附近门店',
                    url: '/pages/shop/shop',
                },
                {
                    name: '拼团',
                    url: '/pages/pt/index/index',
                },
                {
                    name: '预约',
                    url: '/pages/book/index/index',
                },
                {
                    name: '分销中心',
                    url: '/pages/share/index',
                },
                {
                    name: '快速购买',
                    url: '/pages/quick-purchase/index/index',
                },
                {
                    name: '一键拨号',
                    url: 'tel',
                    open_type:'tel'
                },
                {
                    name: '小程序',
                    url: 'wxapp',
                    open_type:'wxapp'
                },
                {
                    name: '客服',
                    url: 'contact',
                    open_type:'contact'
                },
                {
                    name: '外链',
                    url: 'web',
                    open_type:'web'
                },
                {
                    name: '好店推荐',
                    url: '/mch/shop-list/shop-list',
                },
                {
                    name: '入驻商',
                    url: '/mch/m/myshop/myshop',
                },
                {
                    name: '积分商城',
                    url: '/pages/integral-mall/index/index',
                },
                {
                    name: '签到',
                    url: '/pages/integral-mall/register/index',
                },
            ],
        },
    });


  var ec = ColorPicker(
    document.getElementById('color-edit-picker'),
    function(hex, hsv, rgb) {
      var eRgb = 'rgb('+rgb.r+','+rgb.g+','+rgb.b+')';
      var eHexColor = eRgb.changeRgbColorToHex();
      app.editnav.active_color=eHexColor;
    });


  var c = ColorPicker(
    document.getElementById('color-picker'),
    function(hex, hsv, rgb) {
      var sRgb = 'rgb('+rgb.r+','+rgb.g+','+rgb.b+')';
      var hexColor = sRgb.changeRgbColorToHex();
      app.navigation_bar_color['backgroundColor']=hexColor;
    });


    $.loading();
    $.ajax({
        dataType: 'json',
        success: function (res) {
            $.loadingHide();
            if (res.code == 0) {
                app.navbar = res.data.navbar;
                app.navigation_bar_color = res.data.navigation_bar_color;
                c.setHex(res.data.navigation_bar_color.backgroundColor);
                setTimeout(function () {
                    Sortable.create(document.getElementById('sortList'), {
                        animation: 150,
                    }); // That's all.
                }, 300);
            }
        }
    });

    $(document).on('click', '.reset-navbar', function () {
        var href = $(this).attr('href');
        $.confirm({
            content: '确认恢复默认配置？',
            confirm: function () {
                location.href = href;
            }
        });
        return false;
    });

    $(document).on('change', 'input[name="navigation_bar_color[frontColor]"]', function () {
        app.navigation_bar_color.frontColor = this.value;
    });

    $(document).on('click', '.nav-add', function () {
        app.editnav = editnav;
        $('input[name=icon_upload]').val('');
        $('input[name=icon_upload]').parents('.upload-group').find('.upload-preview-img').attr('src', '');
        $('input[name=active_icon_upload]').val('');
        $('input[name=active_icon_upload]').parents('.upload-group').find('.upload-preview-img').attr('src', '');
        $('.nav-edit-modal').modal('show');
    });

    $(document).on('click', '.nav-delete', function () {
        var index = parseInt($(this).attr('data-index'));
        app.navbar.navs.splice(index, 1);
    });

    $(document).on('click', '.nav-edit', function () {
        var index = parseInt($(this).attr('data-index'));
        app.editnav = JSON.parse(JSON.stringify(app.navbar.navs[index]));
        app.editnav.index = index;
        /////
        ec.setHex(app.editnav.active_color);
        $('input[name=icon_upload]').val(app.editnav.icon);
        $('input[name=icon_upload]').parents('.upload-group').find('.upload-preview-img').attr('src', app.editnav.icon);
        $('input[name=active_icon_upload]').val(app.editnav.active_icon);
        $('input[name=active_icon_upload]').parents('.upload-group').find('.upload-preview-img').attr('src', app.editnav.active_icon);
        $('.nav-edit-modal').modal('show');
    });

    $(document).on('change', 'input[name=icon_upload]', function () {
        app.editnav.icon = this.value;
    });

    $(document).on('change', 'input[name=active_icon_upload]', function () {
        app.editnav.active_icon = this.value;
    });
    $(document).on('click', '.save-nav', function () {
        var new_nav = {
            url: app.editnav.url,
            icon: app.editnav.icon,
            active_icon: app.editnav.active_icon,
            text: app.editnav.text,
            color: app.editnav.color,
            active_color: app.editnav.active_color,
            open_type: app.editnav.open_type,
        };

        if(new_nav.open_type == 'wxapp'){
            new_nav.appid = app.editnav.appid;
            new_nav.path = app.editnav.path;
        }
        if(new_nav.open_type == 'tel'){
            new_nav.tel = app.editnav.tel;
        }
        if(new_nav.open_type == 'web'){
            new_nav.web = app.editnav.web;
        }
        if (app.editnav.index !== null) {
            Vue.set(app.navbar.navs, app.editnav.index, new_nav)
        } else {
            app.navbar.navs.push(new_nav);
        }

        $('.nav-edit-modal').modal('hide');
    });
    $(document).on('change','.editnav-url',function(){
        var open_type = $($(this).children('option:selected')).data('index');
        app.editnav.open_type = open_type;
    });
</script>
