<{$toolbar}>

<{if $op=="tad_link_form"}>
  <{if $post_cate_arr or $isAdmin or $uid==$now_uid}>
    <{includeq file="db:tad_link_form.tpl"}>
  <{/if}>
<{elseif $op=="show_one_tad_link"}>

  <div class="card card-body bg-light m-1">
    <div class="row">
      <div class="col-sm-5">
        <a href="index.php?op=go&link_sn=<{$link_sn}>" target="_blank" border=0><img src="<{$pic}>" class="img-fluid" alt="<{$cate_title}>"></a>
      </div>
      <div class="col-sm-7">
        <h1><a href="index.php?op=go&link_sn=<{$link_sn}>" target="_blank" style="text-decoration:none;"><{if $link_title}><{$link_title}><{else}><{$link_url}><{/if}></a></h1>
        <{$smarty.const._MD_TADLINK_LINK_URL}><{$smarty.const._TAD_FOR}><a href="index.php?op=go&link_sn=<{$link_sn}>" target="_blank" ><{$link_url}></a>
        <div class="row">
          <div class="col-sm-6">
            <button class="btn btn-primary btn-sm" type="button">
              <a href="index.php?cate_sn=<{$cate_sn}>" style="color: white;"><{if $cate_sn}><{$cate_title}><{else}><{$smarty.const._MD_TADLINK_UNCATEGORIZED}><{/if}></a> <span class="badge"><{$link_counter}></span>
            </button>
          </div>

          <div class="col-sm-6 text-right">
            <{if $isAdmin or $uid==$now_uid}>
              <a href="index.php?op=tad_link_form&link_sn=<{$link_sn}>" class="btn btn-sm btn-warning"><{$smarty.const._TAD_EDIT}></a>
              <a href="javascript:delete_tad_link_func(<{$link_sn}>)" class="btn btn-sm btn-danger"><{$smarty.const._TAD_DEL}></a>
            <{/if}>
            <a href="index.php?cate_sn=<{$cate_sn}>" class="btn btn-sm btn-info"><{$smarty.const._MD_TADLINK_CATE_INFO2}></a>
          </div>
        </div>
        <p style="margin: 20px auto;"><a href="index.php?op=go&link_sn=<{$link_sn}>" target="_blank" class="btn btn-primary btn-block"><{$smarty.const._MD_TADLINK_GOTO_LINK}><{$link_url}></a></p>



        <{if $link_desc}>
          <hr>
          <{$link_desc}>
        <{/if}>
      </div>
    </div>
  </div>

  <div style="margin:8px;text-align:right;"><{$push_url}></div>
  <{$facebook_comments}>

<{elseif $op=="batch" and $isAdmin and $show_cate_sn}>

    <script type="text/javascript">

      $().ready(function(){
        $("#sort").sortable({ opacity: 0.6, cursor: "move", update: function() {
            var order = $(this).sortable("serialize") + "&action=updateRecordsListings";
            $.post("save_sort.php", order, function(theResponse){
                $("#save_msg").html(theResponse);
            });
        }
        });

        $("#clickAll").click(function() {

           if($("#clickAll").attr("checked"))
           {
             $("input[name='link_sn[]']").each(function() {
                 $(this).attr("checked", true);
             });
           }
           else
           {
             $("input[name='link_sn[]']").each(function() {
                 $(this).attr("checked", false);
             });
           }
           get_all_sn();
        });

        $("input[name='link_sn[]']").change(function() {
          get_all_sn();
        });
      });

      function get_all_sn(){
        var i=0;
        var arr = new Array();
        $("input[name='link_sn[]']").each(function() {
           if($(this).attr("checked")){
            arr[i] = $(this).val();
            i++;
           }
        });
        $('#all_sn').val(arr.join(','));
      };
    </script>

    <div class="row">
      <div class="col-sm-2 text-right">
        <{$smarty.const._MD_TADLINK_SHOW_CATE}><{$smarty.const._TAD_FOR}>
      </div>
      <div class="col-sm-6">
        <select name="show_cate_sn" class="form-control" id="show_cate_sn" onChange="location.href='index.php?op=batch&cate_sn='+this.value;">
          <option value="" ></option>
          <{$get_tad_link_cate_options}>
        </select>
      </div>
      <div class="col-sm-4">
        <{if $isAdmin and $show_cate_sn!=""}>
          <a href="index.php?cate_sn=<{$show_cate_sn}>" class="btn btn-success"><{$smarty.const._MD_TADLINK_BACK}></a>
        <{/if}>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <form action="index.php" method="post" class="form" role="form">


          <span class="badge badge-success" id="save_msg"></span>
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th colspan="2" >
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="clickAll"> <{$smarty.const._MD_TADLINK_SELECT_ALL}>
                    </label>
                  </div>
                </th>
              </tr>
            </thead>
            <tbody id="sort">
              <{foreach item=link from=$all_content}>

                <tr id="tr_<{$link.link_sn}>">
                  <td>
                    <label class="checkbox-inline">
                      <input type="checkbox" name="link_sn[]" value="<{$link.link_sn}>" class="link_sn">
                      <{$link.link_title}>

                      <span style="font-size:12px;"><{$link.link_url}></span>
                      <span class="badge badge-info"><a href="index.php?op=go&link_sn=<{$link.link_sn}>" target="_blank" style="color:white">Go</a></span>

                      <{if $link.overdue}>
                        <span class="badge badge-important"><{$smarty.const._MD_TADLINK_OVERDUE}></span>
                      <{/if}>

                    </label>
                  </td>
                  <td>
                    <a href="javascript:delete_tad_link_func(<{$link.link_sn}>)" class="btn btn-sm btn-danger"><{$smarty.const._TAD_DEL}></a>
                    <a href="index.php?op=tad_link_form&mode=batch&link_sn=<{$link.link_sn}>" class="btn btn-sm btn-warning"><{$smarty.const._TAD_EDIT}></a>
                  </td>
                </tr>

              <{/foreach}>
            </tbody>
          </table>
          <span class="form-text text-muted"><{$smarty.const._MD_TADLINK_DRAG_SORT}></span>
          <input type="hidden" id="all_sn" >
          <a href="javascript:delete_all_link_func()" class="btn btn-danger"><{$smarty.const._MD_TADLINK_BATCH_DEL}></a>
        </form>
      </div>
    </div>
<{else}>

  <{if $all_content}>

    <h1><{if $cate.cate_sn}><{$cate.cate_title}><{else}><{$smarty.const._MD_TADLINK_UNCATEGORIZED}><{/if}></h1>
    <div class="row">
      <div class="col-sm-3">
        <{$ztree_code}>
        <{if $isAdmin and $show_cate_sn!=""}>
          <div class="text-center">
            <a href="index.php?op=batch&cate_sn=<{$show_cate_sn}>" class="btn btn-success"><{$smarty.const._MD_TADLINK_BATCH}><{if $cate.cate_sn}><{$cate.cate_title}><{else}><{$smarty.const._MD_TADLINK_UNCATEGORIZED}><{/if}></a>
          </div>
        <{/if}>
      </div>

      <div class="col-sm-9">
        <{foreach item=link from=$all_content}>
          <div class="row" id="link<{$link.link_sn}>" style="margin:10px 0px; padding:10px 0px; border-bottom: 1px dotted #cfcfcf;">
            <div class="col-sm-3 text-center">
              <a href="<{$link.pic}>" class="fancybox" title="<{$link.link_title}>"><img src="<{$link.thumb}>" alt="<{$link.link_title}>"></a>
            </div>

            <div class="col-sm-9">

              <{if $isAdmin or $link.uid==$now_uid}>
                <div class="pull-right">
                  <a href="javascript:delete_tad_link_func(<{$link.link_sn}>)" class="btn btn-sm btn-danger"><{$smarty.const._TAD_DEL}></a>
                  <a href="index.php?op=tad_link_form&link_sn=<{$link.link_sn}>" class="btn btn-sm btn-warning"><{$smarty.const._TAD_EDIT}></a>
                </div>
              <{/if}>

              <div style="font-size: 24px;">
                <a href="index.php?link_sn=<{$link.link_sn}>" <{$link.js_class}>><{if $link.link_title}><{$link.link_title}><{else}><{$link.link_url}><{/if}></a>
              </div>

              <div style="font-size: 12px; margin: 10px 0px;">
                  <{if $link.cate_sn}><a href="index.php?cate_sn=<{$link.cate_sn}>"><{$link.cate_title}></a><{else}><span style="color:red;"><{$smarty.const._MD_TADLINK_UNCATEGORIZED}></span><{/if}> |

                <a href="index.php?op=go&link_sn=<{$link.link_sn}>" target="_blank"><{$link.link_url}></a>
              </div>

                <div style="color:#404040; font-size: 12px; line-height: 1.8;"><{$link.link_desc}></div>

            </div>
          </div>
        <{/foreach}>
      </div>
    </div>


    <div style="margin:20px auto;">
      <{$bar}>
    </div>
  <{/if}>

  <{if $post_cate_arr or $isAdmin}>
    <{includeq file="db:tad_link_form.tpl"}>
  <{/if}>

<{/if}>