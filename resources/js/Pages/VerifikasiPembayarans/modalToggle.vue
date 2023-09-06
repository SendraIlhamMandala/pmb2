

<template>
    <div>
        <button @click="openModal"
            class="modal-open bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-full">Open
            Modal</button>
        <button @click="toggleForm"
            class="modal-open bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-full">Open
            Modal</button>

        <!-- Modal -->

        <div v-if="isModalOpen" class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50 top-0 left-0"></div>
        <transition name="slide" mode="out-in">
            <div v-if="isModalOpen"
                class="modal opacity-100 pointer-events-auto fixed w-full h-full top-0 left-0 flex items-center justify-center">

                <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

                    <div @click="closeModal"
                        class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
                        <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                            viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                            </path>
                        </svg>
                        <span class="text-sm">(Esc)</span>
                    </div>

                    <div class="modal-content py-4 text-left px-6">
                        <!--Title-->
                        <div class="flex justify-between items-center pb-3">
                            <p class="text-2xl font-bold">Simple Modal!</p>
                            <div @click="closeModal" class="modal-close cursor-pointer z-50">
                                <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18"
                                    height="18" viewBox="0 0 18 18">
                                    <path
                                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                                    </path>
                                </svg>
                            </div>
                        </div>

                        <!--Body-->
                        <p>Modal content can go here</p>
                        <p>...</p>
                        <p>...</p>
                        <p>...</p>
                        <p>...</p>

                        <!--Footer-->
                        <div class="flex justify-end pt-2">
                            <button
                                class="px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2">Action</button>
                            <button @click="closeModal"
                                class="px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>

    <transition name="slide" mode="out-in">
        <div v-if="showForm" key="form" class=" z-10  p-4 bg-white shadow-md rounded-md">
            <!-- Your form fields go here -->

            <div class="button flex justify-center items-center mb-4 ">

                asdfasdf
            </div>

            <button>sdafa</button>
        </div>
    </transition>
</template>
  
<script setup>
import { ref } from 'vue';

const isModalOpen = ref(false);

const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

document.onkeydown = (evt) => {
    evt = evt || window.event;
    const isEscape = evt.key === 'Escape' || evt.key === 'Esc' || evt.keyCode === 27;

    if (isEscape && isModalOpen.value) {
        closeModal();
    }
};

// Close modal when clicking outside of it
document.addEventListener('mousedown', (event) => {
    const modal = document.querySelector('.modal-container');
    if (modal && !modal.contains(event.target)) {
        closeModal();
    }
});

const showForm = ref(false);

const toggleForm = () => {
    showForm.value = !showForm.value;
};
</script>
  

  
<style>
.slide-enter-active,
.slide-leave-active {
    transition: all 0.5s ease;
}

.slide-enter-from,
.slide-leave-to {
    opacity: 0;
    transform: translateY(-5%);
}

.slide-enter-to,
.slide-leave-from {
    transform: translateX(0);
    opacity: 100;
}</style>
    