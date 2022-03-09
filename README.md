![Image of Sprucewire](https://github.com/joshhanley/sprucewire/blob/main/art/Sprucewire-Logo.png)

# Sprucewire

Sprucewire is adapter between Spruce and Livewire, that enables them to be entangled.

It brings the power of Spruce's global state to Livewire so you can seamlessly share data between Livewire components and keep their state in sync.

- [Sprucewire Video](https://www.youtube.com/watch?v=Etwv6jW0Z_w)
- [Demo App](https://sprucewire.joshhanley.com.au/)

The code was inspired by Livewire's @entangle, that was developed by [Caleb Porzio](https://github.com/calebporzio) for use between Livewire and Alpine. It was packaged up by [Josh Hanley](https://github.com/joshhanley) and adapted  for use with Spruce (by [Ryan Chandler](https://github.com/ryangjchandler)).

## Getting Started

It's recommended that you read the documentation of these packages before going through this document:

- [Livewire](https://laravel-livewire.com/docs)
- [Alpine](https://github.com/alpinejs/alpine)
- [Spruce](https://spruce.ryangjchandler.co.uk/)

To use this package you need to:

- [Install and configure Livewire](https://laravel-livewire.com/docs/2.x/installation) ^2.3.6
- [Install Alpine](https://github.com/alpinejs/alpine#install) ^2.7.3
- [Install Spruce](https://spruce.ryangjchandler.co.uk/installation) ^2.6.3 (but don't setup a store)

**Note** Spruce doesn't not support Alpine V3, as such, neither does Sprucewire as it is an extension of Spruce.

## Installation

To install, you can use either:

 - CDN (recommended)
 - NPM

### CDN

To install sprucewire via CDN, include the following script tag to the end of your `<body>` after where you have added Spruce (see [Spruce Installation](https://spruce.ryangjchandler.co.uk/installation#npm-recommended)):

```html
<script src="https://cdn.jsdelivr.net/npm/@joshhanley/sprucewire@0.x.x/dist/sprucewire.umd.js"></script>
```

### NPM

To install sprucewire using NPM, run the following command in your project terminal

```bash
npm install @joshhanley/sprucewire
```

Then add this to your javascript file underneath Spruce (but before Alpine)

```js
import '@joshhanley/sprucewire'
```

## Usage

To use Sprucewire, you need to:

1. Setup stores (using Sprucewire)
2. Use stores (as per Spruce docs)

### Setup Stores
Sprucewire has two different ways to setup and make use of a Spruce store:

- [Register Store](#register-store)
- [Load Store](#load-store)

The method you should use changes depending on whether you are accessing the store in a parent Livewire component or in a child Livewire component (see below for details).

### Use Stores
Once the Store is registered/ loaded using Sprucewire, the rest of using these stores is just the normal Spruce methods. See ["accessing a store from Alpine"](https://spruce.ryangjchandler.co.uk/stores#accessing-a-store-from-alpine).

---

## Register Store

Register store should be used in any parent Livewire component (like a full page component) where you want it to setup and configure the store and seed the stores data with it's initial values.

To register a store, setup Alpine in your parent component, and then call Sprucewire's register store method  `$sprucewire.registerStore()` from your Alpine `x-init` attribute.

**Example**

```html
<div x-data x-init="
    $sprucewire.registerStore('main', {
        name: $sprucewire.entangle('name'),
        sample: $sprucewire.entangle('sample').defer
    });
">
    {{-- Content here --}}
</div>
```

**Store Name**
The first parameter is the name of your Spruce store you want to setup, in the example above it's called 'main'.

**Store Properties**
The second parameter is an object, where you use a similar feature to Livewire's entangle, to entangle Livewire and Spruce properties together.

Each key/value pair is defined like this:

- **The key** is the name of the Spruce store property name
- **The value** is the Livewire property name that you want to "entangle" using Sprucewire's own entangle method `$sprucewire.entangle()`

`$sprucewire.entangle()` can be passed Livewire property names using dot notation.

You can also append `.defer` if you want the Livewire property changes to be deferred.

## Load Store

Load store should be used in any child components that you just want to access and make use of the store.

**:exclamation:Warning:** Any properties that are currently set in the Spruce store will be loaded into your Livewire child component properties, **potentially overwritting what is already there**.

To load a store, similar to registering a store, you setup Alpine in your child component, and then call Sprucewire's load store method `$sprucewire.loadStore()` from your Alpine `x-init` attribute.

**Example**

```html
<div x-data x-init="
    $sprucewire.loadStore('main', {
        name: $sprucewire.entangle('name'),
        sample: $sprucewire.entangle('random').defer
    });
">
    {{-- Content here --}}
</div>
```

The parameters of load store are the same as in register store with the same object setup.

### :bulb: **Property Names Note**

In this example above, a different Livewire property `random` has been mapped to Spruce's property `sample`.

Where as the register store example the Livewire property `sample` was mapped to Spruce's property `sample`.

This demonstrates that you can have different property names in your Livewire components, but as long as the Spruce store property name is the same, then it will still all work.

## Demo App

There is a demo of Sprucewire in action at https://sprucewire.joshhanley.com.au/.

Source code for the demo can be found here https://github.com/joshhanley/sprucewire-demo/.

## Troubleshooting

**:exclamation: Make sure Livewire child components all have a key set**

## Known Limitations

When entangling the following data types, certain modifications can't be done from Spruce, so use Livewire:
- Associative arrays: removing an array item by name won't work
- Collections: Making changes converts it from a collection to an array on Livewire end
- Eloquent collections: adding/removing items won't work
