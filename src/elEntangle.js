export const elEntangle = {
    alpineEl: null,
    livewireComponent: null,
    storeName: null,
    store: null,

    registerStore(storeName, state) {
        // Check if store exists
        this.ensureStoreMissing(storeName)

        // Register store
        this.createStore(storeName, state)

        // Find Livewire component
        this.findLivewireComponent()
        if (this.livewireComponentNotLoaded()) return

        // Loop through state properties
        Object.entries(state).forEach(([storeProperty, entangleObject]) => {
            // Check if we are entangling value
            if (this.isNotEntangleObject(entangleObject)) return

            let livewireProperty = entangleObject.livewireEntangle
            let isDeferred = entangleObject.isDeferred

            // Set initial value of spruce store property to Livewire properties value if they are different
            if (this.valuesAreNotEqual(this.getStoreProperty(storeProperty), this.getLivewireProperty(livewireProperty))) {
                this.setStoreProperty(storeProperty, this.getLivewireProperty(livewireProperty))
            }

            // Register spruce watcher
            this.registerSpruceWatcher(storeProperty, livewireProperty, isDeferred)

            // Register livewire watcher
            this.registerLivewireWatcher(livewireProperty, storeProperty)
        })
    },

    loadStore(storeName, state) {
        // Check if store doesn't exist
        this.ensureStoreExists(storeName)

        // Find store
        this.findStore(storeName)

        // Find Livewire component
        this.findLivewireComponent()
        if (this.livewireComponentNotLoaded()) return

        // Loop through state properties
        Object.entries(state).forEach(([storeProperty, entangleObject]) => {
            // Check if we are entangling value
            if (this.isNotEntangleObject(entangleObject)) return

            // Check if store property exists
            this.ensureStorePropertyExists(storeProperty)

            let livewireProperty = entangleObject.livewireEntangle
            let isDeferred = entangleObject.isDeferred

            // Set initial value of Livewire property to Spruce store properties value if they are different
            // This ensures that if Livewire has set the property on multiple components to be the same that there isn't a request back to the server
            if (this.valuesAreNotEqual(this.getStoreProperty(storeProperty), this.getLivewireProperty(livewireProperty))) {
                this.setLivewireProperty(livewireProperty, this.getStoreProperty(storeProperty), isDeferred)
            }

            // Register spruce watcher
            this.registerSpruceWatcher(storeProperty, livewireProperty, isDeferred)

            // Register livewire watcher
            this.registerLivewireWatcher(livewireProperty, storeProperty)
        })
    },

    entangle(name, defer = false) {
        return {
            isDeferred: defer,
            livewireEntangle: name,
            get defer() {
                this.isDeferred = true
                return this
            },
        }
    },

    ensureStoreMissing(storeName) {
        if (!!Spruce.store(storeName)) {
            throw new Error('[Sprucewire] Spruce store "' + storeName + '" is already registered. Use loadStore.')
        }
    },

    ensureStoreExists(storeName) {
        if (!Spruce.store(storeName)) {
            throw new Error('[Sprucewire] Spruce store "' + storeName + '" is not registered. Use registerStore.')
        }
    },

    createStore(storeName, state) {
        // Remove any values that are entangle objects from the state before assigning
        this.store = Spruce.store(storeName, this.clearEntangleValues(state))
        this.storeName = storeName
    },

    clearEntangleValues(state) {
        // Duplicate state and remove any entangle objects and set with null
        return Object.keys(state).reduce((result, key) => {
            result[key] = this.isEntangleObject(state[key]) ? null : state[key]
            return result
        }, {})
    },

    findStore(storeName) {
        this.store = Spruce.store(storeName)
        this.storeName = storeName
    },

    findLivewireComponent() {
        let livewireEl = this.alpineEl.closest('[wire\\:id]')

        if (livewireEl && livewireEl.__livewire) {
            this.livewireComponent = livewireEl.__livewire
        }
    },

    livewireComponentNotLoaded() {
        return !this.livewireComponent
    },

    isEntangleObject(value) {
        return value && typeof value === 'object' && value.livewireEntangle
    },

    isNotEntangleObject(value) {
        return !this.isEntangleObject(value)
    },

    ensureStorePropertyExists(property) {
        if (!this.store[property]) throw new Error('[Sprucewire] Spruce store "' + this.storeName + '" does not have property "' + property + '".')
    },

    getLivewireProperty(property) {
        return this.livewireComponent.getPropertyValueIncludingDefers(property)
    },

    getStoreProperty(property) {
        let value = this.cloneValue(this.store[property])

        // Unset watchers if they exist to ensure they don't get sent to Livewire
        if (value) {
            delete value.__watchers
        }

        return value
    },

    setLivewireProperty(property, value, isDeferred) {
        // Ensure data is deep cloned when set
        this.livewireComponent.set(property, this.cloneValue(value), isDeferred)
    },

    setStoreProperty(property, value) {
        // Ensure data is deep cloned when set
        this.store[property] = this.cloneValue(value)
    },

    cloneValue(value) {
        // Use stringify and parse as a hack to deep clone
        return typeof value !== 'undefined' ? JSON.parse(JSON.stringify(value)) : value
    },

    valuesAreEqual(value1, value2) {
        // Due to the deep clone using stringify, we need to do the same here to compare.
        return JSON.stringify(value1) === JSON.stringify(value2)
    },

    valuesAreNotEqual(value1, value2) {
        return !this.valuesAreEqual(value1, value2)
    },

    registerSpruceWatcher(storeProperty, livewireProperty, isDeferred) {
        Spruce.watch(this.storeName + '.' + storeProperty, (value) => {
            // Check if new Spruce value and Livewire are the same and if so, then return to prevent a circular dependancy with other watcher.
            if (this.valuesAreEqual(this.getStoreProperty(storeProperty), this.getLivewireProperty(livewireProperty))) return

            //Update Livewire property
            this.setLivewireProperty(livewireProperty, this.getStoreProperty(storeProperty), isDeferred)
        })
    },

    registerLivewireWatcher(livewireProperty, storeProperty) {
        this.livewireComponent.watch(livewireProperty, (value) => {
            // Check if Spruce and new Livewire value are the same and if so, then return to prevent a circular dependancy with other watcher.
            if (this.valuesAreEqual(value, this.getStoreProperty(storeProperty))) return

            // Update Spruce store property
            this.setStoreProperty(storeProperty, value)
        })
    },
}
