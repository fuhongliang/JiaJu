<?php
defined('YII_ENV') or exit('Access Denied');
$this->title = '新增代理';
$urlManager = Yii::$app->urlManager;
?>
<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="nav nav-tabs-custom">
    <li class="active"><a href="javascript:void(0);">代理管理</a></li>
    <span>/</span>
    <li><?= $this->title ?></li>
</ul>
<?php $this->endBlock(); ?>
<link href="<?= Yii::$app->request->baseUrl ?>/new/plugins/chosen/chosen.min.css" rel="stylesheet">

<div class="pd-white-box">
    <form class="auto-form" method="post"
          action="<?= $urlManager->createUrl('mch/agent/create') ?>">
        <div class="form-group row">
            <div class="form-group-label col-sm-2 text-right">
                <label class="col-form-label required">昵称</label>
            </div>
            <div class="col-sm-6">
                <input class="form-control cat-name" name="nickname">
            </div>
        </div>
        <div class="form-group row">
            <div class="form-group-label col-sm-2 text-right">
                <label class="col-form-label required">用户名</label>
            </div>
            <div class="col-sm-6">
                <input class="form-control cat-name" name="username">
            </div>
        </div>
        <div class="form-group row">
            <div class="form-group-label col-sm-2 text-right">
                <label class="col-form-label required">密码</label>
            </div>
            <div class="col-sm-6">
                <input type="password" class="form-control cat-name" name="password">
            </div>
        </div>

        <div class="form-group row">
            <div class="form-group-label col-sm-2 text-right">
                <label class=" col-form-label required">省份</label>
            </div>
            <div class="col-sm-6">
                <select class="form-control" name="agent_province_id" id="province">
                    <option value="0">请选择省份</option>
                    <?php foreach($province as $k=>$v): ?>
                    <option value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="form-group-label col-sm-2 text-right">
                <label class=" col-form-label required">城市</label>
            </div>
            <div class="col-sm-6">
                <select class="form-control" name="agent_city_id" id="city">
                    <option value="0">请选择城市</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="form-group-label col-sm-2 text-right">
                <label class=" col-form-label required">选择地区</label>
            </div>
            <div class="col-sm-6">
                <select data-placeholder="请选择地区" class="form-control chosen-select" id="district" name="district[]" multiple>
                    <option value="0">请选择地区</option>
                </select>
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

<script src="<?= Yii::$app->request->baseUrl ?>/new/plugins/chosen/chosen.jquery.min.js"></script>
<script>
    $(document).ready(function(evt) {
        var config = {
            '.chosen-select'           : {},
            '.chosen-select-deselect'  : { allow_single_deselect: true },
            '.chosen-select-no-single' : { disable_search_threshold: 10 },
            '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
            '.chosen-select-rtl'       : { rtl: true },
            '.chosen-select-width'     : { width: '95%' }
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    });

    $(document).on("change", "#province", function () {
        var province_id = $('#province').val();
        search_city(province_id);
    });

    $(document).on("change", "#city", function () {
        var city_id = $('#city').val();
        search_district(city_id);
    });

    function search_district(id)
    {
        $.ajax({
            url: "<?=$urlManager->createUrl(['mch/agent/search-district'])?>",
            data: {id: id},
            success: function (res) {
                console.log(res);
                if (res.code == 0) {
                    $('#district').empty();
                    var list = res.data.list;
                    $('#district').append(new Option('请选择地区','0'));
                    for(var i = 0; i < list.length; i++){
                        $("#district").append(new Option(list[i].name,list[i].id));
                    }
                    $("#district").trigger("chosen:updated");
                    $("#district").chosen();
                }
            }
        });
    }


    function search_city(id) {
        console.log(id)
        $.ajax({
            url: "<?=$urlManager->createUrl(['mch/agent/search-district'])?>",
            data: {id: id},
            success: function (res) {
                console.log(res);
                if (res.code == 0) {
                    $('#city').empty();
                    var list = res.data.list;
                    $('#city').append(new Option('请选择城市','0'));
                    for(var i = 0; i < list.length; i++){
                        $("#city").append(new Option(list[i].name,list[i].id));
                    }
                }
            }
        });
    }


</script>