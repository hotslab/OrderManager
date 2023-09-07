import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  template: `
  <nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <!-- Mobile menu button-->
          <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
            <span class="absolute -inset-0.5"></span>
            <span class="sr-only">Open main menu</span>
            <!--
              Icon when menu is closed.

              Menu open: "hidden", Menu closed: "block"
            -->
            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <!--
              Icon when menu is open.

              Menu open: "block", Menu closed: "hidden"
            -->
            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
          <div [routerLink]="['/']" class="flex flex-shrink-0 items-center cursor-pointer">
            <img class="h-8 w-auto" src="../../assets/images/logo.svg" alt="Your Company">
          </div>
          <div class="hidden sm:ml-6 sm:block">
            <div class="flex space-x-4">
              <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
              <a [routerLink]="['/orders']" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Orders</a>
              <a [routerLink]="['/login']" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Login</a>
              <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Logout</a>
            </div>
          </div>
        </div>
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
              <button [routerLink]="['/user']" type="button" class="ml-3 flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                <span class="absolute -inset-1.5"></span>
                <span class="sr-only">Open user profile</span>
                <i class="fa-solid text-white text-lg fa-user">text</i>
              </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden" id="mobile-menu">
      <div class="space-y-1 px-2 pb-3 pt-2">
        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
        <a [routerLink]="['/orders']" class="bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Orders</a>
        <a [routerLink]="['/login']" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Login</a>
        <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Logout</a>
      </div>
    </div>
  </nav>
  <div class="min-h-screen p-0 m-0">
    <router-outlet></router-outlet>
  </div>
  <footer class="bg-black h-100 px-3 py-4 text-white text-center flex flex-col justify-between items-center">
    <span class="mb-3">
      OrderManager 
      <i class="fa-solid text-lg fa-copyright">text</i>
      <!-- <span class="material-icons">copyright</span>  -->
      {{ today | date: 'yyyy' }}
    </span>
    <span class="text-xs">All rights reserved</span>
  </footer>
  `,
})
export class AppComponent {
  title = 'frontend';
  today = new Date()
}
