import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-home',
  template: `
  <div
    class="continental-image  flex justify-center items-center m-0"
    style="background-image: url('../../assets/images/background.jpg');"
  >
    <div class="text-center flex flex-col justify-center items-center">
        <img
          class="mb-3 shadow-lg"
          id="banner-image"
          src="../../assets/images/logo.svg" width="250" height="250" priority
        >
        <h1 id="banner-text" class="text-white text-4xl font-bold">ORDER MANAGER</h1>
    </div>
  </div>
  `,
  styles: [`
  .continental-image {
    height: 100vh;
    background-size: 100%;
    background-size: cover; 
    background-position: center;
    background-repeat: no-repeat; 
  }
  `]
})
export class HomeComponent implements OnInit {

  constructor() { }

  ngOnInit() {}

}
