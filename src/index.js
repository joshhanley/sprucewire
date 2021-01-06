import { elEntangle } from './elEntangle'

const SpruceEntangle = {
    start() {
        console.log('start')
        this.attach()
    },

    attach() {
        this.checkDependencies()

        const self = this

        window.Alpine.addMagicProperty('spruceEntangle', (el) => {
            console.log('Spruce Entangle')

            return this.getElEntangle(el)
        })

        window.Alpine.addMagicProperty('entangleProperty', (el) => {
            return function (name, defer = false) {
                return {
                    isDeferred: defer,
                    livewireEntangle: name,
                }
            }
        })
    },

    checkDependencies() {
        if (!window.Alpine) throw new Error('[Spruce Entangle] Alpine must be running.')

        if (!window.Spruce) throw new Error('[Spruce Entangle] Spruce must be running.')

        return true
    },

    getElEntangle(el) {
        return Object.assign({}, elEntangle, {
            alpineEl: el,
        })
    },

    registerStore(el, storeName, state) {
        let elEntangle = this.getElEntangle(el)

        elEntangle.registerStore(storeName, state)
    },
}

window.SpruceEntangle = SpruceEntangle

const deferrer =
    window.deferLoadingAlpine ||
    function (callback) {
        callback()
    }

window.deferLoadingAlpine = function (callback) {
    window.SpruceEntangle.start()

    deferrer(callback)
}

// export default SpruceEntangle
