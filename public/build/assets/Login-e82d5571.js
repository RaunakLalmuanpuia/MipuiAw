import{g as _,n as k,cH as V,u as s,o as m,c as x,b6 as P,K as B,r as C,T as q,a,b as t,S as g,w as R,d as h,h as c,M as y,e as v,F as L,Z as S,L as U,j as f,U as b}from"./app-bfca7ec4.js";import{_ as w}from"./InputError-c26e6dab.js";import{P as $}from"./PrimaryButton-4053eb17.js";import{u as j}from"./use-quasar-8ef4c359.js";import"./_plugin-vue_export-helper-c27b6911.js";const F=["value"],N={__name:"Checkbox",props:{checked:{type:[Array,Boolean],required:!0},value:{default:null}},emits:["update:checked"],setup(i,{emit:p}){const r=i,l=_({get(){return r.checked},set(e){p("update:checked",e)}});return(e,u)=>k((m(),x("input",{type:"checkbox",value:i.value,"onUpdate:modelValue":u[0]||(u[0]=d=>P(l)?l.value=d:null),class:"rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"},null,8,F)),[[V,s(l)]])}},M={class:"row justify-center"},Q=t("div",{class:"bg-grey-4 text-center text-2xl py-2"}," Login ",-1),A={class:"p-5"},E=["onSubmit"],I={class:"mt-4"},T={class:"block mt-4"},z={class:"flex items-center"},D=t("span",{class:"ml-2 text-sm text-gray-600"},"Remember me",-1),H={class:"flex items-center justify-end mt-4"},K={class:"flex justify-end mt-4"},X={__name:"Login",props:{canResetPassword:{type:Boolean},status:{type:String}},setup(i){const p=B(),r=C(!0),l=j(),e=q({email:"",password:"",remember:!1}),u=()=>{e.post(route("login"),{onStart:()=>l.loading.show({message:"Processing..."}),onFinish:()=>[e.reset("password"),l.loading.hide()]})};return _(()=>p.props.isAuth),(d,o)=>(m(),x(L,null,[a(s(S),{title:"Log in"}),t("div",M,[t("div",{class:g(["border m-5 shadow-2",d.$q.screen.xs?"col-11  ":"col-6"])},[Q,t("div",A,[t("form",{onSubmit:R(u,["prevent"])},[t("div",null,[a(h,{label:"Email",id:"email",type:"email",class:"w-full",modelValue:s(e).email,"onUpdate:modelValue":o[0]||(o[0]=n=>s(e).email=n),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),a(w,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),t("div",I,[a(h,{label:"Password",id:"password",dense:"",class:"mt-1 block w-full",modelValue:s(e).password,"onUpdate:modelValue":o[2]||(o[2]=n=>s(e).password=n),required:"",autocomplete:"current-password",type:r.value?"password":"text"},{append:c(()=>[a(U,{name:r.value?"visibility_off":"visibility",class:"cursor-pointer",onClick:o[1]||(o[1]=n=>r.value=!r.value)},null,8,["name"])]),_:1},8,["modelValue","type"]),a(w,{class:"mt-2",message:s(e).errors.password},null,8,["message"])]),t("div",T,[t("label",z,[a(N,{name:"remember",checked:s(e).remember,"onUpdate:checked":o[3]||(o[3]=n=>s(e).remember=n)},null,8,["checked"]),D])]),t("div",H,[i.canResetPassword?(m(),y(s(b),{key:0,href:d.route("password.request"),class:"underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"},{default:c(()=>[f(" Forgot your password? ")]),_:1},8,["href"])):v("",!0),a($,{class:g(["ml-4",{"opacity-25":s(e).processing}]),disabled:s(e).processing},{default:c(()=>[f(" Log in ")]),_:1},8,["class","disabled"])]),t("div",K,[i.canResetPassword?(m(),y(s(b),{key:0,href:d.route("register"),class:"underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"},{default:c(()=>[f(" Register ")]),_:1},8,["href"])):v("",!0)])],40,E)])],2)])],64))}};export{X as default};
