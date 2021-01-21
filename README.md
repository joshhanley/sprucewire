![Image of Sprucewire](https://github.com/joshhanley/sprucewire/blob/main/art/Sprucewire.png)

# Sprucewire

An adapter for Livewire and Spruce enabling them to be entangled.

The code was developed by [Caleb Porzio](https://github.com/calebporzio) for using @entangle between Livewire and Alpine, and packaged up by [Josh Hanley](https://github.com/joshhanley) for use with Spruce (by [Ryan Chandler](https://github.com/ryangjchandler)).

## Getting Started

It's recommended that you read the documentation of these packages before going through this document:

- [Livewire](https://laravel-livewire.com/docs)
- [Spruce](https://docs.ryangjchandler.co.uk/spruce)

To use this package you need to:

- [Install and configure Livewire](https://laravel-livewire.com/docs/2.x/installation)
- [Install Alpine](https://github.com/alpinejs/alpine#install)
- [Install Spruce](https://docs.ryangjchandler.co.uk/spruce/installation) (but don't setup a store)

## Installation

To install, you can use either:

 - CDN (recommended)
 - NPM

### CDN

To install sprucewire via CDN, include the following script tag to the end of your `<body>` after where you have added Spruce (see [Spruce Installation](https://docs.ryangjchandler.co.uk/spruce/installation#npm-recommended)):

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
import '@joshhanleu/sprucewire'
```

## Usage

Sprucewire has two different ways to setup and make use of a Spruce store:

- Register Store
- Load Store

The method you should use changes depending on whether you are accessing the store in a parent Livewire component or in a child Livewire component.

### Register Store

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

### Load Store

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

#### :bulb: **Property Names Note**

In this example above, a different Livewire property `random` has been mapped to Spruce's property `sample`.

Where as the register store example the Livewire property `sample` was mapped to Spruce's property `sample`.

This demonstrates that you can have different property names in your Livewire components, but as long as the Spruce store property name is the same, then it will still all work.


## Limitations

Entangling scalar properties or individual properties of a model property works.

There is a bug when binding arrays and collections, where if you try to add or remove from Spruce end, changes aren't replicated in Livewire.

Collections and arrays work fine if changed from the Livewire end though.

## Troubleshooting

**:exclamation: Make sure child components all have a key set**
