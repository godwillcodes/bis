# Alpine.js Usage Guide

Alpine.js has been successfully set up in the BIS theme. This guide shows you how to use it.

## Setup

Alpine.js is loaded via CDN with the `defer` attribute, which means it will automatically initialize when the DOM is ready.

## Basic Usage

### x-data Directive

Use `x-data` to create a component scope:

```html
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>
    <div x-show="open">Content here</div>
</div>
```

### x-show / x-if

Toggle visibility:

```html
<!-- x-show (toggles display) -->
<div x-show="isVisible">Visible content</div>

<!-- x-if (removes from DOM) -->
<template x-if="isVisible">
    <div>Conditional content</div>
</template>
```

### Event Listeners

```html
<button @click="handleClick()">Click me</button>
<input @input="handleInput($event)" />
<form @submit.prevent="handleSubmit()">...</form>
```

### Two-way Binding

```html
<input x-model="name" type="text" />
<p x-text="name"></p>
```

## Common Patterns

### Dropdown Menu

```html
<div x-data="{ open: false }">
    <button @click="open = !open">Menu</button>
    <div x-show="open" @click.away="open = false">
        Menu content
    </div>
</div>
```

### Modal

```html
<div x-data="{ open: false }">
    <button @click="open = true">Open Modal</button>
    
    <div x-show="open" 
         x-transition
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div @click.away="open = false" class="bg-white p-6 rounded">
            Modal content
            <button @click="open = false">Close</button>
        </div>
    </div>
</div>
```

### Tabs

```html
<div x-data="{ activeTab: 1 }">
    <button @click="activeTab = 1" :class="{ 'active': activeTab === 1 }">Tab 1</button>
    <button @click="activeTab = 2" :class="{ 'active': activeTab === 2 }">Tab 2</button>
    
    <div x-show="activeTab === 1">Tab 1 content</div>
    <div x-show="activeTab === 2">Tab 2 content</div>
</div>
```

## Configuration

To add custom stores or directives, edit `/js/alpine-config.js`:

```javascript
document.addEventListener('alpine:init', () => {
    // Add a global store
    Alpine.store('theme', {
        darkMode: false,
        toggle() {
            this.darkMode = !this.darkMode;
        }
    });
    
    // Use in templates: x-data="$store.theme"
});
```

## Resources

- [Alpine.js Documentation](https://alpinejs.dev/)
- [Alpine.js GitHub](https://github.com/alpinejs/alpine)

