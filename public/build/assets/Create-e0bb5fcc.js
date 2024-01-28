import{q,s as O,r as w,v as D,x as I,y as j,z as M,A as R,B as T,D as z,E as P,G,H as L,I as H,T as K,o as i,c as d,a as r,u as t,h as Y,F as Z,Z as $,b as s,Q,j as J,d as y,t as m,e as c}from"./app-bfca7ec4.js";import{Q as U}from"./QSelect-0be4b91d.js";import{u as W}from"./use-quasar-8ef4c359.js";import"./QChip-fbdc1a57.js";import"./QMenu-7802b655.js";const X=q({name:"QForm",props:{autofocus:Boolean,noErrorFocus:Boolean,noResetFocus:Boolean,greedy:Boolean,onSubmit:Function},emits:["reset","validationSuccess","validationError"],setup(x,{slots:C,emit:b}){const F=O(),f=w(null);let V=0;const v=[];function e(l){const g=typeof l=="boolean"?l:x.noErrorFocus!==!0,k=++V,B=(a,u)=>{b("validation"+(a===!0?"Success":"Error"),u)},A=a=>{const u=a.validate();return typeof u.then=="function"?u.then(p=>({valid:p,comp:a}),p=>({valid:!1,comp:a,err:p})):Promise.resolve({valid:u,comp:a})};return(x.greedy===!0?Promise.all(v.map(A)).then(a=>a.filter(u=>u.valid!==!0)):v.reduce((a,u)=>a.then(()=>A(u).then(p=>{if(p.valid===!1)return Promise.reject(p)})),Promise.resolve()).catch(a=>[a])).then(a=>{if(a===void 0||a.length===0)return k===V&&B(!0),!0;if(k===V){const{comp:u,err:p}=a[0];if(p!==void 0&&console.error(p),B(!1,u),g===!0){const E=a.find(({comp:N})=>typeof N.focus=="function"&&z(N.$)===!1);E!==void 0&&E.comp.focus()}}return!1})}function _(){V++,v.forEach(l=>{typeof l.resetValidation=="function"&&l.resetValidation()})}function S(l){l!==void 0&&P(l);const g=V+1;e().then(k=>{g===V&&k===!0&&(x.onSubmit!==void 0?b("submit",l):l!==void 0&&l.target!==void 0&&typeof l.target.submit=="function"&&l.target.submit())})}function h(l){l!==void 0&&P(l),b("reset"),G(()=>{_(),x.autofocus===!0&&x.noResetFocus!==!0&&o()})}function o(){L(()=>{if(f.value===null)return;const l=f.value.querySelector("[autofocus][tabindex], [data-autofocus][tabindex]")||f.value.querySelector("[autofocus] [tabindex], [data-autofocus] [tabindex]")||f.value.querySelector("[autofocus], [data-autofocus]")||Array.prototype.find.call(f.value.querySelectorAll("[tabindex]"),g=>g.tabIndex>-1);l!=null&&l.focus({preventScroll:!0})})}D(H,{bindComponent(l){v.push(l)},unbindComponent(l){const g=v.indexOf(l);g>-1&&v.splice(g,1)}});let n=!1;return I(()=>{n=!0}),j(()=>{n===!0&&x.autofocus===!0&&o()}),M(()=>{x.autofocus===!0&&o()}),Object.assign(F.proxy,{validate:e,resetValidation:_,submit:S,reset:h,focus:o,getValidationComponents:()=>v}),()=>R("form",{class:"q-form",ref:f,onSubmit:S,onReset:h},T(C.default))}}),ee={class:"py-12"},te={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},oe=s("h3",{class:"mb-2"},"Create State Nodal Officer",-1),ne={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},le={class:"p-6 text-gray-900 ml-3"},se=s("div",{class:"ml-3 mb-5"},[s("div",{class:"mb-8 flex justify-center"}," Add State Nodal Officer ")],-1),ae=["textContent"],re=["textContent"],ie=["textContent"],de=["textContent"],ue=["textContent"],me=["textContent"],ce=["textContent"],fe=["textContent"],xe=["textContent"],ve=["textContent"],pe={class:"mt-3"},be=["textContent"],Ve={class:"mt-3"},ke={__name:"Create",props:["departments","roles"],setup(x){const C=x,b=W(),F=w(!1),f=w(C.departments);w(C.roles);const V=[{label:"Yes",value:1},{label:"No",value:0}],v=["Female","Male"];let e=K({name:"",email:"",password:"",mobile:"",gender:"",designation:"",address:"",pincode:"",alternate_mobile:"",notification:"",active:"",department:"",role:"",department:C.departments.organization_name}),_=()=>{e.post("/admin/nodal",{onStart:()=>b.loading.show({message:"Creating..."}),onSuccess:()=>{b.notify({message:"User Created",closeBtn:!0}),b.loading.hide()},onFinish:()=>b.loading.hide(),preserveScroll:!0})};const S=(h,o)=>{if(h){o(()=>{f.value=C.departments.filter(n=>n.label.toLowerCase().includes(h.toLowerCase()))});return}o(()=>{f.value=C.departments})};return(h,o)=>(i(),d(Z,null,[r(t($),{title:"Create User"}),r(X,{onSubmit:t(_)},{default:Y(()=>[s("div",ee,[s("div",te,[oe,r(Q,{href:"#",onclick:"history.back();return false;",color:"primary",label:"Back"}),s("div",ne,[s("div",le,[J(" Create State Nodal Officer "),se,s("div",null,[s("div",null,[r(y,{modelValue:t(e).name,"onUpdate:modelValue":o[0]||(o[0]=n=>t(e).name=n),label:"Full Name"},null,8,["modelValue"]),t(e).errors.name?(i(),d("div",{key:0,textContent:m(t(e).errors.name),class:"text-red-500 text-xs mt-3"},null,8,ae)):c("",!0)]),s("div",null,[r(y,{modelValue:t(e).email,"onUpdate:modelValue":o[1]||(o[1]=n=>t(e).email=n),label:"Email"},null,8,["modelValue"]),t(e).errors.email?(i(),d("div",{key:0,textContent:m(t(e).errors.email),class:"text-red-500 text-xs mt-3"},null,8,re)):c("",!0)]),s("div",null,[r(y,{modelValue:t(e).password,"onUpdate:modelValue":o[2]||(o[2]=n=>t(e).password=n),label:"Password"},null,8,["modelValue"]),t(e).errors.password?(i(),d("div",{key:0,textContent:m(t(e).errors.password),class:"text-red-500 text-xs mt-3"},null,8,ie)):c("",!0)]),s("div",null,[r(y,{modelValue:t(e).mobile,"onUpdate:modelValue":o[3]||(o[3]=n=>t(e).mobile=n),label:"Mobile",counter:"",maxlength:"10",mask:"##########",rules:[n=>n.length==10||"Must be 10 digits"]},null,8,["modelValue","rules"]),t(e).errors.mobile?(i(),d("div",{key:0,textContent:m(t(e).errors.mobile),class:"text-red-500 text-xs mt-3"},null,8,de)):c("",!0)]),s("div",null,[r(U,{label:"Gender",modelValue:t(e).gender,"onUpdate:modelValue":o[4]||(o[4]=n=>t(e).gender=n),options:v,style:{width:"250px"}},null,8,["modelValue"]),t(e).errors.gender?(i(),d("div",{key:0,textContent:m(t(e).errors.gender),class:"text-red-500 text-xs mt-3"},null,8,ue)):c("",!0)]),s("div",null,[r(y,{modelValue:t(e).designation,"onUpdate:modelValue":o[5]||(o[5]=n=>t(e).designation=n),label:"Designation"},null,8,["modelValue"]),t(e).errors.designation?(i(),d("div",{key:0,textContent:m(t(e).errors.designation),class:"text-red-500 text-xs mt-3"},null,8,me)):c("",!0)]),s("div",null,[r(y,{modelValue:t(e).address,"onUpdate:modelValue":o[6]||(o[6]=n=>t(e).address=n),label:"Office Address"},null,8,["modelValue"]),t(e).errors.address?(i(),d("div",{key:0,textContent:m(t(e).errors.address),class:"text-red-500 text-xs mt-3"},null,8,ce)):c("",!0)]),s("div",null,[r(y,{modelValue:t(e).pincode,"onUpdate:modelValue":o[7]||(o[7]=n=>t(e).pincode=n),label:"Pincode"},null,8,["modelValue"]),t(e).errors.pincode?(i(),d("div",{key:0,textContent:m(t(e).errors.pincode),class:"text-red-500 text-xs mt-3"},null,8,fe)):c("",!0)]),s("div",null,[r(y,{modelValue:t(e).alternate_mobile,"onUpdate:modelValue":o[8]||(o[8]=n=>t(e).alternate_mobile=n),label:"Alternate mobile (Optional)"},null,8,["modelValue"]),t(e).errors.alternate_mobile?(i(),d("div",{key:0,textContent:m(t(e).errors.alternate_mobile),class:"text-red-500 text-xs mt-3"},null,8,xe)):c("",!0)]),s("div",null,[r(U,{label:"Active",modelValue:t(e).active,"onUpdate:modelValue":o[9]||(o[9]=n=>t(e).active=n),options:V,style:{width:"250px"}},null,8,["modelValue"]),t(e).errors.active?(i(),d("div",{key:0,textContent:m(t(e).errors.active),class:"text-red-500 text-xs mt-3"},null,8,ve)):c("",!0)]),s("div",pe,[r(U,{modelValue:t(e).department,"onUpdate:modelValue":o[10]||(o[10]=n=>t(e).department=n),"use-input":"","input-debounce":"0",label:"Department",options:f.value,onFilter:S,style:{width:"250px"},behavior:"menu"},null,8,["modelValue","options"]),t(e).errors.department?(i(),d("div",{key:0,textContent:m(t(e).errors.department),class:"text-red-500 text-xs mt-3"},null,8,be)):c("",!0)])])])]),s("div",Ve,[r(Q,{label:"Submit",color:"primary",type:"submit",disable:F.value},null,8,["disable"])])])])]),_:1},8,["onSubmit"])],64))}};export{ke as default};
