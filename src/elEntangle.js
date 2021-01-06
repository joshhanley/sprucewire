export const elEntangle = {
    alpineEl: null,

    ensureStoreMissing(storeName) {
        if (!!Spruce.store(storeName)) {
            throw new Error('[Spruce Entangle] Spruce store "' + storeName + '" is already registered. Use loadStore.')
        }
    },

    ensureStoreExists(storeName) {
        if (!Spruce.store(storeName)) {
            throw new Error('[Spruce Entangle] Spruce store "' + storeName + '" is not registered. Use registerStore.')
        }
    },

    registerStore(storeName, state) {
        // Check if store exists
        console.log('Check Exists', Spruce.store(storeName), !!Spruce.store(storeName))
        this.ensureStoreMissing()

        // Register store
        console.log('Register Store', storeName, state)
        Spruce.store(storeName, state)

        // Find Livewire component
        console.log('Find Livewire Component')
        let livewireEl = this.alpineEl.closest('[wire\\:id]')

        if (!livewireEl || !livewireEl.__livewire) return
        console.log('Livewire Component Found')

        // Loop through store properties
        Object.entries(Spruce.store(storeName)).forEach(([propertyName, value]) => {
            // Check if we are entangling value
            if (!value || typeof value !== 'object' || !value.livewireEntangle) return
            console.log('Property', propertyName, value)

            let livewireProperty = value.livewireEntangle
            let isDeferred = value.isDeferred
            let livewireComponent = livewireEl.__livewire

            // Set initial value of spruce store property to Livewire properties value
            console.log('Livewire Property Value', JSON.parse(JSON.stringify(livewireEl.__livewire.get(livewireProperty))))
            Spruce.store(storeName)[propertyName] = JSON.parse(JSON.stringify(livewireEl.__livewire.get(livewireProperty)))
            console.log('Property Value', Spruce.store(storeName)[propertyName])

            // Register spruce watcher
            Spruce.watch(storeName + '.' + propertyName, (value) => {
                console.log('Spruce Watcher', value)

                // Check if Spruce and Livewire are the same and if so, then return
                // - This prevents a circular dependancy with the other watcher below.
                // - Due to the deep clone using stringify, we need to do the same here to compare.
                if (JSON.stringify(value) === JSON.stringify(livewireEl.__livewire.getPropertyValueIncludingDefers(livewireProperty))) return

                console.log('Spruce Not Equal')

                //Update Livewire property
                livewireComponent.set(livewireProperty, value, isDeferred)
            })

            // Register livewire watcher
            livewireComponent.watch(livewireProperty, (value) => {
                console.log('Livewire Watcher', value)
                // Update Spruce store property
                // Ensure data is deep cloned otherwise Spruce mutates Livewire data
                Spruce.store(storeName)[propertyName] = typeof value !== 'undefined' ? JSON.parse(JSON.stringify(value)) : value
            })
        })

        console.log(Spruce.store(storeName))
    },

    loadStore(storeName, state) {
        // Check if store doesn't exist
        console.log('Check Does Not Exist', Spruce.store(storeName), !!Spruce.store(storeName))
        this.ensureStoreExists()

        // Find Livewire component
        console.log('Find Livewire Component')
        let livewireEl = this.alpineEl.closest('[wire\\:id]')

        if (!livewireEl || !livewireEl.__livewire) return
        console.log('Livewire Component Found')

        // Loop through state properties
        Object.entries(state).forEach(([propertyName, value]) => {
            console.log('Loop Store', propertyName, value)

            // Check if store property exists
            if (!Spruce.store(storeName)[propertyName]) throw new Error('[Spruce Entangle] Spruce store "' + storeName + '" does not have property "' + propertyName + '".')

            // Check if we are entangling value
            if (!value || typeof value !== 'object' || !value.livewireEntangle) return
            console.log('Property', propertyName, value)

            let livewireProperty = value.livewireEntangle
            let isDeferred = value.isDeferred
            let livewireComponent = livewireEl.__livewire

            // Set initial value of Livewire property to Spruce store properties value if they are different
            console.log('Spruce Property Value', JSON.parse(JSON.stringify(Spruce.store(storeName)[propertyName])))
            // This ensures that if Livewire has set the property on multiple components to be the same that there isn't a request back to the server
            if (JSON.stringify(Spruce.store(storeName)[propertyName]) !== JSON.stringify(livewireEl.__livewire.getPropertyValueIncludingDefers(livewireProperty))) {
                livewireComponent.set(livewireProperty, JSON.parse(JSON.stringify(Spruce.store(storeName)[propertyName])), isDeferred)
            }
            console.log('Property Value', livewireEl.__livewire.getPropertyValueIncludingDefers(livewireProperty))

            // Register spruce watcher
            Spruce.watch(storeName + '.' + propertyName, (value) => {
                console.log('Spruce Watcher', value)

                // Check if Spruce and Livewire are the same and if so, then return
                // - This prevents a circular dependancy with the other watcher below.
                // - Due to the deep clone using stringify, we need to do the same here to compare.
                if (JSON.stringify(value) === JSON.stringify(livewireEl.__livewire.getPropertyValueIncludingDefers(livewireProperty))) return

                console.log('Spruce Not Equal')

                //Update Livewire property
                livewireComponent.set(livewireProperty, value, isDeferred)
            })

            // Register livewire watcher
            livewireComponent.watch(livewireProperty, (value) => {
                console.log('Livewire Watcher', value)
                // Update Spruce store property
                // Ensure data is deep cloned otherwise Spruce mutates Livewire data
                Spruce.store(storeName)[propertyName] = typeof value !== 'undefined' ? JSON.parse(JSON.stringify(value)) : value
            })
        })

        console.log(Spruce.store(storeName))
    },
}
