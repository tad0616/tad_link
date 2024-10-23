<div class="well card card-body bg-light m-1">
    <div class="row">
        <div class="col-sm-5">
            <a href="index.php?op=go&link_sn=<{$link_sn|default:''}>" target="_blank"><img src="<{$pic|default:''}>" class="img-fluid img-responsive" alt="<{$cate_title|default:''}> pic"><span class="sr-only visually-hidden">title:<{$cate_title|default:''}></span></a>
        </div>
        <div class="col-sm-7">
            <h2><a href="index.php?op=go&link_sn=<{$link_sn|default:''}>" target="_blank" style="text-decoration:none;"><{if $link_title|default:false}><{$link_title|default:''}><{else}><{$link_url|default:''}><{/if}></a></h2>

            <{$smarty.const._MD_TADLINK_LINK_URL}><{$smarty.const._TAD_FOR}><a href="index.php?op=go&link_sn=<{$link_sn|default:''}>" target="_blank" ><{$link_url|default:''}></a>
            <div class="row">
                <div class="col-sm-6">
                    <a href="index.php?cate_sn=<{$cate_sn|default:''}>"><{if $cate_sn && $cate_title}><{$cate_title|default:''}><{else}><{$smarty.const._MD_TADLINK_UNCATEGORIZED}><{/if}></a> <span class="badge badge-info bg-info"><{$link_counter|default:''}></span>
                </div>

                <div class="col-sm-6 text-right text-end">
                <{if $smarty.session.tad_link_adm or $uid==$now_uid}>
                    <a href="index.php?op=tad_link_form&link_sn=<{$link_sn|default:''}>" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square" aria-hidden="true"></i> <{$smarty.const._TAD_EDIT}></a>
                    <a href="javascript:delete_tad_link_func(<{$link_sn|default:''}>)" class="btn btn-sm btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> <{$smarty.const._TAD_DEL}></a>
                <{/if}>
                <a href="index.php?cate_sn=<{$cate_sn|default:''}>" class="btn btn-sm btn-info"><{$smarty.const._MD_TADLINK_CATE_INFO2}></a>
                </div>
            </div>
            <p style="margin: 20px auto;" class="d-grid gap-2"><a href="index.php?op=go&link_sn=<{$link_sn|default:''}>" target="_blank" class="btn btn-primary btn-block"><{$smarty.const._MD_TADLINK_GOTO_LINK}><{$link_url|default:''}></a></p>

            <{if $link_desc|default:false}>
                <hr>
                <{$link_desc|default:''}>
            <{/if}>
        </div>
    </div>
</div>

<div style="margin:8px;text-align:right;"><{$push_url|default:''}></div>
