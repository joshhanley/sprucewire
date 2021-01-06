const e={alpineEl:null,livewireComponent:null,storeName:null,store:null,registerStore(e,t){this.ensureStoreMissing(e),this.createStore(e,t),this.findLivewireComponent(),this.livewireComponentNotLoaded()||Object.entries(t).forEach(([e,t])=>{if(this.isNotEntangleObject(t))return;let r=t.livewireEntangle,i=t.isDeferred;this.valuesAreNotEqual(this.getStoreProperty(e),this.getLivewireProperty(r))&&this.setStoreProperty(e,this.getLivewireProperty(r)),this.registerSpruceWatcher(e,r,i),this.registerLivewireWatcher(r,e)})},loadStore(e,t){this.ensureStoreExists(e),this.findStore(e),this.findLivewireComponent(),this.livewireComponentNotLoaded()||Object.entries(t).forEach(([e,t])=>{if(this.isNotEntangleObject(t))return;this.ensureStorePropertyExists(e);let r=t.livewireEntangle,i=t.isDeferred;this.valuesAreNotEqual(this.getStoreProperty(e),this.getLivewireProperty(r))&&this.setLivewireProperty(r,this.getStoreProperty(e),i),this.registerSpruceWatcher(e,r,i),this.registerLivewireWatcher(r,e)})},entangle:(e,t=!1)=>({isDeferred:t,livewireEntangle:e,get defer(){return this.isDeferred=!0,this}}),ensureStoreMissing(e){if(Spruce.store(e))throw new Error('[Sprucewire] Spruce store "'+e+'" is already registered. Use loadStore.')},ensureStoreExists(e){if(!Spruce.store(e))throw new Error('[Sprucewire] Spruce store "'+e+'" is not registered. Use registerStore.')},createStore(e,t){this.store=Spruce.store(e,this.clearEntangleValues(t)),this.storeName=e},clearEntangleValues(e){return Object.keys(e).reduce((t,r)=>(t[r]=this.isEntangleObject(e[r])?null:e[r],t),{})},findStore(e){this.store=Spruce.store(e),this.storeName=e},findLivewireComponent(){let e=this.alpineEl.closest("[wire\\:id]");e&&e.__livewire&&(this.livewireComponent=e.__livewire)},livewireComponentNotLoaded(){return!this.livewireComponent},isEntangleObject:e=>e&&"object"==typeof e&&e.livewireEntangle,isNotEntangleObject(e){return!this.isEntangleObject(e)},ensureStorePropertyExists(e){if(!this.store[e])throw new Error('[Sprucewire] Spruce store "'+this.storeName+'" does not have property "'+e+'".')},getLivewireProperty(e){return this.livewireComponent.getPropertyValueIncludingDefers(e)},getStoreProperty(e){return this.store[e]},setLivewireProperty(e,t,r){this.livewireComponent.set(e,this.cloneValue(t),r)},setStoreProperty(e,t){this.store[e]=this.cloneValue(t)},cloneValue:e=>void 0!==e?JSON.parse(JSON.stringify(e)):e,valuesAreEqual:(e,t)=>JSON.stringify(e)===JSON.stringify(t),valuesAreNotEqual(e,t){return!this.valuesAreEqual(e,t)},registerSpruceWatcher(e,t,r){Spruce.watch(this.storeName+"."+e,e=>{this.valuesAreEqual(e,this.getLivewireProperty(t))||this.setLivewireProperty(t,e,r)})},registerLivewireWatcher(e,t){this.livewireComponent.watch(e,e=>{this.valuesAreEqual(e,this.getStoreProperty(t))||this.setStoreProperty(t,e)})}},t={start(){console.log("start"),this.attach()},attach(){this.checkDependencies(),window.Alpine.addMagicProperty("sprucewire",e=>(console.log("Sprucewire"),this.getElEntangle(e)))},checkDependencies(){if(!window.Alpine)throw new Error("[Sprucewire] Alpine must be running.");if(!window.Spruce)throw new Error("[Sprucewire] Spruce must be running.");return!0},getElEntangle:t=>Object.assign({},e,{alpineEl:t}),registerStore(e,t,r){this.getElEntangle(e).registerStore(t,r)}};window.Sprucewire=t;const r=window.deferLoadingAlpine||function(e){e()};window.deferLoadingAlpine=function(e){window.Sprucewire.start(),r(e)};export default t;
//# sourceMappingURL=sprucewire.module.js.map
