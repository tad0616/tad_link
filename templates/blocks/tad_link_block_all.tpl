<{if $block.display_type=='list'}>
    <{foreach from=$block.data item=cate}>
        <{if $cate.item}>
            <h3><a href="<{$xoops_url}>/modules/tad_link/index.php?cate_sn=<{$cate.cate_sn}>" style="text-shadow:1px 1px 1px #aaaaaa;"><{$cate.cate_title}></a></h3>
            <ul class="fa-ul">
            <{foreach from=$cate.item item=link}>
                <li style="margin:8px 0px;"><a href="<{$link.val}>" target="_blank">
                    <i class="fa-li fa fa-external-link-square" aria-hidden="true"></i>
                    <{$link.link_title}></a>
                </li>
            <{/foreach}>
            </ul>
        <{/if}>
    <{/foreach}>
<{else}>
    <{foreach from=$block.data item=cate}>
      <select onChange="<{$cate.link_js}>" style='background-color:<{$cate.color}>;' class="form-control">
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
