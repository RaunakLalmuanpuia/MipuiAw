import{r as v,T as g,z as h,o as i,c as m,a as n,u as t,b as e,w as C,Q as b,d as y,t as f,e as x,n as R,P as U,F as E,Z as S}from"./app-bfca7ec4.js";import{Q as w}from"./QSelect-0be4b91d.js";import{u as N}from"./use-quasar-8ef4c359.js";import"./QChip-fbdc1a57.js";import"./QMenu-7802b655.js";const V={class:""},k={class:"py-12"},Q={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},T=e("h4",{class:"mb-2"},"Create Category",-1),B={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},D={class:"p-6 text-gray-900 ml-3"},F=e("div",{class:"ml-3 mb-5"},[e("div",{class:"mb-8 flex justify-center"}," Add Category ")],-1),j=["textContent"],I=["textContent"],M=e("div",{class:"mt-3"},[e("button",{type:"submit",class:"bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500"}," Create ")],-1),Z={__name:"Create",props:{errors:Object,departments:"",CURRENT_USER:""},setup(u){const r=u;let l=v(!0);const p=N();let s=g({name:"",department:"",errors:""});var d="";h(()=>{r.CURRENT_USER.role_id==3&&(console.log("09876596t"),l.value=!1,console.log(l),d=r.CURRENT_USER.department_id)});let c=()=>{(r.CURRENT_USER.role_id==1||r.CURRENT_USER.role_id==2)&&(d=s.department.value),s.transform(_=>({..._,department:d})).post("/admin/category",{onStart:()=>p.loading.show({message:"Creating..."}),onFinish:()=>{p.loading.hide()}})};return(_,o)=>(i(),m(E,null,[n(t(S),{title:"Create Category"}),e("div",V,[e("form",{onSubmit:o[2]||(o[2]=C((...a)=>t(c)&&t(c)(...a),["prevent"]))},[e("div",k,[e("div",Q,[T,n(b,{href:"#",onclick:"history.back();return false;",color:"primary",label:"Back"}),e("div",B,[e("div",D,[F,e("div",null,[n(y,{modelValue:t(s).name,"onUpdate:modelValue":o[0]||(o[0]=a=>t(s).name=a),label:"Category Name"},null,8,["modelValue"]),t(s).errors.name?(i(),m("div",{key:0,textContent:f(t(s).errors.name),class:"text-red-500 text-xs mt-3"},null,8,j)):x("",!0)]),R(e("div",null,[n(w,{modelValue:t(s).department,"onUpdate:modelValue":o[1]||(o[1]=a=>t(s).department=a),options:u.departments,label:"-- Select department --"},null,8,["modelValue","options"]),t(s).errors.department?(i(),m("div",{key:0,textContent:f(t(s).errors.department),class:"text-red-500 text-xs mt-3"},null,8,I)):x("",!0)],512),[[U,t(l)]])])]),M])])],32)])],64))}};export{Z as default};
