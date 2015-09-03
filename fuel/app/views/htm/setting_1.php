<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8" />
    <title>詳細設定</title>
    <link rel="shortcut icon" href="/assets/img/icon/quiz_generator.png">
    <script src="/third/jquery-2.1.1.min.js"></script>
    <script src="/third/jquery.cookie.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/basic.css?ver=33" />
    <link rel="stylesheet" href="/assets/css/pc.css?ver=33" media="only screen and (min-width : 711px)">
    <link rel="stylesheet" href="/assets/css/sp.css?ver=33" media="only screen and (max-width : 710px)">
    <meta name="viewport" content="width=device-width, user-scalable=no" >
    </head>
<body>

<script>var ua = '<?=Config::get("my.ua")?>';</script>
<script src="/assets/js/analytics.js"></script>

画像をダブルクリックすると、好きなところに文字が書き込めます。
<p>
    <img src="/assets/img/icon/quiz_generator.png" width="300px" height="300px" id="img1" />
</p>
<input type="button" value="保存" onclick="decorator1.save();" />
<input type="button" value="ロード" onclick="decorator1.load();" />


<script>
function createImgDecorator(id){
	// 装飾対象img要素
	var img = document.getElementById(id);
	// ダブルクリックでテキストボックスを追加できるよう設定
	img.addEventListener("dblclick", appendText, false);

	var ImgDecorator = function(){};

	ImgDecorator.prototype = {
		save : function(){
			// 保存はCanvasに再描画することによって行う
			var canvas = document.createElement("canvas");

			// Canvasが使用できる事の確認
			if (!canvas || !canvas.getContext){
				return;
			}
			// Canvas全体に画像を描画
			canvas.width = img.clientWidth;
			canvas.height = img.clientHeight;

			var context = canvas.getContext('2d');
			context.drawImage(img, 0, 0);

			for(var i=0; i<document.body.childNodes.length; i++){
				var element = document.body.childNodes[i];
				// 要素が画像の上にあるか
				if(img.offsetLeft <= element.offsetLeft && element.offsetLeft <= img.offsetLeft + img.clientWidth){
					if(img.offsetTop <= element.offsetTop && element.offsetTop <= img.offsetTop + img.clientHeight){
						var inputElements = element.getElementsByTagName("input");
						// 要素がinput要素を1つ持っているか
						if(inputElements.length == 1){
							// 画像の左上を原点とする相対座標を取得
							var left = element.offsetLeft - img.offsetLeft;
							// 縦位置は中央揃えで合わせる
							var top = element.offsetTop + element.clientHeight / 2 - img.offsetTop;
							context.textBaseline = "middle";
							context.font = inputElements[0].style.fontSize + " " + inputElements[0].style.fontFamily;
							// Canvas上にテキストを描画
							context.fillText(inputElements[0].value, left, top);
						}
					}
				}
			}

			// 画像をBase64エンコードした文字列をlocalStorageに保存
			localStorage[id] = canvas.toDataURL();
		},
		load : function(){
			if(localStorage[id]){
				// 画像をlocalStorageに保存された画像に置き換え
				document.getElementById(id).src = localStorage[id];
			}
		}
	};

	function appendText(evt){
		// イベントが発生した絶対座標を取得
		var left = evt.target.offsetLeft + evt.offsetX;
		var top = evt.target.offsetTop + evt.offsetY;
		// テキストボックスを作成
		var element = createTextInput(left, top);

		// テキストボックスを追加してフォーカスを設定
		document.body.appendChild(element);
		element.focus();
	}

	function createTextInput(left, top){
		// テキストボックスの外枠となるdivを作成
		var div = document.createElement("div");
		div.setAttribute("style", "position:absolute;left:" + left + "px;top:" + top + "px;cursor:move;border-width:5px;");
		// ドラッグできるよう設定
		div.addEventListener("mousedown", startMove, false);

		// テキストボックスを作成
		var textInput = document.createElement("input");
		textInput.setAttribute("type", "text");
		// 外枠に合わせて幅を調整できるようwidthは100%
		// 後で正確に再描画するためにフォントとフォントサイズまで指定する
		textInput.setAttribute("style", "border-style:none;background-color:transparent;width:100%;font-size:14px;font-family:sans-serif;");
		// ドラッグ時のデフォルト動作をキャンセルするため、クリック時の動作を自前で定義する
		textInput.addEventListener("click", function(){textInput.focus();}, false);
		div.appendChild(textInput);

		// テキストボックスの幅を調整するためのdivを作成
		var rightBorder = document.createElement("div");
		rightBorder.setAttribute("style", "height:100%;cursor:e-resize;position:absolute;top:0px;right:0px;width:5px;");
		// ドラッグできるよう設定
		rightBorder.addEventListener("mousedown", startResize, false);
		div.appendChild(rightBorder);

		// テキストボックスが元の画像をはみ出さないよう幅を調整
		if(left + 100 > img.offsetLeft + img.clientWidth){
			div.style.width = (img.offsetLeft + img.clientWidth - left) + "px";
		}else{
			div.style.width = "100px";
		}

		// returnされたdivにフォーカスを設定できるようインスタンスを拡張
		div.focus = function(){
			textInput.focus();
		};

		return div;
	}

	// テキストボックスをドラッグで移動するための関数
	function startMove(evt1){
	    var move = function(evt2){
	    	// イベントが発生した時のテキストボックスの新しい絶対座標を取得
			var left = window.pageXOffset + evt2.clientX - evt1.offsetX;
	    	var top  = window.pageYOffset + evt2.clientY - evt1.offsetY;
	    	// 元の画像をはみ出さないよう位置を調整
	    	if(left < img.offsetLeft){
	    		left = img.offsetLeft;
	    	}else if(left + evt1.target.clientWidth > img.offsetLeft + img.clientWidth){
	    		left = img.offsetLeft + img.clientWidth - evt1.target.clientWidth;
	    	}
	    	if(top < img.offsetTop){
	    		top = img.offsetTop;
	    	}else if(top + evt1.target.clientHeight > img.offsetTop + img.clientHeight){
	    		top = img.offsetTop + img.clientHeight - evt1.target.clientHeight;
	    	}
	    	// 新しい位置を設定
	    	evt1.target.style.left = left + "px";
	    	evt1.target.style.top = top + "px";
	    };
	    var endMove = function(){
	    	// 移動イベントを終了
		document.removeEventListener("mousemove", move, false);
		document.removeEventListener("mouseup", endMove, false);
	    };
	    // 移動イベントを開始
	    document.addEventListener("mousemove", move, false);
	    document.addEventListener("mouseup", endMove, false);
	    // 移動中に他の要素が選択状態になってしまうのを抑制
	    evt1.preventDefault();
	}

	// テキストボックスの幅をドラッグで変更するための関数
	function startResize(evt1){
	    var resize = function(evt2){
	    	// イベントが発生した時のテキストボックスの新しい右端を取得
			var right = window.pageXOffset + evt2.clientX;
	    	// 元の画像をはみ出さないよう位置を調整
	    	if(right > img.offsetLeft + img.clientWidth){
	    		right = img.offsetLeft + img.clientWidth;
	    	}
	    	// 新しい幅を設定
	    	evt1.target.parentNode.style.width = (right - evt1.target.parentNode.offsetLeft) + "px";
	    };
	    var endResize = function(){
		    // テキストボックスの幅変更イベントを終了
		    document.removeEventListener("mousemove", resize, false);
		    document.removeEventListener("mouseup", endResize, false);
	    };
	    // テキストボックスの幅変更イベントを開始
	    document.addEventListener("mousemove", resize, false);
	    document.addEventListener("mouseup", endResize, false);
	    // 移動イベントを抑制
	    evt1.stopPropagation();
	    // テキストボックスの幅変更中に他の要素が選択状態になってしまうのを抑制
	    evt1.preventDefault();
	}

	return new ImgDecorator();
}

var decorator1 = createImgDecorator("img1");

</script>
</body>
</html>