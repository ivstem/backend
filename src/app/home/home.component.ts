import {
  Component,
  OnInit
} from '@angular/core';

import { AppState } from '../app.service';
import { CheckService } from '../app.service';
import { Check } from '../check';
import { Title } from './title';
import { XLargeDirective } from './x-large';

@Component({
  /**
   * The selector is what angular internally uses
   * for `document.querySelectorAll(selector)` in our index.html
   * where, in this case, selector is the string 'home'.
   */
  selector: 'home',  // <home></home>
  /**
   * We need to tell Angular's Dependency Injection which providers are in our app.
   */
  providers: [
    Title
  ],
  /**
   * Our list of styles in our component. We may add more to compose many styles together.
   */
  styleUrls: [ './home.component.css' ],
  /**
   * Every Angular template is first compiled by the browser before Angular runs it's compiler.
   */
  templateUrl: './home.component.html'
})
export class HomeComponent implements OnInit {
  /**
   * Set our default values
   */
  public localState = { 
      value: '', 
      id: null,
      all: <Check[]> [],
  };
  /**
   * TypeScript public modifiers
   */
  constructor(
    public appState: AppState,
    public title: Title,
    public api: CheckService,
  ) {
      this.api.getAll()
          .then(res => {
              this.localState.all = res;
              console.log('res:', res);
          });
  }

  public ngOnInit() {
    console.log('hello `Home` component');
    /**
     * this.title.getData().subscribe(data => this.data = data);
     */
  }

  public submitState(value: string) {
    console.log('submitState', value);
    this.appState.set('value', value);
    this.localState.value = '';
  }
  public getID() {
      var res = +prompt('ID check entity:', '');
      console.info('ID', res)
      this.appState.set('id', res);
      this.localState.id = res;
      var r = this.api.getByID(res);
      r.then(res => {
          console.info('CheckService', res);
          this.localState.value = res.doc;
      });
  }
  public setID() {
      var r = this.api.setByID(this.localState.value, this.localState.id);
      r.then(res => {
          console.info('api', res);
      });
  }
}
