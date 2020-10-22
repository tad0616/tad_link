
<{if $mode=="batch" and $smarty.session.tad_link_adm and $show_cate_sn}>

    <script type="text/javascript">
        $().ready(function(){
            $("#sort").sortable({ opacity: 0.6, cursor: "move", update: function() {
                var order = $(this).sortable("serialize") + "&action=updateRecordsListings";
                $.post("save_sort.php", order, function(theResponse){
                    $("#save_msg").html(theResponse);
                });
            }
            });

            $("#clickAll").click(function() {
                if($("#clickAll").prop("checked"))
                {
                    $("input[name='link_sn[]']").each(function() {
                        $(this).prop("checked", true);
                    });
                }
                else
                {
                    $("input[name='link_sn[]']").each(function() {
                        $(this).prop("checked", false);
                    });
                }
                get_all_sn();
            });

            $("input[name='link_sn[]']").change(function() {
                get_all_sn();
            });
        });

        function get_all_sn(){
            var i=0;
            var arr = new Array();
            $("input[name='link_sn[]']").each(function() {
                if($(this).prop("checked")){
                    arr[i] = $(this).val();
                    i++;
                }
            });
            $('#all_sn').val(arr.join(','));
        };

        function delete_all_link_func(){
            swal({
                title: '<{$smarty.const._TAD_DEL_CONFIRM}>',
                text: '<{$smarty.const._TAD_DEL_CONFIRM_TEXT}>',
                type: 'warning',
                showCancelButton: 1,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: '<{$smarty.const._TAD_DEL_CONFIRM_BTN}>',
                closeOnConfirm: false ,
                allowOutsideClick: true
            },
            function(){
                location.href='index.php?op=delete_all_link&mode=batch&cate_sn=10&all_sn=' + $('#all_sn').val();
            });
        }
    </script>

    <div class="row">
        <div class="col-sm-2 text-right">
            <{$smarty.const._MD_TADLINK_SHOW_CATE}><{$smarty.const._TAD_FOR}>
        </div>
        <div class="col-sm-6">
            <select name="show_cate_sn" class="form-control" id="show_cate_sn" onChange="location.href='index.php?mode=batch&cate_sn='+this.value;">
                <option value="" ></option>
                <{$get_tad_link_cate_options}>
            </select>
        </div>
        <div class="col-sm-4">
            <{if $smarty.session.tad_link_adm and $show_cate_sn!=""}>
                <a href="index.php?cate_sn=<{$show_cate_sn}>" class="btn btn-success"><{$smarty.const._MD_TADLINK_BACK}></a>
            <{/if}>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <form action="index.php" method="post" class="form" role="form">
                <span class="badge badge-success" id="save_msg"></span>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th colspan="2" >
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="clickAll"> <{$smarty.const._MD_TADLINK_SELECT_ALL}>
                                    </label>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="sort">
                    <{foreach item=link from=$all_content}>
                        <tr id="tr_<{$link.link_sn}>">
                            <td>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="link_sn[]" value="<{$link.link_sn}>" class="link_sn">
                                    <{$link.link_title}>

                                    <span style="font-size: 0.75rem;"><{$link.link_url}></span>
                                    <span class="badge badge-info"><a href="index.php?op=go&link_sn=<{$link.link_sn}>" target="_blank" style="color:white">Go</a></span>

                                    <{if $link.overdue}>
                                        <span class="badge badge-important"><{$smarty.const._MD_TADLINK_OVERDUE}></span>
                                    <{/if}>

                                </label>
                            </td>
                            <td>
                                <a href="javascript:delete_tad_link_func(<{$link.link_sn}>)" class="btn btn-sm btn-danger"><{$smarty.const._TAD_DEL}></a>
                                <a href="index.php?op=tad_link_form&mode=batch&link_sn=<{$link.link_sn}>" class="btn btn-sm btn-warning"><{$smarty.const._TAD_EDIT}></a>
                            </td>
                        </tr>
                    <{/foreach}>
                    </tbody>
                </table>
                <span class="form-text text-muted help-block"><{$smarty.const._MD_TADLINK_DRAG_SORT}></span>
                <input type="hidden" id="all_sn" >
                <a href="javascript:delete_all_link_func()" class="btn btn-danger"><{$smarty.const._MD_TADLINK_BATCH_DEL}></a>
            </form>
        </div>
    </div>
<{else}>

    <{if $all_content}>

        <h2><{if $cate.cate_sn}><{$cate.cate_title}><{else}><{$smarty.const._MD_TADLINK_UNCATEGORIZED}><{/if}></h2>
        <div class="row">
            <div class="col-sm-3">
                <{$ztree_code}>
                <{if $smarty.session.tad_link_adm and $show_cate_sn!=""}>
                    <div class="text-center">
                        <a href="index.php?mode=batch&cate_sn=<{$show_cate_sn}>" class="btn btn-success"><{$smarty.const._MD_TADLINK_BATCH}><{if $cate.cate_sn}><{$cate.cate_title}><{else}><{$smarty.const._MD_TADLINK_UNCATEGORIZED}><{/if}></a>
                    </div>
                <{/if}>
            </div>

            <div class="col-sm-9">
                <{foreach item=link from=$all_content}>
                    <div class="row" id="link<{$link.link_sn}>" style="margin:10px 0px; padding:10px 0px; border-bottom: 1px dotted #cfcfcf;">
                        <div class="col-sm-3 text-center">
                            <a href="<{$link.pic}>" class="fancybox" title="<{$link.link_title}>"><img src="<{$link.thumb}>" alt="<{$link.link_title}>"></a>
                        </div>

                        <div class="col-sm-9">

                            <{if $smarty.session.tad_link_adm or $link.uid==$now_uid}>
                                <div class="pull-right float-right">
                                    <a href="javascript:delete_tad_link_func(<{$link.link_sn}>)" class="btn btn-sm btn-danger"><{$smarty.const._TAD_DEL}></a>
                                    <a href="index.php?op=tad_link_form&link_sn=<{$link.link_sn}>" class="btn btn-sm btn-warning"><{$smarty.const._TAD_EDIT}></a>
                                </div>
                            <{/if}>

                            <div style="font-size: 1.5rem;">
                                <a href="index.php?link_sn=<{$link.link_sn}>" <{$link.js_class}>><{if $link.link_title}><{$link.link_title}><{else}><{$link.link_url}><{/if}></a>
                            </div>

                            <div style="font-size: 0.75rem; margin: 10px 0px;">
                                <{if $link.cate_sn}><a href="index.php?cate_sn=<{$link.cate_sn}>"><{$link.cate_title}></a><{else}><span style="color:red;"><{$smarty.const._MD_TADLINK_UNCATEGORIZED}></span><{/if}> |

                                <a href="index.php?op=go&link_sn=<{$link.link_sn}>" target="_blank"><{$link.link_url}></a>
                            </div>

                            <div style="color:#404040; font-size: 0.75rem; line-height: 1.8;"><{$link.link_desc}></div>

                        </div>
                    </div>
                <{/foreach}>
            </div>
        </div>


        <div style="margin:20px auto;">
            <{$bar}>
        </div>
    <{/if}>

    <{if $post_cate_arr or $smarty.session.tad_link_adm}>
        <{includeq file="$xoops_rootpath/modules/tad_link/templates/op_tad_link_form.tpl"}>
    <{/if}>
<{/if}>