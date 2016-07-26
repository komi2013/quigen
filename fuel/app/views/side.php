<table id="header">
<tr>
  <td>
    <img src="/assets/img/icon/menu.png" class="icon" id="menu">
  </td>
  <td id="page_news" class="<?= $this_page == 'news' ? 'this_page' : '' ?>" style="position: relative;">
    <a href="/htm/news/" rel="nofollow"><span id="news_num"></span><img src="/assets/img/icon/mail.png" class="icon"></a>
  </td>
  <td id="page_forumlist" class="<?= $this_page == 'forumlist'  ? 'this_page' : '' ?>">
    <a href="/forumlist/" rel="nofollow" ><img src="/assets/img/icon/chat.png" class="icon"></a>
  </td>
  <td id="page_rank" class="<?= $this_page == 'rank'  ? 'this_page' : '' ?>" >
    <a href="/rank/" ><img src="/assets/img/icon/ranking.png" alt="rank" class="icon"></a>
  </td>
  <td id="page_myprofile" class="<?= $this_page == 'myprofile' ? 'this_page' : '' ?>" >
    <a href="/myprofile/" rel="nofollow"><img src="/assets/img/icon/guest.png" id="page_myimg" class="icon"></a>
  </td>
  </tr>
</table>
<table id="drawer">
  <tr><td id="ad_menu"><iframe src="/htm/ad_blank/" width="300" height="250" frameborder="0" scrolling="no"></iframe></td></tr>
  <tr><td id="page_generate"  class="<?= $this_page == 'generate' ? 'this_page' : '' ?>" >             <a href="/generate/" rel="nofollow"   >&nbsp;&nbsp;&nbsp;make quiz</a></td></tr>
  <tr><td id="page_gene4word"  class="<?= $this_page == 'gene4word' ? 'this_page' : '' ?>" >             <a href="/gene4word/" rel="nofollow"   >&nbsp;&nbsp;&nbsp;make word quiz</a></td></tr>
  <tr><td id="page_top"        class="<?= $this_page == 'top'       ? 'this_page' : '' ?>" >             <a href="/"                            >&nbsp;&nbsp;&nbsp;other quiz</a></td></tr>
  <tr><td id="page_myanswer"   class="<?= $this_page == 'myanswer'  ? 'this_page' : '' ?>" >             <a href="/htm/myanswer_offline/" rel="nofollow" >&nbsp;&nbsp;&nbsp;offline</a></td></tr>
<?php /*
  <tr><td id="page_paid"        >  <a href="/paid/" rel="nofollow"         >&nbsp;&nbsp;&nbsp;有料クイズ</a></td></tr>
  <tr><td id="page_mypacklist"  >  <a href="/mypacklist/" rel="nofollow"   >&nbsp;&nbsp;&nbsp;クイズで稼ぐ</a></td></tr>
*/ ?>
</table>
