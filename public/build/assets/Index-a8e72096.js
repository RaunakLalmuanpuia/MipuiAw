import{Q as u}from"./QTd-bd214e85.js";import{r as C,T as y,J as v,o as Q,c as z,a as e,u as s,h as a,b as r,i as x,F as V,R as p,Z as N,j as c,t as f,Q as m,k as B,l as T,m as q,n as I,p as M,w as R,d as Y,C as F}from"./app-bfca7ec4.js";import{Q as L}from"./QTable-e2e2fc3c.js";import{d as O}from"./date-37bbfee8.js";import{u as P}from"./use-quasar-8ef4c359.js";import"./index-d04a8c6f.js";import"./QSelect-0be4b91d.js";import"./QChip-fbdc1a57.js";import"./QMenu-7802b655.js";import"./use-fullscreen-0d7e226b.js";const U=r("h4",null,"Sub Organization List",-1),A={class:"q-pa-md"},E=r("span",{class:"text-weight-bold"},"Edit Sub Department",-1),$=["onSubmit"],j={class:"q-pa-md"},J={class:"q-gutter-x-md column",style:{width:"400px"}},ne={__name:"Index",props:{departments:[],subDepartment:""},setup(g){const l=P(),d=C(!1),n=y({sssubDepartment:""}),b=o=>{d.value=!0,n.organization_name=o.organization_name,n.id=o.id},_=[{name:"id",align:"left",label:"Sl No",field:"id",headerClasses:""},{name:"name",align:"left",label:"Sub Department Name",field:"organization_name"},{name:"subname",align:"left",label:"Parent Department",field:"department_id"},{name:"created_at",align:"left",label:"Created_at",field:"created_at",format:o=>O.formatDate(o,"DD MMM YYYY, hh:mm A")},{name:"actions",align:"left",label:"Action",field:"id"}],h=(o,i)=>{console.log(p)},w=o=>{console.log("Im the only one: "+n.id),n.put(route("department.update",n.id),{onStart:()=>{l.loading.show()},onSuccess:()=>{l.loading.hide(),l.notify({message:"Department Updated",closeBtn:!0,icon:"check",iconColor:"blue"}),d.value=!1},onFinish:()=>{l.loading.hide()}})},D=o=>{l.dialog({title:"Confirm Delete",message:"Are you sure?",ok:"Yes",cancel:"No"}).onOk(()=>{p.delete(route("department.destory",o),{onStart:()=>l.loading.show({message:"Deleteing..."}),onSuccess:()=>{l.notify({message:"Student deleted",closeBtn:!0}),l.loading.hide()},onFinish:()=>l.loading.hide()})})};return(o,i)=>{const k=v("Link");return Q(),z(V,null,[e(s(N),{title:"Sub Department Index"}),U,e(k,{href:"/department/create",class:"p-2 m-5 bg-blue-5 text-white shadow-2"},{default:a(()=>[c("New Sub Department")]),_:1}),r("div",A,[e(L,{rows:g.subDepartment,columns:_,"row-key":"name",onRequest:o.tableData,onRowClick:h,flat:"",bordered:"",title:"Sub-Organization List",separator:"cell",pagination:{sortBy:"id",rowsPerPage:10},"records-per-page-options":"[1,5,10]"},{"body-cell-id":a(t=>[e(u,{key:"id",props:t},{default:a(()=>[c(f(t.rowIndex+1),1)]),_:2},1032,["props"])]),"body-cell-subname":a(t=>[e(u,{props:t},{default:a(()=>[c(f(t.row.department.organization_name),1)]),_:2},1032,["props"])]),"body-cell-actions":a(t=>[e(u,{key:"action",props:t},{default:a(()=>[e(m,{dense:"",round:"",flat:"",color:"green",onClick:S=>b(t.row),icon:"edit"},null,8,["onClick"]),e(m,{dense:"",round:"",flat:"",color:"red",onClick:S=>D(t.row.id),icon:"delete"},null,8,["onClick"])]),_:2},1032,["props"])]),_:1},8,["rows","onRequest"]),e(x,{modelValue:d.value,"onUpdate:modelValue":i[1]||(i[1]=t=>d.value=t)},{default:a(()=>[e(B,null,{default:a(()=>[e(T,null,{default:a(()=>[e(q,null,{default:a(()=>[E]),_:1}),I(e(m,{flat:"",round:"",dense:"",icon:"close"},null,512),[[F]])]),_:1}),e(M,null,{default:a(()=>[r("form",{onSubmit:R(w,["prevent"]),method:"post"},[r("div",j,[r("div",J,[e(Y,{name:"organization_name",standout:"",modelValue:s(n).organization_name,"onUpdate:modelValue":i[0]||(i[0]=t=>s(n).organization_name=t),error:!!s(n).errors.organization_name,"error-message":s(n).errors.organization_name,dense:o.dense,placeholder:"Sub Department Name"},null,8,["modelValue","error","error-message","dense"]),e(m,{label:"Update",dense:"",color:"black",type:"submit",disable:s(n).processing},null,8,["disable"])])])],40,$)]),_:1})]),_:1})]),_:1},8,["modelValue"])])],64)}}};export{ne as default};
