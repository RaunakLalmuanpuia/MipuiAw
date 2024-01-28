import{r as v,T as w,o as a,c as d,a as r,u as t,b as s,Q as N,j as b,d as u,t as i,e as m,w as k,F as O,Z as h}from"./app-bfca7ec4.js";import{Q as x}from"./QSelect-0be4b91d.js";import"./QChip-fbdc1a57.js";import"./QMenu-7802b655.js";const U=["onSubmit"],E={class:"py-12"},F={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},B={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},D={class:"p-6 text-gray-900 ml-3"},Q=s("div",{class:"ml-3 mb-5"},[s("div",{class:"mb-8 flex justify-center"}," Edit Nodal Officer ")],-1),M=["textContent"],S=["textContent"],A=["textContent"],L=["textContent"],R=["textContent"],j=["textContent"],P=["textContent"],T=["textContent"],G=["textContent"],I=["textContent"],Y={class:"mt-2"},Z={style:{"min-width":"250px","max-width":"300px"}},q={class:"mt-3"},z=["textContent"],H=s("div",{class:"mt-3"},[s("button",{type:"submit",class:"bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500"}," Update ")],-1),$={__name:"Edit",props:["roles","stateNodalOfficer","departments","myDepartment","myRole","referer"],setup(V){const n=V,c=[{label:"Yes",value:1},{label:"No",value:0}],f=v(n.departments),_=["Female","Male"],y=v(n.roles),e=w({name:n.stateNodalOfficer.name,email:n.stateNodalOfficer.email,role_id:n.stateNodalOfficer.role_id,mobile:n.stateNodalOfficer.mobile,password:n.stateNodalOfficer.password,gender:n.stateNodalOfficer.gender,designation:n.stateNodalOfficer.designation,address:n.stateNodalOfficer.address,pincode:n.stateNodalOfficer.pincode,alternate_mobile:n.stateNodalOfficer.alternate_mobile,notification:n.stateNodalOfficer.notification,active:n.stateNodalOfficer.active==1?c[0]:c[1],role:n.myRole,department:n.myDepartment,referer:n.referer}),g=p=>{e.put(route("nodal.update",n.stateNodalOfficer.id))},C=(p,l)=>{if(p){l(()=>{f.value=n.departments.filter(o=>o.label.toLowerCase().includes(p.toLowerCase()))});return}l(()=>{f.value=n.departments})};return(p,l)=>(a(),d(O,null,[r(t(h),{title:"Edit User"}),s("form",{onSubmit:k(g,["prevent"])},[s("div",E,[s("div",F,[r(N,{href:"#",onclick:"history.back();return false;",color:"primary",label:"Back"}),s("div",B,[s("div",D,[b(" Edit Nodal Officer "),Q,s("div",null,[s("div",null,[r(u,{modelValue:t(e).name,"onUpdate:modelValue":l[0]||(l[0]=o=>t(e).name=o),label:"Full Name"},null,8,["modelValue"]),t(e).errors.name?(a(),d("div",{key:0,textContent:i(t(e).errors.name),class:"text-red-500 text-xs mt-3"},null,8,M)):m("",!0)]),s("div",null,[r(u,{modelValue:t(e).email,"onUpdate:modelValue":l[1]||(l[1]=o=>t(e).email=o),label:"Email"},null,8,["modelValue"]),t(e).errors.email?(a(),d("div",{key:0,textContent:i(t(e).errors.email),class:"text-red-500 text-xs mt-3"},null,8,S)):m("",!0)]),s("div",null,[r(u,{modelValue:t(e).mobile,"onUpdate:modelValue":l[2]||(l[2]=o=>t(e).mobile=o),label:"Mobile",counter:"",maxlength:"10",mask:"##########",rules:[o=>o.length==10||"Must be 10 digits"]},null,8,["modelValue","rules"]),t(e).errors.mobile?(a(),d("div",{key:0,textContent:i(t(e).errors.mobile),class:"text-red-500 text-xs mt-3"},null,8,A)):m("",!0)]),s("div",null,[r(u,{modelValue:t(e).password,"onUpdate:modelValue":l[3]||(l[3]=o=>t(e).password=o),label:"Password (Leave blank to retain password)"},null,8,["modelValue"]),t(e).errors.password?(a(),d("div",{key:0,textContent:i(t(e).errors.password),class:"text-red-500 text-xs mt-3"},null,8,L)):m("",!0)]),s("div",null,[r(x,{label:"Gender",modelValue:t(e).gender,"onUpdate:modelValue":l[4]||(l[4]=o=>t(e).gender=o),options:_,style:{width:"250px"}},null,8,["modelValue"]),b(),t(e).errors.gender?(a(),d("div",{key:0,textContent:i(t(e).errors.gender),class:"text-red-500 text-xs mt-3"},null,8,R)):m("",!0)]),s("div",null,[r(u,{modelValue:t(e).designation,"onUpdate:modelValue":l[5]||(l[5]=o=>t(e).designation=o),label:"Designation"},null,8,["modelValue"]),t(e).errors.designation?(a(),d("div",{key:0,textContent:i(t(e).errors.designation),class:"text-red-500 text-xs mt-3"},null,8,j)):m("",!0)]),s("div",null,[r(u,{modelValue:t(e).address,"onUpdate:modelValue":l[6]||(l[6]=o=>t(e).address=o),label:"Office Address"},null,8,["modelValue"]),t(e).errors.address?(a(),d("div",{key:0,textContent:i(t(e).errors.address),class:"text-red-500 text-xs mt-3"},null,8,P)):m("",!0)]),s("div",null,[r(u,{modelValue:t(e).pincode,"onUpdate:modelValue":l[7]||(l[7]=o=>t(e).pincode=o),label:"Pincode"},null,8,["modelValue"]),t(e).errors.pincode?(a(),d("div",{key:0,textContent:i(t(e).errors.pincode),class:"text-red-500 text-xs mt-3"},null,8,T)):m("",!0)]),s("div",null,[r(u,{modelValue:t(e).alternate_mobile,"onUpdate:modelValue":l[8]||(l[8]=o=>t(e).alternate_mobile=o),label:"Alternate mobile (Optional)"},null,8,["modelValue"]),t(e).errors.alternate_mobile?(a(),d("div",{key:0,textContent:i(t(e).errors.alternate_mobile),class:"text-red-500 text-xs mt-3"},null,8,G)):m("",!0)]),s("div",null,[r(x,{modelValue:t(e).active,"onUpdate:modelValue":l[9]||(l[9]=o=>t(e).active=o),label:"Active",options:c,style:{width:"250px"},"map-options":""},null,8,["modelValue"]),t(e).errors.active?(a(),d("div",{key:0,textContent:i(t(e).errors.active),class:"text-red-500 text-xs mt-3"},null,8,I)):m("",!0)])]),s("div",Y,[s("div",Z,[r(x,{modelValue:t(e).role,"onUpdate:modelValue":l[10]||(l[10]=o=>t(e).role=o),"input-debounce":"0",label:"Roles",options:y.value,style:{width:"250px"},behavior:"menu"},null,8,["modelValue","options"])])]),s("div",q,[r(x,{modelValue:t(e).department,"onUpdate:modelValue":l[11]||(l[11]=o=>t(e).department=o),"use-input":"","input-debounce":"0",label:"Department",options:f.value,onFilter:C,style:{width:"250px"},behavior:"menu"},null,8,["modelValue","options"]),t(e).errors.department?(a(),d("div",{key:0,textContent:i(t(e).errors.department),class:"text-red-500 text-xs mt-3"},null,8,z)):m("",!0)])])]),H])])],40,U)],64))}};export{$ as default};