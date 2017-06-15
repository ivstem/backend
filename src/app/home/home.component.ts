import {
    Component,
    OnInit
} from '@angular/core';

// import { AppState } from '../app.service';
import { CheckService } from '../app.service';
import { Check } from '../check';
import { Title } from './title';
// import { XLargeDirective } from './x-large';

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
        doc: '', 
        id: null,
        play: <boolean> false,
        index: <number> 0,
        all: <Check[]> [],
        res: [],
        resEmpty: <number> 0,
    };
    /**
     * TypeScript public modifiers
     */
    constructor(
        public title: Title,
        public api: CheckService,
    ) {
        this.api.getAll()
            .then(res => {
                this.localState.all = res;
            });
    }

    public ngOnInit() {
        console.log('hello `Home` component');
        if (localStorage.edit) {
            this.getID(+localStorage.edit);
            localStorage.edit = '';
        }
    }

    public submitState() {
        if (this.localState.value.length > 20) {
            if (this.localState.id && this.localState.value === this.localState.doc) {
                this.go();
            } else {
                this.setID(this.go);
            }
        } else {
            alert('Заповніть поле перевірки (мінімум 20 символів)');
        }
    }
    public stop() {
        this.localState.play = false;
        this.localState.index = 0;
        this.percent(0);
    }
    public getID(id?:number) {
        var res;
        if (id) {
            res = id;
        } else {
            res = +prompt('ID check entity:', '');
        }
        this.localState.id = res;
        var r = this.api.getByID(res);
        r.then(res => {
            this.localState.doc = res.doc;
            this.localState.value = res.doc;
        });
    }
    public setID(fn) {
        console.info('api', '+++');
        this.api.setByID(this.localState.value, this.localState.id)
            .then(res => {
                this.localState.id = res.id;
                this.localState.doc = this.localState.value;
                if (fn) {
                    fn.call(this);
                }
            });
    }
    public go() {
        this.localState.play = !this.localState.play;
        if (this.localState.play) {
            if (this.localState.index == 0) {
                this.localState.res = [];
                this.localState.resEmpty = 0;
            }
            this._go();
        }
    }
    public _go() {
        let that = this,
            all = this.localState.all,
            index = this.localState.index;
        if (index < all.length) {
            if (this.localState.play) {
                this._getPlagiat(this.localState.id, all[index])
                    .then(res => {
                        this.localState.index++;
                        that._go();
                    });
            }
        } else {
            this.localState.play = false;
            this.localState.index = 0;
        }
    }
    public _getPlagiat(checkID, id) {
        return this.api.getPlagiat(checkID, id)
            .then(res => {
                if (!this.localState.play) {
                    return Promise.reject('Stop!');
                }
                if (res['percent']) {
                    this.localState.res.push({
                        percent: res['percent'],
                        theseID: res['theseID'],
                        theseNPP: res['theseNPP'],
                        per: res['per'],
                        open: false,
                    });
                    this.localState.res = this.localState.res.sort((a, b) => {
                        return b.percent - a.percent;
                    });
                } else {
                    this.localState.resEmpty++;
                }
                let percent = (this.localState.index + 1)/this.localState.all.length * 100;
                this.percent(percent);
            });
    }
    public percent(percent) {
        let $el = document.querySelector('#progress-bar');
        $el['MaterialProgress'].setProgress(percent);
        $el['MaterialProgress'].setBuffer(percent? 75: 100);
    }
}
