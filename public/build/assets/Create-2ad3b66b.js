import{q,W as k,s as w,X as C,g as f,A as p,B as g,K as y,T as B,o as v,c as x,a as i,u as s,b as e,h as V,S as n,t as b,e as _,d as A,Q as N,F as Q,Z as S,j as $}from"./app-bfca7ec4.js";import{Q as D}from"./QSelect-0be4b91d.js";import{u as F}from"./use-quasar-8ef4c359.js";import"./QChip-fbdc1a57.js";import"./QMenu-7802b655.js";const R=q({name:"QBanner",props:{...k,inlineActions:Boolean,dense:Boolean,rounded:Boolean},setup(a,{slots:r}){const{proxy:{$q:c}}=w(),h=C(a,c),d=f(()=>"q-banner row items-center"+(a.dense===!0?" q-banner--dense":"")+(h.value===!0?" q-banner--dark q-dark":"")+(a.rounded===!0?" rounded-borders":"")),t=f(()=>`q-banner__actions row items-center justify-end col-${a.inlineActions===!0?"auto":"all"}`);return()=>{const u=[p("div",{class:"q-banner__avatar col-auto row items-center self-start"},g(r.avatar)),p("div",{class:"q-banner__content col text-body2"},g(r.default))],o=g(r.action);return o!==void 0&&u.push(p("div",{class:t.value},o)),p("div",{class:d.value+(a.inlineActions===!1&&o!==void 0?" q-banner--top-padding":""),role:"alert"},u)}}}),I={class:"mt-5 ml-5"},P=e("h3",null,"Lodge Appeal",-1),T={class:"row m-3"},U=["textContent"],j={class:"row m-3"},z=e("div",{class:"text-blue"},"Maximum 2000 characters are allowed in the textbox ",-1),O=["textContent"],W={class:"row m-3 mt-3"},E={key:0,class:"bg-red-2 border-red-9 mt-5 p-4 border-2"},G=e("div",{class:"text-red-9 text-h6 text-bold"}," WARNING! ",-1),K={class:"text-grey-9"},J={__name:"Create",props:["grievances"],setup(a){const r=a,c=F(),h=y(),d=f(()=>h.props.flash.message);let t=B({grievance:"",reason:""});const u=()=>{t.post("/citizen/appeal",{onStart:()=>c.loading.show({message:"Uploading..."}),onFinish:()=>{c.loading.hide()}})};return(o,m)=>(v(),x(Q,null,[i(s(S),{title:"Appeal"}),e("div",I,[P,e("div",null,[e("div",null,[i(R,{class:"bg-light-blue-2 border text-red-8 m-5"},{default:V(()=>[$(' Please Note : This option can be used to lodge appeal for the grievances which are closed during last 30 days where the feedback has been provided as "POOR" and option to file appeal was not selected ')]),_:1})]),e("div",T,[e("div",{class:n(["mr-5 text-bold",o.$q.screen.xs?"col-12 text-left":"col-3 text-right"])}," Registration Number ",2),e("div",{class:n(o.$q.screen.xs?"col-12":"col-8")},[i(D,{"stack-label":"",modelValue:s(t).grievance,"onUpdate:modelValue":m[0]||(m[0]=l=>s(t).grievance=l),options:r.grievances,label:"-- Select registration number --",dense:"",outlined:""},null,8,["modelValue","options"]),s(t).errors.grievance?(v(),x("div",{key:0,textContent:b(s(t).errors.grievance),class:"text-red-500 text-xs mt-3"},null,8,U)):_("",!0)],2)]),e("div",j,[e("div",{class:n(["mr-5 text-bold",o.$q.screen.xs?"col-12 text-left":"col-3 text-right"])}," Reason For Appeal ",2),e("div",{class:n(o.$q.screen.xs?"col-12":"col-8")},[z,e("div",null,[i(A,{type:"textarea",class:"border p-3",id:"reason",modelValue:s(t).reason,"onUpdate:modelValue":m[1]||(m[1]=l=>s(t).reason=l),rows:"5",rules:[l=>l.length==2e3],maxlength:"2000",counter:""},null,8,["modelValue","rules"]),s(t).errors.reason?(v(),x("div",{key:0,textContent:b(s(t).errors.reason),class:"text-red-500 text-xs mt-3"},null,8,O)):_("",!0)])],2)]),e("div",W,[e("div",{class:n(["mr-5 text-bold",o.$q.screen.xs?"col-12 text-left":"col-3 text-right"])},null,2),e("div",{class:n(o.$q.screen.xs?"col-12":"col-8")},[i(N,{color:"primary",icon:"save",label:"Submit",onClick:u})],2)]),s(d)?(v(),x("div",E,[G,e("div",K,b(s(d)),1)])):_("",!0)])])],64))}};export{J as default};