(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([[3],{4129:function(t,e,a){"use strict";a.r(e);var s=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("q-layout",{attrs:{view:"hHh lpR fFf"}},[a("q-header",{staticClass:"bg-white text-grey-14",attrs:{bordered:"",reveal:""}},[a("div",{staticClass:"menu-closed"},[a("q-btn",{attrs:{flat:"",dense:"",round:"",icon:t.leftDrawerOpen?"far fa-times":"far fa-align-center","aria-label":"Menu"},on:{click:function(e){t.leftDrawerOpen=!t.leftDrawerOpen}}})],1),a("q-toolbar",[a("q-toolbar-title",{staticClass:"text-weight-bolder",attrs:{shrink:""}},[t._v("\n        Go Media CRM"),a("div",{staticClass:"text-subtitle2"},[t._v("Breadcrumb data missing")])]),a("q-space"),[a("div",{staticClass:"row no-wrap q-col-gutter-md"},[a("div",{staticClass:"column self-center"},[a("q-btn",{attrs:{dense:"",round:"",flat:"",icon:"notifications"}},[a("q-badge",{attrs:{color:"red","text-color":"white",floating:""}},[t._v("2")]),a("q-menu",{attrs:{"auto-close":"",square:"","max-width":"width: 400px; max-width:95vw",offset:[10,0]}},[a("q-list",{staticStyle:{width:"400px","max-width":"95vw"}},[a("q-item-section",{staticClass:"text-white text-bolder bg-grey q-pl-md q-pa-sm",attrs:{header:""}},[t._v("\n                    You have 4 messages\n                  ")]),t._l(t.notifications,(function(t){return a("notification",{key:t.id,attrs:{notification:t}})}))],2)],1)],1)],1),t.user?a("div",{staticClass:"column self-center"},[a("q-item",{staticClass:"q-pa-none cursor-pointer"},[a("q-item-section",{staticClass:"q-pa-none q-mr-xs",staticStyle:{"min-width":"auto"},attrs:{avatar:""}},[a("avatar",{staticClass:"cursor-pointer",attrs:{size:"30px",user:t.user}})],1),a("q-item-section",{staticClass:"gt-sm q-pa-none"},[t._v(t._s(t.user.name))]),a("q-item-section",{staticClass:"gt-sm q-pa-none",staticStyle:{padding:"0"},attrs:{side:""}},[a("q-icon",{attrs:{name:"expand_more"}})],1),a("q-menu",{attrs:{"auto-close":"",square:"",offset:[10,0]}},[a("q-list",{staticStyle:{width:"200px"}},[a("q-item",{attrs:{clickable:""}},[a("q-item-section",{staticStyle:{"min-width":"auto"},attrs:{avatar:""}},[a("q-icon",{attrs:{color:"primary",name:"edit",size:"xs"}})],1),a("q-item-section",{staticClass:"q-pl-none"},[t._v("Edit Profile")])],1),a("q-separator"),a("q-item",{attrs:{clickable:""}},[a("q-item-section",{staticStyle:{"min-width":"auto"},attrs:{avatar:""}},[a("q-icon",{attrs:{color:"primary",name:"lock",size:"xs"}})],1),a("q-item-section",{staticClass:"q-pl-none"},[t._v("Change Password")])],1),a("q-separator"),a("q-item",{attrs:{clickable:""},on:{click:t.onLogout}},[a("q-item-section",{staticStyle:{"min-width":"auto"},attrs:{avatar:""}},[a("q-icon",{attrs:{color:"primary",name:"exit_to_app",size:"xs"}})],1),a("q-item-section",{staticClass:"q-pl-none"},[t._v("Logout")])],1)],1)],1)],1)],1):t._e()])]],2)],1),a("q-drawer",{staticClass:"q-pa-none q-ma-none",attrs:{"show-if-above":"",side:"left",width:200,breakpoint:1023,"content-class":"bg-gm-blue"},model:{value:t.leftDrawerOpen,callback:function(e){t.leftDrawerOpen=e},expression:"leftDrawerOpen"}},[a("q-scroll-area",{staticClass:"fit q-pa-none",style:t.$q.screen.lt.md?"margin-top: 90px;height: calc(100% - 130px)!important":"height: calc(100% - 40px)!important"},[a("q-list",{staticClass:"q-pa-none"},t._l(t.sideLinks,(function(e){return a("links",t._b({key:e.title},"links",e,!1))})),1)],1),a("q-toolbar",{staticClass:"absolute-top menu-toolbar lt-md"},[a("q-btn",{attrs:{flat:"",dense:"",round:"",icon:"fal fa-times","aria-label":"Menu"},on:{click:function(e){t.leftDrawerOpen=!t.leftDrawerOpen}}})],1)],1),a("q-page-container",[a("router-view",{key:t.pageKey})],1)],1)},i=[],o=a("ded3"),n=a.n(o),r=a("2f62"),c={data:function(){return{leftDrawerOpen:!1,pageKey:Date.now(),sideLinks:[{title:"Dashboard",icon:"fal fa-tachometer",route:"Dashboard"},{title:"Customers",icon:"fal fa-handshake-alt",route:"Customers"},{title:"Prospects",icon:"fal fa-calculator",route:"Prospects"},{title:"Tasks",icon:"fal fa-calculator",route:"Tasks"},{title:"Suppliers",icon:"fal fa-calculator",route:"Suppliers"},{title:"Parts",icon:"fal fa-calculator",route:"Parts"},{title:"Assets",icon:"fal fa-calculator",route:"Assets"},{title:"Users",icon:"fal fa-users",route:"Users"},{title:"Roles",icon:"fal fa-users-cog",route:"Roles"}],appName:"JNElectrical"}},methods:n()(n()({},Object(r["b"])("app",["Logout"])),{},{onLogout:function(){var t=this;this.Logout().then((function(){t.$router.push({name:"Login"})}))}}),watch:{$route:function(t){this.pageKey=Date.now()}},computed:{user:{get:function(){return this.$store.state.app.user},set:function(t){this.$store.commit("app/currentUser",t)}},notifications:{get:function(){return this.$store.state.app.notifications},set:function(t){this.$store.commit("app/updateNotifications",t)}}}},l=c,u=(a("b53f"),a("2877")),p=a("4d5a"),f=a("e359"),m=a("9c40"),d=a("65c6"),q=a("6ac5"),h=a("2c91"),w=a("58a81"),b=a("4e73"),g=a("1c1c"),v=a("4074"),C=a("66e5"),x=a("0016"),k=a("eb85"),y=a("9404"),_=a("4983"),Q=a("09e3"),D=a("eebe"),S=a.n(D),O=Object(u["a"])(l,s,i,!1,null,null,null);e["default"]=O.exports,S()(O,"components",{QLayout:p["a"],QHeader:f["a"],QBtn:m["a"],QToolbar:d["a"],QToolbarTitle:q["a"],QSpace:h["a"],QBadge:w["a"],QMenu:b["a"],QList:g["a"],QItemSection:v["a"],QItem:C["a"],QIcon:x["a"],QSeparator:k["a"],QDrawer:y["a"],QScrollArea:_["a"],QPageContainer:Q["a"]})},"88ea":function(t,e,a){},b53f:function(t,e,a){"use strict";var s=a("88ea"),i=a.n(s);i.a}}]);