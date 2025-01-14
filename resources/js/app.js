// Import application styles and bootstrap setup
import '../css/app.css';
import './bootstrap';

// Import necessary modules from Vue, Inertia.js, and Ziggy
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// Define the application name, defaulting to 'Laravel' if not set in the environment
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Create the Inertia.js application
createInertiaApp({
    // Set the document title format
    title: (title) => `${title} - ${appName}`,

    // Resolve the page components dynamically based on the given name
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`, // Path to the Vue component
            import.meta.glob('./Pages/**/*.vue'), // Glob to match all page components
        ),

    // Set up the Vue application
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) }) // Render the Inertia app
            .use(plugin) // Use the Inertia plugin
            .use(ZiggyVue) // Use the ZiggyVue plugin for route handling
            .mount(el); // Mount the application to the DOM
    },

    // Configure the progress bar shown during navigation
    progress: {
        color: '#4B5563', // Gray-600 color for the progress bar
    },
});
