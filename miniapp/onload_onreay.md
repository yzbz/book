####小程序页面onload()，onready()加载顺序

 **1、小程序** 
 
* onLoad(Object query) 页面加载时触发。一个页面只会调用一次，可以在 onLoad
的参数中获取打开当前页面路径中的参数。
* onShow() 页面显示/切入前台时触发。
* onReady() 页面初次渲染完成时触发。一个页面只会调用一次，代表页面已经准备妥当

<p style="font-size:20px;font-weight:bold;color:#f96">所以加载顺序是先加载onLoad，再是onShow，最后onReady</p>
 
**2、原生js** 
 
* document.ready 表示文档结构加载完成（不包含图片等非文字媒体文件）；ready如果定义多个，都会按渲染顺序执行。
* window.onload 包含图片等在内的所有元素都加载完成。但是，onload不管定义多少个，只执行一个（最后一个）

<p style="font-size:20px;font-weight:bold;color:#f96">所以加载顺序是先加载ready，后onload，正好和小程序相反</p>

**3、Jquery** 
<p style="font-size:20px;margin-left:20px;font-weight:bold;color:#f96">(document).ready(function())，简写(function(){});</p>
