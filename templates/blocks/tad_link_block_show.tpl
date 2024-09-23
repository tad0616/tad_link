<{if $block.links|default:false}>
    <{if $block.col=='0' && $block.links|default:false}>
        <{foreach from=$block.links item=web}>
            <div style="float: left; text-align: center; width: 130px; height: <{if $block.height|default:false}><{$block.height}><{else}><{$web.height}><{/if}>px; overflow: hidden;">
            <{$web.pic}>
            <{if $web.title or $web.url}>
                <{if $web.title|default:false}><p style="font-size: 0.75rem;height: 1.2rem; overflow: hidden;"><{$web.title}></p><{/if}>
                <{if $web.url|default:false}><p style="font-size: 0.6875rem; height: 1.2rem; overflow: hidden;"><{$web.url}></p><{/if}>
            <{/if}>
            </div>
        <{/foreach}>
        <div style='clear:both;'></div>
    <{elseif $block.links|default:false}>
        <div class="row">
            <{foreach from=$block.links item=web}>
            <div class="col-sm-<{$block.col}>" <{if $block.height|default:false}>style="height: <{$block.height}>px;"<{/if}>>
                <div class="thumbnail my-2" <{if $block.height!=0}>style="height: <{$block.height}>px; overflow: hidden;"<{/if}>>
                    <{$web.pic}>
                    <{if $web.title or $web.url}>
                        <div class="caption">
                            <{if $web.title|default:false}><p style="font-size: 0.75rem;height: 1.2rem; overflow: hidden;"><{$web.title}></p><{/if}>
                            <{if $web.url|default:false}><p style="font-size: 0.6875rem; height: 1.2rem; overflow: hidden;"><{$web.url}></p><{/if}>
                        </div>
                    <{/if}>
                </div>
            </div>
            <{/foreach}>
        </div>
    <{/if}>

    <{if $block.cate_sn|default:false}>
        <div style="text-align:right;">
            [ <a href="<{$xoops_url}>/modules/tad_link/index.php?cate_sn=<{$block.cate_sn}>">more...</a> ]
        </div>
    <{/if}>
<{/if}>