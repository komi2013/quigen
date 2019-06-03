<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>term and condition</title>
    <meta name="robots" content="noindex">
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <script>var ua = '<?=Config::get("my.ua")?>';</script>
    <script src="/assets/js/analytics.js<?=Config::get("my.cache_v")?>"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css<?=Config::get("my.cache_v")?>" />
    <link rel="stylesheet" href="/assets/css/pc.css<?=Config::get("my.cache_v")?>" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css<?=Config::get("my.cache_v")?>" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
  </head>
<body>

<?php
  $side = View::forge('side');
  $side->this_page = 'rule';
  echo $side;
?>

<div id="content">
<table>
  <tr><td class="td_99" style="background-color:#CBFFD3;">term</td></tr>
  <tr><td>
<li>You may not post violent, nude, partially nude, discriminatory, unlawful, infringing, hateful, pornographic or sexually suggestive photos or other content via the Service.</li>
<li>You are responsible for any activity that occurs through your account and you agree you will not sell, transfer, license or assign your account, followers, username, or any account rights. With the exception of people or businesses that are expressly authorized to create accounts on behalf of their employers or clients, Quigen prohibits the creation of and you agree that you will not create an account for anyone other than yourself. You also represent that all information you provide or provided to Quigen upon registration and at all other times will be true, accurate, current and complete and you agree to update your information as necessary to maintain its truth and accuracy.</li>
<li>You agree that you will not solicit, collect or use the login credentials of other Quigen users.</li>
<li>You are responsible for keeping your password secret and secure.</li>
<li>You must not defame, stalk, bully, abuse, harass, threaten, impersonate or intimidate people or entities and you must not post private or confidential information via the Service, including, without limitation, your or any other person's credit card information, social security or alternate national identity numbers, non-public phone numbers or non-public email addresses.</li>
<li>You may not use the Service for any illegal or unauthorized purpose. You agree to comply with all laws, rules and regulations (for example, federal, state, local and provincial) applicable to your use of the Service and your Content (defined below), including but not limited to, copyright laws.</li>
<li>You are solely responsible for your conduct and any data, text, files, information, usernames, images, graphics, photos, profiles, audio and video clips, sounds, musical works, works of authorship, applications, links and other content or materials (collectively, "Content") that you submit, post or display on or via the Service.</li>
<li>You must not change, modify, adapt or alter the Service or change, modify or alter another website so as to falsely imply that it is associated with the Service or Quigen.</li>
<li>You must not create or submit unwanted email, comments, likes or other forms of commercial or harassing communications (a/k/a "spam") to any Quigen users.</li>
<li>You must not use domain names or web URLs in your username without prior written consent from Quigen.</li>
<li>You must not interfere or disrupt the Service or servers or networks connected to the Service, including by transmitting any worms, viruses, spyware, malware or any other code of a destructive or disruptive nature. You may not inject content or code or otherwise alter or interfere with the way any Quigen page is rendered or displayed in a user's browser or device.</li>
<li>You must not create accounts with the Service through unauthorized means, including but not limited to, by using an automated device, script, bot, spider, crawler or scraper.</li>
<li>You must not attempt to restrict another user from using or enjoying the Service and you must not encourage or facilitate violations of these Terms of Use or any other Quigen terms.</li>
<li>Violation of these Terms of Use may, in Quigen's sole discretion, result in termination of your Quigen account. You understand and agree that Quigen cannot and will not be responsible for the Content posted on the Service and you use the Service at your own risk. If you violate the letter or spirit of these Terms of Use, or otherwise create risk or possible legal exposure for Quigen, we can stop providing all or part of the Service to you.</li>
      </td></tr>  
</table>
<table>
  <tr><td class="td_99_c"><a href="https://www.youtube.com/watch?v=ZQlq1a-jPHw" target="_blank">how to use(video)</a></td></tr>
  <tr><td class="td_99_c"><a href="http://quizgenerator-help.hatenadiary.jp/archive/2015" target="_blank">how to use(blog)</a></td></tr>
</table>

</div>
<script src="/assets/js/basic.js<?=Config::get("my.cache_v")?>"></script>
<script src="/assets/js/check_news.js<?=Config::get("my.cache_v")?>"></script>
<script>
  
if(localStorage.quest){
  var quest = JSON.parse(localStorage.quest);
  if(quest[4] != 1){
    quest[4] = 1;
    localStorage.quest = JSON.stringify(quest);
    var ticket = JSON.parse(localStorage.ticket);
    ticket[0] = ticket[0] + 12;
    localStorage.ticket = JSON.stringify(ticket);
    notify[2] = 'yet';
    notify[3] = 1;
    notify[4] = notify[4]+1;
    if(localStorage.news){
      var news = JSON.parse(localStorage.news);
    }else{
      var news = [];
    }
    news.unshift('<a href="/htm/quest/">rule is completed<img src="/assets/img/icon/star_1.png"></a>');
    localStorage.news = JSON.stringify(news);
    localStorage.notify = JSON.stringify(notify);
  }
}
$(function(){ ga('send', 'pageview'); });

</script>

</body>
</html>