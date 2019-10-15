###简述LNMP的工作过程
> 参考文章<br>
> <a href="https://www.cnblogs.com/zhouguowei/p/9720108.html">nginx和php之间是怎样通信的呢？</a>

####首先我们先来了解一下整一个的工作流程

浏览器发送http请求给服务器nginx上，nginx将这个请求转发给fast-cgi模块，fast-cgi去与php-fpm通信，<br>
php-fpm调用php解析器解析，将解析结果原路返回直到浏览器上，最终浏览器解析内容渲染。

####简要的解释下其中的要点
* fast-cgi  

> FastCGI是一个运用于Http Server和动态脚本语言间通信的接口，多数流行的Http Server都支持FastCGI，包括Apache、Nginx和lighttpd等。同时，FastCGI也被许多脚本语言支持，其中就有PHP。
> FastCGI接口方式采用C/S结构，可以将HttP服务器和脚本解析服务器分开，同时在脚本解析服务器上启动一个或者多个脚本解析守护进程。
> 当HttP服务器每次遇到动态程序时，可以将其直接交付给FastCGI进程来执行，然后将得到的结果返回给客户端。这种方式可以让HttP服务器专一地处理静态请求或者将动态脚本服务器的结果返回给客户端，这在很大程度上提高了整个应用系统的性能。
> 在linux上fast-cgi是一个socket，文件socket或者ip的socket

* php-fpm

> PHP-FPM是一个PHP FastCGI进程管理器，是只用于PHP的,可以在 http://php-fpm.org/download下载得到
> PHP-FPM其实是PHP源代码的一个补丁，旨在将FastCGI进程管理整合进PHP包中。必须将它patch到你的PHP源代码中，在编译安装PHP后才可以使用
> php5.3以后，php-fpm被集成到php的core中，默认安装，无须配置。

####细化其中的工作原理

关键在于nginx和php这一块的通信流程和运行

Nginx不支持对外部程序的直接调用或者解析，所有的外部程序（包括PHP）必须通过FastCGI接口来调用。FastCGI接口在Linux下是socket（这个socket可以是文件socket，也可以是ip socket）。

wrapper： 为了调用CGI程序，还需要一个FastCGI的wrapper（wrapper可以理解为用于启动另一个程序的程序），这个wrapper绑定在某个固定socket上，如端口或者文件socket。
当Nginx将CGI请求发送给这个socket的时候，通过FastCGI接口，wrapper接收到请求，然后Fork(派生）出一个新的线程，这个线程调用解释器或者外部程序处理脚本并读取返回数据；
接着，wrapper再将返回的数据通过FastCGI接口，沿着固定的socket传递给Nginx；
最后，Nginx将返回的数据（html页面或者图片）发送给客户端。这就是Nginx+FastCGI的整个运作过程，

<img src="https://upload-images.jianshu.io/upload_images/6095563-b44cbc47b8252b68.jpg?imageMogr2/auto-orient/strip|imageView2/2">

所以，我们首先需要一个wrapper，这个wrapper需要完成的工作：

通过调用fastcgi（库）的函数通过socket和ningx通信（读写socket是fastcgi内部实现的功能，对wrapper是非透明的）
调度thread，进行fork和kill 与application（php）进行通信
