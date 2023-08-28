import { reactive } from 'vue';

// Create a reactive bus object
const bus = reactive({
  emit(event, ...args) {
    bus[event]?.forEach((callback) => {
      callback(...args);
    });
  },
  on(event, callback) {
    if (!bus[event]) {
      bus[event] = [];
    }
    bus[event].push(callback);
  },
  off(event, callback) {
    const callbacks = bus[event];
    if (callbacks) {
      const index = callbacks.indexOf(callback);
      if (index !== -1) {
        callbacks.splice(index, 1);
      }
    }
  },
});

export default bus;
