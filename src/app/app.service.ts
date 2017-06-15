import { Check } from './check';
import { Injectable } from '@angular/core';

export type InternalStateType = {
  [key: string]: any
};

@Injectable()
export class AppState {

  public _state: InternalStateType = { };

  /**
   * Already return a clone of the current state.
   */
  public get state() {
    return this._state = this._clone(this._state);
  }
  /**
   * Never allow mutation
   */
  public set state(value) {
    throw new Error('do not mutate the `.state` directly');
  }

  public get(prop?: any) {
    /**
     * Use our state getter for the clone.
     */
    const state = this.state;
    return state.hasOwnProperty(prop) ? state[prop] : state;
  }

  public set(prop: string, value: any) {
    /**
     * Internally mutate our state.
     */
    return this._state[prop] = value;
  }

  private _clone(object: InternalStateType) {
    /**
     * Simple object clone.
     */
    return JSON.parse(JSON.stringify( object ));
  }
}

// import { HEROES } from './mock-heroes';
// import { Injectable } from '@angular/core';

@Injectable()
export class CheckService {
  getHeroes(): Promise<Check[]> {
    return Promise.resolve([]);
  }

  getHeroesSlowly(): Promise<Check[]> {
    return new Promise(resolve => {
      // Simulate server latency with 2 second delay
      setTimeout(() => resolve(this.getHeroes()), 2000);
    });
  }

  getHero(id: number): Promise<Check> {
    return this.getHeroes()
               .then(heroes => heroes.find(hero => hero.id === id));
  }
  getByID(id: number): Promise<Check> {
    return new Promise((resolve, reject) => {
        return fetch('http://plagiat-slaawwa.c9users.io/backend/api/theses/getcheck', {
                headers: {
                  'Accept': 'application/json',
                  'Content-Type': 'application/json'
                },
                method: "POST",
                body: JSON.stringify({id})
            })
            .then(res => { return resolve(res.json()); })
            .catch(error => {
                return Promise.reject(Error(error.message));
            })
    });
  }
  setByID(doc: string, id: number): Promise<Check> {
    return new Promise((resolve, reject) => {
        return fetch('http://plagiat-slaawwa.c9users.io/backend/api/theses/setcheck', {
                headers: {
                  'Accept': 'application/json',
                  'Content-Type': 'application/json'
                },
                method: "POST",
                body: JSON.stringify({id, doc})
            })
            .then(res => { return resolve(res.json()); })
            .catch(error => {
                return Promise.reject(Error(error.message));
            })
    });
  }
  getAll(): Promise<Check[]> {
    return new Promise((resolve, reject) => {
        return fetch('http://plagiat-slaawwa.c9users.io/backend/api/theses/getall', {
                headers: {
                  'Accept': 'application/json',
                  'Content-Type': 'application/json'
                },
                method: "POST",
            })
            .then(res => { return resolve(res.json()); })
            .catch(error => {
                return Promise.reject(Error(error.message));
            })
    });
  }
}
