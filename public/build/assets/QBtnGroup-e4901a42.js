import{q as s,g as r,A as l,B as u}from"./app-bfca7ec4.js";const d=s({name:"QBtnGroup",props:{unelevated:Boolean,outline:Boolean,flat:Boolean,rounded:Boolean,square:Boolean,push:Boolean,stretch:Boolean,glossy:Boolean,spread:Boolean},setup(o,{slots:t}){const a=r(()=>{const n=["unelevated","outline","flat","rounded","square","push","stretch","glossy"].filter(e=>o[e]===!0).map(e=>`q-btn-group--${e}`).join(" ");return`q-btn-group row no-wrap${n.length>0?" "+n:""}`+(o.spread===!0?" q-btn-group--spread":" inline")});return()=>l("div",{class:a.value},u(t.default))}});export{d as Q};
