<{$formValidator_code}>

<script type="text/javascript">
  $(document).ready(function(){
    $('#LinkGet').click(function() {
      $.post("link_ajax.php", { url: $('#LinkUrl').val()},
       function(data) {
        var obj = $.parseJSON(data);
          $('#LinkTitle').val(obj.title);
          $('#LinkDesc').val(obj.description);
          <{if $capture_from=="120.115.2.78"}>
            $('#thumb').attr("src","http://120.115.2.78/img.php?w=400&h=300&url="+$('#LinkUrl').val());
          <{else}>
            $('#thumb').attr("src","http://capture.heartrails.com/400x300/border?"+$('#LinkUrl').val());
          <{/if}>
       });
    });

    $('#thumb').click(function() {
      <{if $capture_from == "120.115.2.78"}>
        $('#thumb').attr("src","http://120.115.2.78/img.php?w=400&h=300&url="+$('#LinkUrl').val());
      <{else}>
        $('#thumb').attr("src","http://capture.heartrails.com/400x300/border?"+$('#LinkUrl').val());
      <{/if}>
    });
  });
</script>

<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>


<div class="card card-body bg-light m-1">
  <form action="index.php" method="post" id="myForm" enctype="multipart/form-data" role="form">
    <div class="form-group row">
      <div class="col-sm-12">
        <input type="text" name="link_url" id="LinkUrl" style="font-size:24px;" class="validate[required,custom[url]] form-control" placeholder="http://<{$smarty.const._MD_TADLINK_LINK_URL}>" value="<{$link_url}>">
      </div>
    </div>

    <div class="form-group row">
      <div class="col-sm-6">
        <input type="text" name="link_title" id="LinkTitle" class="validate[required] form-control" placeholder="<{$smarty.const._MD_TADLINK_LINK_TITLE}>" value="<{$link_title}>">
      </div>
      <div class="col-sm-4">
        <input type="text" name="unable_date" class="form-control" value="<{$unable_date}>" id="unable_date" placeholder="<{$smarty.const._MD_TADLINK_UNABLE_DATE}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd' , startDate:'%y-%M-%d}'})">
      </div>
      <div class="col-sm-2">
        <button type="button" id="LinkGet" class="btn btn-primary pull-right"><{$smarty.const._MD_TADLINK_AUTOGET}></button>
      </div>
    </div>


    <div class="form-group row">
      <{if $get_tad_link_cate_options}>
        <div class="col-sm-6">
          <select name="cate_sn" size=1 id="cate_sn" class="form-control">
            <{if $isAdmin}>
              <option value=""></option>
            <{/if}>
            <{$get_tad_link_cate_options}>
          </select>
        </div>
        <div class="col-sm-6">
          <{if $isAdmin}>
          <input type="text" name="new_cate" class="form-control" id="new_cate" placeholder="<{$smarty.const._MD_TADLINK_NEW_CATE}>">
          <{/if}>
        </div>
      <{elseif $isAdmin}>
        <div class="col-sm-12">
         <input type="text" name="new_cate" class="validate[required] form-control" id="new_cate" placeholder="<{$smarty.const._MD_TADLINK_ADD_NEW_CATE}>">
       </div>
      <{/if}>
    </div>

    <div class="form-group row">
      <div class="col-sm-6">
        <textarea name="link_desc" class="form-control" rows=3 id="LinkDesc" placeholder="<{$smarty.const._MD_TADLINK_LINK_DESC}>"><{$link_desc}></textarea>
      </div>
      <div class="col-sm-2">
        <img src="<{$pic}>" id="thumb" alt="thumb" title="thumb">
      </div>
      <div class="col-sm-4">
        <input type="file" name="pic" accept="image/gif,image/jpeg,image/png">
      </div>
    </div>

    <div class="form-group row">
      <div class="col-sm-12">
        <input type="hidden" name="enable" value="1">
        <input type="hidden" name="mode" value="<{$mode}>">
        <input type="hidden" name="link_sn" value="<{$link_sn}>">
        <input type="hidden" name="op" value="<{$next_op}>">
        <button type="submit" class="btn btn-info pull-right"><{if $link_sn}><{$smarty.const._TAD_SAVE}><{else}><{$smarty.const._MD_TADLINK_QUICK_ADD}><{/if}></button>
      </div>
    </div>

  </form>
</div>
<div style="color:<{$color}>;"><{$chk_msg}></div>
<div class="clearfix"></div>