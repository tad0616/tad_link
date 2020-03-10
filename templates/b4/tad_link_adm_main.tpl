<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3">
      <div id="save_msg"></div>

      <{$ztree_code}>

      <a href="main.php?op=tad_link_cate_form" class="btn btn-info btn-block"><{$smarty.const._TAD_ADD}></a>
    </div>
    <div class="col-sm-9">

      <{if $cate_sn > 0}>
        <div class="row">
          <div class="col-sm-4">
            <h3>
              <{$cate.cate_title}>
            </h3>
          </div>
          <div class="col-sm-8 text-right">
            <div style="margin-top: 10px;">
              <a href="javascript:delete_tad_link_cate_func(<{$cate.cate_sn}>);" class="btn btn-danger <{if $cate_count.$cate_sn > 0}>disabled<{/if}>"><{$smarty.const._TAD_DEL}></a>
              <a href="main.php?op=tad_link_cate_form&cate_sn=<{$cate_sn}>" class="btn btn-warning"><{$smarty.const._TAD_EDIT}></a>
            </div>
          </div>
        </div>
      <{/if}>



      <{if $op=="tad_link_cate_form"}>
        <h2><{$smarty.const._MA_TADLINK_CATE_FORM}></h2>

        <form action="main.php" method="post" id="myForm" enctype="multipart/form-data" role="form">
          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-sm-right">
              <{$smarty.const._MA_TADLINK_OF_CATE_SN}>
            </label>
            <div class="col-sm-3">
              <select name="of_cate_sn" size=1 class="form-control">
                <option value=""></option>
                <{$get_tad_link_cate_options}>
              </select>
            </div>
            <label class="col-sm-2 col-form-label text-sm-right">
              <{$smarty.const._MA_TADLINK_CATE_TITLE}>
            </label>
            <div class="col-sm-4">
              <input type="text" name="cate_title" value="<{$cate_title}>" id="cate_title" class="validate[required] form-control">
            </div>
            <div class="col-sm-1">
              <input type="hidden" name="cate_sn" value="<{$cate_sn}>">
              <input type="hidden" name="cate_sort" value="<{$cate_sort}>">
              <input type="hidden" name="op" value="<{$next_op}>">
              <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-sm-right">
              <{$smarty.const._MA_TADLINK_SET_POST_POWER}>
            </label>
            <div class="col-sm-10">
              <{$enable_post_group}>
            </div>
          </div>


          <!--分類編號-->

        </form>
      <{elseif $data}>
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
                    <span style="color:gray;font-size: 0.75em;"> (<{$link.link_counter}>)</span>
                  </td>
                  <td><{$link.link_url}></td>
                  <td>
                    <a href="javascript:delete_tad_link_func(<{$link.link_sn}>);" class="btn btn-sm btn-danger" id="del<{$link.link_sn}>"><{$smarty.const._TAD_DEL}></a>
                    <a href="<{$xoops_url}>/modules/tad_link/index.php?op=tad_link_form&link_sn=<{$link.link_sn}>" class="btn btn-sm btn-info" id="update<{$link.link_sn}>"><{$smarty.const._TAD_EDIT}></a>
                  </td>
                </tr>
              <{/foreach}>
            </tbody>
          </table>
          <{$bar}>
        </form>
      <{else}>
        <div class="alert alert-danger text-center">
          <h3><{$smarty.const._MA_TADLINK_EMPTY}></h3>
        </div>

      <{/if}>
    </div>
  </div>
</div>
