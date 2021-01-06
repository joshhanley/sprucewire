import { elEntangle } from './elEntangle'

const Sprucewire = {
    start() {
        console.log('start')
        this.attach()
    },

    attach() {
        this.checkDependencies()

        const self = this

        window.Alpine.addMagicProperty('sprucewire', (el) => {
            console.log('Sprucewire')

            return this.getElEntangle(el)
        })

        window.Alpine.addMagicProperty('entangleProperty', (el) => {
            return function (name, defer = false) {
                return {
                    isDeferred: defer,
                    livewireEntangle: name,
                    get defer() {
                        this.isDeferred = true
                        return this
                    },
                }
            }
        })
    },

    checkDependencies() {
        if (!window.Alpine) throw new Error('[Sprucewire] Alpine must be running.')

        if (!window.Spruce) throw new Error('[Sprucewire] Spruce must be running.')

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

window.Sprucewire = Sprucewire

const deferrer =
    window.deferLoadingAlpine ||
    function (callback) {
        callback()
    }

window.deferLoadingAlpine = function (callback) {
    window.Sprucewire.start()

    deferrer(callback)
}

// export default Sprucewire
