###XSS攻击原理与解决方法

####简介
XSS攻击是Web攻击中最常见的攻击方法之一，它是通过对网页注入可执行代码且成功地被浏览器 执行，达到攻击的目的，
形成了一次有效XSS攻击，一旦攻击成功，它可以获取用户的联系人列表，然后向联系人发送虚假诈骗信息，可以删除用户的日志等等，
有时候还和其他攻击方式同时实 施比如SQL注入攻击服务器和数据库、Click劫持、相对链接劫持等实施钓鱼，它带来的危害是巨 大的，是web安全的头号大敌。

####条件    
1、需要向web页面注入恶意代码；

2、这些恶意代码能够被浏览器成功的执行。

####根据XSS攻击的效果可以分为几种类型
1、XSS反射型攻击，恶意代码并没有保存在目标网站，通过引诱用户点击一个链接到目标网站的恶意链接来实施攻击的。

2、XSS存储型攻击，恶意代码被保存到目标网站的服务器中，这种攻击具有较强的稳定性和持久性，比较常见场景是在博客，论坛等社交网站上
，但OA系统，和CRM系统上也能看到它身影，比如：某CRM系统的客户投诉功能上存在XSS存储型漏洞，黑客提交了恶意攻击代码，当系统管理员查看投诉信息时恶意代码执行
，窃取了客户的资料，然而管理员毫不知情，这就是典型的XSS存储型攻击。

####解决方法
可以利用下面这些函数对出现xss漏洞的参数进行过滤
    
    1、htmlspecialchars() 函数,用于转义处理在页面上显示的文本。
    2、htmlentities() 函数,用于转义处理在页面上显示的文本。
    3、strip_tags() 函数,过滤掉输入、输出里面的恶意标签。
    4、header() 函数,使用header("Content-type:application/json"); 用于控制 json 数据的头部，不用于浏览。
    5、urlencode() 函数,用于输出处理字符型参数带入页面链接中。
    6、intval() 函数用于处理数值型参数输出页面中。
    7、自定义函数,在大多情况下，要使用一些常用的 html 标签，以美化页面显示，如留言、小纸条。那么在这样的情况下，要采用白名单的方法使用合法的标签显示，过滤掉非法的字符。