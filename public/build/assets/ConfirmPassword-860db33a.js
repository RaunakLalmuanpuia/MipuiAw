import{T as n,o as m,c as l,a,u as o,b as e,h as d,S as c,w as p,F as u,Z as f,j as _}from"./app-bfca7ec4.js";import{_ as w}from"./InputError-c26e6dab.js";import{_ as b,a as h}from"./TextInput-cffe87e6.js";import{P as g}from"./PrimaryButton-4053eb17.js";import"./_plugin-vue_export-helper-c27b6911.js";const x=e("div",{class:"mb-4 text-sm text-gray-600"}," This is a secure area of the application. Please confirm your password before continuing. ",-1),y=["onSubmit"],P={class:"flex justify-end mt-4"},S={__name:"ConfirmPassword",setup(V){const s=n({password:""}),t=()=>{s.post(route("password.confirm"),{onFinish:()=>s.reset()})};return(v,r)=>(m(),l(u,null,[a(o(f),{title:"Confirm Password"}),x,e("form",{onSubmit:p(t,["prevent"])},[e("div",null,[a(b,{for:"password",value:"Password"}),a(h,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:o(s).password,"onUpdate:modelValue":r[0]||(r[0]=i=>o(s).password=i),required:"",autocomplete:"current-password",autofocus:""},null,8,["modelValue"]),a(w,{class:"mt-2",message:o(s).errors.password},null,8,["message"])]),e("div",P,[a(g,{class:c(["ml-4",{"opacity-25":o(s).processing}]),disabled:o(s).processing},{default:d(()=>[_(" Confirm ")]),_:1},8,["class","disabled"])])],40,y)],64))}};export{S as default};
