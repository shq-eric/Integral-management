2018.8—2018.8 基于SSM的影院管理系统
项目描述：1.实现一个给用户网上购票，退票，查看编辑基本信息；给管理员管理影院的电影，影厅，排挡信息和编辑员工信息的平台
2.本项目结构上分为View，表现(controller)层，业务(service)层和持久(DAO/Mapper)层，层次间的依赖关系自下到上。采用的技术有SpringMVC，Spring，MyBatis等。其中表现层采用SpringMVC框架开发；业务层封装业务流程，为适应业务的变更，每一业务模块均有专门的接口及实现类(既调用DAO层的接口，又要提供接口给Controller层的类来进行调用)，利用Spring的IoC功能将实现类注入给表现层的Action；数据访问层借助于MyBatis实现，用来操作数据库的增删改查。
项目中职责：1.数据库设计，数据库没有采用外键，减少维护带来的麻烦还有使用一些逻辑判断取代触发器。
2.独立开发管理员模块。界面设计采用一个boostrap管理后台模板gentelella-master。前后端数据交互利用session对象，对登录者的信息保存在session；利用request重定向，设置setAttribute；利用Ajax进行异步数据请求，数据以json格式返回；post/get表单提交。实现影厅，电影，电影排期的增删查改。电影上传图片。管理员的分等级管理
3.成员间使用myeclipse的svn插件进行版本更新
软件环境：win10+tomcat8.5+mysql5.7+JDK1.8+mybatis3.3.1+spring4+springmvc4
开发工具：Sublime Text3+navicat+myelipse
项目成果：1.实现大体流程；当有电影在某个影厅播放，该影厅被锁定无法进行删除；未登录进入不了管理员系统，进入页面前做了相应的拦截。
2.对于个人而言，
熟悉应用开发框架Spring、SpringMVC、MyBatis框架及其相互整合框架,能够独立采用ssm主流框架技术开发项目
熟悉XML、HTML、JSP、CSS、AJAX、JDBC、JavaScript、Servlet、jQuery、Bootstrap等Java Web技术
熟悉主流数据库MySQL的使用，有良好的SQL设计和编程能力。
熟悉应用Tomcat服务器，熟悉svn的使用。
2018.5—2018.6 积分商城管理后台
项目描述：1.一个积分商城的管理后台，以及vagrant环境和lnmp的搭建以及项目部署，以保证与正式环境保持一致，避免上线的时候环境导致运行异常。
2.本项目采用lnmp架构。因Nginx是一个高性能的HTTP和反向代理服务器，配置相对于apache也较简单，利用fast-cgi的方式动态解析PHP脚本。
项目中职责：实现平台的增删查改和绑定/解绑账号和订单的多条件筛选展示和以csv格式导出。
1.其中使用了bootstrapValidator对平台信息表单的验证和datetimepicker时间选择器对订单进行一段时间的筛选；使用了由PHP写出来的模板引擎Smarty，解决了页面代码的冗余，也分离了逻辑代码和外在的内容，使代码易于阅读管理
2.使用AR类关联对于数据表取代原本的sql语句查询；使用ActiveForm把模型和表单结合在一起，简化了表单 input 元素的 html 代码编写 。
软件环境：centos7+php7+mysql5.7+nginx
开发工具：sublim Text3+VirtualBox+TortoiseGit+XShell6
项目成果：完成该管理后台并上线。
在这个项目中收获很多，熟练使用vagrant+VirtualBox搭建虚拟开发环境以及php，ngnix的简易配置
熟悉git客户端tortoisegit的操作
熟悉yii2框架以及加深对mvc模型的认识
2018.3—2018.4 基于CI的词库管理系统
项目描述：做一个词库管理系统，因里面只有部分功能，所以继续使用php的CI框架完善，通过8uftp这款ftp工具上传项目
项目中职责：独立完善一个外包项目，在几个数据较多的表添加检索。
界面结构采用原先的风格。数据交互利用ajax和Jquery封装好的$.ajax方法异步传输或者form表单同步提交。后台使用ci框架实现mvc模式
软件环境：win10+php5.6+mysql5.7+apache2.4
开发工具：8UFTP+wamp+navicat+Zend Studio12.5.1
项目成果：实现了词库的导入导出，词典分页展示，以及增删查改常规功能。
2018.1—2018.2 h5射击小游戏
项目描述：给20天时间使用typescript语言去设计一款h5小游戏。我参照微信小游戏 飞机大战做出一款射击游戏，利用layabox游戏开发引擎，
项目中职责：总监给一部分图片素材，另一部分用fiddler去其他微信小游戏爬下来。界面设计是用layaair的编辑模式，可以编排UI组件，再自行查看layabox的官方手册，和typescript的语法。
软件环境：win10
开发工具：layeAir+Fiddler
项目成果：只是简单地实现积分倍数的射击，射击音效，和停止游戏，结束游戏。
熟悉了typescript的语法
熟悉了layabox引擎以及layaair的使用
熟悉Fiddler如何抓取网页图片，文字等信息