import{Q as m}from"./QTd-bd214e85.js";import{K as V,g as y,r as Q,T as w,o as r,c as u,a as e,u as a,b as t,h as s,i as k,F as C,Z as T,j as U,t as x,Q as c,k as A,l as E,m as R,n as S,p as B,w as N,d as I,f as q,C as D}from"./app-bfca7ec4.js";import{Q as L}from"./QTable-e2e2fc3c.js";import{u as P}from"./use-quasar-8ef4c359.js";import{u as j}from"./vue-router-9d2630ad.js";import"./QSelect-0be4b91d.js";import"./QChip-fbdc1a57.js";import"./QMenu-7802b655.js";import"./use-fullscreen-0d7e226b.js";const F={class:"m-4"},M=t("h4",{class:"mb-4"},"Action",-1),K={class:"q-pa-md"},O={key:0},Z={key:1},$=t("span",{class:"text-weight-bold"},"Edit Action",-1),z=["onSubmit"],G={class:"q-pa-md"},H={class:"q-gutter-x-md column",style:{width:"400px"}},ie={__name:"Index",props:{actions:Object},setup(p){const b=P(),f=V(),_=y(()=>f.props.CURRENT_USER),d=Q(!1),l=w({id:"",label:"",visible:""});j();const g=i=>{d.value=!0,l.id=i.id,l.label=i.label,l.visible=i.visible},v=[{name:"id",align:"left",label:"ID",field:"id",headerClasses:""},{name:"label",align:"left",label:"Label",field:"label"},{name:"name",align:"left",label:"Value",field:"name"},{name:"visible",align:"left",label:"Visible",field:"visible"},{name:"actions",align:"left",label:"Action",field:"id"}],h=i=>{console.log("Im the only one: "+i),l.put(route("action.update",l.id),{onSuccess:()=>{d.value=!1,b.notify({message:"Action Updated",closeBtn:!0,icon:"check",iconColor:"blue"})}})};return(i,n)=>(r(),u(C,null,[e(a(T),{title:"Action List"}),t("div",F,[M,t("div",K,[e(L,{rows:p.actions,columns:v,"row-key":"name",flat:"",bordered:"",title:"Action List",separator:"cell",pagination:{sortBy:"id",rowsPerPage:10},"records-per-page-options":"[1,5,10]"},{"body-cell-id":s(o=>[e(m,{key:"id",props:o},{default:s(()=>[U(x(o.rowIndex+1),1)]),_:2},1032,["props"])]),"body-cell-actions":s(o=>[e(m,{key:"action",props:o},{default:s(()=>[a(_).role_id==1?(r(),u("div",O,[e(c,{dense:"",round:"",flat:"",color:"green",onClick:J=>g(o.row),icon:"edit"},null,8,["onClick"])])):(r(),u("div",Z," - "))]),_:2},1032,["props"])]),_:1},8,["rows"]),e(k,{modelValue:d.value,"onUpdate:modelValue":n[2]||(n[2]=o=>d.value=o)},{default:s(()=>[e(A,null,{default:s(()=>[e(E,null,{default:s(()=>[e(R,null,{default:s(()=>[$]),_:1}),S(e(c,{flat:"",round:"",dense:"",icon:"close"},null,512),[[D]])]),_:1}),e(B,null,{default:s(()=>[t("form",{onSubmit:N(h,["prevent"]),method:"post"},[t("div",G,[t("div",H,[e(I,{name:"label",standout:"",modelValue:a(l).label,"onUpdate:modelValue":n[0]||(n[0]=o=>a(l).label=o),error:!!a(l).errors.label,"error-message":a(l).errors.label,dense:i.dense,placeholder:"Action Name"},null,8,["modelValue","error","error-message","dense"]),t("div",null,[e(q,{modelValue:a(l).visible,"onUpdate:modelValue":n[1]||(n[1]=o=>a(l).visible=o),label:"Visibility for dropdown","true-value":"1","false-value":"0","left-label":""},null,8,["modelValue"])]),e(c,{label:"Update",dense:"",color:"black",type:"submit",disable:a(l).processing},null,8,["disable"])])])],40,z)]),_:1})]),_:1})]),_:1},8,["modelValue"])])])],64))}};export{ie as default};
