(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([[5],{"3ade":function(e,s,r){},7536:function(e,s,r){"use strict";var o=r("3ade"),i=r.n(o);i.a},b2c5:function(e,s,r){"use strict";r.r(s);var o=function(){var e=this,s=e.$createElement,r=e._self._c||s;return r("div",[r("h3",{staticClass:"text-center"},[e._v("\n    Welcome.\n  ")]),r("p",{staticClass:"text-center q-mb-md"},[e._v("\n    Sign in by entering your email address and password below\n  ")]),r("q-form",{ref:"loginForm",on:{submit:e.onLogin}},[r("div",{staticClass:"col"},[r("q-input",{ref:"email",attrs:{"bottom-slots":"","error-message":"email"in e.errors?e.errors.email.join(", "):"",error:"email"in e.errors,label:"Email Address",autofocus:"",color:"blue-grey-14"},model:{value:e.form.email,callback:function(s){e.$set(e.form,"email",s)},expression:"form.email"}})],1),r("div",{staticClass:"col"},[r("q-input",{attrs:{label:"Password","bottom-slots":"","error-message":"password"in e.errors?e.errors.password.join(", "):"",error:"password"in e.errors,type:e.isPwd?"password":"text",color:"blue-grey-14"},scopedSlots:e._u([{key:"append",fn:function(){return[r("q-icon",{staticClass:"cursor-pointer",attrs:{name:e.isPwd?"visibility_off":"visibility"},on:{click:function(s){e.isPwd=!e.isPwd}}})]},proxy:!0}]),model:{value:e.form.password,callback:function(s){e.$set(e.form,"password",s)},expression:"form.password"}})],1),r("div",{staticClass:"col row q-mb-lg q-mt-sm"},[r("div",{staticClass:"col"},[r("q-checkbox",{attrs:{dense:"",label:"Remember me"},model:{value:e.form.remember,callback:function(s){e.$set(e.form,"remember",s)},expression:"form.remember"}})],1),r("div",{staticClass:"col text-right"},[r("q-btn",{attrs:{flat:"",dense:"",size:"sm",label:"Forgot Password?",to:"/login/forgot-password",align:"right"}})],1)]),r("q-btn",{staticClass:"full-width q-pa-sm",attrs:{size:"md",label:"Login",color:"gm-pink",align:"center",type:"submit"}}),r("q-inner-loading",{attrs:{showing:e.visible}},[r("q-spinner-tail",{attrs:{size:"50px",color:"primary"}})],1)],1)],1)},i=[],t=r("ded3"),n=r.n(t),a=r("2f62"),l={data:function(){return{form:{email:"admin@gomedia.co",password:"9yeKweRyRho7",remember:!1},isPwd:!0,errors:{},visible:!1}},methods:n()(n()({},Object(a["b"])("app",["Login"])),{},{onLogin:function(){var e=this;this.errors={},this.visible=!0,console.func("pages/login/LoginIndex:methods.login()",arguments),this.Login(this.form).then((function(s){e.$router.push({name:"Dashboard"}),e.visible=!1})).catch((function(s){e.visible=!1,s.errors?e.errors=s.errors:e.$core.error(s.message)}))},pwdChanged:function(){console.func("pages/login/SelectPassword:methods.pwdChanged()",arguments),this.password=this.$refs.pwd.$refs.input.value}})},c=l,m=(r("7536"),r("2877")),d=r("0378"),p=r("27f9"),u=r("0016"),f=r("8f8e"),b=r("9c40"),g=r("74f7"),w=r("007d"),h=r("eebe"),v=r.n(h),q=Object(m["a"])(c,o,i,!1,null,null,null);s["default"]=q.exports,v()(q,"components",{QForm:d["a"],QInput:p["a"],QIcon:u["a"],QCheckbox:f["a"],QBtn:b["a"],QInnerLoading:g["a"],QSpinnerTail:w["a"]})}}]);