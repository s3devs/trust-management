(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([[10],{"71ee":function(e,t,a){"use strict";a.r(t);var n=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("q-page",{attrs:{padding:""}},[a("tasks",{ref:"tasks",attrs:{table:e.tasks,hidePagination:!1,loading:e.loading,pagination:e.pagination},on:{request:e.onRequest}})],1)},i=[],l=(a("4de4"),a("ded3")),s=a.n(l),o=a("2f62"),d={data:function(){return{loading:!1,tasks:{columns:[{name:"id",align:"left",label:"ID",field:"id",sortable:!0,style:"width: 30px"},{name:"title",align:"left",label:"Title",field:"title",sortable:!0},{name:"users",align:"left",label:"Assign To",field:"users",sortable:!1},{name:"type",align:"left",label:"Type",field:"type",sortable:!0},{name:"priority",align:"left",label:"Priority",field:"priority",sortable:!0},{name:"due_date",align:"left",label:"Due Date",field:"due_date",sortable:!0},{name:"completed",align:"left",label:"Completed",field:"completed",sortable:!0},{name:"actions",align:"right",sortable:!1}],data:[]},pagination:{sortBy:"id",descending:!0,page:1,filter:"",deleted:!1,rowsPerPage:15,rowsNumber:15}}},methods:s()(s()({},Object(o["b"])("task",["List"])),{},{onRequest:function(e){var t=this,a=e.pagination,n=a.page,i=a.rowsPerPage,l=a.sortBy,s=a.descending,o=a.deleted,d=a.filter;this.loading=!0,this.List({page:n,limit:i,filter:d,order:l,deleted:o,descending:s?"desc":"asc"}).then((function(e){t.tasks.data=t.tableData,t.pagination.rowsNumber=e.total,t.pagination.page=n,t.pagination.rowsPerPage=i,t.pagination.sortBy=l,t.pagination.descending=s,t.loading=!1}))}}),mounted:function(){this.onRequest({pagination:this.pagination})},computed:{tableData:function(){return this.$store.state.task.data}}},r=d,g=a("2877"),p=a("9989"),u=a("eebe"),f=a.n(u),b=Object(g["a"])(r,n,i,!1,null,null,null);t["default"]=b.exports,f()(b,"components",{QPage:p["a"]})}}]);