if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js').then(function(registration) {
  }).catch(function(err) {
    console.log('ServiceWorker の登録に失敗しました。', err);
  });
}

const CACHE_NAME = 'cache-v35';
const urlsToCache = [
    '/test.html',
    '/third/test3.html',
    '/favicon.ico',
    '/sw.js',
    '/htm/translation/',
    '/assets/img/icon/quiz_generator.png',
    '/third/jquery-2.1.1.min.js',
    '/third/jquery.cookie.js',
    '/third/vue.min.js',
    '/assets/js/analytics_offline.js',
    '/assets/css/basic.css',
    '/assets/css/pc.css',
    '/assets/css/sp.css',
    '/assets/img/icon/upload_0.png',
    '/assets/img/icon/success.png',
    '/assets/img/icon/trash.png',
    '/assets/js/check_news.js',
    '/assets/js/basic_offline.js',
    '/assets/js/translation.js'
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    // キャッシュを開く
    caches.open(CACHE_NAME)
    .then((cache) => {
      // 指定されたファイルをキャッシュに追加する
      return cache.addAll(urlsToCache);
    })
  );
});

caches.keys().then(function(keys) {
    var promises = [];
    // キャッシュストレージを全て削除する
    keys.forEach(function(cacheName) {
        if (cacheName && cacheName != CACHE_NAME) {
            promises.push(caches.delete(cacheName));
        }
    });
});

//self.addEventListener('activate', (event) => {
//  event.waitUntil(
//    caches.keys().then((cacheNames) => {
//      return cacheNames.filter((cacheName) => {
//        // このスコープに所属していて且つCACHE_NAMEではないキャッシュを探す
//        return cacheName.startsWith(`${registration.scope}!`) &&
//               cacheName !== CACHE_NAME;
//      });
//    }).then((cachesToDelete) => {
//      return Promise.all(cachesToDelete.map((cacheName) => {
//        // いらないキャッシュを削除する
//        return caches.delete(cacheName);
//      }));
//    })
//  );
//});

self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request.url.split('?')[0])
    .then((response) => {
      // キャッシュ内に該当レスポンスがあれば、それを返す
      if (response) {
        return response;
      }

      // 重要：リクエストを clone する。リクエストは Stream なので
      // 一度しか処理できない。ここではキャッシュ用、fetch 用と2回
      // 必要なので、リクエストは clone しないといけない

      let fetchRequest = event.request.clone();
      return fetch(fetchRequest)
        .then((response) => {
          if (!response || response.status !== 200 || response.type !== 'basic') {
            // キャッシュする必要のないタイプのレスポンスならそのまま返す
            return response;
          }
          return response;
        });
    })
  );
});