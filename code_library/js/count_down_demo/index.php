<?php
/**
 *  [发条]网 主入口程序
 * 
 * @version $Id: index.php 5 2011-05-20 11:38:44Z wangxinyi $
 * @package system
 * @author  Wang xinyi <wxysky@sourcedot.net>
 */


/**#@ 
 *  对各种请求进行处理， 这样可以支持二级域名访问，并允许用户直接进入用户空间
 */


/**#@-*/
defined('_DEV') || define('_DEV',false);
$_dev = _DEV ? 'http://img.fatiao.me' :'';
echo<<<EOT

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=7"/>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
    
    <title>发条网-开发站</title>
    <script type="text/javascript" src="{$_dev}/js/lib/jquery-1.6.1.min.js"></script> 

    <script type="text/javascript">

    $(function(){
    
    
      /** 
       * 
       * 开发倒计时使用的一个对象,用于用于指定时间的倒计时显示，可以设置到期事件，也可
       * 以设置两个时间段的倒计时,可以绑定各种事件，支持各种方式的事件绑定，比如到达指
       * 定时间，或者一个时间段等。
       * 
       * 可以用于团购，在线js游戏等内容
       *
       * TODO: 以后增加样式定义等内容
       *
       * 
       * @author  乐天派 <divein@126.com>
       **/       
       var countDown  ={
         /* 记分板容器对象 */
         countPaneObj : $('#ctPanel'),
         /* 计分板对象*/
         sPaneObj : null,
         mPaneObj : null,
         hPaneObj : null,
         dPaneObj : null,
         /* 倒计时间隔1秒*/
         interval: 1000,
         /*上线时间暂定 7.10号 */
         targetDate: '2011-8-10 12:00:00',         
         /* 保存当前时间,这里用个变量保存，是为了在页面显示 */
         nowDate: new Date(),
         /* 用来保存时间句柄*/
         _timer :null,
         /* 用来保存倒计时时间的容器 */
         /* 返回一个计时器 */
         runTimer: function(){
             _runtimer = this;             
             /** 比较当前时间和目的时间 */
             var tf = _runtimer._timeDiff(_runtimer.targetDate,_runtimer.nowDate);
             /** 插入时间显示框*/
             /* 天 */
             this.countPaneObj.append('<div id="ct_d3" ></div><div id="ct_d2" ></div><div id="ct_d1" ></div>');
             this.countPaneObj.append('<div class="ct_d_sp" ></div>');             
             /* 小时 */
             this.countPaneObj.append('<div id="ct_h2" ></div><div id="ct_h" ></div>');
             this.countPaneObj.append('<div class="ct_h_sp" ></div>');                 
             /* 分钟 */
             this.countPaneObj.append('<div id="ct_m2" ></div><div id="ct_m" ></div>');
             this.countPaneObj.append('<div class="ct_m_sp" ></div>');             
             /* 秒 */
             this.countPaneObj.append('<div id="ct_s2" ></div><div id="ct_s" ></div>');
             this.countPaneObj.append('<div class="ct_s_sp" ></div>');             
             
             for(arr in tf){   _runtimer[arr] = tf[arr]; }   
          
             /** 设置当前时间 */
             /**TODO: 这里写得太啰嗦了， 需要重构下  **/
             var val  =  this._splitn(_runtimer.S,2);
             $('#ct_s',this.countPaneObj).css({backgroundPosition: "0px -"+((parseInt(val[0])+1) * 65)+"px"});
             $('#ct_s2',this.countPaneObj).css({backgroundPosition: "-48px -"+((parseInt(val[1])+1) * 65)+"px"});            
             val = this._splitn(_runtimer.M,2);
             $('#ct_m',this.countPaneObj).css({backgroundPosition: "0px -"+((parseInt(val[0])+1) * 65)+"px"});
             $('#ct_m2',this.countPaneObj).css({backgroundPosition: "-48px -"+((parseInt(val[1])+1) * 65)+"px"});    
             val = this._splitn(_runtimer.H,2);
             $('#ct_h',this.countPaneObj).css({backgroundPosition: "0px -"+((parseInt(val[0])+1) * 65)+"px"});
             $('#ct_h2',this.countPaneObj).css({backgroundPosition: "-48px -"+((parseInt(val[1])+1) * 65)+"px"});    
             val = this._splitn(_runtimer.D,3);             
             $('#ct_d1',this.countPaneObj).css({backgroundPosition: "0px -"+((parseInt(val[0])+1) * 65)+"px"});
             $('#ct_d2',this.countPaneObj).css({backgroundPosition: "0px -"+((parseInt(val[1])+1) * 65)+"px"});    
             $('#ct_d3',this.countPaneObj).css({backgroundPosition: "0px -"+((parseInt(val[2])+1) * 65)+"px"});             
             var timer = function(){
                _runtimer.countDownTime();
             };
            
             _timer = window.setInterval(timer,1000);             
             return _runtimer;
         },
         /**
          * 对时间进行倒计时
          */
         countDownTime : function(){
            this.S--;
            this._raiseEvent('d',{t:'S',v:this.S});
            if(this.S == -1) { 
               this.M --; this.S = 59; 
               this._raiseEvent('d',{t:'M',v:this.M});
               this._raiseEvent('d',{t:'S',v:this.S}); 
            }
            if(this.M == -1) { 
               this.H--; this.M = 59; 
               this._raiseEvent('d',{t:'H',v:this.H});
               this._raiseEvent('d',{t:'M',v:this.M}); 
            }
            if(this.H == -1){
             this.D--;
             this.H = 59;
             this._raiseEvent('d',{t:'D',v:this.D});
             this._raiseEvent('d',{t:'H',v:this.H}); 
            }
            if(this.S==0 && this.M ==0 && this.H==0 && this.D==0){
               window.clearInterval(this._timer);
            }
            this.dS--;
            /*TODO: 以后加上 全局分钟，全局小时，全局时间的处理 */            
         },
         /**
          * 添加处理事件
          */
         addEventHandler:function(func){
            this._bindHander.push(func);
            return this;
         },
         /**
          * 绑定用来处理事件的函数数组
          */
         _bindHander:[],
         /**
          * 抛出倒计时事件函数
          *
          * @param type 事件类型，
          * 目前支持倒计时事件 TODO:以后支持里程碑事件，特定节日事件  'd' 表示倒计时事件。
          * 当类型为 'd' 时候， 传入的参数对象 第一个 t 标识类型，分别有 'S':秒，'M':分钟, 'H':小时,‘D':天
          * @param src  事件源
          */
         _raiseEvent:  function(type,src){
            if(type=='d'){
                for(var func in this._bindHander){                  
                   this._bindHander[func].call(this,src);
                }            
            }else{
               /* 目前不支持这种事件*/
            }
         },
         /* 返回两个时间的间隔 */
         _timeDiff:function(date1,date2){
        
            var objInterval = {D: 60 * 60 * 24,H: 60 * 60,M: 60,S:1000};
            var reg = /^(\d+)-(\d+)-(\d+)\s+(\d+):(\d+):(\d+)/;
            var match1 = reg.exec(date1);
            var dt1 = new Date(match1[1],parseInt(match1[2])-1,match1[3],match1[4],match1[5],match1[6]);
           
           /* 判断date2 是否是 Date类型*/
            if(date2 instanceof Date){
               var dt2 = date2;
            }else{
               var match2 = reg.exec(date2);   
               var dt2 = new Date(match2[1],parseInt(match2[2])-1,match2[3],match2[4],match2[5],match2[6]);            
            }                    
            
            /* 如果时间到，或者给出的时间大于等于预期时间，返回0 */
            if( dt1.getTime() <= dt2.getTime()){
                return 0;
            }
            var _diff = Math.round((dt1.getTime() - dt2.getTime()) /objInterval['S']);
            
            /* 比较单项 */            
            var diffDay  =  Math.round(_diff / objInterval['D']);
            var diffHour =  Math.round(_diff / objInterval['H']);
            var diffMinute = Math.round(_diff / objInterval['M']);
            var diffSecond = _diff;
            /* 获得组合数据*/
            var offDay = Math.floor(_diff / objInterval['D'])
            var offHour = Math.floor(_diff / objInterval['H']) % 24;
            var offMinute = Math.floor(_diff / objInterval['M']) % 60;
            var offSecond = _diff % 60;                
            
            return {           
                  D:offDay, H:offHour, M:offMinute, S:offSecond, 
                  dD:diffDay, dH:diffHour, dM:diffMinute, dS:diffSecond
            };
                        
         },     
         /**
          * @param v 表示要显示的数字
          * @param offset 表示img sprite（其中小时高位为2，所以偏移位置不一样)
          * @param id     显示的id,这里只需要给出低位id即可
          * @param h       高位值， 小时为 2， 分钟和秒为 6              
          */
         _time:function(v,offset,id,h){
           //TODO: 这里需要重构， 提供一个函数，提供统一渲染方法。           
             var val =  this._splitn(v,2);
           var lval = parseInt(val[0]);
           var hval = parseInt(val[1]);
           
           //处理秒1
           var pos =(lval+1) * 65;     
           if(lval == 9){           
             pos = 0 ;
             $(id,this.countPaneObj).stop().animate({backgroundPosition:("0px -"+pos+"px")},{duration:800,complete:function(){
                $(this).css({backgroundPosition: "0px -650px"});
             }});
           }else{
             $(id,this.countPaneObj).stop().animate({backgroundPosition:("0px -"+pos+"px")},{duration:800});
           }
           //处理秒2
           if(lval == 9){           
             var pos2 =(hval+1) * 65;     
             if(hval == (h-1)){           
               pos2 = 0 ;
               $(id+"2",this.countPaneObj).stop().animate({backgroundPosition:("-"+offset+"px -"+pos2+"px")},{duration:800,complete:function(){
                   $(this).css({backgroundPosition: "-"+offset+"px -"+(h*65)+"px"});
                }});
             }else{
               $(id+"2",this.countPaneObj).stop().animate({backgroundPosition:("-"+offset+"px -"+pos2+"px")},{duration:800});
           }           
           }
           
        },
        /** 日期单独处理 */
        _day:function(v){
           //目前只处理3位长度日期
           var val =  this._splitn(v,3);
           for(var i=0;i<val.length;i++){
              var pos =(lval+1) * 65;
              var pval = parseInt(val[i]);
              if(pval == 9){           
                pos = 0 ;
                $("ct_d"+i,this.countPaneObj).stop().animate({backgroundPosition:("0px -"+pos+"px")},{duration:800,complete:function(){
                     $(this).css({backgroundPosition: "0px -650px"});
                 }});
              }else{
                $("ct_d"+i,this.countPaneObj).stop().animate({backgroundPosition:("0px -"+pos+"px")},{duration:800});
              }
           }
        },
        _splitn: function(n,len){
           var _str = n.toString(10);
           //TODO: 这里先不考虑 len 小于 n长度的情况
           var _tostr = '';
           for(var v = 0; v < len - _str.length; v++){
              _tostr += '0';
           }
           _tostr += _str;
           var _ret =[];
           for(var i=0;i< _tostr.length;i++){
              _ret.unshift(_tostr.substring(i,i+1));
           }
           return _ret;
        }
      }.addEventHandler(function(src){
    
         /**
          * 运行时绑定的处理句柄
          */
         if(src.t == 'S'){
            this._time(src.v,'48','#ct_s','6');
          }else if(src.t =='M'){
            this._time(src.v,'48','#ct_m','6');
          }else if(src.t =='H'){
            this._time(src.v,'96','#ct_h','3');            
          }else if(src.t =='D'){
            this._day(src.v);
          }
                    
        
      }).runTimer();
     
      countDown._splitn(245,10);
      $("#target_time").text(countDown.targetDate);
    });
    </script>
    <style type="text/css">
      #ctPanel { 
        width:546px; overflow:hidden; border:0; height:66p;x
      }
      #ct_s,#ct_s2,#ct_m,#ct_m2,#ct_h,#ct_h2,#ct_d3,#ct_d2,#ct_d1{
          float:left; height:64px;  width:50px;
          background: url('/images/widget/countdown.gif') no-repeat;
      }
      .ct_d_sp{
          float:left;         
          background: url('/images/widget/countdown.gif')  no-repeat -50px -715px;
          width: 24px; height:64px; 
      }
      .ct_h_sp{
          float:left;
          background: url('/images/widget/countdown.gif')  no-repeat -74px -715px;
          width: 24px; height:64px; 
      }
      .ct_m_sp{
          float:left;
          background: url('/images/widget/countdown.gif') no-repeat -97px -715px;
          width: 24px; height:64px; 
      }     
      .ct_s_sp{
          float:left;
          background: url('/images/widget/countdown.gif') no-repeat -121px -715px;
          width: 24px; height:64px; 
      }            
    </style>
</head>
<body>
    <div><h1>目标时间:<span id="target_time"></span><div id="ctPanel" ></div></h1></div>

</body>
</html>

EOT;
