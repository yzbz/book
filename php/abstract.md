## 抽象类

* 1.使用关键字: abstract

* 2.类中只要有一个方法声明为abstract抽象方法,那么这个类就必须声明为抽象类

* 3.抽象方法只允许有方法声明与参数列表,不允许有方法体

* 4.因为抽象方法的不确定性,所以抽象类禁止实例化,仅允许通过继承来实例化

* 5.继承抽象类的子类中,必须将抽象类中的所有抽象方法全部实现

* 6.子类成员的访问限制级别必须等于或小于抽象类的约定,例如抽象类是protected,子类必须相同

* 7.方法可以是protected 或者 public，不允许是private

* 8.子类方法参数必须与抽象类方法参数完全一致,但允许增加默认参数
```
//抽象类
abstract class Test {
  protected $name;
  protected $age;
  //抽象方法
  abstract public function getAget();
  //即使是抽象类也是可以使用构造函数的
  public function __construct() {
   //todo 
  }
}
```
