<div class="row">
    <div class="col-sm-3">
        <div id="save_msg"></div>
        <{$ztree_code}>
        <div class="d-grid gap-2">
            <a href="main.php?op=tad_link_cate_form" class="btn btn-info btn-block"><{$smarty.const._MA_TADLINK_ADD_CATE}></a>
        </div>
    </div>
    <div class="col-sm-9">

        <{if $cate_sn > 0 and $now_op!='tad_link_cate_form'}>
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="my d-inline-block"><{$cate.cate_title}></h2>
                    <a href="javascript:delete_tad_link_cate_func(<{$cate.cate_sn}>);" class="btn btn-danger btn-sm <{if $cate_count.$cate_sn > 0}>disabled<{/if}>"><{$smarty.const._TAD_DEL}></a>
                        <a href="main.php?op=tad_link_cate_form&cate_sn=<{$cate_sn}>" class="btn btn-warning btn-sm"><{$smarty.const._TAD_EDIT}></a>
                </div>
            </div>
        <{/if}>

        <{if $now_op|default:false}>
            <{include file="$xoops_rootpath/modules/tad_link/templates/op_`$now_op`.tpl"}>
        <{/if}>

    </div>
</div>