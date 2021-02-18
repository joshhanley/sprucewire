import { elEntangle } from './elEntangle'

const Sprucewire = {
    start() {
        this.attach()
    },

    attach() {
        this.checkDependencies()

        window.Alpine.addMagicProperty('sprucewire', (el) => {
            return this.getElEntangle(el)
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

export default Sprucewire
