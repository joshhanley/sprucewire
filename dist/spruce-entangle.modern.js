const e={alpineEl:null,loadStore(e,r){if(console.log("Check Does Not Exist",Spruce.store(e),!!Spruce.store(e)),!Spruce.store(e))throw new Error('[Spruce Entangle] Spruce store "'+e+'" is not registered. Use registerStore.');console.log("Find Livewire Component");let o=this.alpineEl.closest("[wire\\:id]");o&&o.__livewire&&(console.log("Livewire Component Found"),Object.entries(r).forEach(([r,t])=>{if(console.log("Loop Store",r,t),!Spruce.store(e)[r])throw new Error('[Spruce Entangle] Spruce store "'+e+'" does not have property "'+r+'".');if(!t||"object"!=typeof t||!t.livewireEntangle)return;console.log("Property",r,t);let n=t.livewireEntangle,i=t.isDeferred,l=o.__livewire;console.log("Spruce Property Value",JSON.parse(JSON.stringify(Spruce.store(e)[r]))),JSON.stringify(Spruce.store(e)[r])!==JSON.stringify(o.__livewire.getPropertyValueIncludingDefers(n))&&l.set(n,JSON.parse(JSON.stringify(Spruce.store(e)[r])),i),console.log("Property Value",o.__livewire.getPropertyValueIncludingDefers(n)),Spruce.watch(e+"."+r,e=>{console.log("Spruce Watcher",e),JSON.stringify(e)!==JSON.stringify(o.__livewire.getPropertyValueIncludingDefers(n))&&(console.log("Spruce Not Equal"),l.set(n,e,i))}),l.watch(n,o=>{console.log("Livewire Watcher",o),Spruce.store(e)[r]=void 0!==o?JSON.parse(JSON.stringify(o)):o})}),console.log(Spruce.store(e)))},registerStore(e,r){if(console.log("Check Exists",Spruce.store(e),!!Spruce.store(e)),Spruce.store(e))throw new Error('[Spruce Entangle] Spruce store "'+e+'" is already registered. Use loadStore.');console.log("Register Store",e,r),Spruce.store(e,r),console.log("Find Livewire Component");let o=this.alpineEl.closest("[wire\\:id]");o&&o.__livewire&&(console.log("Livewire Component Found"),Object.entries(Spruce.store(e)).forEach(([r,t])=>{if(!t||"object"!=typeof t||!t.livewireEntangle)return;console.log("Property",r,t);let n=t.livewireEntangle,i=t.isDeferred,l=o.__livewire;console.log("Livewire Property Value",JSON.parse(JSON.stringify(o.__livewire.get(n)))),Spruce.store(e)[r]=JSON.parse(JSON.stringify(o.__livewire.get(n))),console.log("Property Value",Spruce.store(e)[r]),Spruce.watch(e+"."+r,e=>{console.log("Spruce Watcher",e),JSON.stringify(e)!==JSON.stringify(o.__livewire.getPropertyValueIncludingDefers(n))&&(console.log("Spruce Not Equal"),l.set(n,e,i))}),l.watch(n,o=>{console.log("Livewire Watcher",o),Spruce.store(e)[r]=void 0!==o?JSON.parse(JSON.stringify(o)):o})}),console.log(Spruce.store(e)))}},r={start(){console.log("start"),this.attach()},attach(){this.checkDependencies(),window.Alpine.addMagicProperty("spruceEntangle",e=>(console.log("Spruce Entangle"),this.getElEntangle(e))),window.Alpine.addMagicProperty("entangleProperty",e=>function(e,r=!1){return{isDeferred:r,livewireEntangle:e}})},checkDependencies(){if(!window.Alpine)throw new Error("[Spruce Entangle] Alpine must be running.");if(!window.Spruce)throw new Error("[Spruce Entangle] Spruce must be running.");return!0},getElEntangle:r=>Object.assign({},e,{alpineEl:r}),registerStore(e,r,o){this.getElEntangle(e).registerStore(r,o)}};window.SpruceEntangle=r;const o=window.deferLoadingAlpine||function(e){e()};window.deferLoadingAlpine=function(e){window.SpruceEntangle.start(),o(e)};
//# sourceMappingURL=spruce-entangle.modern.js.map
