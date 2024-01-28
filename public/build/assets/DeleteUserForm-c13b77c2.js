import{o as u,c as _,cg as w,Y as $,z as C,c7 as B,g as D,M as S,a,h as r,n as m,P as f,b as e,aY as p,S as v,u as c,e as V,bi as E,r as x,T,G as U,j as y,cT as A}from"./app-bfca7ec4.js";import{_ as M}from"./_plugin-vue_export-helper-c27b6911.js";import{_ as N}from"./InputError-c26e6dab.js";import{_ as P,a as z}from"./TextInput-cffe87e6.js";const K={},O={class:"inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"};function W(t,n){return u(),_("button",O,[w(t.$slots,"default")])}const g=M(K,[["render",W]]),j={class:"fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50","scroll-region":""},F=e("div",{class:"absolute inset-0 bg-gray-500 opacity-75"},null,-1),I=[F],L={__name:"Modal",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0}},emits:["close"],setup(t,{emit:n}){const o=t;$(()=>o.show,()=>{o.show?document.body.style.overflow="hidden":document.body.style.overflow=null});const s=()=>{o.closeable&&n("close")},i=l=>{l.key==="Escape"&&o.show&&s()};C(()=>document.addEventListener("keydown",i)),B(()=>{document.removeEventListener("keydown",i),document.body.style.overflow=null});const d=D(()=>({sm:"sm:max-w-sm",md:"sm:max-w-md",lg:"sm:max-w-lg",xl:"sm:max-w-xl","2xl":"sm:max-w-2xl"})[o.maxWidth]);return(l,b)=>(u(),S(E,{to:"body"},[a(p,{"leave-active-class":"duration-200"},{default:r(()=>[m(e("div",j,[a(p,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0","enter-to-class":"opacity-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:r(()=>[m(e("div",{class:"fixed inset-0 transform transition-all",onClick:s},I,512),[[f,t.show]])]),_:1}),a(p,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to-class":"opacity-100 translate-y-0 sm:scale-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100 translate-y-0 sm:scale-100","leave-to-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:r(()=>[m(e("div",{class:v(["mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto",c(d)])},[t.show?w(l.$slots,"default",{key:0}):V("",!0)],2),[[f,t.show]])]),_:3})],512),[[f,t.show]])]),_:3})]))}},Y=["type"],G={__name:"SecondaryButton",props:{type:{type:String,default:"button"}},setup(t){return(n,o)=>(u(),_("button",{type:t.type,class:"inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"},[w(n.$slots,"default")],8,Y))}},q={class:"space-y-6"},H=e("header",null,[e("h2",{class:"text-lg font-medium text-gray-900"},"Delete Account"),e("p",{class:"mt-1 text-sm text-gray-600"}," Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain. ")],-1),J={class:"p-6"},Q=e("h2",{class:"text-lg font-medium text-gray-900"}," Are you sure you want to delete your account? ",-1),R=e("p",{class:"mt-1 text-sm text-gray-600"}," Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account. ",-1),X={class:"mt-6"},Z={class:"mt-6 flex justify-end"},ae={__name:"DeleteUserForm",setup(t){const n=x(!1),o=x(null),s=T({password:""}),i=()=>{n.value=!0,U(()=>o.value.focus())},d=()=>{s.delete(route("profile.destroy"),{preserveScroll:!0,onSuccess:()=>l(),onError:()=>o.value.focus(),onFinish:()=>s.reset()})},l=()=>{n.value=!1,s.reset()};return(b,h)=>(u(),_("section",q,[H,a(g,{onClick:i},{default:r(()=>[y("Delete Account")]),_:1}),a(L,{show:n.value,onClose:l},{default:r(()=>[e("div",J,[Q,R,e("div",X,[a(P,{for:"password",value:"Password",class:"sr-only"}),a(z,{id:"password",ref_key:"passwordInput",ref:o,modelValue:c(s).password,"onUpdate:modelValue":h[0]||(h[0]=k=>c(s).password=k),type:"password",class:"mt-1 block w-3/4",placeholder:"Password",onKeyup:A(d,["enter"])},null,8,["modelValue","onKeyup"]),a(N,{message:c(s).errors.password,class:"mt-2"},null,8,["message"])]),e("div",Z,[a(G,{onClick:l},{default:r(()=>[y(" Cancel ")]),_:1}),a(g,{class:v(["ml-3",{"opacity-25":c(s).processing}]),disabled:c(s).processing,onClick:d},{default:r(()=>[y(" Delete Account ")]),_:1},8,["class","disabled"])])])]),_:1},8,["show"])]))}};export{ae as default};
