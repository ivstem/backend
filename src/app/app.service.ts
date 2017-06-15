import { Check } from './check';
import { Injectable } from '@angular/core';

const HOST = ENV == 'development'
    ? 'http://plagiat-slaawwa.c9users.io'
    : '';

function _fetch(url, data=<string|object> '', method='POST') {
    return new Promise((resolve, reject) => {
        let options = {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            method,
        };
        if (data) {
            options['body'] = JSON.stringify(data);
        }
        return fetch(url, options)
            .then(res => {
                return resolve(res.json());
            })
            .catch(error => {
                return Promise.reject(Error(error.message));
            });
    });
}

@Injectable()
export class CheckService {

    getByID(id: number): Promise<Check> {
        let url = `${HOST}/backend/api/theses/getcheck`;
        return _fetch(url, {id});
    }

    setByID(doc: string, id: number): Promise<Check> {
        let url = `${HOST}/backend/api/theses/setcheck`;
        return _fetch(url, {id, doc});
    }

    getAll(data = ''): Promise<Check[]> {
        let url = `${HOST}/backend/api/theses/getall`;
        return _fetch(url, data);
    }

    getPlagiat(checkID, id): Promise<object> {
        let url = `${HOST}/backend/api/theses/getplagiat`;
        return _fetch(url, {checkID, id});
    }

}
