> 前言：很多同学容易将小程序生命周期和页面的生命周期混淆为一起，
> 这两个其实应该是不同却又相互关联的生命周期，所以，
> 用实际代码操作并结合官方理论讲讲这个，好好捋捋。

 **1、小程序生命周期** 
 #####
 注册小程序。接受一个 Object 参数，其指定小程序的生命周期回调等。<br>
 App() 必须在 app.js 中调用，必须调用且只能调用一次。不然会出现无法预期的后果。<br>
#####参数如下:
```javascript
App({
  onLaunch (options) {
    // Do something initial when launch.
  },
  onShow (options) {
    // Do something when show.
  },
  onHide () {
    // Do something when hide.
  },
  onError (msg) {
    console.log(msg)
  },
  globalData: 'I am global data'
})
 ```
 
<img src="https://upload-images.jianshu.io/upload_images/2891127-e2cb2eb71aa25ebd.png?imageMogr2/auto-orient/strip|imageView2/2">

从中我们可以知道小程序的生命周期函数的调用顺序为：onLaunch>onShow>onHide
<br>
 
 **2、页面生命周期** 
 #####
 页面生命周期函数就是当你每进入/切换到一个新的页面的时候，就会调用的生命周期函数。<br>
 Page(Object) 函数用来注册一个页面。<br>
 接受一个Object类型参数，其指定页面的初始数据、生命周期回调、事件处理函数等。
#####参数如下:
```javascript
Page({
  data: {
    text: "This is page data."
  },
  onLoad: function(options) {
    // 页面创建时执行
  },
  onShow: function() {
    // 页面出现在前台时执行
  },
  onReady: function() {
    // 页面首次渲染完毕时执行
  },
  onHide: function() {
    // 页面从前台变为后台时执行
  },
  onUnload: function() {
    // 页面销毁时执行
  },
  onPullDownRefresh: function() {
    // 触发下拉刷新时执行
  },
  onReachBottom: function() {
    // 页面触底时执行
  },
  onShareAppMessage: function () {
    // 页面被用户分享时执行
  },
  onPageScroll: function() {
    // 页面滚动时执行
  },
  onResize: function() {
    // 页面尺寸变化时执行
  },
  onTabItemTap(item) {
    // tab 点击时执行
    console.log(item.index)
    console.log(item.pagePath)
    console.log(item.text)
  },
  // 事件响应函数
  viewTap: function() {
    this.setData({
      text: 'Set some data for updating view.'
    }, function() {
      // this is setData callback
    })
  },
  // 自由数据
  customData: {
    hi: 'MINA'
  }
})
 ```
 
 从中我们可以知道小程序的生命周期函数的调用顺序为：<br>
    onLoad>onReady>onShow；<br>
    至于onHide函数就是当隐藏页面的时候触发。