import{r as a,T as f,J as b,o as g,c as v,a as s,u as w,b as e,h as i,S as k,t as x,j as c,d as S,F as U,Z as C,ax as u}from"./app-bfca7ec4.js";import{u as N}from"./use-quasar-8ef4c359.js";const P={class:"m-5"},R={class:"row mt-3"},y=e("i",{class:"q-icon material-icons-outlined"}," arrow_back ",-1),T={class:"border shadow"},V={class:"row p-3 bg-grey-4 text-h5"},q={class:"p-5"},B={__name:"NewPhone",props:["CURRENT_USER","errors"],setup(m){const l=m,n=N(),r=a("");a(!1),a(""),a(!1);let _=f({new_mobilex:""});const p=()=>{_.transform(d=>({new_mobile:r.value})).get("/generateOtpForMobileUpdate",{onStart:()=>n.loading.show({message:"Uploading..."}),onFinish:()=>{n.loading.hide()},onSuccess:()=>{n.notify({message:"OTP Request Successfully",icon:"check",iconColor:"blue"})}})};return(d,o)=>{const h=b("Link");return g(),v(U,null,[s(w(C),{title:"Update Phone"}),e("div",P,[s(h,{class:"full-width border",onclick:"history.back();return false;"},{default:i(()=>[e("div",R,[s(u,{avatar:""},{default:i(()=>[y]),_:1}),s(u,null,{default:i(()=>[c(" Back ")]),_:1})])]),_:1}),e("div",T,[e("div",V,[e("div",{class:k(d.$q.screen.xs?"col-12":"col-8")}," Update Phone Number ",2)]),e("div",null,[e("div",q,[e("div",null," Old Phone : "+x(l.CURRENT_USER.mobile),1),e("div",null,[c(" New Phone : "),s(S,{outlined:"",dense:"",modelValue:r.value,"onUpdate:modelValue":o[0]||(o[0]=t=>r.value=t),style:{width:"300px"},mask:"##########",rules:[t=>t.length==10||"Must be 10 digits"],maxlength:"10",required:"",error:!!l.errors.new_mobile,"error-message":l.errors.new_mobile},null,8,["modelValue","rules","error","error-message"])]),e("div",{class:"cursor-pointer",onClick:o[1]||(o[1]=t=>p())}," Sent OTP ")])])])])],64)}}};export{B as default};
