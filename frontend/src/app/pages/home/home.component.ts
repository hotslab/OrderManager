import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-home',
  template: `
    <p class="text-danger">
      home works!
    </p>
    <div class="bg-white rounded-lg p-20 m-20 shadow-lg text-center">
      <button class="bg-blue hover:bg-indigo text-red-500 font-bold py-2 px-4 rounded">
        Button
      </button>
    </div>
  `,
  styles: []
})
export class HomeComponent implements OnInit {

  constructor() { }

  ngOnInit() {}

}
