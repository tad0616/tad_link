<{if $block.data|default:false}>
    <{if $block.display_type=='list'}>
        <{foreach from=$block.data item=cate}>
            <{if $cate.item|default:false}>
                <{if $block.show_title=='1' && $cate.cate_title}>
                    <h4><a href="<{$xoops_url}>/modules/tad_link/index.php?cate_sn=<{$cate.cate_sn}>" style="text-shadow:1px 1px 1px #aaaaaa;"><{$cate.cate_title}></a></h4>
                <{/if}>
                <ul class="vertical_menu">
                <{foreach from=$cate.item item=link}>
                    <li>
                        <i class="fa fa-external-link-square" aria-hidden="true"></i>
                        <a href="<{$link.val}>" target="_blank"><{if $link.link_title|default:false}><{$link.link_title}><{else}><{$link.val}><{/if}></a>
                    </li>
                <{/foreach}>
                </ul>
            <{/if}>
        <{/foreach}>
    <{else}>
        <{foreach from=$block.data item=cate}>
            <select onChange="<{$cate.link_js}>" style='background-color: <{$cate.cate_bg}>;color: <{$cate.cate_color}>;' class="form-control form-control form-select" title="select cate">
                <option value=""><{$cate.cate_title}></option>
                <{foreach from=$cate.item item=link}>
                    <option value='<{$link.val}>'>
                        <i class="fa fa-caret-right" aria-hidden="true"></i>
                        <{$link.link_title}>
                    </option>
                <{/foreach}>
            </select>
        <{/foreach}>
    <{/if}>

    <div style="text-align:right;">
        [ <a href="<{$xoops_url}>/modules/tad_link/index.php">more...</a> ]
    </div>
<{/if}>