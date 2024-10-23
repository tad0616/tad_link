<{if $data|default:false}>
    <form action="main.php" method="post" role="form">
        <table class="table table-striped table-bordered">
            <tr>
                <th nowrap><{$smarty.const._MA_TADLINK_CATE_TITLE}></th>
                <th nowrap><{$smarty.const._MA_TADLINK_LINK_TITLE}></th>
                <th nowrap><{$smarty.const._MA_TADLINK_LINK_URL}></th>
                <th nowrap><{$smarty.const._TAD_FUNCTION}></th>
            </tr>
            <tbody>
                <{foreach from=$data item=link}>
                    <tr>
                        <td>
                            <a href="main.php?cate_sn=<{$link.cate_sn}>"><{$link.cate_title}></a>
                        </td>
                        <td>
                            <a href="<{$xoops_url}>/modules/tad_link/index.php?link_sn=<{$link.link_sn}>"><{$link.link_title}></a>
                            <span style="color:gray;font-size: 0.75rem;"> (<{$link.link_counter}>)</span>
                        </td>
                        <td><{$link.link_url}></td>
                        <td>
                            <a href="javascript:delete_tad_link_func(<{$link.link_sn}>);" class="btn btn-sm btn-danger" id="del<{$link.link_sn}>"><i class="fa fa-trash-o" aria-hidden="true"></i> <{$smarty.const._TAD_DEL}></a>
                            <a href="<{$xoops_url}>/modules/tad_link/index.php?op=tad_link_form&link_sn=<{$link.link_sn}>" class="btn btn-sm btn-warning" id="update<{$link.link_sn}>"><i class="fa fa-pencil-square" aria-hidden="true"></i> <{$smarty.const._TAD_EDIT}></a>
                        </td>
                    </tr>
                <{/foreach}>
            </tbody>
        </table>
        <{$bar|default:''}>
    </form>
<{else}>
    <div class="alert alert-danger text-center">
        <h3><{$smarty.const._MA_TADLINK_EMPTY}></h3>
    </div>
<{/if}>