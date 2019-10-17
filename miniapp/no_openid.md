> 前言：小程序开发过程中，index.wxml加载时需要使用用户信息，之前wx.login是写在app.js的onLaunch函数中，
> 通过后台获取到openid后存储到本地缓存中，之后在index.js中获取openid老是出现第一次取值为空，第二次再打开就有值的情况。
> 原代码如下

app.js

    onLaunch: function () {
        var that = this 
        wx.login({
          success: function (res) {
            //code 获取用户信息的凭证
            if (res.code) {
              //请求获取用户详细信息
              wx.request({
                url: "https://pig.intmote.com/wxApp/user/getOpenid.do",
                data: { "code": res.code },
                method: 'GET',
                header: {
                  'Content-type': 'application/json'
                },
                success: function (res) {
                  //保存openid
                  wx.setStorageSync('openid', res.data.openid);//存储openid
                  wx.showToast({ title: "登录成功" })
                }
              });
            } else {
              wx.showToast({ title: "登录失败" })
            }
          }
        }) 
       },

index.js

    onLoad: function () {
        var that = this;  
        wx.showToast({ title: wx.getStorageSync('openid') });  
        that.setData({
          openid: wx.getStorageSync('openid')
        })
      },
#####出现这种情况是因为app.js onLaunch是异步加载，在加载index.js onLoad的时候还没有取到openid

####解决方案：

使用promise来获取异步操作的消息。

####Promise简介
Promise 是异步编程的一种解决方案，所谓Promise ，简单说就是一个容器，里面保存着某个未来才会结束的事件(通常是一个异步操作）的结果。
从语法上说，Promise是一个对象，从它可以获取异步操作的消息。

####小程序代码实现：
1.app.js中定义getOpenid函数，并使用promise生成实例

    getOpenid: function () {
        var that = this;
        return new Promise(function (resolve, reject) {
          wx.login({
            success: function (res) {
              //code 获取用户信息的凭证
              if (res.code) {
                //请求获取用户openid
                wx.request({
                  url: "https://pig.intmote.com/wxApp/user/getOpenid.do",
                  data: { "code": res.code },
                  method: 'GET',
                  header: {
                    'Content-type': 'application/json'
                  },
                  success: function (res) {
                    wx.setStorageSync('openid', res.data.openid);//存储openid
                    var res = {
                      status: 200,
                      data: res.data.openid
                    }
                    resolve(res);
                  }
                });
              } else {
                console.log('获取用户登录态失败！' + res.errMsg)
                reject('error');  
              }
            }
          })
        });
      }, 
      
2.index.js通过promise的then方法取出openid

    //获取应用实例
    const app = getApp()
    Page({
      data: {
        openid : '',
      }, 
      onLoad: function () {
        var that = this;  
        app.getOpenid().then(function (res) {
          if (res.status == 200) {
            that.setData({
              openid: wx.getStorageSync('openid')
            })
          } else {
            console.log(res.data);
          }
        }); 
      },
    })