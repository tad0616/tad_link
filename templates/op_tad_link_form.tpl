<script type="text/javascript">
    $(document).ready(function(){
        $('#LinkGet').click(function() {
            $.post("link_ajax.php", { url: $('#LinkUrl').val()},
            function(data) {
                var obj = $.parseJSON(data);
                $('#LinkTitle').val(obj.title);
                $('#LinkDesc').val(obj.description);
                $('#thumb').attr("src","https://capture.heartrails.com/400x300/border?"+$('#LinkUrl').val());
            });
        });

        $('#thumb').click(function() {
            $('#thumb').attr("src","https://capture.heartrails.com/400x300/border?"+$('#LinkUrl').val());
        });
    });
</script>


<div class="well card card-body bg-light m-1">
    <form action="index.php" method="post" id="myForm" enctype="multipart/form-data" role="form" class="form-horizontal">
        <div class="form-group row mb-3">
            <div class="col-sm-12">
                <input type="text" name="link_url" id="LinkUrl" style="font-size: 1.5rem;" class="validate[required,custom[url]] form-control" placeholder="https://<{$smarty.const._MD_TADLINK_LINK_URL}>" value="<{$link_url|default:''}>">
            </div>
        </div>

        <div class="form-group row mb-3">
            <div class="col-sm-6">
                <input type="text" name="link_title" id="LinkTitle" class="validate[required] form-control" placeholder="<{$smarty.const._MD_TADLINK_LINK_TITLE}>" value="<{$link_title|default:''}>">
            </div>
            <div class="col-sm-4">
                <input type="text" name="unable_date" class="form-control" value="<{$unable_date|default:''}>" id="unable_date" placeholder="<{$smarty.const._MD_TADLINK_UNABLE_DATE}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd' , startDate:'%y-%M-%d}'})">
            </div>
            <div class="col-sm-2">
                <button type="button" id="LinkGet" class="btn btn-primary pull-right float-right pull-end"><i class="fa fa-cloud-download" aria-hidden="true"></i> <{$smarty.const._MD_TADLINK_AUTOGET}></button>
            </div>
        </div>


        <div class="form-group row mb-3">
            <{if $get_tad_link_cate_options|default:false}>
                <div class="col-sm-6">
                    <select name="cate_sn" size=1 id="cate_sn" class="form-select">
                        <{if $smarty.session.tad_link_adm|default:false}>
                            <option value=""></option>
                        <{/if}>
                        <{$get_tad_link_cate_options|default:''}>
                    </select>
                </div>
                <div class="col-sm-6">
                    <{if $smarty.session.tad_link_adm|default:false}>
                        <input type="text" name="new_cate" class="form-control" id="new_cate" placeholder="<{$smarty.const._MD_TADLINK_NEW_CATE}>">
                    <{/if}>
                </div>
            <{elseif $smarty.session.tad_link_adm}>
                <div class="col-sm-12">
                    <input type="text" name="new_cate" class="validate[required] form-control" id="new_cate" placeholder="<{$smarty.const._MD_TADLINK_ADD_NEW_CATE}>">
                </div>
            <{/if}>
        </div>

        <div class="form-group row mb-3">
            <div class="col-sm-6">
                <textarea name="link_desc" class="form-control" rows=3 id="LinkDesc" placeholder="<{$smarty.const._MD_TADLINK_LINK_DESC}>"><{$link_desc|default:''}></textarea>
            </div>
            <div class="col-sm-2">
                <img src="<{$pic|default:''}>" id="thumb" alt="thumb" title="thumb">
            </div>
            <div class="col-sm-4">
                <input type="file" name="pic" accept="image/gif,image/jpeg,image/png">
            </div>
        </div>

        <div class="bar">
            <input type="hidden" name="enable" value="1">
            <input type="hidden" name="mode" value="<{$mode|default:''}>">
            <input type="hidden" name="link_sn" value="<{$link_sn|default:''}>">
            <input type="hidden" name="op" value="<{$next_op|default:''}>">
            <button type="submit" class="btn btn-info"><i class="fa fa-floppy-o" aria-hidden="true"></i> <{if $link_sn|default:false}> <{$smarty.const._TAD_SAVE}><{else}><{$smarty.const._MD_TADLINK_QUICK_ADD}><{/if}></button>
        </div>
    </form>
</div>

<div style="color:<{$color|default:''}>;"><{$chk_msg|default:''}></div>
<div class="clearfix"></div>