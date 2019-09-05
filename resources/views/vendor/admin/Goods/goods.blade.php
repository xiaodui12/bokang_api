@extends('admin::base', ['header' => $header,"description"=>$description,"breadcrumb"=>$breadcrumb])

@section('content_info')

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">编辑</h3>
                        <div class="box-tools">

                            <div class="btn-group pull-right" style="margin-right: 5px">
                                <a href="/admin/goods" class="btn btn-sm btn-default" title="列表"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;列表</span></a>
                            </div>
                        </div>
                    </div>

                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="form" method="post" accept-charset="UTF-8" class="form-horizontal" >

                        <div class="box-body">

                            <div class="fields-group">
                                @foreach($form_info as $key=>$value)
                                    @if($value["type"]== "html")
                                        {!! $value["html"] !!}
                                    @elseif($value["type"]== "sku")
                                        <div class="form-group ">
                                            <label class="col-sm-2  control-label">商品规格</label>
                                            <div class="col-sm-8">
                                                <a id="add_multi_sku" class="item_add_sku_btn">添加多级型号</a>

                                                <div class="sku_guige">
                                                    <div>商品规格</div>
                                                    <!---下列存放动态生成的商品规格：颜色，尺码等-->
                                                    <div class="sku_modellist">
                                                    </div>
                                                </div>
                                                <!---此处为动态生成的表格内容-->
                                                <div class="sku_table">
                                                    <!--表格头部-->
                                                    <div class="sku_tableHead clearfix">
                                                    </div>
                                                    <!---表格内信息--->
                                                    <div class="sku_tablecell"></div>
                                                </div>
                                            </div>
                                        </div>

                                    @elseif($value["type"]== "image")
                                        <div class="form-group" id="image_{{$value['name']}}">
                                            <label class="col-sm-2  control-label">{{$value["label"]}}</label>
                                            <div class="col-sm-8">
                                                @uploader(['name' => $value["name"], 'max' => 5, 'accept' => 'jpg,png,gif'])
                                            </div>
                                        </div>
                                        <script>
                                            var list=JSON.parse('<?php echo (!empty($value["value"])&&!empty($value["value"][$value["name"]]))?json_encode($value["value"][$value["name"]]):"[]"?>');


                                            for(var i in list){
                                                var html="";
                                                 html= $("<div>");
                                                html.attr("id","WU_FILE_"+i);
                                                html.addClass("img-item");
                                                html.append($("<div>").addClass("delete"));
                                                html.append($("<img>").addClass("img").attr("src",list[i]));
                                                html.append($("<div>").addClass("wrapper").css("display","none"));
                                                html.append($("<input>").attr("type","hidden").attr("name",'{{$value["name"]}}'+"[]").val(list[i]));


                                                    $("#image_{{$value['name']}}").find(".picker").before(html);


                                            }

                                        </script>
                                    @else
                                        @include($value["model"],$value)
                                    @endif
                                @endforeach


                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}"><div class="col-md-2">
                            </div>

                            <div class="col-md-8">

                                <div class="btn-group pull-right">
                                    <button type="submit" class="btn btn-primary">提交</button>
                                </div>

                                <label class="pull-right" style="margin: 5px 10px 0 0;">
                                    <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" class="after-submit" name="after-save" value="1" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> 继续编辑
                                </label>
                                <label class="pull-right" style="margin: 5px 10px 0 0;">
                                    <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" class="after-submit" name="after-save" value="2" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> 继续创建
                                </label>
                                <label class="pull-right" style="margin: 5px 10px 0 0;">
                                    <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" class="after-submit" name="after-save" value="3" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> 查看
                                </label>

                                <div class="btn-group pull-left">
                                    <button type="reset" class="btn btn-warning">重置</button>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>

            </div></div>

    </section>



    <script type="text/javascript" src="/demo/goods_sku/layer.js"></script>
    @uploader('assets')
    <link rel="stylesheet" href="/demo/goods_sku/skin/default/layer.css" />
    <style>
        a {
            cursor: pointer;
            background: #F5F5F5;
        }

        a:hover {
            border-color: #BBB5B5;
        }

        * {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
        }

        .sku_btns a {
            background: #1EACEA;
            color: #FFFFFF;
            padding: 5px 10px;
        }

        input {
            outline: none;
        }

        span {
            display: inline-block;
        }

        .clearfix:after {
            content: "";
            display: block;
            height: 0;
            clear: both;
        }
        /****商品规格***/

        .sku_guige {
            margin-top: 20px;
            display: none;
        }

        .sku_modellist_title {
            font-size: 14px;
            margin-top: 20px;
        }
        /**********表格sku************/

        .sku_table {
            margin-top: 15px;
            border: 1px solid #dfdfdf;
            text-align: center;
            min-height: 320px;
            display: none;
        }

        .sku_table input {
            width: 100px;
        }

        .sku_tableHead {
            background: #F5F5F5;
            height: 40px;
            border-bottom: 1px solid #dfdfdf;
        }

        .sku_t_title {
            float: left;
            width: 120px;
            padding: 5px 0;
            margin-top: 7px;
            border-right: 1px solid #dfdfdf;
        }

        .sku_cell {
            border-bottom: 1px solid #DFDFDF;
        }
        /*****弹窗中间部分内容*****/

        .sku_content {
            padding: 25px 20px;
            display: none;
        }

        .sku_add {
            margin-top: 20px;
            height: 36px;
            font-size: 14px;
        }

        .sku_list {
            font-size: 0;
            margin-top: 15px;
        }

        .sku_item {
            margin-top: 20px;
        }

        .sku_list a {
            padding: 7px 20px;
            border: 1px solid #d7d7d7;
            border-radius: 5px;
        }

        .sku_list span {
            position: relative;
            font-size: 16px;
            margin-right: 20px;
        }

        .sku_list .itemactive {
            background: #2AC845;
            color: #fff;
        }

        .sku_list .sku_item_close {
            display: none;
            position: absolute;
            right: -10px;
            top: -15px;
            height: 20px;
            width: 20px;
            background: rgba(0, 0, 0, .5);
            color: #FFF;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
            font-style: normal;
            cursor: pointer;
        }

        .sku_add input {
            height: 34px;
            padding: 5px;
            width: 210px;
            border: 1px solid #dfdfdf;
            float: left;
            border-right: none;
        }

        .sku_add a {
            background: #F5F5F5;
            height: 34px;
            text-align: center;
            display: inline-block;
            min-width: 80px;
            padding-top: 10px;
            border: 1px solid #DFDFDF;
        }

        .layui-layer-btn .layui-layer-btn0 {
            background: #f1f1f1;
            border-color: #DEDEDE;
            color: #000;
        }

        .layui-layer-btn .layui-layer-btn1 {
            background: #4898d5;
            border-color: #4898d5;
            color: #fff;
        }
    </style>




    <!---弹窗中间内容-->
    <div class="sku_content">
        <div class="sku_list sku_content_sku_list">

        </div>
        <div class="sku_add"><input type="text" placeholder="请输入商品型号" class="sku_input">
            <a id="sku_addbtn">新建</a>
        </div>
    </div>
    <script>


        var sizes = JSON.parse('<?php echo  empty($detail['sizes'])?'{}':$detail['sizes']?>');
        var sizesList = JSON.parse('<?php echo empty($detail['sizesList'])?'{}':$detail['sizesList']?>');
        var tabledata =JSON.parse('<?php echo empty($detail['tabledata'])?'{}':$detail['tabledata']?>');
        var selectedArr = JSON.parse('<?php echo empty($detail['selectedArr'])?'{}':$detail['selectedArr']?>');
        var sku = JSON.parse('<?php echo empty($sku)?'[]':$sku?>');
        var hasdid = {};
        var hastext = [];

        function load_sku()
        {
            var nametitle=[];
            for(var i in sizesList){

                $(".sku_content_sku_list").append("<span class=\"sku_item\"><a id=\""+i+"\" data-id=\""+i+"\" class=\"itemactive\">"+sizesList[i]["name"]+"</a><i class=\"sku_item_close\" style=\"display: none;\">×</i></span>");
                nametitle.push(sizesList[i]["name"]);

                sizes[sizesList[i]['name']]=[];
                var child=sizesList[i]["child"];
                new Skumodel(sizesList[i]['name'], child, sizesList[i]['id'])
                for(var c_i in child){
                    sizes[sizesList[i]['name']].push(child[c_i]["name"])
                }
                $(".sku_guige").show();
                $(".sku_table").show();
            }

            for(var j in selectedArr){
                for(var k in selectedArr[j]){
                    $(".sku_list").find("#"+selectedArr[j][k].dataid).addClass("itemactive")
                }
            }
            tableContent();
            createTablehead(nametitle);

            for(var i in sku){
                $(".name_"+sku[i]["code"]).val(sku[i]["name"]);
                $(".price_"+sku[i]["code"]).val(sku[i]["price"]);
                $(".sku_"+sku[i]["code"]).val(sku[i]["sku"]);
            }


        }
        /***
         * Skumodel 为生成规格类
         * title为规格名字  string  例：尺码
         * times将要生成的规格项目  Array  例如：尺码：xxl,xl,m,s
         * dataid为产生型号的标识最外层元素上的id   string
         * **/
        var Skumodel = function(title, items, dataid) {
            //最外层div+标题栏
            this.title = title || "";
            this.items = items || [];


            this.container=$("<div>").addClass("sku_container").attr("id",dataid);

            var sku_modellist_title=$("<div>").addClass("sku_modellist_title").html(this.title+" :")
            this.container.append(sku_modellist_title);

            //模型列表
            this.skumodels = $('<div>').addClass("sku_models");
            this.skumlist = $('<div>').addClass("sku_list")
            this.skuinputcon = $('<div>').addClass("sku_add");
            //输入框
            this.skuinput = $('<input type="text" placeholder="请输入型号属性">');
            //新建按钮
            this.addbtn = $('<a>').html("新建");
            this.init(this.items)
        }
        Skumodel.prototype = {
            //初始化显示组件
            init: function(items) {
                var html = "";
                for(var i = 0; i < items.length; i++)
                {
                    var value=items[i];
                    var id=getIndex();
                    if(items[i].name){
                        id=items[i].id;
                        value=items[i].name;
                    }
                    html += '<span class="sku_item"><a  id="'+id+'" data-id="' + id + '">' + value + '<\/a><i class="sku_item_close">×<\/i><\/span>';
                }
                //获取所有生成按钮
                this.skumlist.append($(html))
                this.skumodels.append(this.skumlist)
                this.container.append(this.skumodels)
                this.skuinputcon.append(this.skuinput)
                this.skuinputcon.append(this.addbtn)
                this.skumodels.append(this.skuinputcon)
                $(".sku_modellist").append(this.container);
                this.bindEvent()
            },
            bindEvent: function() {
                var self = this;
                //点击新建按钮产生
                this.addbtn.click(function() {
                    self.createItem();
                });
                //点击删除按钮删除
                this.deleteItem();
                //控制删除符号
                this.toggleCloseEle();
            },
            //创建sku子元素
            createItem: function() {
                var value=$.trim(this.skuinput.val());
                if(value.length <= 0) {
                    layer.alert("请输入内容");
                    return
                }
                var pid=this.container[0].id;

                var id=getIndex();

                if(sizes[this.title].indexOf(value)>=0){
                    layer.msg("请勿重复创建")
                    return;
                }
                sizes[this.title].push(this.skuinput.val());
                if( !sizesList[pid]){
                    sizesList[pid]={"name":this.title,id:pid,child:[]}
                }
                sizesList[pid]["child"].push({name:this.skuinput.val(),id:id});
                this.skumlist.append($('<span class="sku_item"><a class="itemactive" id="' + id + '" data-id="' + id + '">' + value + '</a><i class="sku_item_close">×</i></span>'))
                this.skuinput.val("")
                tableContent()
            },

            //监听删除元素
            deleteItem: function() {
                var self=this;
                this.skumlist.on("click", ".sku_item_close", function() {
                    $(this).parent().remove();
                    var text = $(this).parent().find("a").text();
                    var textarr = sizes[self.title];
                    textarr.splice(textarr.indexOf(text), 1)
                    tableContent();
                });
            },
            //控制删除符号的显示
            toggleCloseEle: function() {
                //显示删除符号
                this.skumlist.on("mouseover", ".sku_item", function() {
                    $(this).find(".sku_item_close").css({
                        display: "inline-block"
                    })
                });
                //显示删除符号
                this.skumlist.on("mouseout", ".sku_item", function() {
                    $(this).find(".sku_item_close").css({
                        display: "none"
                    })
                });
            }
        };
        /****
         * SkuCell动态产生表格内容类
         * cellist为表格内部元素    Array   如["红色","xxl"]
         * dataid为行表格id 产生元素的唯一标识   string
         * ***/
        var SkuCell = function(celllist, dataid) {

            //每行表格的父元素
            this.cellcon =$("<div>").attr("id",dataid).addClass("sku_cell clearfix");
            var nameInput=$("<input>").addClass("name_"+dataid).attr("name","name["+dataid+"]").val(celllist.join(","));
            this.nameInput =$("<div>").addClass("sku_t_title").append(nameInput);



            var input='<input class="price_'+dataid+'" value="0" name="price['+dataid+']"/>';
            //价格输入
            this.moneyInput = $("<div>").addClass("sku_t_title").append(input);
            var input='<input class="sku_'+dataid+'" value="0" name="sku['+dataid+']"/>';
            //库存输入
            this.leftInput = $("<div>").addClass("sku_t_title").append(input);
            this.init(celllist)
        };
        SkuCell.prototype = {
            constructor: SkuCell,
            init: function(celllist) {
                var html = "";
                for(var i = 0; i < celllist.length; i++) {
                    this.cellcon.append($("<div>").addClass("sku_t_title").html(celllist[i]));
                }
                this.cellcon.append(this.nameInput);
                this.cellcon.append(this.moneyInput);
                this.cellcon.append(this.leftInput);
                $('.sku_tablecell').append(this.cellcon)
            }
        };
        /****
         * 创建表格头部
         * arr 将要创建的表头内容 Arr ["颜色"，"尺码"]
         * **/
        function createTablehead(arr) {
            var mustArr = ["名称","价格", "库存"];
            var relayArr = arr.concat(mustArr);

            html = "";
            $(".sku_tableHead").html("")
            for(var i = 0, len = relayArr.length; i < len; i++) {
                html = $("<div>").addClass("sku_t_title").html(relayArr[i]);
                $(".sku_tableHead").append(html)
            }
        }
        /***
         * 排列组合计算出选择的规格型号的组合方式
         *
         * */
        function getResult() {
            var head = arguments[0][0];
            for(var i in arguments[0]) {
                if(i != 0) {
                    head = group(head, arguments[0][i])
                }
            }
            tabledata = [];
            $(".sku_cell").each(function(index) {
                tabledata.push($(this).attr("id"))
            }).hide()
            head=head?head:[];
            for(var j = 0, len = head.length; j < len; j++) {

                var newcell = head[j]["datatext"].split(',')
                var dataid = head[j]["dataid"];

                if(tabledata.indexOf(dataid) < 0) {
                    new SkuCell(newcell, dataid)
                } else {
                    $("#" + dataid).show()
                }
            }
        };
        //组合前两个数据
        function group(first, second) {
            var result = [];
            for(var i = 0, leni = first.length; i < leni; i++) {
                for(var j = 0, len = second.length; j < len; j++) {
                    result.push({
                        dataid: first[i]["dataid"] + "-" + second[j]["dataid"],
                        datatext: first[i]["datatext"] + "," + second[j]["datatext"]
                    })
                }
            }
            return result
        }
        //动态产生一个索引，用于后续操作
        var i = 3;
        function getIndex() {
            return "d" + i++;
        };
        //控制表格内容
        function tableContent() {
            $(".sku_modellist .sku_models").each(function(index, ele) {
                var aa = $(this).find(".itemactive");
                selectedArr[index] = []
                for(var i = 0; i < aa.length; i++) {
                    selectedArr[index][i] = {};
                    selectedArr[index][i]["dataid"] = $(aa[i]).attr("data-id");
                    selectedArr[index][i]["datatext"] = $(aa[i]).text();
                }
            })
            getResult(selectedArr);
        }
        $(function() {

            //点击添加多级型号事件 layer弹出层
            $("#add_multi_sku").click(function() {
                //layer详细用法 http://www.layui.com/doc/modules/layer.html
                layer.open({
                    type: 1,
                    resize: false,
                    title: "选择商品型号",
                    area: ["800px", "456px"],
                    btn: ["取消", "确定"],
                    content: $(".sku_content"), //此处后放置到弹出层内部的内容
                    yes: function(index, layero) { //取消按钮对应回调函数
                        layer.close(index)
                    },
                    btn2: function(index) { //确认按钮对应事件
                        //清空规格规格
                        $(".sku_modellist").html("");
                        var arrs = [];
                        selectedArr = {}; //清空
                        //获取被选中多级型号元素
                        $(".sku_content_sku_list .itemactive").each(function() {
                            var text = $(this).text(); //选中元素的文字
                            var dataid = $(this).attr("data-id"); //选中的元素上的参数用于创建规格时候的唯一标识
                            var arr = sizes[text] || [];
                            sizes[text] = arr;
                            //创建规格
                            new Skumodel(text, arr, dataid)
                            arrs.push(text);
                        })
                        //根据arrs数据判断出是否显示表格同时清空表格
                        if(arrs.length) {
                            $(".sku_guige").show()
                            $(".sku_table").show();
                            $(".sku_tableHead").html('')
                            $(".sku_tablecell").html("")
                            $(".sku_container .sku_item a").addClass("itemactive");
                            createTablehead(arrs);
                            tableContent()
                        } else {
                            $(".sku_table").hide()
                            $(".sku_guige").hide()
                        }
                    }
                })
            });
            setTimeout(function () {
                load_sku();
            },500)


            //弹窗中的新建sku
            $("#sku_addbtn").click(function() {
                var haveit = false;
                var value=$.trim($(".sku_input").val());
                if(value.length<=0){layer.alert("请输入内容");return}
                $(".sku_content_sku_list a").each(function() {
                    if($(this).text() ==value ) {
                        layer.msg('新建的已存在,请勿重复创建');
                        haveit = true;
                        $(".sku_input").val("")
                    }
                })
                var id= getIndex();
                if(haveit) return;
                var skuitem = '<span class="sku_item"><a id="'+id+'" data-id="' + id+ '">' + value+ '</a><i class="sku_item_close">×</i></span>'
                $(".sku_content_sku_list").append(skuitem);
                $(".sku_input").val("")
            });
            //显示删除符号
            $(".sku_content_sku_list").on("mouseover", ".sku_item", function() {
                $(this).find(".sku_item_close").css({
                    display: "inline-block"
                })
            });
            //显示删除符号
            $(".sku_content_sku_list").on("mouseout", ".sku_item", function() {
                $(this).find(".sku_item_close").css({
                    display: "none"
                })
            });
            //删除添加的型号
            $(".sku_content_sku_list").on("click", ".sku_item_close", function() {
                $(this).parent().remove();
            })

            $(".sku_content_sku_list").on("click", "a", function() {
                $(this).toggleClass("itemactive")
                var len = $(".sku_content_sku_list .itemactive").length;
                if(len > 3) {
                    layer.msg("商品规格最多选择3个");
                    $(this).toggleClass("itemactive")
                }
            });
        })



    </script>
    <script>
        $("#form").submit(function () {
            if(sizes.length>0){
                tableContent();
            }
            var form=$(this).serializeArray();
            form=form.concat({"name":"sizes","value":JSON.stringify(sizes)})
            form=form.concat({"name":"tabledata","value":JSON.stringify(tabledata)})
            form=form.concat({"name":"selectedArr","value":JSON.stringify(selectedArr)})
            form=form.concat({"name":"sizesList","value":JSON.stringify(sizesList)})

            $.ajax({
                "url":"/admin/goodscreate",
                "data":form,
                "type":"post",
                "dataType":"json",
                success:function (res) {
                    if(res.status==0){
                        alert(res.data);
                        location.href="/admin/goods"
                    }else{
                        alert(res.msg);
                    }
                }
            })
            return false;
        })



    </script>
@endsection