import{Q as c}from"./QTd-bd214e85.js";import{r as k,T as y,o as v,c as C,a as e,u as t,b as s,t as f,h as a,i as Q,F as S,Z as D,j as d,U as g,Q as m,w as p,k as V,l as O,m as T,n as q,p as B,d as I,R as x,C as R}from"./app-bfca7ec4.js";import{Q as U}from"./QTable-e2e2fc3c.js";import{d as Y}from"./date-37bbfee8.js";import{u as A}from"./use-quasar-8ef4c359.js";import"./QSelect-0be4b91d.js";import"./QChip-fbdc1a57.js";import"./QMenu-7802b655.js";import"./use-fullscreen-0d7e226b.js";const M={class:"container mt-5 mb-5 ml-5"},P=s("h5",null,"Sub Nodal Officers",-1),E={class:"mb-4"},F={class:"q-pa-md"},$=s("span",{class:"text-weight-bold"},"Edit State Nodal Officer",-1),j=["onSubmit"],L={class:"q-pa-md"},Z={class:"q-gutter-x-md column",style:{width:"400px"}},ae={__name:"Index",props:{sibling:Object,departmentId:"",departmentName:"",role:""},setup(u){const n=A(),b=k(!1),r=y({name:""}),h=[{name:"id",align:"left",label:"Sl No",field:"id",headerClasses:""},{name:"name",align:"left",label:"Department Nodal Officer",field:"name"},{name:"mobile",align:"left",label:"Phone",field:"mobile"},{name:"roles",align:"left",label:"Role",field:"role"},{name:"last_active",align:"left",label:"Last Active",field:"last_login",format:o=>Y.formatDate(o,"DD MMM YYYY, hh:mm A")??"-"},{name:"actions",align:"left",label:"Action",field:"id"}],_=o=>{console.log("Im the only one: "+o)},w=o=>{n.dialog({title:"Confirm Delete",message:"Are you sure?",ok:"Yes",cancel:"No"}).onOk(()=>{x.delete(route("nodal.destroy",o),{onStart:()=>n.loading.show({message:"Deleting...."}),onSuccess:()=>{n.notify({message:"User deleted",closeBtn:!0}),n.loading.hide()},onFinish:()=>n.loading.hide(),preserveState:!1})}).onCancel(()=>{})};return(o,i)=>(v(),C(S,null,[e(t(D),{title:"Create Sub-Nodal"}),s("div",M,[P,s("h4",E,f(u.departmentName),1),e(t(g),{href:o.route("all.officer"),as:"button",type:"button"},{default:a(()=>[d("Back")]),_:1},8,["href"]),e(t(g),{href:"/nodal/sibling/"+u.departmentId,class:"p-2 m-5 bg-blue-5 text-white shadow-2"},{default:a(()=>[d("New Sub Department Nodal")]),_:1},8,["href"]),s("div",F,[e(U,{rows:u.sibling,columns:h,"row-key":"name",onRequest:o.tableData,flat:"",bordered:"",title:"List",separator:"cell",filter:o.filter,pagination:{rowsPerPage:10},"records-per-page-options":"[1,5,10]"},{"body-cell-id":a(l=>[e(c,{key:"id",props:l},{default:a(()=>[d(f(l.rowIndex+1),1)]),_:2},1032,["props"])]),"body-cell-roles":a(l=>[e(c,{props:l},{default:a(()=>[d(f(l.row.role.name),1)]),_:2},1032,["props"])]),"body-cell-actions":a(l=>[e(c,{key:"action",props:l},{default:a(()=>[e(m,{dense:"",round:"",flat:"",color:"green",onClick:p(N=>o.$inertia.get("/admin/adminViewSubNodalOfficerEdit/"+l.row.id),["stop"]),icon:"edit"},null,8,["onClick"]),e(m,{dense:"",round:"",flat:"",color:"red",onClick:p(N=>w(l.row.id),["stop"]),icon:"delete"},null,8,["onClick"])]),_:2},1032,["props"])]),_:1},8,["rows","onRequest","filter"]),e(Q,{modelValue:b.value,"onUpdate:modelValue":i[1]||(i[1]=l=>b.value=l)},{default:a(()=>[e(V,null,{default:a(()=>[e(O,null,{default:a(()=>[e(T,null,{default:a(()=>[$]),_:1}),q(e(m,{flat:"",round:"",dense:"",icon:"close"},null,512),[[R]])]),_:1}),e(B,null,{default:a(()=>[s("form",{onSubmit:p(_,["prevent"]),method:"post"},[s("div",L,[s("div",Z,[e(I,{name:"name",standout:"",modelValue:t(r).name,"onUpdate:modelValue":i[0]||(i[0]=l=>t(r).name=l),error:!!t(r).errors.name,"error-message":t(r).errors.name,dense:o.dense,placeholder:"Department Name"},null,8,["modelValue","error","error-message","dense"]),e(m,{label:"Update",dense:"",color:"black",type:"submit",disable:t(r).processing},null,8,["disable"])])])],40,j)]),_:1})]),_:1})]),_:1},8,["modelValue"])])])],64))}};export{ae as default};