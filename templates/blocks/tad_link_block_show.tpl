<!--div style="float: left; text-align: center; width: 130px; height: <{if $block.height}><{$block.height}><{else}><{$web.height}><{/if}>px; overflow: hidden;"-->

<div class="row">
  <{foreach from=$block.links item=web}>
    <div class="col-sm-<{$block.col}>" <{if $block.height}>style="height: <{$block.height}>px;"<{/if}>>
      <div class="thumbnail" <{if $block.height!=0}>style="height: <{$block.height}>px; overflow: hidden;"<{/if}>>
        <{$web.pic}>
        <{if $web.title or $web.url}>
        <div class="caption">
          <{if $web.title}><p style="font-size: 12px;height: 15px; overflow: hidden;"><{$web.title}></p><{/if}>
          <{if $web.url}><p style="font-size: 11px; height: 15px; overflow: hidden;"><{$web.url}></p><{/if}>
        </div>
        <{/if}>
      </div>
    </div>
  <{/foreach}>
</div>
<div style="text-align:right;">
  [ <a href="<{$xoops_url}>/modules/tad_link/index.php?cate_sn=<{$block.cate_sn}>">more...</a> ]
</div>
