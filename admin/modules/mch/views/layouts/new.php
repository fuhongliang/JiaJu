<?php
defined('YII_ENV') or exit('Access Denied');

use app\models\AdminPermission;
$urlManager = Yii::$app->urlManager;
$this->params['active_nav_group'] = isset($this->params['active_nav_group']) ? $this->params['active_nav_group'] : 0;
$version = hj_core_version();

$admin = null;
$admin_permission_list = [];
if (!Yii::$app->admin->isGuest) {
    $admin = Yii::$app->admin->identity;
    $admin_permission_list = json_decode($admin->permission, true);
    if (!$admin_permission_list)
        $admin_permission_list = [];
} else {
    $admin = true;
    $admin_permission_list = $this->context->we7_user_auth;
}
try {
    $plugin_list = \app\hejiang\CloudPlugin::getInstalledPluginList();
} catch (Exception $e) {
    $plugin_list = [];
}
$new = false;

$current_url = Yii::$app->request->absoluteUrl;
$key = 'addons/';
$we7_url = mb_substr($current_url, 0, stripos($current_url, $key));
$this->beginPage();
?>

<!doctype html>
<html lang="zh-CN">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/new/iconfont/iconfont.css?v=2224222">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/new/plugins/bootstrap-4.3.1/css/bootstrap.css">
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/new/css/theme.css">
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/new/css/style.css">
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/new/css/navbar.css">

    <link rel="icon" href="data:image/ico;base64,aWNv">

    <!--新图标 -->
    <link href="//at.alicdn.com/t/font_1464739_mcnj31hh4a.css" rel="stylesheet">
    <!-- 原本文件 -->
    <link href="<?= Yii::$app->request->baseUrl ?>/statics/new/jquery-ui/jquery-ui.css" rel="stylesheet">
    <link href="<?= Yii::$app->request->baseUrl ?>/statics/mch/css/jquery.datetimepicker.min.css" rel="stylesheet">
    <link href="<?= Yii::$app->request->baseUrl ?>/statics/css/flex.css?version=<?= $version ?>" rel="stylesheet">

    <!--文件上传-->
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/new/css/file_upload.css">

    <!-- 原本文件 -->
    <script>var _csrf = "<?=Yii::$app->request->csrfToken?>";</script>
    <script>var _upload_url = "<?=Yii::$app->urlManager->createUrl(['upload/file'])?>";</script>
    <script>var _upload_file_list_url = "<?=Yii::$app->urlManager->createUrl(['mch/store/upload-file-list'])?>";</script>
    <script>var _district_data_url = "<?=Yii::$app->urlManager->createUrl(['api/default/district', 'store_id' => $this->context->store->id])?>";</script>
    <script>var CLODOP_URL = "<?= Yii::$app->request->baseUrl ?>/statics/mch/js/Lodop.js"</script>


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= Yii::$app->request->baseUrl ?>/new/plugins/jquery-3.4.0.min.js"></script>

    <!-- 新增两个 -->
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/new/jquery-ui/jquery-ui.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/new/tether-1.3.3/dist/js/tether.min.js"></script>

    <script src="<?= Yii::$app->request->baseUrl ?>/new/plugins/popper-1.14.7.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/new/plugins/bootstrap-4.3.1/js/bootstrap.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/new/js/common.js"></script>

    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/js/vue.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/js/tether.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/js/plupload.full.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/js/jquery.datetimepicker.full.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/js/common.js?version=<?= $version ?>"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/js/common.v2.js?version=<?= $version ?>"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/js/clipboard.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/vendor/layer/layer.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/statics/mch/vendor/laydate/laydate.js"></script>
    <title><?= $this->title ?></title>
</head>
<body class="hasLeft">
<?php $this->beginBody() ?>
<?= $this->render('/components/pick-link.php') ?>
<?= $this->render('/components/pick-file.php') ?>
<!-- 文件选择模态框 Modal -->
<div class="modal fade" id="file_select_modal_1" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="panel">
            <div class="panel-header">
                <span>选择文件</span>
                <a href="javascript:" class="panel-close" data-dismiss="modal">&times;</a>
            </div>
            <div class="panel-body">
                <div class="file-list"></div>
                <div class="file-loading text-center" style="display: none">
                    <img style="height: 1.14286rem;width: 1.14286rem" src="<?= Yii::$app->request->baseUrl ?>/statics/images/loading-2.svg">
                </div>
                <div class="text-center">
                    <a style="display: none" href="javascript:" class="file-more">加载更多</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- 地区选择模态框 -->
<div class="modal" tabindex="-1" role="dialog" id="district_pick_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">选择地区</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="districtProvince">省</label>
                            </div>
                            <select v-model="province_id" v-on:change="provinceChange" class="form-control custom-select" id="districtProvince">
                                <option :value="item.id" v-for="(item,index) in province_list">{{item.name}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="districtCity">市</label>
                            </div>
                            <select v-model="city_id" v-on:change="cityChange" class="form-control" id="districtCity">
                                <option :value="item.id" v-for="(item,index) in city_list">{{item.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="districtOther">县/区</label>
                            </div>
                            <select v-model="district_id" v-on:change="districtChange" class="form-control" id="districtOther">
                                <option :value="item.id" v-for="(item,index) in district_list">{{item.name}}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary district-confirm-btn" href="javascript:void(0);">确定</a>
            </div>
        </div>
    </div>
</div>

<?php
$menu_list = $this->context->getMenuList();
$route = Yii::$app->requestedRoute;
$current_menu = getCurrentMenu($menu_list, $route);
//var_dump($current_menu);die;
function activeMenu($item, $route)
{
    if (isset($item['route']) && ($item['route'] == $route)) {
        return 'active';
    }
    if (isset($item['sub'])) {
        foreach ($item['sub'] as $i) {
            if (isset($i['route']) && $route == $i['route']) {
                return 'active';
            }
        }
    }
    if (isset($item['children']) && is_array($item['children'])) {
        foreach ($item['children'] as $sub_item) {
            $active = activeMenu($sub_item, $route);
            if ($active != '')
                return $active;
        }
    }
    return '';
}

function currentMenu($item, $route)
{
    if (isset($item['route']) && ($item['route'] == $route)) {
        return 'current';
    }
    if (isset($item['sub'])) {
        foreach ($item['sub'] as $i) {
            if (isset($i['route']) && $route == $i['route']) {
                return 'current';
            }
        }
    }
    if (isset($item['children']) && is_array($item['children'])) {
        foreach ($item['children'] as $sub_item) {
            $active = currentMenu($sub_item, $route);
            if ($active != '')
                return $active;
        }
    }
    return '';
}

function getCurrentMenu($menu_list, $route, $return = [], $level = 0)
{
    foreach ($menu_list as $item) {
        if ($level == 0) {
            $return = $item;
        }
        if (isset($item['route'])) {
            if ($item['route'] == $route) {
                return $return;
            }

            if (isset($item['sub'])) {
                foreach ($item['sub'] as $k => $i) {
                    if ($i['route'] == $route) {
                        return $return;
                    }
                }
            }
        }
        if (isset($item['children']) && is_array($item['children'])) {
            $aa = getCurrentMenu($item['children'], $route, $return, $level + 1);
            if ($aa) {
                return $aa;
            }
        }
    }
    return null;
}

?>
<!--  左边菜单栏 -->
<div class="left-fixed-nav">
    <nav class="admin-sideNav-first">
        <div class="logo-box" id="logo-box">
            <img src="<?= Yii::$app->request->baseUrl ?>/new/image/logo.png" alt="">
        </div>
        <ul class="sideNav-menu">
            <?php foreach ($menu_list as $item): ?>
            <li class="<?= activeMenu($item, $route) ?>">
                <a href="javascript:void(0);" onclick='window.location.href ="<?= $urlManager->createUrl($item['route']) ?>"'>
                    <span class="nav-icon <?= $item['icon'] ?>"></span><?= $item['name'] ?></a>
                <div class="admin-sideNav-second">
                    <ul class="sideNav-menu id_menu">
                         <?php if ($current_menu && count($current_menu['children'])): ?>
                             <?php foreach ($current_menu['children'] as $secondItem): ?>
                                 <li class="<?= currentMenu($secondItem, $route) ?>"><a href="<?= $urlManager->createUrl($secondItem['route']) ?>"><?= $secondItem['name'] ?></a></li>
                             <?php endforeach; ?>
                        <?php endif;?>
                    </ul>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</div>

<!-- 右边内容 -->
<div class="content">
    <nav class="navbar navbar-expand navbar-light topbar mb-4">
        <?= $this->blocks['breadcrumbs'] ?>
        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1" hidden>
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon iconfont icon-tongzhi"></i>
                    <!-- Counter - Alerts -->
                    <span class="badge badge-danger badge-counter">3+</span>
                </a>
                <!-- Dropdown - Alerts -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Alerts Center
                    </h6>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3"><div class="icon-circle bg-primary"><i class="fas fa-file-alt text-white"></i></div></div>
                        <div>
                            <div class="small text-gray-500">December 12, 2019</div>
                            <span class="font-weight-bold">A new monthly report is ready to download!</span>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-success">
                                <i class="fas fa-donate text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 7, 2019</div>
                            $290.29 has been deposited into your account!
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-warning">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 2, 2019</div>
                            Spending Alert: We've noticed unusually high spending for your account.
                        </div>
                    </a>
                    <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1" hidden>
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon iconfont icon-xinxi"></i>
                    <!-- Counter - Messages -->
                    <span class="badge badge-danger badge-counter">7</span>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">
                        Message Center
                    </h6>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="image/logo.png" alt="">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                            <div class="small text-gray-500">Emily Fowler · 58m</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="image/logo.png" alt="">
                            <div class="status-indicator"></div>
                        </div>
                        <div>
                            <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                            <div class="small text-gray-500">Jae Chun · 1d</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="image/logo.png" alt="">
                            <div class="status-indicator bg-warning"></div>
                        </div>
                        <div>
                            <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                            <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="image/logo.png" alt="">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div>
                            <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                            <div class="small text-gray-500">Chicken the Dog · 2w</div>
                        </div>
                    </a>
                    <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                        <?php if (Yii::$app->mchRoleAdmin->identity->nickname): ?>
                        <?= Yii::$app->mchRoleAdmin->identity->nickname ?>
                        <?php else: ?>
                        <?= $this->context->store->name ?>
                        <?php endif; ?>
                    </span>
                    <img class="img-profile rounded-circle" src="<?= Yii::$app->request->baseUrl ?>/new/image/logo.png">
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <?php if (Yii::$app->user->isGuest == false): ?>
                        <a class="dropdown-item" href="<?= Yii::$app->urlManager->createUrl(['mch/passport/logout']) ?>">返回系统</a>
                    <?php elseif(Yii::$app->admin->id === 1): ?>
                        <a class="dropdown-item" href="<?= Yii::$app->urlManager->createUrl(['mch/passport/logout']) ?>">返回系统</a>
                    <?php elseif (Yii::$app->admin->isGuest === false): ?>
                        <a class="dropdown-item"
                           href="<?= Yii::$app->urlManager->createUrl(['admin/passport/logout']) ?>">退出登录</a>
                    <?php else: ?>
                        <a class="dropdown-item"
                           href="<?= Yii::$app->urlManager->createUrl(['mch/permission/passport/logout']) ?>">退出登录</a>
                    <?php endif; ?>
                </div>
            </li>
        </ul>
    </nav>

    <?= $content ?>
</div>

<script>
    var checkUrl = "<?=Yii::$app->urlManager->createUrl(['mch/get-data/order'])?>";


    var sound = "<?=Yii::$app->request->baseUrl . '/statics/'?>/5611.wav";

    function playSound(id) {
        var borswer = window.navigator.userAgent.toLowerCase();
        if (borswer.indexOf("ie") >= 0) {
            //IE内核浏览器
            var strEmbed = '<embed name="embedPlay" src="' + sound + '" autostart="true" hidden="true" loop="false"></embed>';
            if ($("body").find("embed").length <= 0)
                $("body").append(strEmbed);
            var embed = document.embedPlay;

            //浏览器不支持 audion，则使用 embed 播放
            embed.volume = 100;
        } else {
            //非IE内核浏览器
            var strAudio = "<audio id='audioPlay' src='" + sound + "' hidden='true'>";
            if ($("body").find("audio").length <= 0)
                $("body").append(strAudio);
            var audio = document.getElementById("audioPlay");

            //浏览器支持 audion
            audio.play();
        }
    }

    function is_index(indexOf, list) {
        for (var i = 0; i < list.length; i++) {
            if (indexOf == list[i]) {
                return true;
            }
        }
        return false;
    }

    // 订单消息
    function checkmessage() {
        $.ajax({
            url: checkUrl,
            type: 'get',
            dataType: 'json',
            success: function (res) {
                var sound_list = JSON.parse(localStorage.getItem('sound_list'));
                if (!sound_list) {
                    sound_list = [];
                }
                if (res.code == 0) {
                    var count = res.data.length;
                    if (count == 0) {
                        return;
                    }
                    $('.message-list').empty();

                    for (var i = 0; i < count; i++) {
                        $('.message-list').prop('hidden', false);
                        $('.totalNum').prop('hidden', false).html(count);
                        var type = res.data[i].type;
                        var order_type = res.data[i].order_type;
                        if (order_type == 4) {
                            var html = "<a target='_blank' class='dropdown-item' data-index='" + res.data[i].id + "' href='" + res.data[i].url + "'>" + res.data[i].name + "申请商品上架</a>";
                        } else {
                            if (type == 0) {
                                var html = "<a target='_blank' class='dropdown-item' data-index='" + res.data[i].id + "' href='" + res.data[i].url + "'>" + res.data[i].name + "下了一个订单</a>";
                            } else {
                                var html = "<a target='_blank' class='dropdown-item' data-index='" + res.data[i].id + "' href='" + res.data[i].url + "'>" + res.data[i].name + "一个售后订单</a>";
                            }
                        }

                        $('.message-list').append(html);

                        if (res.data[i].is_sound == 0 && !is_index(res.data[i].id, sound_list)) {
                            sound_list.push(res.data[i].id);
                            playSound(res.data[i].id);
                        }

                    }
                    localStorage.setItem('sound_list', JSON.stringify(sound_list));
                    $('.message-list').append("<a class='dropdown-item' style='text-align:center' href='<?=Yii::$app->urlManager->createUrl(['mch/store/order-message', 'status' => 1])?>'>全部消息</a>");
                }
            }
        });
    }

    $(document).ready(function () {
        $('.message').hover(function () {
            $('.message-list').show();
        }, function () {
            $('.message-list').hide();
        });
        $('.message-list').on('click', 'a', function () {
            var num = $('.totalNum');
            num.text(num.text() - 1);
            if (num.text() == 0) {
                num.prop('hidden', true);
                $('.message-list').prop('hidden', true)
            }
            $.ajax({
                url: '<?=Yii::$app->urlManager->createUrl(['mch/get-data/message-del'])?>',
                type: 'get',
                dataType: 'json',
                data: {
                    'id': $(this).data('index')
                },
                success: function (res) {
                    if (res.code == 0) {
                        window.location.href = $(this).data('url');
                    }
                }
            });
            $(this).remove();
        });
        setInterval(function () {
            checkmessage();
        }, 30000);
    });

    /*
     * 获取浏览器竖向滚动条宽度
     * 首先创建一个用户不可见、无滚动条的DIV，获取DIV宽度后，
     * 再将DIV的Y轴滚动条设置为永远可见，再获取此时的DIV宽度
     * 删除DIV后返回前后宽度的差值
     *
     * @return    Integer     竖向滚动条宽度
     **/
    function getScrollWidth() {
        var noScroll, scroll, oDiv = document.createElement("DIV");
        oDiv.style.cssText = "position:absolute; top:-1000px; width:100px; height:100px; overflow:hidden;";
        noScroll = document.body.appendChild(oDiv).clientWidth;
        oDiv.style.overflowY = "scroll";
        scroll = oDiv.clientWidth;
        document.body.removeChild(oDiv);
        return noScroll - scroll;
    }

    if ($('.sidebar-content')) {
        $('.sidebar-content').css('width', ($('.sidebar-content').width() + getScrollWidth()) + 'px');
    }


    $(document).on("click", "body > .sidebar .sidebar-2 .nav-item", function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        } else {
            $(this).addClass('active');
        }
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip({
            animation: false,
        })
    });

    $(document).on("click", ".input-hide .tip-block", function () {
        $(this).hide();
    });


    $(document).on("click", ".input-group .dropdown-item", function () {
        var val = $.trim($(this).text());
        $(this).parents(".input-group").find(".form-control").val(val);
    });

    //图片库vue对象
    var file_app;
</script>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
