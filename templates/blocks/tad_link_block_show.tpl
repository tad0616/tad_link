<{foreach from=$block.links item=web}>
  <div style="float: left; text-align: center; width: 130px; height: <{if $block.height}><{$block.height}><{else}><{$web.height}><{/if}>px; overflow: hidden;">
    <{$web.pic}>
    <{$web.title}>
    <{$web.url}>
  </div>

<{/foreach}>
<div style='clear:both;'></div>