# Sprucewire

An adapter for Livewire and Spruce enabling them to be entangled.

The code was developed by [Caleb Porzio](https://github.com/calebporzio) for using @entangle between Livewire and Alpine, and packaged up by [Josh Hanley](https://github.com/joshhanley) for use with Spruce.

## Getting Started

It's recommended that you read the documentation of these packages before going through this document:

- [Livewire](https://laravel-livewire.com/docs)
- [Spruce](https://docs.ryangjchandler.co.uk/spruce)

## Installation

To install, run the following command from the terminal:

## Usage

To use this package you need to:

- [Install and configure Livewire](https://laravel-livewire.com/docs/2.x/installation)
- [Install Alpine](https://github.com/alpinejs/alpine#install)
- [Install Spruce](https://docs.ryangjchandler.co.uk/spruce/installation) (but don't setup a store)

## Limitations

Entangling scalar properties or individual properties of a model property works.

There is a bug when binding arrays and collections, where if you try to add or remove from Spruce end, changes aren't replicated in Livewire.

Collections and arrays work fine if changed from the Livewire end though.
