import{T as d,o as l,c as r,b as t,a as o,u as e,t as c,e as u,w as _,h as p,S as f,Z as w,j as y}from"./app-bfca7ec4.js";import{_ as g}from"./InputError-c26e6dab.js";import{_ as b,a as h}from"./TextInput-cffe87e6.js";import{P as v}from"./PrimaryButton-4053eb17.js";import"./_plugin-vue_export-helper-c27b6911.js";const x={class:"row justify-center mt-5"},k={class:"col-4"},V=t("div",{class:"mb-4 text-sm text-gray-600"}," Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one. ",-1),N={key:0,class:"mb-4 font-medium text-sm text-green-600"},P=["onSubmit"],S={class:"flex items-center justify-end mt-4"},T={__name:"ForgotPassword",props:{status:{type:String}},setup(a){const s=d({email:""}),m=()=>{s.post(route("password.email"))};return(B,i)=>(l(),r("div",x,[t("div",k,[o(e(w),{title:"Forgot Password"}),V,a.status?(l(),r("div",N,c(a.status),1)):u("",!0),t("div",null,[t("form",{onSubmit:_(m,["prevent"])},[t("div",null,[o(b,{for:"email",value:"Email"}),o(h,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:e(s).email,"onUpdate:modelValue":i[0]||(i[0]=n=>e(s).email=n),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),o(g,{class:"mt-2",message:e(s).errors.email},null,8,["message"])]),t("div",S,[o(v,{class:f({"opacity-25":e(s).processing}),disabled:e(s).processing},{default:p(()=>[y(" Email Password Reset Link ")]),_:1},8,["class","disabled"])])],40,P)])])]))}};export{T as default};