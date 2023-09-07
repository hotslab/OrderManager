import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-page-not-found',
  template: `
  <div class="flex justify-center items-center min-h-screen">
    <h1 class="text-2xl font-black">NOT FOUND</h1>
  </div>
  `,
  styles: []
})
export class PageNotFoundComponent implements OnInit {

  constructor() { }

  ngOnInit() {
  }

}
