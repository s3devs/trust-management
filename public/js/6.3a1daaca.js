(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([[6],{"3ade":function(e,s,o){},7536:function(e,s,o){"use strict";var t=o("3ade"),a=o.n(t);a.a},b2c5:function(e,s,o){"use strict";o.r(s);var t=function(){var e=this,s=e.$createElement,o=e._self._c||s;return o("div",[o("h3",{staticClass:"text-center"},[e._v("\n    Welcome.\n  ")]),o("p",{staticClass:"text-center q-mb-md"},[e._v("\n    Sign in by entering your email address and password below\n  ")]),o("q-form",{ref:"loginForm",on:{submit:e.login}},[o("div",{staticClass:"col q-mb-lg"},[o("q-input",{ref:"email",attrs:{label:"Email Address",autofocus:"",color:"blue-grey-14"},model:{value:e.email,callback:function(s){e.email=s},expression:"email"}})],1),o("div",{staticClass:"col"},[o("q-input",{attrs:{label:"Password",type:e.isPwd?"password":"text",color:"blue-grey-14"},scopedSlots:e._u([{key:"append",fn:function(){return[o("q-icon",{staticClass:"cursor-pointer",attrs:{name:e.isPwd?"visibility_off":"visibility"},on:{click:function(s){e.isPwd=!e.isPwd}}})]},proxy:!0}]),model:{value:e.password,callback:function(s){e.password=s},expression:"password"}})],1),o("div",{staticClass:"col row q-mb-lg"},[o("q-space"),o("q-btn",{attrs:{flat:"",size:"sm",label:"Forgot Password?",to:"/login/forgot-password",align:"right"}})],1),o("q-btn",{staticClass:"full-width q-pa-sm",attrs:{size:"md",label:"Login",color:"gm-pink",align:"center",type:"submit"}})],1)],1)},a=[],n=(o("ac1f"),o("5319"),{data:function(){return{email:"",password:"",isPwd:!0,rememberMe:!1}},methods:{login:function(){var e=this;console.func("pages/login/LoginIndex:methods.login()",arguments),this.$refs.loginForm.validate().then((function(s){s?e.$api.auth.login({email:e.email,password:e.password,device_name:e.$core.uid()}).then((function(s){e.$store.commit("SessionData/updateToken",s.token),e.$store.commit("SessionData/updateUser",s.user),e.$store.commit("SessionData/updatePermissions",s.permissions),e.$store.commit("SessionData/updateModules",s.modules),e.$router.replace("/")})).catch((function(s){e.$core.error(s.message)})):e.$core.error("Please make sure you enter a valid email address.")})).catch((function(e){console.error(e)}))},pwdChanged:function(){console.func("pages/login/SelectPassword:methods.pwdChanged()",arguments),this.password=this.$refs.pwd.$refs.input.value}}}),i=n,r=(o("7536"),o("2877")),l=o("0378"),c=o("27f9"),d=o("0016"),u=o("2c91"),m=o("9c40"),p=o("eebe"),f=o.n(p),w=Object(r["a"])(i,t,a,!1,null,null,null);s["default"]=w.exports,f()(w,"components",{QForm:l["a"],QInput:c["a"],QIcon:d["a"],QSpace:u["a"],QBtn:m["a"]})}}]);