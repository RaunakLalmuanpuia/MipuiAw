import{q as d,s as u,g as v,A as n,B as r}from"./app-bfca7ec4.js";const p=d({name:"QTd",props:{props:Object,autoWidth:Boolean,noHover:Boolean},setup(t,{slots:e}){const l=u(),a=v(()=>"q-td"+(t.autoWidth===!0?" q-table--col-auto-width":"")+(t.noHover===!0?" q-td--no-hover":"")+" ");return()=>{if(t.props===void 0)return n("td",{class:a.value},r(e.default));const c=l.vnode.key,o=(t.props.colsMap!==void 0?t.props.colsMap[c]:null)||t.props.col;if(o===void 0)return;const{row:s}=t.props;return n("td",{class:a.value+o.__tdClass(s),style:o.__tdStyle(s)},r(e.default))}}});export{p as Q};
