<table id="header">
<tr>
  <td>
    <img src="/assets/img/icon/menu.png" class="icon" id="menu">
  </td>
  <td id="page_news" class="<?= $this_page == 'news' ? 'this_page' : '' ?>" style="position: relative;">
    <a href="/htm/news/" rel="nofollow"><span id="news_num"></span><img src="/assets/img/icon/mail.png" class="icon"></a>
  </td>
  <td id="page_forumlist" class="<?= $this_page == 'forumlist'  ? 'this_page' : '' ?>">
    <a href="/forumlist/" rel="nofollow" ><img src="/assets/img/icon/list.png" class="icon"></a>
  </td>
  <td id="page_rank" class="<?= $this_page == 'rank'  ? 'this_page' : '' ?>" >
    <a href="/rank/" ><img src="/assets/img/icon/ranking.png" alt="rank" class="icon"></a>
  </td>
  <td id="page_myprofile" class="<?= $this_page == 'myprofile' ? 'this_page' : '' ?>" >
    <a href="/htm/myprofile/" rel="nofollow"><img src="/assets/img/icon/guest.png" id="page_myimg" class="icon"></a>
  </td>
  </tr>
</table>

<table id="drawer">
  <tr><td id="ad_menu"><iframe src="/htm/ad_blank/" width="300" height="250" frameborder="0" scrolling="no"></iframe></td></tr>
  <tr><td id="page_generate"  class="<?= $this_page == 'generate' ? 'this_page' : '' ?>" style="text-align: center;" >
    <a href="/generate/" rel="nofollow" class="td_a"><img src="/assets/img/icon/pencil.png" class="icon"></a></td></tr>
  <tr><td id="page_top"        class="<?= $this_page == 'top'       ? 'this_page' : '' ?>" style="text-align: center;">
    <a href="/" class="td_a"><img src="/assets/img/icon/home.png" class="icon"></a></td></tr>
<?php if(Config::get("my.lang") == 'en'){ ?>
  <tr><td id="page_translation"   class="<?= $this_page == 'translation'  ? 'this_page' : '' ?>" style="text-align: center;">
    <a href="/htm/translation/" rel="nofollow" class="td_a" ><img src="/assets/img/icon/translation.png" class="icon"></a></td></tr>
<?php }?>
<?php /*
  <tr><td id="page_paid"        >  <a href="/paid/" rel="nofollow"         >&nbsp;&nbsp;&nbsp;有料クイズ</a></td></tr>
  <tr><td id="page_mypacklist"  >  <a href="/mypacklist/" rel="nofollow"   >&nbsp;&nbsp;&nbsp;クイズで稼ぐ</a></td></tr>
 * 
*/ ?>
</table>
